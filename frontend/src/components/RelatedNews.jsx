import React from 'react';
import { Link } from 'react-router-dom';
import { useQuery } from '@tanstack/react-query';
import apiClient from '../utils/axios';

// Import CSS
import '../styles/components/ProductSidebar.css'; // Đổi tên file CSS cho phù hợp
import 'bootstrap/dist/css/bootstrap.min.css';

// --- Hàm Helper ---
const createImageUrl = (imagePath) => {
    if (!imagePath) {
        return "https://placehold.co/60x60/eee/ccc?text=?";
    }
    const baseUrl = import.meta.env.VITE_API_URL.replace(/\/$/, ''); // Xóa dấu / ở cuối VITE_API_URL nếu có
    const relativePath = imagePath.replace(/^\//, ''); // Xóa dấu / ở đầu imagePath nếu có
    return `${baseUrl}/${relativePath}`; // Kết hợp lại để đảm bảo chỉ có một dấu /
};

// --- Các hàm Fetch cho React Query ---
const fetchSidebarPosts = async () => {
    const { data } = await apiClient.get('/api/posts');
    const posts = data.data || data;
    if (Array.isArray(posts)) {
        return posts.map(post => ({
            ...post,
            image: createImageUrl(post.image),
        }));
    }
    return []; // Luôn trả về mảng để tránh lỗi
};

const fetchNewProducts = async () => {
    const { data } = await apiClient.get('/api/products/new');
    const products = data.data || data;
    if (Array.isArray(products)) {
        return products.map(product => ({
            ...product,
            image: createImageUrl(product.image),
        }));
    }
    return []; // Luôn trả về mảng để tránh lỗi
};


// --- Component Skeleton Loader ---
const SidebarSkeleton = ({ title }) => (
    <div className="sidebar-section mb-4">
        <h4 className="sidebar-title mb-4 placeholder-glow">
            <span className="placeholder col-6"></span>
        </h4>
        {Array.from({ length: 3 }).map((_, index) => (
            <div className="d-flex mb-3" key={index}>
                <div className="me-3">
                    <div style={{ width: '60px', height: '60px', backgroundColor: '#e9ecef' }}></div>
                </div>
                <div className="flex-grow-1">
                    <h6 className="placeholder-glow">
                        <span className="placeholder col-12"></span>
                    </h6>
                    <p className="placeholder-glow">
                        <span className="placeholder col-8"></span>
                    </p>
                </div>
            </div>
        ))}
    </div>
);


function ProductSidebar() {
    // Sử dụng useQuery để tải và cache "Bài viết liên quan"
    const {
        data: relatedArticles = [],
        isLoading: isLoadingArticles,
        isError: isErrorArticles
    } = useQuery({
        queryKey: ['posts', 'sidebar'], // Key cache cho bài viết ở sidebar
        queryFn: fetchSidebarPosts,
    });

    // Sử dụng useQuery để tải và cache "Sản phẩm mới"
    const {
        data: newProducts = [],
        isLoading: isLoadingProducts,
        isError: isErrorProducts
    } = useQuery({
        queryKey: ['products', 'new'], // Key cache cho sản phẩm mới
        queryFn: fetchNewProducts,
    });

    return (
        <div className="sidebar">
            {/* Phần hiển thị bài viết liên quan */}
            {isLoadingArticles ? (
                <SidebarSkeleton />
            ) : isErrorArticles ? (
                <div className="sidebar-section text-danger p-3">Lỗi tải bài viết.</div>
            ) : relatedArticles.length > 0 && (
                <div className="sidebar-section mb-4">
                    <h4 className="sidebar-title mb-4">Bài viết liên quan</h4>
                    <div className="related-articles">
                        {relatedArticles.slice(0, 5).map((article) => ( // Giới hạn 5 bài viết
                            <Link to={`/tin-tuc/${article.id}`} key={article.id} className="text-decoration-none text-dark article-link">
                                <div className="article-item d-flex mb-3">
                                    <div className="article-image me-3" style={{ width: '35px', flexShrink: 0 }}>
                                        <img
                                            src={article.image}
                                            alt={article.title}
                                            className="img-fluid"
                                            style={{ width: '35px', height: '35px', objectFit: 'cover' }}
                                        />
                                    </div>
                                    <div className="article-content">
                                        {/* SỬA ĐỔI: Thêm class fw-normal để chữ không in đậm */}
                                        <h6 className="article-title mb-0 fw-normal">{article.title}</h6>
                                    </div>
                                </div>
                            </Link>
                        ))}
                    </div>
                </div>
            )}

            {/* Phần hiển thị sản phẩm mới */}
            {isLoadingProducts ? (
                <SidebarSkeleton />
            ) : isErrorProducts ? (
                <div className="sidebar-section text-danger p-3">Lỗi tải sản phẩm.</div>
            ) : newProducts.length > 0 && (
                <div className="sidebar-section">
                    <h4 className="sidebar-title mb-4">Sản phẩm mới</h4>
                    <div className="new-products">
                        {newProducts.slice(0, 5).map((product) => ( // Giới hạn 5 sản phẩm
                            <Link to={`/cua-hang/${product.id}`} key={product.id} className="text-decoration-none text-dark product-link">
                                <div className="product-item d-flex mb-3">
                                    <div className="product-image me-3" style={{ width: '60px', flexShrink: 0 }}>
                                        <img
                                            src={product.image}
                                            alt={product.title}
                                            className="img-fluid"
                                            style={{ width: '60px', height: '60px', objectFit: 'cover' }}
                                        />
                                    </div>
                                    <div className="product-content">
                                        {/* SỬA ĐỔI: Thêm class fw-normal để chữ không in đậm */}
                                        <h6 className="product-title mb-1 fw-normal">{product.title}</h6>
                                        <p className="product-price mb-0">{new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.price)}</p>
                                    </div>
                                </div>
                            </Link>
                        ))}
                    </div>
                </div>
            )}
        </div>
    );
}

// Đổi tên component cho phù hợp với cách bạn sử dụng
export default ProductSidebar;
