import React, { useState, useEffect } from 'react';
import { useNavigate, useLocation, useParams } from 'react-router-dom'; // Giữ nguyên import
import ProductSearchBar from '../components/ProductSearchBar';
import ProductSidebar from '../components/ProductSidebar';
import FlowerCard from '../components/FlowerCard';
import hoaKhaiTruong from "../assets/images/hoa-khai-truong.webp";
import apiClient from '../utils/axios';
import 'bootstrap/dist/css/bootstrap.min.css';
import '../styles/pages/Products.css';
import '../styles/pages/Category.css';

const Category = () => {
    const [products, setProducts] = useState([]);
    const [categoryDetails, setCategoryDetails] = useState(null);
    const [loading, setLoading] = useState(true);
    const navigate = useNavigate();
    const location = useLocation();

    // THAY ĐỔI 1: Lấy cả `category` và `style` từ useParams
    const { category, style } = useParams();

    const searchParams = new URLSearchParams(location.search);
    const sort = searchParams.get('sort') || 'newest';
    const keyword = searchParams.get('keyword') || '';
    // THAY ĐỔI 2: Xóa dòng `styleAlias` không còn dùng đến
    // const styleAlias = searchParams.get('style');

    useEffect(() => {
        const fetchData = async () => {
            setLoading(true);
            setProducts([]);
            setCategoryDetails(null);

            try {
                let productsUrl = '';
                let categoryDetailsUrl = '';

                // THAY ĐỔI 3: Cập nhật logic gọi API để dùng biến `style` mới
                if (category === 'ban-chay-nhat') {
                    productsUrl = '/api/products/top';
                    setCategoryDetails({ name: 'Sản phẩm bán chạy nhất', description: 'Tổng hợp các sản phẩm được yêu thích và bán chạy nhất tại cửa hàng.' });
                } else if (category) {
                    if (keyword) {
                        // Nếu có từ khóa tìm kiếm, sử dụng endpoint search
                        productsUrl = `/api/products/search?category=${category}&keyword=${keyword}`;
                    } else if (style) {
                        productsUrl = `/api/products/category/${category}/${style}`;
                    } else {
                        productsUrl = `/api/products/category/${category}`;
                    }
                    if (style) {
                        categoryDetailsUrl = `/api/categories/${category}/${style}`;
                    } else {
                        categoryDetailsUrl = `/api/categories/${category}`;
                    }
                } else {
                    productsUrl = '/api/products';
                }

                // Phần còn lại của logic fetch không đổi
                const promises = [];
                if (productsUrl) {
                    promises.push(apiClient.get(productsUrl, { params: { sort } }));
                }
                if (categoryDetailsUrl) {
                    promises.push(apiClient.get(categoryDetailsUrl));
                }

                if (promises.length === 0) {
                    setLoading(false);
                    return;
                }

                const results = await Promise.all(promises);
                const productsRes = results[0];
                if (productsRes) {
                    setProducts(productsRes.data.data || []);
                }

                if (categoryDetailsUrl) {
                    const categoryRes = results[1];
                    if (categoryRes) {
                        setCategoryDetails(categoryRes.data.data);
                    }
                }

            } catch (err) {
                console.error('Lỗi khi tải dữ liệu trang danh mục:', err);
                setProducts([]);
                setCategoryDetails(null);
            } finally {
                setLoading(false);
            }
        };

        fetchData();
        // THAY ĐỔI 4: Cập nhật dependency array
    }, [category, style, location.search]);

    const handleProductClick = (id) => {
        navigate(`/cua-hang/${id}`);
    };

    const handleSortChange = (newSort) => {
        const newSearchParams = new URLSearchParams(location.search);
        newSearchParams.set('sort', newSort);
        navigate({ search: newSearchParams.toString() });
    };

    if (loading) {
        return <div className="text-center p-5">Đang tải dữ liệu...</div>;
    }

    return (
        <div style={{ overflowX: 'hidden' }}>
            <ProductSearchBar
                category={category}
                styleType={style} // Truyền `style` thay vì `styleAlias`
                productQuantity={products.length}
                onSortChange={handleSortChange}
                currentSort={sort}
                keyword={keyword}
            />
            {/* Phần JSX còn lại không thay đổi */}
            <div className="row wrapper-category">
                <div className="col-lg-3 d-none d-lg-block">
                    <ProductSidebar />
                </div>
                <div className="col-lg-9 col-12">
                    <div className="container">
                        {categoryDetails && (
                            <div className="category-header mb-4">
                                <h1 className="category-title">{categoryDetails.name}</h1>
                                <p className="category-description" dangerouslySetInnerHTML={{ __html: categoryDetails.description }}></p>
                            </div>
                        )}

                        <div className="row g-4">
                            {products.length > 0 ? (
                                products.map((product, index) => (
                                    <div
                                        key={product.id || index}
                                        className="col-lg-3 col-md-4 col-6"
                                        style={{ cursor: 'pointer' }}
                                        onClick={() => handleProductClick(product.id)}
                                    >
                                        <FlowerCard
                                            imageUrl={
                                                product.image
                                                    ? `${import.meta.env.VITE_API_URL.replace(/\/$/, '')}/${product.image.replace(/^\//, '')}`
                                                    : hoaKhaiTruong
                                            }
                                            title={product.title}
                                            buttonText="Đặt mua"
                                            buttonType="order"
                                            productId={product.id}
                                            category={product.category}
                                        />
                                    </div>
                                ))
                            ) : (
                                <p>Không tìm thấy sản phẩm nào khớp với lựa chọn của bạn.</p>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Category;