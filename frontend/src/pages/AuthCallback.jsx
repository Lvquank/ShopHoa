import { useEffect } from 'react';
import { useNavigate, useSearchParams } from 'react-router-dom';
import { useUser } from '../contexts/UserContext';
import { toast } from 'react-toastify';

function AuthCallback() {
    const [searchParams] = useSearchParams();
    const navigate = useNavigate();
    const { login } = useUser();

    useEffect(() => {
        const handleCallback = async () => {
            const token = searchParams.get('token');
            const error = searchParams.get('error');
            const userData = searchParams.get('user');

            if (error) {
                toast.error(decodeURIComponent(error));
                navigate('/login');
                return;
            }

            if (token) {
                try {
                    // Parse user data nếu có
                    let user = null;
                    if (userData) {
                        try {
                            user = JSON.parse(decodeURIComponent(userData));
                        } catch (e) {
                            console.error('Error parsing user data:', e);
                        }
                    }

                    // Log để debug
                    console.log('Token received:', token);
                    console.log('User data received:', user);

                    // Login với token và user data
                    login({
                        token: token,
                        user: user
                    });

                    toast.success('Đăng nhập thành công!');
                    navigate('/');
                } catch (err) {
                    console.error('Login error:', err);
                    toast.error('Có lỗi xảy ra khi xử lý đăng nhập');
                    navigate('/login');
                }
            } else {
                navigate('/login');
            }
        };

        handleCallback();
    }, [searchParams, navigate, login]);

    return (
        <div className="d-flex justify-content-center align-items-center min-vh-100">
            <div className="spinner-border text-primary" role="status">
                <span className="visually-hidden">Đang xử lý...</span>
            </div>
        </div>
    );
}

export default AuthCallback;
