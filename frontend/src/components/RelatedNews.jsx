import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

// Import CSS từ file ngoài như ban đầu
import '../styles/components/RelatedNews.css';
import 'bootstrap/dist/css/bootstrap.min.css';

// Component RelatedNews
function RelatedNews() {
    // State để lưu trữ dữ liệu từ API
    const [relatedArticles, setRelatedArticles] = useState([]);
    const [newProducts, setNewProducts] = useState([]);

    // State để quản lý trạng thái loading và lỗi
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    // Sử dụng biến môi trường từ file .env của Vite
    const API_URL = import.meta.env.VITE_API_URL;

    useEffect(() => {
        // Kiểm tra nếu API_URL chưa được định nghĩa
        if (!API_URL) {
            console.error("VITE_API_URL không được định nghĩa trong file .env");
            setError("Lỗi cấu hình: Không tìm thấy địa chỉ API.");
            setLoading(false);
            return;
        }

        const fetchData = async () => {
            try {
                setError(null);
                setLoading(true);

                // Gọi đồng thời cả hai API
                const [articlesResponse, productsResponse] = await Promise.all([
                    axios.get(`${API_URL}/api/posts`),
                    axios.get(`${API_URL}/api/products/new`)
                ]);

                // Cập nhật state cho bài viết liên quan (linh hoạt hơn)
                // Kịch bản 1: API trả về cấu trúc { success: true, data: [...] }
                if (articlesResponse.data && articlesResponse.data.success && Array.isArray(articlesResponse.data.data)) {
                    setRelatedArticles(articlesResponse.data.data);
                }
                // Kịch bản 2: API trả về trực tiếp một mảng [...]
                else if (Array.isArray(articlesResponse.data)) {
                    setRelatedArticles(articlesResponse.data);
                }
                // Kịch bản lỗi
                else {
                    console.warn("API bài viết không trả về dữ liệu thành công hoặc dữ liệu không đúng định dạng.", articlesResponse.data);
                }

                // Cập nhật state cho sản phẩm mới (linh hoạt hơn)
                // Kịch bản 1: API trả về cấu trúc { success: true, data: [...] }
                if (productsResponse.data && productsResponse.data.success && Array.isArray(productsResponse.data.data)) {
                    setNewProducts(productsResponse.data.data);
                }
                // Kịch bản 2: API trả về trực tiếp một mảng [...]
                else if (Array.isArray(productsResponse.data)) {
                    setNewProducts(productsResponse.data);
                }
                // Kịch bản lỗi
                else {
                    console.warn("API sản phẩm không trả về dữ liệu thành công hoặc dữ liệu không đúng định dạng.", productsResponse.data);
                }

            } catch (err) {
                console.error("Lỗi khi tải dữ liệu:", err);
                setError("Không thể kết nối đến máy chủ. Vui lòng thử lại sau.");
            } finally {
                setLoading(false);
            }
        };

        fetchData();
    }, [API_URL]); // Chạy lại effect nếu API_URL thay đổi

    // Hàm xử lý và tạo URL hình ảnh
    const createImageUrl = (imagePath) => {
        // Nếu không có đường dẫn ảnh, trả về placeholder
        if (!imagePath) {
            return "https://placehold.co/60x60/eee/ccc?text=?";
        }
        // Loại bỏ phần domain cũ nếu có
        let relativePath = imagePath.replace("http://localhost:8000", "");

        // Đảm bảo đường dẫn tương đối luôn bắt đầu bằng dấu "/"
        if (!relativePath.startsWith('/')) {
            relativePath = '/' + relativePath;
        }

        return `${API_URL}${relativePath}`;
    };

    // Hiển thị trạng thái đang tải
    if (loading) {
        return <div className="sidebar-section text-center p-3">Đang tải...</div>;
    }

    // Hiển thị lỗi
    if (error) {
        return <div className="sidebar-section text-center text-danger p-3">{error}</div>;
    }

    return (
        <div className="sidebar">
            {/* Related Articles */}
            {relatedArticles.length > 0 && (
                <div className="sidebar-section mb-4">
                    <h4 className="sidebar-title mb-4">Bài viết liên quan</h4>
                    <div className="related-articles">
                        {relatedArticles.map((article) => (
                            <Link to={`/tin-tuc/${article.id}`} key={article.id} className="text-decoration-none text-dark">
                                <div className="article-item d-flex mb-3">
                                    <div className="article-image me-3">
                                        <img
                                            src={createImageUrl(article.image)}
                                            alt={article.title}
                                            className="img-fluid"
                                        />
                                    </div>
                                    <div className="article-content">
                                        <h6 className="article-title mb-0">{article.title}</h6>
                                    </div>
                                </div>
                            </Link>
                        ))}
                    </div>
                </div>
            )}

            {/* New Products */}
            {newProducts.length > 0 && (
                <div className="sidebar-section">
                    <h4 className="sidebar-title mb-4">Sản phẩm mới</h4>
                    <div className="new-products">
                        {newProducts.map((product) => (
                            <Link to={`/cua-hang/${product.id}`} key={product.id} className="text-decoration-none text-dark">
                                <div className="product-item d-flex mb-3">
                                    <div className="product-image me-3">
                                        <img
                                            src={createImageUrl(product.image)}
                                            alt={product.title}
                                            className="img-fluid"
                                        />
                                    </div>
                                    <div className="product-content">
                                        <h6 className="product-title mb-1">{product.title}</h6>
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

export default RelatedNews;
