// src/components/ProductReviews.jsx
import React, { useState, useEffect, useCallback } from 'react';
import ReviewItem from './ReviewItem'; // Import component con
import { useUser } from '../contexts/UserContext'; // Import context để kiểm tra đăng nhập
import apiClient from '../utils/axios'; // Import apiClient đã cấu hình
import 'bootstrap-icons/font/bootstrap-icons.css';

// Component cho form đánh giá trong Modal
const ReviewForm = ({ rating, setRating, comment, setComment }) => {
    const [hoverRating, setHoverRating] = useState(0);

    return (
        <>
            <div className="mb-3">
                <label className="form-label fw-medium">Đánh giá của bạn <span className="text-danger">*</span></label>
                <div>
                    {[1, 2, 3, 4, 5].map((star) => (
                        <i
                            key={star}
                            className={`bi bi-star-fill fs-4 me-1 ${star <= (hoverRating || rating) ? 'text-warning' : 'text-secondary'}`}
                            style={{ cursor: 'pointer', transition: 'color 0.2s' }}
                            onClick={() => setRating(star)}
                            onMouseEnter={() => setHoverRating(star)}
                            onMouseLeave={() => setHoverRating(0)}
                        />
                    ))}
                </div>
            </div>
            <div className="mb-3">
                <label className="form-label fw-medium">Nhận xét của bạn</label>
                <textarea
                    value={comment}
                    onChange={(e) => setComment(e.target.value)}
                    className="form-control"
                    rows={4}
                    placeholder="Viết nhận xét của bạn..."
                />
            </div>
        </>
    );
};


// Component chính
const ReviewCard = ({ productId }) => {
    // State cho danh sách reviews
    const [reviews, setReviews] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    // State cho form trong modal
    const [rating, setRating] = useState(0);
    const [comment, setComment] = useState('');
    const [formError, setFormError] = useState('');
    const [isSubmitting, setIsSubmitting] = useState(false);

    // Lấy thông tin user từ context
    const { user } = useUser();

    // Hàm để lấy danh sách reviews
    const fetchReviews = useCallback(async () => {
        try {
            setLoading(true);
            const response = await apiClient.get(`/api/products/${productId}/reviews`);
            setReviews(response.data.data || []); // Dữ liệu từ phân trang nằm trong `data`
        } catch (err) {
            setError('Không thể tải danh sách đánh giá.');
            console.error(err);
        } finally {
            setLoading(false);
        }
    }, [productId]);

    // Gọi fetchReviews khi component được mount hoặc productId thay đổi
    useEffect(() => {
        fetchReviews();
    }, [fetchReviews]);

    // Hàm xử lý gửi form
    const handleSubmit = async (e) => {
        e.preventDefault();
        if (rating === 0) {
            setFormError('Vui lòng chọn số sao đánh giá.');
            return;
        }

        setIsSubmitting(true);
        setFormError('');
        try {
            const payload = { rating, comment };
            await apiClient.post(`/api/products/${productId}/reviews`, payload);

            // Đóng modal bằng cách tìm đến button và click nó
            const closeButton = document.getElementById('closeReviewModalBtn');
            if (closeButton) {
                closeButton.click();
            }

            // Reset form và tải lại danh sách reviews
            setRating(0);
            setComment('');
            fetchReviews();

        } catch (err) {
            setFormError(err.response?.data?.message || 'Đã có lỗi xảy ra.');
            console.error(err);
        } finally {
            setIsSubmitting(false);
        }
    };

    return (
        <div className="container my-5">
            <div className="d-flex justify-content-between align-items-center mb-4">
                <h2 className="h4 fw-bold text-dark mb-0">Đánh giá ({reviews.length})</h2>
                {/* Chỉ hiển thị button khi người dùng đã đăng nhập */}
                {user && (
                    <button
                        className="btn btn-warning text-white fw-semibold"
                        data-bs-toggle="modal"
                        data-bs-target="#reviewModal"
                    >
                        <i className="bi bi-pencil-square me-2"></i> Viết đánh giá
                    </button>
                )}
            </div>

            {/* Hiển thị danh sách reviews */}
            <div className="border rounded-3 p-4 bg-white">
                {loading && <p>Đang tải...</p>}
                {error && <p className="text-danger">{error}</p>}
                {!loading && reviews.length > 0 && (
                    reviews.map(review => <ReviewItem key={review.id} review={review} />)
                )}
                {!loading && reviews.length === 0 && (
                    <p className="text-muted text-center p-3">Chưa có đánh giá nào cho sản phẩm này.</p>
                )}
            </div>

            {/* Modal để viết đánh giá - chỉ dành cho người dùng đã đăng nhập */}
            {user && (
                <div className="modal fade" id="reviewModal" tabIndex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
                    <div className="modal-dialog modal-dialog-centered">
                        <div className="modal-content">
                            <form onSubmit={handleSubmit}>
                                <div className="modal-header">
                                    <h5 className="modal-title" id="reviewModalLabel">Đánh giá của bạn</h5>
                                    <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div className="modal-body">
                                    {formError && <div className="alert alert-danger">{formError}</div>}
                                    <ReviewForm
                                        rating={rating}
                                        setRating={setRating}
                                        comment={comment}
                                        setComment={setComment}
                                    />
                                </div>
                                <div className="modal-footer">
                                    <button type="button" id="closeReviewModalBtn" className="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <button type="submit" className="btn btn-warning text-white" disabled={isSubmitting}>
                                        {isSubmitting ? 'Đang gửi...' : 'Gửi đánh giá'}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
};

export default ReviewCard;