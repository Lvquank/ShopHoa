import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from "react-router-dom";
import RelatedNews from "../components/RelatedNews";
import 'bootstrap/dist/css/bootstrap.min.css';

// Lấy URL API từ biến môi trường của Vite
const API_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000';

// Hàm trợ giúp để tạo URL hình ảnh an toàn
const createImageUrl = (imagePath) => {
    if (!imagePath) {
        return "https://placehold.co/400x300/eee/ccc?text=No+Image";
    }
    const relativePath = imagePath.replace("http://localhost:8000", "");
    return `${API_URL}${relativePath.startsWith('/') ? '' : '/'}${relativePath}`;
};

// Hàm trợ giúp để định dạng ngày tháng
const formatDate = (dateString) => {
    try {
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = `TH${date.getMonth() + 1}`;
        return { day, month };
    } catch (e) {
        return { day: 'N/A', month: '' };
    }
};

// Hàm trợ giúp để rút gọn nội dung và loại bỏ thẻ HTML
const truncateContent = (htmlString, length = 100) => {
    if (!htmlString) return '';
    const plainText = htmlString.replace(/<[^>]+>/g, ''); // Loại bỏ thẻ HTML
    if (plainText.length <= length) {
        return plainText;
    }
    return plainText.substring(0, length) + '...';
};


function News() {
    const [posts, setPosts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchPosts = async () => {
            try {
                const response = await axios.get(`${API_URL}/api/posts`);
                if (response.data && Array.isArray(response.data.data)) {
                    setPosts(response.data.data);
                } else if (Array.isArray(response.data)) {
                    setPosts(response.data);
                } else {
                    console.error("API response is not an array:", response.data);
                    setPosts([]);
                }
            } catch (err) {
                console.error("Error fetching posts:", err);
                setError("Không thể tải danh sách bài viết. Vui lòng thử lại sau.");
            } finally {
                setLoading(false);
            }
        };

        fetchPosts();
    }, []);

    return (
        <div className="about-page">
            <div className="container py-5">
                <div className="row">
                    <div className="col-lg-9 col-md-12 border-end border-gray pe-lg-4">
                        {loading && <div className="text-center">Đang tải bài viết...</div>}
                        {error && <div className="alert alert-danger">{error}</div>}

                        {!loading && !error && (
                            <div className="row g-4">
                                {posts.map((post) => {
                                    const { day, month } = formatDate(post.created_at);
                                    return (
                                        <div className="col-12" key={post.id}>
                                            <Link to={`/tin-tuc/${post.id}`} className="text-decoration-none text-dark">
                                                <div className="card border-0 shadow-sm h-100">
                                                    <div className="row g-0">
                                                        <div className="col-md-4">
                                                            <div className="position-relative h-100">
                                                                <img
                                                                    src={createImageUrl(post.image)}
                                                                    className="img-fluid rounded-start h-100 object-fit-cover"
                                                                    alt={post.title}
                                                                    style={{ minHeight: '200px' }}
                                                                />
                                                                <div className="position-absolute top-0 start-0 bg-danger text-white px-2 py-1 text-center rounded-end">
                                                                    <small className="fw-bold d-block">{day}</small>
                                                                    <small className="fw-bold d-block">{month}</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div className="col-md-8 d-flex align-items-center">
                                                            <div className="card-body">
                                                                <h5 className="card-title fw-bold text-dark">
                                                                    {post.title}
                                                                </h5>
                                                                <p className="card-text text-muted">
                                                                    {truncateContent(post.content)}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </Link>
                                        </div>
                                    );
                                })}
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

export default News;
