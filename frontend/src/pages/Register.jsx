import { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { toast } from 'react-toastify';
import '../styles/pages/Register.css';
import { getCsrfToken } from '../utils/api';
import googleIcon from '../assets/images/google-icon.svg';
import facebookIcon from '../assets/images/facebook-icon.svg';

// Helper function to get cookie value
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null;
}

function Register() {
    const navigate = useNavigate();
    const [formData, setFormData] = useState({
        username: '',
        email: '',
        phone_number: '', // Changed from phone to phone_number to match API
        password: '',
        confirm_password: '' // Changed from password_confirmation to match API
    });

    const [error, setError] = useState('');

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prevState => ({
            ...prevState,
            [name]: value
        }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            // Get CSRF token before making the register request
            await getCsrfToken();

            const response = await fetch(`${import.meta.env.VITE_API_URL}/api/auth/register`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-XSRF-TOKEN': getCookie('XSRF-TOKEN'),
                },
                credentials: 'include',
                body: JSON.stringify(formData),
            });

            const data = await response.json();

            if (response.ok) {
                toast.success(data.message || 'Đăng ký thành công!');
                // Redirect to home page after successful registration
                navigate('/');
            } else {
                if (data.errors) {
                    // Handle validation errors
                    const errorMessages = Object.values(data.errors).flat();
                    setError(errorMessages.join('\n'));
                    toast.error(errorMessages[0]); // Show first error in toast
                } else {
                    setError(data.message || 'Đăng ký thất bại');
                    toast.error(data.message || 'Đăng ký thất bại');
                }
            }
        } catch (err) {
            setError('Có lỗi xảy ra, vui lòng thử lại sau');
            toast.error('Có lỗi xảy ra, vui lòng thử lại sau');
        }
    };

    return (
        <section className="register-section">
            <div className="container">
                <h1 className="text-center">Đăng ký</h1>
                <div className="row d-flex justify-content-center mt-5">
                    <div className="col-md-6 col-lg-5">
                        <form onSubmit={handleSubmit}>
                            <div className="box-input">
                                <input
                                    className="input-text"
                                    type="text"
                                    placeholder="Username"
                                    name="username"
                                    value={formData.username}
                                    onChange={handleChange}
                                />
                            </div>

                            <div className="row">
                                <div className="col-md-6">
                                    <div className="box-input">
                                        <input
                                            className="input-text"
                                            type="email"
                                            placeholder="Email"
                                            name="email"
                                            value={formData.email}
                                            onChange={handleChange}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="box-input">
                                        <input
                                            className="input-text"
                                            type="tel"
                                            placeholder="Số điện thoại" name="phone_number"
                                            value={formData.phone_number}
                                            onChange={handleChange}
                                        />
                                    </div>
                                </div>
                            </div>

                            <div className="box-input">
                                <input
                                    className="input-text"
                                    type="password"
                                    placeholder="Mật khẩu (tối thiểu 6 kí tự)"
                                    name="password"
                                    value={formData.password}
                                    onChange={handleChange}
                                />
                            </div>

                            <div className="box-input">
                                <input
                                    className="input-text"
                                    type="password"
                                    placeholder="Xác nhận mật khẩu"
                                    name="confirm_password"
                                    value={formData.confirm_password}
                                    onChange={handleChange}
                                />
                                {error && <small className="text-danger d-block">{error}</small>}
                            </div>

                            <button className="btn rounded-0 w-100 btn-register" type="submit">
                                Đăng ký
                            </button>
                        </form>
                        <div className="gach"></div>
                        <Link to="/dang-nhap" className="mb-4" style={{ fontSize: '14px' }}>
                            Bạn đã có tài khoản? Đăng nhập ngay
                        </Link>
                        <a
                            href={`${import.meta.env.VITE_API_URL}/auth/google`}
                            className="btn rounded-0 mt-3 d-flex align-items-center justify-content-center w-100 social-login py-2"
                        >
                            <img src={googleIcon} width="15" alt="Google" />
                            <span className="ms-2">Tiếp tục bằng Google</span>
                        </a>
                        <a
                            href={`${import.meta.env.VITE_API_URL}/auth/facebook`}
                            className="btn rounded-0 mt-3 d-flex align-items-center justify-content-center w-100 social-login py-2"
                        >
                            <img src={facebookIcon} width="15" alt="Facebook" />
                            <span className="ms-2">Tiếp tục bằng Facebook</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    );
}

export default Register;
