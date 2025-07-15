import { useState } from 'react';
import { Link } from 'react-router-dom';
import { toast } from 'react-toastify';
import '../styles/pages/Register.css';
import googleIcon from '../assets/images/google-icon.svg';
import facebookIcon from '../assets/images/facebook-icon.svg';

function Register() {
    const [formData, setFormData] = useState({
        username: '',
        email: '',
        phone: '',
        password: '',
        password_confirmation: ''
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
            const response = await fetch(`${import.meta.env.VITE_API_URL}/api/register`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData),
            });

            const data = await response.json();

            if (data.success) {
                toast.success('Đăng ký thành công!');
                // Handle successful registration (redirect, etc.)
            } else {
                setError(data.message || 'Đăng ký thất bại');
                toast.error(data.message || 'Đăng ký thất bại');
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
                                            placeholder="Số điện thoại"
                                            name="phone"
                                            value={formData.phone}
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
                                    name="password_confirmation"
                                    value={formData.password_confirmation}
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
