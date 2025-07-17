import { useState } from 'react';
import { Link } from 'react-router-dom';
import { toast } from 'react-toastify';
import '../styles/pages/Login.css';
import googleIcon from '../assets/images/google-icon.svg';
import facebookIcon from '../assets/images/facebook-icon.svg';
import { useUser } from '../context/UserContext';

// CSRF và API logic nên được tách ra để dễ quản lý
const api = {
    getCsrfToken: () => fetch(`${import.meta.env.VITE_API_URL}/sanctum/csrf-cookie`, {
        credentials: 'include'
    }),
    login: (credentials) => fetch(`${import.meta.env.VITE_API_URL}/api/auth/login`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        // credentials: 'include' không cần thiết cho API login với token
        body: JSON.stringify(credentials),
    })
};


function Login() {
    const { login } = useUser();
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
            // CSRF không thực sự cần thiết cho API login/register trả về token,
            // nhưng việc gọi nó cũng không gây hại.
            // await api.getCsrfToken();

            const response = await api.login(formData);
            const data = await response.json();

            if (response.ok) {
                // SỬA LỖI TẠI ĐÂY:
                // Truyền toàn bộ object `data` vào hàm login của context
                // để nó có thể truy cập cả `data.user` và `data.token`.
                login(data);

                toast.success(data.message || 'Đăng nhập thành công!');

                // Đợi toast hiển thị xong rồi chuyển hướng
                setTimeout(() => {
                    window.location.href = '/';
                }, 1000);

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
                                    required
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
                        <a
                            href={`${import.meta.env.VITE_API_URL}/auth/google/redirect`}
                            className="btn rounded-0 mt-3 d-flex align-items-center justify-content-center w-100 social-login py-2"
                        >
                            <img src={googleIcon} width="15" alt="Google" />
                            <span className="ms-2">Đăng nhập bằng Google</span>
                        </a>
                        <a
                            href={`${import.meta.env.VITE_API_URL}/auth/facebook/redirect`}
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