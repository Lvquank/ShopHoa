import React, { createContext, useContext, useState, useEffect, useCallback } from 'react';
import apiClient from '../utils/axios';
// SỬA ĐỔI: Import useUser để biết trạng thái đăng nhập
import { useUser } from './UserContext';
// SỬA ĐỔI: Import Cookies để kiểm tra token
import Cookies from 'js-cookie';

const CartContext = createContext();

export const useCart = () => {
    const context = useContext(CartContext);
    if (!context) {
        throw new Error('useCart must be used within a CartProvider');
    }
    return context;
};

export const CartProvider = ({ children }) => {
    const [cartItems, setCartItems] = useState([]);
    const [cartCount, setCartCount] = useState(0);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);

    // Lấy thông tin người dùng từ UserContext
    const { user } = useUser();

    const clearError = () => setError(null);

    const fetchCart = useCallback(async () => {
        // SỬA ĐỔI: Kiểm tra token từ Cookies thay vì localStorage.
        // Mặc dù interceptor đã xử lý, việc kiểm tra này giúp tránh gọi API không cần thiết.
        if (!Cookies.get('authToken')) {
            setCartItems([]);
            setCartCount(0);
            return;
        }

        setLoading(true);
        clearError();
        try {
            const response = await apiClient.get('/api/cart/show');
            setCartItems(response.data.items || []);
            setCartCount(response.data.count || 0);
        } catch (err) {
            const errorMessage = err.response?.data?.message || 'Không thể tải giỏ hàng.';
            // Chỉ hiển thị lỗi nếu không phải lỗi 401 (Unauthenticated)
            if (err.response?.status !== 401) {
                setError(errorMessage);
            }
            console.error('Error fetching cart:', err);
        } finally {
            setLoading(false);
        }
    }, []);

    // SỬA ĐỔI QUAN TRỌNG:
    // useEffect này sẽ theo dõi trạng thái đăng nhập của người dùng.
    useEffect(() => {
        if (user) {
            // Nếu có user (đã đăng nhập), tự động fetch giỏ hàng.
            fetchCart();
        } else {
            // Nếu không có user (đã đăng xuất), xóa sạch dữ liệu giỏ hàng ở phía client.
            setCartItems([]);
            setCartCount(0);
        }
    }, [user, fetchCart]); // Phụ thuộc vào `user` để chạy lại khi đăng nhập/đăng xuất.

    const handleApiResponse = (response) => {
        setCartItems(response.data.items || []);
        setCartCount(response.data.count || 0);
        clearError();
        return response.data;
    };

    const handleApiError = (err, defaultMessage) => {
        const errorMessage = err.response?.data?.message || defaultMessage;
        setError(errorMessage);
        console.error(`Error: ${defaultMessage}`, err);
        throw err; // Ném lỗi ra để component gọi có thể xử lý (ví dụ: hiển thị toast)
    };

    const addToCart = async (productId, quantity = 1) => {
        setLoading(true);
        clearError();
        try {
            const response = await apiClient.post('/api/cart/add', { product_id: productId, quantity });
            return handleApiResponse(response);
        } catch (err) {
            return handleApiError(err, 'Lỗi khi thêm vào giỏ hàng');
        } finally {
            setLoading(false);
        }
    };

    // SỬA ĐỔI: Áp dụng Optimistic Update cho việc cập nhật số lượng
    const updateCartItem = async (productId, quantity) => {
        const originalCartItems = [...cartItems];

        // Cập nhật UI ngay lập tức
        const updatedItems = cartItems
            .map(item => (item.id === productId ? { ...item, quantity } : item))
            .filter(item => item.quantity > 0); // Xóa sản phẩm nếu số lượng là 0

        const newCount = updatedItems.reduce((sum, item) => sum + item.quantity, 0);
        setCartItems(updatedItems);
        setCartCount(newCount);
        clearError();

        try {
            // Gửi yêu cầu đến server trong nền
            const response = await apiClient.post('/api/cart/update', { product_id: productId, quantity });
            // Cập nhật lại state với dữ liệu chính xác từ server để đảm bảo đồng bộ
            setCartItems(response.data.items || []);
            setCartCount(response.data.count || 0);
        } catch (err) {
            // Nếu có lỗi, hoàn tác lại thay đổi trên UI
            handleApiError(err, 'Lỗi khi cập nhật giỏ hàng');
            setCartItems(originalCartItems);
            const originalCount = originalCartItems.reduce((sum, item) => sum + item.quantity, 0);
            setCartCount(originalCount);
        }
    };

    // SỬA ĐỔI: Áp dụng Optimistic Update cho việc xóa sản phẩm
    const removeFromCart = async (productId) => {
        const originalCartItems = [...cartItems];

        // Cập nhật UI ngay lập tức
        const updatedItems = cartItems.filter(item => item.id !== productId);
        const newCount = updatedItems.reduce((sum, item) => sum + item.quantity, 0);
        setCartItems(updatedItems);
        setCartCount(newCount);
        clearError();

        try {
            // Gửi yêu cầu đến server trong nền
            const response = await apiClient.post('/api/cart/remove', { product_id: productId });
            // Cập nhật lại state với dữ liệu chính xác từ server
            setCartItems(response.data.items || []);
            setCartCount(response.data.count || 0);
        } catch (err) {
            // Nếu có lỗi, hoàn tác lại thay đổi trên UI
            handleApiError(err, 'Lỗi khi xóa sản phẩm');
            setCartItems(originalCartItems);
            const originalCount = originalCartItems.reduce((sum, item) => sum + item.quantity, 0);
            setCartCount(originalCount);
        }
    };

    return (
        <CartContext.Provider value={{
            cartItems,
            cartCount,
            loading,
            error,
            clearError,
            addToCart,
            updateCartItem,
            removeFromCart,
            fetchCart // Vẫn cung cấp fetchCart để có thể gọi thủ công nếu cần
        }}>
            {children}
        </CartContext.Provider>
    );
};
