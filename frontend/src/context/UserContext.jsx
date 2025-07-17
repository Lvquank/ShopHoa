import { createContext, useState, useContext, useEffect } from 'react';
import Cookies from 'js-cookie';

const UserContext = createContext();

// Custom hook để quản lý logic authentication
function useAuth() {
    const [user, setUser] = useState(null); // Chỉ cần một state cho user là đủ

    // Effect này chạy một lần duy nhất khi component được mount
    useEffect(() => {
        const userInfoCookie = Cookies.get('userInfo');
        const authToken = Cookies.get('authToken');

        // Nếu có thông tin user trong cookie, hãy tạm thời tin tưởng và set state
        // để người dùng thấy giao diện đã đăng nhập ngay lập tức.
        if (userInfoCookie && authToken) {
            try {
                const parsedUserInfo = JSON.parse(userInfoCookie);
                setUser(parsedUserInfo);
            } catch (error) {
                console.error("Failed to parse user info from cookie", error);
                // Nếu cookie hỏng, xóa hết đi
                logout();
            }
        }
    }, []);

    // Hàm login, nhận response từ API
    const login = (response) => {
        if (!response || !response.user || !response.token) {
            console.error('Invalid login response format', response);
            return;
        }

        const { user: userData, token } = response;

        // 1. LƯU THÔNG TIN USER VÀO COOKIES
        Cookies.set('userInfo', JSON.stringify(userData), { expires: 7, path: '/', sameSite: 'Lax' });

        // 2. LƯU TOKEN VÀO COOKIES - ĐÂY LÀ BƯỚC QUAN TRỌNG NHẤT
        Cookies.set('authToken', token, { expires: 7, path: '/', sameSite: 'Lax' });

        // Cập nhật state của ứng dụng
        setUser(userData);
    };

    // Hàm logout
    const logout = () => {
        // LẤY TOKEN TỪ COOKIES ĐỂ GỬI LÊN SERVER (nếu cần)
        const authToken = Cookies.get('authToken');

        // Gọi API logout ở backend
        // Backend sẽ dựa vào token này để biết cần vô hiệu hóa token nào
        if (authToken) {
            fetch(`${import.meta.env.VITE_API_URL}/api/auth/logout`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    // THÊM TOKEN VÀO HEADER
                    'Authorization': `Bearer ${authToken}`
                },
            }).catch(error => console.error("Logout API call failed, but logging out on client anyway.", error));
        }

        // Xóa cookies ở phía client
        Cookies.remove('authToken');
        Cookies.remove('userInfo');

        // Reset state
        setUser(null);

        // Chuyển hướng về trang đăng nhập (tùy chọn)
        // window.location.href = '/login';
    };

    // Hàm kiểm tra xác thực với backend (ví dụ: khi F5 trang)
    // Bạn có thể gọi hàm này trong một useEffect khác nếu cần kiểm tra định kỳ
    const verifyAuthOnServer = async () => {
        const authToken = Cookies.get('authToken');
        if (!authToken) {
            // Nếu không có token thì không cần kiểm tra
            return;
        }

        try {
            const response = await fetch(`${import.meta.env.VITE_API_URL}/api/auth/check`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    // THÊM TOKEN VÀO HEADER
                    'Authorization': `Bearer ${authToken}`
                }
            });

            if (!response.ok) {
                // Nếu token không hợp lệ (ví dụ: hết hạn, đã bị xóa)
                // thì đăng xuất ở client
                if (response.status === 401) {
                    console.log('Session expired on server. Logging out.');
                    logout();
                }
                throw new Error('Auth check failed');
            }

            // Nếu thành công, có thể cập nhật lại thông tin user nếu cần
            const data = await response.json();
            setUser(data.user);
            Cookies.set('userInfo', JSON.stringify(data.user), { expires: 7, path: '/', sameSite: 'Lax' });

        } catch (error) {
            console.error('Error during auth check:', error);
        }
    };

    // Ví dụ: kiểm tra lại với server mỗi khi tab trình duyệt được focus lại
    useEffect(() => {
        window.addEventListener('focus', verifyAuthOnServer);
        return () => {
            window.removeEventListener('focus', verifyAuthOnServer);
        }
    }, []);


    return { user, login, logout };
}

export function UserProvider({ children }) {
    const auth = useAuth();

    return (
        <UserContext.Provider value={{
            user: auth.user,
            // Lấy role trực tiếp từ object user
            role: auth.user?.role_id,
            userInfo: auth.user, // userInfo và user bây giờ là một
            login: auth.login,
            logout: auth.logout
        }}>
            {children}
        </UserContext.Provider>
    );
}

export function useUser() {
    const context = useContext(UserContext);
    if (context === undefined) {
        throw new Error('useUser must be used within a UserProvider');
    }
    return context;
}
