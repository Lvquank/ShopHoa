import React, { useState } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

const ReviewCard = () => {
    const [rating, setRating] = useState(0);
    const [hoverRating, setHoverRating] = useState(0);
    const [review, setReview] = useState('');
    const [name, setName] = useState('');
    const [email, setEmail] = useState('');
    const [saveInfo, setSaveInfo] = useState(false);

    const handleStarClick = (starValue) => {
        setRating(starValue);
    };

    const handleStarHover = (starValue) => {
        setHoverRating(starValue);
    };

    const handleStarLeave = () => {
        setHoverRating(0);
    };

    const handleSubmit = () => {
        console.log({
            rating,
            review,
            name,
            email,
            saveInfo
        });
        // Handle form submission here
    };

    const renderStars = () => {
        return [1, 2, 3, 4, 5].map((star) => (
            <i
                key={star}
                className={`bi bi-star-fill fs-4 me-1 ${star <= (hoverRating || rating) ? 'text-warning' : 'text-secondary'}`}
                style={{ cursor: 'pointer', transition: 'color 0.2s' }}
                onClick={() => handleStarClick(star)}
                onMouseEnter={() => handleStarHover(star)}
                onMouseLeave={handleStarLeave}
            />
        ));
    };

    return (
        <div className="container my-4">
            <div className="mb-4">
                <h2 className="h4 fw-bold text-dark mb-2">Đánh giá</h2>
                <p className="text-muted">Chưa có đánh giá nào.</p>
            </div>

            <div className="border border-2 border-warning rounded-3 p-4 bg-white">
                <h3 className="h6 fw-semibold text-dark mb-4">
                    Hãy là người đầu tiên nhận xét "Đặt hoa bó 20-10"
                </h3>

                <div>
                    <div className="mb-4">
                        <label className="form-label fw-medium">
                            Đánh giá của bạn <span className="text-danger">*</span>
                        </label>
                        <div>{renderStars()}</div>
                    </div>

                    <div className="mb-4">
                        <label className="form-label fw-medium">
                            Nhận xét của bạn <span className="text-danger">*</span>
                        </label>
                        <textarea
                            value={review}
                            onChange={(e) => setReview(e.target.value)}
                            className="form-control"
                            rows={4}
                            placeholder="Viết nhận xét của bạn..."
                        />
                    </div>

                    <div className="row mb-4">
                        <div className="col-md-6 mb-3 mb-md-0">
                            <label className="form-label fw-medium">
                                Tên <span className="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                value={name}
                                onChange={(e) => setName(e.target.value)}
                                className="form-control"
                            />
                        </div>
                        <div className="col-md-6">
                            <label className="form-label fw-medium">
                                Email <span className="text-danger">*</span>
                            </label>
                            <input
                                type="email"
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                                className="form-control"
                            />
                        </div>
                    </div>

                    <div className="form-check mb-4">
                        <input
                            type="checkbox"
                            checked={saveInfo}
                            onChange={(e) => setSaveInfo(e.target.checked)}
                            className="form-check-input"
                            id="saveInfoCheckbox"
                        />
                        <label className="form-check-label text-secondary" htmlFor="saveInfoCheckbox">
                            Lưu tên của tôi, email, và trang web trong trình duyệt này cho lần bình luận kế tiếp của tôi.
                        </label>
                    </div>

                    <button
                        onClick={handleSubmit}
                        className="btn btn-warning text-white fw-semibold px-4 py-2 shadow-sm"
                    >
                        GỬI ĐI
                    </button>
                </div>
            </div>
        </div>
    );
};

export default ReviewCard;