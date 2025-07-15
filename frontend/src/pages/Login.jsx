import { useState } from 'react';
import { Link } from 'react-router-dom';
import { toast } from 'react-toastify';
import '../styles/pages/Login.css';
import googleIcon from '../assets/images/google-icon.svg';
import facebookIcon from '../assets/images/facebook-icon.svg';

function Login() {
    const [formData, setFormData] = useState({
        email: '',
        password: ''
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
            // API call will go here
            const response = await fetch(`${import.meta.env.VITE_API_URL}/api/login`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData),
            });

            const data = await response.json();

            if (data.success) {
                toast.success('Đăng nhập thành công!');
                // Handle successful login (redirect, etc.)
            } else {
                setError(data.message || 'Đăng nhập thất bại');
                toast.error(data.message || 'Đăng nhập thất bại');
            }
        } catch (err) {
            setError('Có lỗi xảy ra, vui lòng thử lại sau');
            toast.error('Có lỗi xảy ra, vui lòng thử lại sau');
        }
    };

    return (
        <section className="login-section">
            <div className="container">
                <h1 className="text-center">Đăng nhập</h1>
                <div className="row d-flex justify-content-center mt-5">
                    <div className="col-md-6 col-lg-5">
                        <form onSubmit={handleSubmit}>
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

                            <div className="box-input">
                                <input
                                    className="input-text"
                                    type="password"
                                    placeholder="Mật khẩu"
                                    name="password"
                                    value={formData.password}
                                    onChange={handleChange}
                                />
                                {error && <small className="text-danger d-block">{error}</small>}
                            </div>

                            <button className="btn rounded-0 w-100 btn-login" type="submit">
                                Đăng nhập
                            </button>
                        </form>
                        <div className="gach"></div>
                        <Link to="/quen-mat-khau" className="mb-2" style={{ fontSize: '14px' }}>
                            Quên mật khẩu?
                        </Link>
                        <Link to="/dang-ky" className="mb-4" style={{ fontSize: '14px' }}>
                            Bạn chưa có tài khoản? Đăng ký ngay
                        </Link>
                        <a
                            href={`${import.meta.env.VITE_API_URL}/auth/google`}
                            className="btn rounded-0 mt-3 d-flex align-items-center justify-content-center w-100 social-login py-2"
                        >
                            <img src={googleIcon} width="15" alt="Google" />
                            <span className="ms-2">Đăng nhập bằng Google</span>
                        </a>
                        <a
                            href={`${import.meta.env.VITE_API_URL}/auth/facebook`}
                            className="btn rounded-0 mt-3 d-flex align-items-center justify-content-center w-100 social-login py-2"
                        >
                            <img src={facebookIcon} width="15" alt="Facebook" />
                            <span className="ms-2">Đăng nhập bằng Facebook</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    );
}

export default Login;
