import { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { toast } from 'react-toastify';
import '../styles/pages/Register.css';
import googleIcon from '../assets/images/google-icon.svg';
import facebookIcon from '../assets/images/facebook-icon.svg';

// API call logic can be kept separate for better management
const api = {
    register: (formData) => {
        return fetch(`${import.meta.env.VITE_API_URL}/api/auth/register`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(formData),
        });
    }
};

function Register() {
    const navigate = useNavigate();
    const [formData, setFormData] = useState({
        username: '',
        email: '',
        phone_number: '',
        password: '',
        // SỬA LỖI: Tên trường phải là 'password_confirmation' để khớp với Laravel
        password_confirmation: ''
    });

    const [errors, setErrors] = useState({});
    const [loading, setLoading] = useState(false);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prevState => ({
            ...prevState,
            [name]: value
        }));
        // Xóa lỗi khi người dùng bắt đầu nhập lại
        if (errors[name]) {
            setErrors(prevErrors => ({ ...prevErrors, [name]: null }));
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        setErrors({}); // Xóa lỗi cũ

        try {
            const response = await api.register(formData);
            const data = await response.json();

            if (response.ok) {
                // THÊM: Thông báo thành công và chuyển hướng đến trang đăng nhập
                toast.success(data.message || 'Đăng ký thành công! Vui lòng đăng nhập.');
                navigate('/login'); // Chuyển hướng đến trang đăng nhập
            } else {
                if (data.errors) {
                    // Xử lý lỗi validation từ server
                    setErrors(data.errors);
                    toast.error('Vui lòng kiểm tra lại thông tin đã nhập.');
                } else {
                    // Xử lý các lỗi khác
                    toast.error(data.message || 'Đăng ký thất bại, vui lòng thử lại.');
                }
            }
        } catch (err) {
            console.error("Register error:", err);
            toast.error('Có lỗi xảy ra, không thể kết nối đến máy chủ.');
        } finally {
            setLoading(false);
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
                                    className={`input-text ${errors.username ? 'is-invalid' : ''}`}
                                    type="text"
                                    placeholder="Tên người dùng"
                                    name="username"
                                    value={formData.username}
                                    onChange={handleChange}
                                />
                                {errors.username && <small className="text-danger">{errors.username[0]}</small>}
                            </div>

                            {/* SỬA LỖI LAYOUT: Đặt Email và Số điện thoại vào trong một row */}
                            <div className="row">
                                <div className="col-md-6">
                                    <div className="box-input">
                                        <input
                                            className={`input-text ${errors.email ? 'is-invalid' : ''}`}
                                            type="email"
                                            placeholder="Email"
                                            name="email"
                                            value={formData.email}
                                            onChange={handleChange}
                                        />
                                        {errors.email && <small className="text-danger">{errors.email[0]}</small>}
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="box-input">
                                        <input
                                            className={`input-text ${errors.phone_number ? 'is-invalid' : ''}`}
                                            type="tel"
                                            placeholder="Số điện thoại"
                                            name="phone_number"
                                            value={formData.phone_number}
                                            onChange={handleChange}
                                        />
                                        {errors.phone_number && <small className="text-danger">{errors.phone_number[0]}</small>}
                                    </div>
                                </div>
                            </div>

                            <div className="box-input">
                                <input
                                    className={`input-text ${errors.password ? 'is-invalid' : ''}`}
                                    type="password"
                                    placeholder="Mật khẩu (tối thiểu 6 kí tự)"
                                    name="password"
                                    value={formData.password}
                                    onChange={handleChange}
                                />
                                {errors.password && <small className="text-danger">{errors.password[0]}</small>}
                            </div>

                            <div className="box-input">
                                <input
                                    className="input-text"
                                    type="password"
                                    placeholder="Xác nhận mật khẩu"
                                    name="password_confirmation" // Tên này phải khớp với state
                                    value={formData.password_confirmation}
                                    onChange={handleChange}
                                />
                            </div>

                            <button className="btn rounded-0 w-100 btn-register" type="submit" disabled={loading}>
                                {loading ? 'Đang xử lý...' : 'Đăng ký'}
                            </button>
                        </form>
                        <div className="gach"></div>
                        <Link to="/login" className="mb-4" style={{ fontSize: '14px' }}>
                            Bạn đã có tài khoản? Đăng nhập ngay
                        </Link>
                        {/* Lưu ý: Luồng đăng nhập bằng MXH cho SPA cần xử lý phía client */}
                        <button className="btn rounded-0 mt-3 d-flex align-items-center justify-content-center w-100 social-login py-2">
                            <img src={googleIcon} width="15" alt="Google" />
                            <span className="ms-2">Tiếp tục bằng Google</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    );
}

export default Register;
