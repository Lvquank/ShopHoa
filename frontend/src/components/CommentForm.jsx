import React, { useState } from 'react';

export default function CommentForm() {
    const [formData, setFormData] = useState({
        comment: '',
        name: '',
        email: '',
        website: '',
        saveInfo: false
    });

    const handleInputChange = (e) => {
        const { name, value, type, checked } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: type === 'checkbox' ? checked : value
        }));
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        console.log('Form data:', formData);
        // Xử lý submit form ở đây
    };

    return (
        <div className="p-4 bg-light rounded shadow">
            <h4 className="mb-3">Để lại một bình luận</h4>
            <p className="text-muted mb-4">
                Email của bạn sẽ không được hiển thị công khai. Các trường bắt buộc được đánh dấu *
            </p>

            <div onSubmit={handleSubmit}>
                {/* Comment textarea */}
                <div className="mb-3">
                    <label className="form-label fw-bold">
                        Bình luận <span className="text-danger">*</span>
                    </label>
                    <textarea
                        className="form-control"
                        name="comment"
                        rows="6"
                        value={formData.comment}
                        onChange={handleInputChange}
                        required
                    ></textarea>
                </div>

                {/* Name, Email, Website row */}
                <div className="row mb-3">
                    <div className="col-md-4 mb-3">
                        <label className="form-label fw-bold">
                            Tên <span className="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            className="form-control"
                            name="name"
                            value={formData.name}
                            onChange={handleInputChange}
                            required
                        />
                    </div>

                    <div className="col-md-4 mb-3">
                        <label className="form-label fw-bold">
                            Email <span className="text-danger">*</span>
                        </label>
                        <input
                            type="email"
                            className="form-control"
                            name="email"
                            value={formData.email}
                            onChange={handleInputChange}
                            required
                        />
                    </div>

                    <div className="col-md-4 mb-3">
                        <label className="form-label fw-bold">
                            Trang web
                        </label>
                        <input
                            type="url"
                            className="form-control"
                            name="website"
                            value={formData.website}
                            onChange={handleInputChange}
                        />
                    </div>
                </div>

                {/* Checkbox */}
                <div className="mb-4">
                    <div className="form-check">
                        <input
                            className="form-check-input"
                            type="checkbox"
                            name="saveInfo"
                            checked={formData.saveInfo}
                            onChange={handleInputChange}
                        />
                        <label className="form-check-label">
                            Lưu tên của tôi, email, và trang web trong trình duyệt này cho lần bình luận kế tiếp của tôi.
                        </label>
                    </div>
                </div>

                {/* Submit button */}
                <button
                    type="button"
                    className="btn text-white fw-bold px-4 py-2"
                    style={{ backgroundColor: '#ff5722', border: 'none' }}
                    onClick={handleSubmit}
                >
                    GỬI BÌNH LUẬN
                </button>
            </div>
        </div>
    );
}