import React, { useState, useEffect } from 'react';
import axios from 'axios'; // Cần cài đặt: npm install axios
import Cookies from 'js-cookie'; // Cần cài đặt: npm install js-cookie
import { useUser } from '../contexts/UserContext'; // Sửa lại đường dẫn đến file UserContext của bạn

const API_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000';

export default function CommentForm({ postId }) {
    // Lấy thông tin user từ context
    const { user } = useUser();

    // State cho dữ liệu form
    const [formData, setFormData] = useState({
        comment: '',
        name: '',
        email: '',
        website: '',
    });

    // State để quản lý quá trình submit
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);
    const [success, setSuccess] = useState('');

    // Tự động điền thông tin user vào form khi đã đăng nhập
    useEffect(() => {
        if (user) {
            setFormData(prev => ({
                ...prev,
                name: user.username || '', // Giả sử tên user lưu trong 'username'
                email: user.email || ''
            }));
        }
    }, [user]); // Chạy lại effect khi user thay đổi

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();

        // Reset trạng thái
        setLoading(true);
        setError(null);
        setSuccess('');

        // Lấy token xác thực từ Cookies
        const token = Cookies.get('authToken');
        if (!token) {
            setError('Bạn cần đăng nhập để bình luận.');
            setLoading(false);
            return;
        }

        try {
            // Dữ liệu gửi đi
            const payload = {
                post_id: postId,
                comment: formData.comment,
                name: formData.name,
                email: formData.email,
                website: formData.website,
            };

            // Gọi API
            const response = await axios.post(`${API_URL}/api/post-reviews`, payload, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            // Xử lý khi thành công
            if (response.data.success) {
                setSuccess('Bình luận của bạn đã được gửi thành công!');
                // Reset ô bình luận, giữ lại tên và email
                setFormData(prev => ({
                    ...prev,
                    comment: ''
                }));
            }

        } catch (err) {
            console.error('Lỗi khi gửi bình luận:', err);
            if (err.response && err.response.status === 422) {
                // Lỗi validation từ Laravel
                const validationErrors = err.response.data.errors;
                const firstError = Object.values(validationErrors)[0][0];
                setError(firstError || 'Dữ liệu không hợp lệ.');
            } else {
                setError('Đã có lỗi xảy ra. Vui lòng thử lại.');
            }
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="p-4 bg-light rounded">
            <h4 className="mb-3">Để lại một bình luận</h4>
            <p className="text-muted mb-4">
                Email của bạn sẽ không được hiển thị công khai. Các trường bắt buộc được đánh dấu *
            </p>

            <form onSubmit={handleSubmit}>
                {/* Hiển thị thông báo lỗi hoặc thành công */}
                {error && <div className="alert alert-danger">{error}</div>}
                {success && <div className="alert alert-success">{success}</div>}

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
                        disabled={loading}
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
                            disabled={loading}
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
                            disabled={loading}
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
                            disabled={loading}
                        />
                    </div>
                </div>

                {/* Submit button */}
                <button
                    type="submit"
                    className="btn text-white fw-bold px-4 py-2"
                    style={{ backgroundColor: '#ff5722', border: 'none' }}
                    disabled={loading}
                >
                    {loading ? 'ĐANG GỬI...' : 'GỬI BÌNH LUẬN'}
                </button>
            </form>
        </div>
    );
}
