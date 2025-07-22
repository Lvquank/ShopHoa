import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'bootstrap-icons/font/bootstrap-icons.css';

import RelatedNews from "../components/RelatedNews";
import CommentForm from '../components/CommentForm';
import apiClient from '../utils/axios';

const NewsDetail = () => {
    const { id } = useParams();

    // --- STATE MANAGEMENT ---
    const [post, setPost] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    // --- DATA FETCHING ---
    useEffect(() => {
        const fetchPost = async () => {
            if (!id) {
                setLoading(false);
                setError('ID bài viết không hợp lệ.');
                return;
            }

            try {
                setLoading(true);
                // API sẽ trả về post object có chứa mảng 'images'
                const response = await apiClient.get(`/api/posts/${id}`);
                setPost(response.data);
            } catch (err) {
                setError('Không tìm thấy bài viết hoặc đã có lỗi xảy ra.');
                console.error("Lỗi khi tải bài viết:", err);
            } finally {
                setLoading(false);
            }
        };

        fetchPost();
    }, [id]);

    // --- LOGIC RENDER NỘI DUNG CHÍNH ---
    const renderPostContent = (postData) => {
        // Guard clause: Đảm bảo có đủ dữ liệu cần thiết
        if (!postData || !postData.description || !postData.images) {
            return <p>Nội dung bài viết không có sẵn.</p>;
        }

        // 1. Tạo "bản đồ" để tra cứu ảnh nhanh bằng ID
        const imageMap = new Map(postData.images.map(img => [img.id.toString(), img]));

        // 2. Tách chuỗi nội dung thành các phần (văn bản và thẻ giữ chỗ)
        const contentParts = postData.description.split(/(\[image id="\d+"\])/g);

        // Lấy base URL của API từ biến môi trường
        const apiBaseUrl = import.meta.env.VITE_API_URL

        // 3. Render xen kẽ
        return contentParts.map((part, index) => {
            const imageMatch = part.match(/\[image id="(\d+)"\]/);

            if (imageMatch) { // Nếu là thẻ giữ chỗ
                const imageId = imageMatch[1];
                const image = imageMap.get(imageId);

                if (image) {
                    const imageUrl = `${apiBaseUrl}/${image.url.replace(/^storage\//, 'storage/')}`;
                    return (
                        <div key={index} className="text-center my-4">
                            <img
                                src={imageUrl}
                                alt={image.caption || 'Post Image'}
                                className="img-fluid"
                                style={{ maxWidth: "600px" }}
                            />
                        </div>
                    );
                }
                return null; // Bỏ qua nếu không tìm thấy ảnh
            } else { // Nếu là văn bản
                // Chỉ render nếu phần text không trống
                if (part) {
                    return <div key={index} dangerouslySetInnerHTML={{ __html: part }} />;
                }
                return null;
            }
        });
    };

    // --- RENDER LOGIC ---
    if (loading) {
        return <div className="text-center py-5">Đang tải bài viết...</div>;
    }

    if (error) {
        return <div className="text-center py-5 text-danger">{error}</div>;
    }

    if (!post) {
        return <div className="text-center py-5">Không có dữ liệu để hiển thị.</div>;
    }

    return (
        <div style={{ backgroundColor: '#ffffff', padding: '0 12rem' }}>
            <div className="py-5">
                <div className="row">
                    <div className="col-lg-9 col-md-12 border-end border-gray pe-lg-5">
                        <div className="mb-4">
                            <p className="text-uppercase text-secondary fw-bold mb-1">Tin tức</p>

                            <h3 className="fw-semibold mb-2">{post.title}</h3>
                            <p className="text-muted mb-4">
                                POSTED ON {new Date(post.created_at).toLocaleDateString('vi-VN')} BY
                                <strong className="text-dark"> {post.user ? post.user.name.toUpperCase() : 'ADMIN'}</strong>
                            </p>

                            {/* SỬA ĐỔI QUAN TRỌNG: Gọi hàm renderPostContent tại đây */}
                            <div>{renderPostContent(post)}</div>
                        </div>

                        {/* --- Phần JSX tĩnh được giữ lại --- */}
                        <div className="d-flex flex-wrap align-items-center gap-3 pt-2">
                            <div className="d-flex gap-2 ms-2">
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
                        <hr />
                        <p className="text-muted">
                            This entry was posted in Tin tức and tagged hoa 20/10.
                        </p>
                        <hr />

                        <CommentForm postId={post.id} />
                    </div>

                    <div className="col-lg-3 col-md-12">
                        <RelatedNews currentPostId={post.id} />
                    </div>
                </div>
            </div>
        </div>
    );
}

export default NewsDetail;