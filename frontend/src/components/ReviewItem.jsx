// src/components/ReviewItem.jsx
import React from 'react';

// Hàm để render các ngôi sao dựa trên rating
const renderStars = (rating) => {
    return [...Array(5)].map((_, index) => (
        <i
            key={index}
            className={`bi bi-star-fill fs-6 me-1 ${index < rating ? 'text-warning' : 'text-secondary'}`}
        />
    ));
};

const ReviewItem = ({ review }) => {
    return (
        <div className="d-flex mb-4">
            <div className="flex-shrink-0">
                {/* Giả sử user có trường 'avatar', nếu không có thể dùng icon mặc định */}
                <img
                    src={review.user.avatar || 'https://via.placeholder.com/50'}
                    alt={review.user.name}
                    className="rounded-circle"
                    style={{ width: '50px', height: '50px', objectFit: 'cover' }}
                />
            </div>
            <div className="ms-3 flex-grow-1">
                <div className="d-flex align-items-center mb-1">
                    <h6 className="fw-bold text-dark mb-0 me-2">{review.user.name}</h6>
                    <div className="text-muted" style={{ fontSize: '0.8rem' }}>
                        {new Date(review.created_at).toLocaleDateString('vi-VN')}
                    </div>
                </div>
                <div>{renderStars(review.rating)}</div>
                <p className="text-secondary mt-2 mb-0">{review.comment}</p>
            </div>
        </div>
    );
};

export default ReviewItem;