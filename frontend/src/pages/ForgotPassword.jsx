// src/components/ForgotPassword.js
import React, { useState } from 'react';
import axios from 'axios';
import Swal from 'sweetalert2';
import 'bootstrap/dist/css/bootstrap.min.css'
import '../styles/pages/ResetPassword.css';
function ForgotPassword() {
    const [email, setEmail] = useState('');
    const [error, setError] = useState('');
    const [isLoading, setIsLoading] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setIsLoading(true);
        setError('');

        try {
            // Gọi API backend của bạn
            const response = await axios.post(`${import.meta.env.VITE_API_URL}/api/auth/forgot-password`, { email });

            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: response.data.message, // "Link đặt lại mật khẩu đã được gửi..."
            });

        } catch (err) {
            const message = err.response?.data?.message || 'Có lỗi xảy ra. Vui lòng thử lại.';
            setError(message); // Hiển thị lỗi bên dưới input
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
        <section className="reset-password py-5">
            <div className="container">
                <h1 className="text-center">Quên mật khẩu</h1>
                <div className="row d-flex justify-content-center mt-5">
                    <div className="col-md-6 col-lg-5">
                        <form onSubmit={handleSubmit}>
                            <div className="mb-3">
                                <input
                                    className="input-text"
                                    style={{ borderRadius: '0' }}
                                    type="email"
                                    placeholder="Nhập email bạn đã đăng kí trước đó"
                                    name="email"
                                    value={email}
                                    onChange={(e) => setEmail(e.target.value)}
                                    required
                                />
                                {error && <small className="text-danger">{error}</small>}
                            </div>

                            <button className="btn rounded-0 w-100 btn-reset-password" type="submit" disabled={isLoading}>
                                {isLoading ? 'Đang gửi...' : 'Gửi Email'}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    );
}

export default ForgotPassword;