// src/components/ResetPassword.js
import React, { useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import axios from 'axios';
import Swal from 'sweetalert2';
import '../styles/pages/ResetPassword.css';
function ResetPassword() {
    // Lấy token từ URL, ví dụ: /reset-password/your-token
    const { token } = useParams();
    const navigate = useNavigate();

    const [password, setPassword] = useState('');
    const [confirmPassword, setConfirmPassword] = useState('');
    const [errors, setErrors] = useState({});
    const [isLoading, setIsLoading] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setIsLoading(true);
        setErrors({});

        if (password !== confirmPassword) {
            setErrors({ confirm_password: 'Mật khẩu xác nhận không khớp.' });
            setIsLoading(false);
            return;
        }

        try {
            // Gọi API backend với token và mật khẩu mới
            const response = await axios.post(`${import.meta.env.VITE_API_URL}/api/auth/reset-password`, {
                token,
                password,
                password_confirmation: confirmPassword,
            });

            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: response.data.message,
            }).then(() => {
                navigate('/login'); // Chuyển hướng đến trang đăng nhập sau khi thành công
            });

        } catch (err) {
            const apiErrors = err.response?.data?.errors || {};
            const message = err.response?.data?.message || 'Có lỗi xảy ra. Token có thể không hợp lệ hoặc đã hết hạn.';
            setErrors(apiErrors);
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: message,
            });
        } finally {
            setIsLoading(false);
        }
    };

    return (
        <section className="reset-passwrod py-5">
            <div className="container">
                <h1 className="text-center">Đặt lại mật khẩu</h1>
                <div className="row d-flex justify-content-center mt-5">
                    <div className="col-md-6 col-lg-5">
                        <form onSubmit={handleSubmit}>
                            <div className="box-input mb-3">
                                <input
                                    className="input-text"
                                    type="password"
                                    placeholder="Nhập mật khẩu mới"
                                    name="password"
                                    value={password}
                                    onChange={(e) => setPassword(e.target.value)}
                                    required
                                />
                                {errors.password && <small className="text-danger">{errors.password[0]}</small>}
                            </div>
                            <div className="box-input mb-3">
                                <input
                                    className="input-text"
                                    type="password"
                                    placeholder="Xác nhận mật khẩu mới"
                                    name="confirm_password"
                                    value={confirmPassword}
                                    onChange={(e) => setConfirmPassword(e.target.value)}
                                    required
                                />
                                {errors.confirm_password && <small className="text-danger">{errors.confirm_password}</small>}
                            </div>

                            <button className="btn rounded-0 w-100 btn-reset-password" type="submit" disabled={isLoading}>
                                {isLoading ? 'Đang xử lý...' : 'Xác nhận'}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    );
}

export default ResetPassword;