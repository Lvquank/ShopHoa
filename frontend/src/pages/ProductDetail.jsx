import "../styles/pages/About.css"
import "../styles/pages/ProductDetail.css";
import logoImg from "../assets/images/logo.webp"
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import RelatedNews from "../components/RelatedNews"
import 'bootstrap-icons/font/bootstrap-icons.css';
import { useState, useEffect } from 'react';
import { useParams } from "react-router-dom";
import ReviewCard from "../components/ReviewCard";
const ProductDetail = () => {
    const { productId } = useParams();
    const [product, setProduct] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [activeTab, setActiveTab] = useState('description');

    useEffect(() => {
        const fetchProduct = async () => {
            try {
                const response = await fetch(`http://127.0.0.1:8000/api/products/${productId}`);
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
    const primaryDetail = product?.details?.[0];
    return (
        <div className="wrapper">
            <div className="container py-5">
                <div className="row">

                    <div className="col-lg-9 col-md-12 border-end border-gray">
                        <div className="row g-4 align-items-start">
                            {/* Product Image */}
                            <div className="col-lg-5 d-flex justify-content-center mb-4 mb-lg-0 align-items-stretch">
                                <img
                                    src={product?.image || '/api/placeholder/400/600'}
                                    alt={product?.title}
                                    className="img-fluid shadow-lg border h-100"
                                    style={{ objectFit: 'cover', background: '#f8f8f8', borderRadius: 0, minHeight: 480 }}
                                    onError={e => { e.target.src = '/api/placeholder/400/600'; }}
                                />
                            </div>
                            {/* Product Info */}
                            <div className="col-lg-7 d-flex flex-column justify-content-center" style={{ minHeight: 480 }}>
                                {/* Breadcrumb */}
                                <nav className="mb-2 text-sm text-secondary">
                                    <span className="text-orange-500 fw-bold cursor-pointer">Trang chủ</span>
                                    <span className="mx-2">/</span>
                                    <span className="text-orange-500 fw-bold cursor-pointer">{product?.category || 'Danh mục'}</span>
                                    <span className="mx-2">/</span>
                                    <span>{product?.title || 'Sản phẩm'}</span>
                                </nav>
                                {/* Product Title */}
                                <h1 className="display-6 fw-bold text-dark mb-3">
                                    {product?.title || 'Đặt Hoa Đám Tang Mỹ Tho 0966183183'}
                                </h1>
                                {/* Product Features */}
                                {product?.description && (
                                    <div className="mb-4">
                                        <ul className="list-unstyled text-dark fs-6" style={{ paddingLeft: 0 }}>
                                            {/* Hiển thị HTML ul/li từ product.description, thêm dấu + đầu mỗi dòng bằng CSS */}
                                            <div
                                                className="product-description-list"
                                                dangerouslySetInnerHTML={{ __html: product.description }}
                                            />
                                        </ul>
                                    </div>
                                )}
                                {/* Order Button */}
                                <button className="btn btn-lg btn-orange text-white fw-bold px-5 py-2 mb-3 shadow-sm" style={{ background: '#ff6600' }}>
                                    Đặt mua
                                </button>
                                {/* Tags & Social */}
                                <div className="d-flex flex-wrap align-items-center gap-3 pt-2">
                                    <span className="badge bg-light text-secondary fs-6">Thẻ: <span className="text-orange-500">{product?.tag || 'hoa đám tang'}</span></span>
                                    <div className="d-flex gap-2 ms-2">
                                        <a href="#" className="d-flex align-items-center justify-content-center border border-2 border-secondary rounded-circle bg-white social-icon" style={{ width: 36, height: 36 }}>
                                            <i className="bi bi-facebook fs-5" style={{ color: '#b0b0b0' }}></i>
                                        </a>
                                        <a href="#" className="d-flex align-items-center justify-content-center border border-2 border-secondary rounded-circle bg-white social-icon" style={{ width: 36, height: 36 }}>
                                            <i className="bi bi-twitter fs-5" style={{ color: '#b0b0b0' }}></i>
                                        </a>
                                        <a href="#" className="d-flex align-items-center justify-content-center border border-2 border-secondary rounded-circle bg-white social-icon" style={{ width: 36, height: 36 }}>
                                            <i className="bi bi-envelope fs-5" style={{ color: '#b0b0b0' }}></i>
                                        </a>
                                        <a href="#" className="d-flex align-items-center justify-content-center border border-2 border-secondary rounded-circle bg-white social-icon" style={{ width: 36, height: 36 }}>
                                            <i className="bi bi-pinterest fs-5" style={{ color: '#b0b0b0' }}></i>
                                        </a>
                                        <a href="#" className="d-flex align-items-center justify-content-center border border-2 border-secondary rounded-circle bg-white social-icon" style={{ width: 36, height: 36 }}>
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
                                    className={`nav-link fw-bold ${activeTab === 'description' ? 'active border-orange-500 border-bottom-2' : ''}`}
                                    style={activeTab === 'description' ? { color: '#ff6600', borderBottom: '3px solid #ff6600', background: '#fff' } : { color: '#888', background: '#f7f7f7' }}
                                    onClick={() => setActiveTab('description')}
                                >
                                    MÔ TẢ
                                </button>
                            </li>
                            <li className="nav-item">
                                <button
                                    className={`nav-link fw-bold ${activeTab === 'review' ? 'active border-orange-500 border-bottom-2' : ''}`}
                                    style={activeTab === 'review' ? { color: '#ff6600', borderBottom: '3px solid #ff6600', background: '#fff' } : { color: '#888', background: '#f7f7f7' }}
                                    onClick={() => setActiveTab('review')}
                                >
                                    ĐÁNH GIÁ (0)
                                </button>
                            </li>
                        </ul>
                        {/* Tab Content */}
                        {activeTab === 'description' && (
                            <div className="mx-auto px-4 py-6">
                                {/* Hiển thị details nếu có */}
                                {product?.details && product.details.length > 0 && product.details.map((detail, idx) => (
                                    <div key={detail.id || idx} className="mb-4">
                                        {detail.title && (
                                            <h2 className="fw-bold mb-2" style={{ fontSize: '1.5rem' }}>{detail.title}</h2>
                                        )}
                                        {detail.intro && (
                                            <div className="mb-2 text-secondary" style={{ fontSize: '1rem' }}
                                                dangerouslySetInnerHTML={{ __html: detail.intro }} />
                                        )}
                                        {detail.image && (
                                            <div className="d-flex justify-content-center">
                                                <img src={detail.image} alt={detail.title || ''} className="img-fluid mb-2 border" style={{ borderRadius: 8 }} />
                                            </div>
                                        )}
                                        {detail.description && (
                                            <div className="mb-2 text-secondary" style={{ fontSize: '1rem' }}
                                                dangerouslySetInnerHTML={{ __html: detail.description }} />
                                        )}
                                    </div>
                                ))}
                                <div className="container my-4">
                                    <h4 className="fw-bold mb-3">Những cam kết hoa đám tang Bà Rịa:</h4>
                                    <ul className="list-unstyled">
                                        <li className="mb-2"><span className="text-success fw-bold me-2">+</span>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
                                        <li className="mb-2"><span className="text-success fw-bold me-2">+</span>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
                                        <li className="mb-2"><span className="text-success fw-bold me-2">+</span>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng,</li>
                                        <li className="mb-2"><span className="text-success fw-bold me-2">+</span>Dịch vụ giao hoa bằng ô tô theo yêu cầu quý khách</li>
                                        <li className="mb-2"><span className="text-success fw-bold me-2">+</span>Miễn phí thiết kế bảng chữ theo ý quý khách</li>
                                        <li className="mb-2"><span className="text-success fw-bold me-2">+</span>Hình thức thanh toán dễ dàng thuận tiện.</li>
                                        <li className="mb-2"><span className="text-success fw-bold me-2">+</span>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
                                    </ul>
                                    <p className="mt-3">
                                        Bạn có bất kỳ thắc mắc nào, hãy liên hệ ngay cho chúng tôi qua Hotline
                                        <strong className="text-danger">0966183183</strong> để được tư vấn và hỗ trợ nhanh nhất!
                                    </p>
                                </div>
                            </div>
                        )}
                        {activeTab === 'review' && (
                            <div className="px-4 py-4 bg-white rounded-3 border border-1 border-light-subtle">
                                <ReviewCard />
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