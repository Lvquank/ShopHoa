import { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { toast } from 'react-toastify';
// THÊM: Import hook từ thư viện Google OAuth
import { useGoogleLogin } from '@react-oauth/google';

import '../styles/pages/Login.css';
import googleIcon from '../assets/images/google-icon.svg';
import facebookIcon from '../assets/images/facebook-icon.svg';
import { useUser } from '../context/UserContext';

// Tách logic API ra
const api = {
    login: (credentials) => fetch(`${import.meta.env.VITE_API_URL}/api/auth/login`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify(credentials),
    }),

    // THÊM: Hàm gọi API backend với Google access token
    loginWithGoogle: (accessToken) => fetch(`${import.meta.env.VITE_API_URL}/api/auth/google/callback`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ access_token: accessToken }),
    }),

    // Sửa lại hàm xử lý response cho đúng với cấu trúc API trả về
    handleLoginResponse: (data) => {
        console.log('Response data from API:', data);

        // Kiểm tra nếu response có status true, có access_token và có data user
        if (data && data.status === true && data.access_token && data.data) {
            return {
                token: data.access_token,
                user: data.data
            };
        }
        throw new Error('Invalid login response format: ' + JSON.stringify(data));
    }
};


function Login() {
    const { login } = useUser();
    const navigate = useNavigate();
    const [formData, setFormData] = useState({
        email: '',
        password: ''
    });

    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prevState => ({
            ...prevState,
            [name]: value
        }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        setError('');

        try {
            const response = await api.login(formData);
            const data = await response.json();

            if (response.ok && data.status === true) {
                const loginData = api.handleLoginResponse(data);
                login(loginData);
                toast.success('Đăng nhập thành công!');
                navigate('/');
            } else {
                setError(data.message || 'Email hoặc mật khẩu không đúng.');
                toast.error(data.message || 'Email hoặc mật khẩu không đúng.');
            }
        } catch (err) {
            console.error('Login error:', err);
            setError('Có lỗi xảy ra, vui lòng thử lại sau.');
            toast.error('Có lỗi xảy ra, vui lòng thử lại sau.');
        } finally {
            setLoading(false);
        }
    };

    // THÊM: Xử lý logic đăng nhập Google
    const handleGoogleLogin = useGoogleLogin({
        // Callback khi đăng nhập Google thành công
        onSuccess: async (tokenResponse) => {
            setLoading(true);
            try {
                // Gọi API backend của bạn với access_token từ Google
                const response = await api.loginWithGoogle(tokenResponse.access_token);
                const data = await response.json();

                if (response.ok && data.status === true) {
                    // Xử lý response từ backend
                    const loginData = api.handleLoginResponse(data);
                    login(loginData); // Cập nhật context
                    toast.success(data.message || 'Đăng nhập bằng Google thành công!');
                    navigate('/'); // Chuyển hướng về trang chủ
                } else {
                    toast.error(data.message || 'Đăng nhập bằng Google thất bại.');
                }
            } catch (error) {
                console.error('Google login backend error:', error);
                toast.error('Không thể xác thực với máy chủ.');
            } finally {
                setLoading(false);
            }
        },
        // Callback khi có lỗi xảy ra
        onError: (error) => {
            console.error('Google Login Failed:', error);
            toast.error('Đăng nhập bằng Google thất bại. Vui lòng thử lại.');
        },
    });


    return (
        <section className="login-section">
            <div className="container">
                <h1 className="text-center">Đăng nhập</h1>
                <div className="row d-flex justify-content-center mt-5">
                    <div className="col-md-6 col-lg-5">
                        <form onSubmit={handleSubmit}>
                            {/* Form đăng nhập thông thường */}
                            <div className="box-input">
                                <input
                                    className="input-text"
                                    type="email"
                                    placeholder="Email"
                                    name="email"
                                    value={formData.email}
                                    onChange={handleChange}
                                    required
                                    disabled={loading}
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
                                    required
                                    disabled={loading}
                                />
                                {error && <small className="text-danger d-block mt-1">{error}</small>}
                            </div>
                            <button className="btn rounded-0 w-100 btn-login" type="submit" disabled={loading}>
                                {loading ? 'Đang xử lý...' : 'Đăng nhập'}
                            </button>
                        </form>
                        <div className="gach"></div>
                        <Link to="/quen-mat-khau" className="mb-2" style={{ fontSize: '14px' }}>
                            Quên mật khẩu?
                        </Link>
                        <Link to="/dang-ky" className="mb-4" style={{ fontSize: '14px' }}>
                            Bạn chưa có tài khoản? Đăng ký ngay
                        </Link>

                        {/* Sửa lại nút đăng nhập Google để gọi hàm xử lý phía client */}
                        <button
                            onClick={() => handleGoogleLogin()} // Gọi hàm đã được tạo bởi hook
                            disabled={loading}
                            className="btn rounded-0 mt-3 d-flex align-items-center justify-content-center w-100 social-login py-2"
                        >
                            <img src={googleIcon} width="15" alt="Google" />
                            <span className="ms-2">Đăng nhập bằng Google</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    );
}

export default Login;