import "../styles/pages/About.css"
import "../styles/pages/ProductDetail.css";
import "../styles/common/colors.css";
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import RelatedNews from "../components/RelatedNews"
import 'bootstrap-icons/font/bootstrap-icons.css';
import React, { useState, useEffect } from 'react';
import { useParams, useNavigate } from "react-router-dom";
import { Offcanvas } from 'bootstrap';
import ReviewCard from "../components/ReviewCard";
import { useCart } from '../contexts/CartContext';

const ProductDetail = () => {
    const { addToCart } = useCart();
    const { productId } = useParams();
    const navigate = useNavigate();
    const [product, setProduct] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [activeTab, setActiveTab] = useState('description');
    const [relatedProducts, setRelatedProducts] = useState([]);

    // Hàm trợ giúp để xây dựng URL hình ảnh một cách an toàn
    const buildImageUrl = (imagePath) => {
        if (!imagePath) {
            return "/api/placeholder/400/600"; // Fallback nếu không có đường dẫn
        }
        const baseUrl = import.meta.env.VITE_API_URL.replace(/\/$/, ''); // Xóa dấu / ở cuối
        const relativePath = imagePath.replace(/^\//, ''); // Xóa dấu / ở đầu
        return `${baseUrl}/${relativePath}`;
    };

    const handleAddToCart = async () => {
        try {
            setLoading(true);
            await addToCart(product.id, 1);

            // Mở giỏ hàng
            const offcanvasCart = new Offcanvas(document.getElementById('offcanvasCart'));
            offcanvasCart.show();
        } catch (error) {
            console.error('Error adding to cart:', error);
            alert(error.response?.data?.message || 'Có lỗi xảy ra khi thêm vào giỏ hàng');
        } finally {
            setLoading(false);
        }
    };

    const handleBuyNow = async () => {
        try {
            setLoading(true);
            await addToCart(product.id, 1);
            // Chuyển đến trang thanh toán
            navigate('/gio-hang');
        } catch (error) {
            console.error('Error buying now:', error);
            alert(error.response?.data?.message || 'Có lỗi xảy ra');
        } finally {
            setLoading(false);
        }
    };

    // Hàm render mô tả chi tiết với hình ảnh động
    const renderDetailContent = (detail) => {
        if (!detail || !detail.description) return '';

        const images = detail.images || [];
        const imageMap = new Map(images.map(img => [
            img.id,
            buildImageUrl(img.image) // Sử dụng hàm trợ giúp
        ]));

        const renderedHtml = detail.description.replace(/\[image id="(\d+)"\]/g, (match, imageId) => {
            const imageUrl = imageMap.get(parseInt(imageId, 10));
            if (imageUrl) {
                return `
                        <div class="d-flex justify-content-center my-3">
                            <img 
                                src="${imageUrl}" 
                                alt="Hình ảnh chi tiết ${imageId}" 
                                class="img-fluid border" 
                                style="border-radius: 8px; max-width: 100%; height: auto;" 
                                loading="lazy"
                            />
                        </div>`;
            }
            return ''; // Bỏ qua nếu không tìm thấy ảnh
        });

        return renderedHtml;
    };


    useEffect(() => {
        const fetchProduct = async () => {
            setLoading(true);
            try {
                const response = await fetch(`${import.meta.env.VITE_API_URL}/api/products/${productId}`);
                const data = await response.json();

                if (data.success) {
                    setProduct(data.data);
                } else {
                    setError('Không thể tải thông tin sản phẩm');
                }
            } catch (err) {
                setError('Lỗi kết nối API');
            } finally {
                setLoading(false);
            }
        };

        fetchProduct();
    }, [productId]);

    // Lấy các sản phẩm liên quan
    useEffect(() => {
        const fetchRelatedProducts = async () => {
            if (!product?.category?.alias) return;

            try {
                const response = await fetch(`${import.meta.env.VITE_API_URL}/api/products/category/${encodeURIComponent(product.category.alias)}?exclude=${productId}`);
                const data = await response.json();
                if (data.success) {
                    setRelatedProducts(data.data || []);
                }
            } catch (err) {
                console.error('Error fetching related products:', err);
                setRelatedProducts([]);
            }
        };

        fetchRelatedProducts();
    }, [productId, product?.category?.alias]);


    if (loading) {
        return (
            <div className="min-h-screen bg-gray-50 flex items-center justify-center">
                <div className="text-center">
                    <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-orange-500 mx-auto"></div>
                    <p className="mt-4 text-gray-600">Đang tải...</p>
                </div>
            </div>
        );
    }

    if (error) {
        return (
            <div className="min-h-screen bg-gray-50 flex items-center justify-center">
                <div className="text-center">
                    <p className="text-red-600 text-lg">{error}</p>
                </div>
            </div>
        );
    }

    return (
        <div className="wrapper">
            <div className="container py-5">
                <div className="row">
                    <div className="col-lg-9 col-md-12 border-end border-gray">
                        <div className="row g-4 align-items-start mb-4">
                            {/* Product Image */}
                            <div className="col-lg-5 d-flex justify-content-center mb-4 mb-lg-0 align-items-stretch">
                                <img
                                    src={buildImageUrl(product?.image)} // Sử dụng hàm trợ giúp
                                    alt={product?.title}
                                    className="img-fluid border h-100"
                                    style={{ objectFit: 'cover', background: '#f8f8f8', borderRadius: 0, minHeight: 480 }}
                                    onError={e => { e.target.src = '/api/placeholder/400/600'; }}
                                />
                            </div>
                            {/* Product Info */}
                            <div className="col-lg-7 d-flex flex-column justify-content-center" style={{ minHeight: 480 }}>
                                {/* Breadcrumb ĐÃ SỬA LỖI */}
                                <nav className="mb-2 text-sm text-secondary">
                                    <span
                                        className="text-primary-custom fw-bold cursor-pointer"
                                        onClick={() => navigate('/')}
                                    >
                                        Trang chủ
                                    </span>
                                    <span className="mx-2">/</span>
                                    <span
                                        className="text-primary-custom fw-bold cursor-pointer"
                                        onClick={() => navigate(`/cua-hang?category=${product?.category?.alias || ''}`)}
                                    >
                                        {product?.category?.name || 'Cửa hàng'}
                                    </span>

                                    {/* Phần hiển thị style không đổi */}
                                    {product?.style && (
                                        <>
                                            <span className="mx-2">/</span>
                                            <span
                                                className="text-primary-custom fw-bold cursor-pointer"
                                                onClick={() => navigate(`/cua-hang?category=${product.category.alias}&style=${product.style.alias}`)}
                                            >
                                                {product.style.name}
                                            </span>
                                        </>
                                    )}
                                </nav>
                                {/* Product Title */}
                                <h4 className="text-dark mb-3">
                                    {product?.title || 'Chưa có tiêu đề'}
                                </h4>
                                {/* Product Short Description */}
                                {product?.description && (
                                    <div className="mb-4">
                                        <div
                                            className="product-description-list"
                                            dangerouslySetInnerHTML={{ __html: product.description }}
                                        />
                                    </div>
                                )}
                                {/* Order Buttons */}
                                <div className="d-flex gap-3 mb-3">
                                    <button
                                        className="btn-primary-custom px-4 py-2 shadow-sm border-0"
                                        onClick={handleAddToCart}
                                        disabled={loading}
                                    >
                                        {loading ? (
                                            <span className="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                        ) : (
                                            <i className="bi bi-cart-plus me-2"></i>
                                        )}
                                        Thêm vào giỏ hàng
                                    </button>
                                    <button
                                        className="btn-primary-custom px-4 py-2 shadow-sm border-0"
                                        onClick={handleBuyNow}
                                        disabled={loading}
                                    >
                                        <i className="bi bi-lightning-charge me-2"></i>
                                        Đặt mua
                                    </button>
                                </div>
                                {/* Tags & Social */}
                                <div className="d-flex flex-column gap-3 pt-2">
                                    <div className="badge bg-light text-secondary fs-6 align-self-start">Thẻ: <span className="text-primary-custom">{product?.tag || 'chưa có thẻ'}</span></div>
                                    <div className="d-flex gap-2">
                                        <a href="#" className="d-flex align-items-center justify-content-center border border-2 border-secondary rounded-circle bg-white social-icon facebook" style={{ width: 36, height: 36 }}>
                                            <i className="bi bi-facebook fs-5" style={{ color: '#b0b0b0' }}></i>
                                        </a>
                                        <a href="#" className="d-flex align-items-center justify-content-center border border-2 border-secondary rounded-circle bg-white social-icon twitter" style={{ width: 36, height: 36 }}>
                                            <i className="bi bi-twitter fs-5" style={{ color: '#b0b0b0' }}></i>
                                        </a>
                                        <a href="#" className="d-flex align-items-center justify-content-center border border-2 border-secondary rounded-circle bg-white social-icon email" style={{ width: 36, height: 36 }}>
                                            <i className="bi bi-envelope fs-5" style={{ color: '#b0b0b0' }}></i>
                                        </a>
                                        <a href="#" className="d-flex align-items-center justify-content-center border border-2 border-secondary rounded-circle bg-white social-icon pinterest" style={{ width: 36, height: 36 }}>
                                            <i className="bi bi-pinterest fs-5" style={{ color: '#b0b0b0' }}></i>
                                        </a>
                                        <a href="#" className="d-flex align-items-center justify-content-center border border-2 border-secondary rounded-circle bg-white social-icon linkedin" style={{ width: 36, height: 36 }}>
                                            <i className="bi bi-linkedin fs-5" style={{ color: '#b0b0b0' }}></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Tabs */}
                        <ul className="nav nav-tabs mb-4" style={{ borderBottom: '2px solid #eee', position: 'sticky', top: 0, zIndex: 10, background: '#fff' }}>
                            <li className="nav-item">
                                <button
                                    className={`nav-link fw-bold ${activeTab === 'description' ? 'active active-primary-custom' : ''}`}
                                    style={activeTab === 'description' ? { borderBottom: '3px solid var(--primary-color)', background: '#fff' } : { color: '#888', background: '#f7f7f7' }}
                                    onClick={() => setActiveTab('description')}
                                >
                                    MÔ TẢ
                                </button>
                            </li>
                            <li className="nav-item">
                                <button
                                    className={`nav-link fw-bold ${activeTab === 'review' ? 'active active-primary-custom' : ''}`}
                                    style={activeTab === 'review' ? { borderBottom: '3px solid var(--primary-color)', background: '#fff' } : { color: '#888', background: '#f7f7f7' }}
                                    onClick={() => setActiveTab('review')}
                                >
                                    ĐÁNH GIÁ (0)
                                </button>
                            </li>
                        </ul>

                        {/* Tab Content */}
                        {activeTab === 'description' && (
                            <div className="product-long-description px-2">
                                {product?.details && product.details.length > 0 ? (
                                    product.details.map((detail) => (
                                        <div
                                            key={detail.id}
                                            dangerouslySetInnerHTML={{ __html: renderDetailContent(detail) }}
                                        />
                                    ))
                                ) : (
                                    <p>Sản phẩm này chưa có mô tả chi tiết.</p>
                                )}
                            </div>
                        )}

                        {activeTab === 'review' && (
                            <div className="px-4 py-4 bg-white rounded-3 border border-1 border-light-subtle">
                                <ReviewCard productId={product.id} />
                            </div>
                        )}

                        {/* Sản phẩm tương tự */}
                        {relatedProducts.length > 0 && (
                            <div className="mt-5">
                                <h5 className="text-start mb-4 fw-semibold text-primary-custom">Sản phẩm tương tự</h5>
                                <div className="row g-2">
                                    {relatedProducts.slice(0, 6).map((relatedProduct) => (
                                        <div key={relatedProduct.id} className="col-lg-2 col-md-4 col-sm-6">
                                            <div className="card border-0 h-100">
                                                <div className="position-relative">
                                                    <img
                                                        src={buildImageUrl(relatedProduct.image)} // Sử dụng hàm trợ giúp
                                                        alt={relatedProduct.title}
                                                        className="card-img-top"
                                                        style={{ height: '150px', objectFit: 'cover', cursor: 'pointer' }}
                                                        onClick={() => navigate(`/cua-hang/${relatedProduct.id}`)}
                                                    />
                                                </div>
                                                <div className="card-body p-2 text-center">
                                                    <h6
                                                        className="card-title text-dark mb-0 fw-normal"
                                                        style={{ fontSize: '0.9rem', cursor: 'pointer', lineHeight: '1.2' }}
                                                        onClick={() => navigate(`/cua-hang/${relatedProduct.id}`)}
                                                    >
                                                        {relatedProduct.title}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        )}
                    </div>
                    <div className="col-lg-3 col-md-12">
                        <RelatedNews />
                    </div>
                </div>
            </div>
        </div>
    );
}

export default ProductDetail;
