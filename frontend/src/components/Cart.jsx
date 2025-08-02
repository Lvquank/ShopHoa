import React, { useEffect, useRef } from 'react';
import { useNavigate } from 'react-router-dom';
import { useCart } from '../contexts/CartContext';
import '../styles/components/Cart.css';

const Cart = () => {
    const { cartItems, loading, error, fetchCart, updateCartItem, removeFromCart, clearError } = useCart();
    const navigate = useNavigate();
    const offcanvasRef = useRef(null); // Chỉ cần ref để tham chiếu đến element

    // ✅ SỬA ĐỔI: useEffect duy nhất để xử lý việc đóng offcanvas
    useEffect(() => {
        const handleOutsideClick = (event) => {
            const offcanvasElement = offcanvasRef.current;
            // Kiểm tra nếu offcanvas đang mở và người dùng click ra ngoài nó
            if (offcanvasElement && offcanvasElement.classList.contains('show') && !offcanvasElement.contains(event.target)) {
                // Tìm nút close bên trong offcanvas
                const closeButton = offcanvasElement.querySelector('[data-bs-dismiss="offcanvas"]');
                // Nếu tìm thấy, thực hiện một cú click ảo
                if (closeButton) {
                    closeButton.click();
                }
            }
        };

        document.addEventListener('mousedown', handleOutsideClick);
        return () => {
            document.removeEventListener('mousedown', handleOutsideClick);
        };
    }, []); // Chỉ cần chạy 1 lần

    useEffect(() => {
        fetchCart();
    }, [fetchCart]);

    const handleQuantityChange = async (productId, newQuantity) => {
        if (newQuantity < 1) return;
        await updateCartItem(productId, newQuantity);
    };

    const handleRemoveItem = async (productId) => {
        await removeFromCart(productId);
    };

    // Sửa lại handleNavigate để đơn giản hơn
    const handleNavigate = (path) => {
        const closeButton = offcanvasRef.current?.querySelector('[data-bs-dismiss="offcanvas"]');
        if (closeButton) {
            closeButton.click();
        }
        // Thêm độ trễ nhỏ để animation kịp chạy
        setTimeout(() => {
            navigate(path);
        }, 150);
    };

    const formatPrice = (price) => {
        if (price == null) return '0 ₫';
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(price);
    };

    const total = cartItems.reduce((sum, item) => sum + item.price * item.quantity, 0);

    return (
        <div ref={offcanvasRef} className="offcanvas offcanvas-end" data-bs-scroll="true" tabIndex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
            <div className="offcanvas-header border-bottom">
                <h5 className="offcanvas-title fw-bold" id="offcanvasCartLabel">GIỎ HÀNG</h5>
                {/* Đây chính là nút Close mà chúng ta đang "nhờ" */}
                <button type="button" className="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div className="offcanvas-body d-flex flex-column">
                {/* ... Toàn bộ phần JSX render bên trong không thay đổi ... */}
                {error && (
                    <div className="alert alert-danger d-flex align-items-center" role="alert">
                        {error}
                        <button type="button" className="btn-close ms-auto" onClick={clearError} aria-label="Close"></button>
                    </div>
                )}
                {loading ? (
                    <div className="d-flex flex-column align-items-center justify-content-center h-100">
                        <div className="spinner-border text-primary" role="status">
                            <span className="visually-hidden">Đang tải...</span>
                        </div>
                        <p className="mt-2 text-muted">Đang cập nhật giỏ hàng...</p>
                    </div>
                ) : cartItems.length === 0 ? (
                    <div className="d-flex flex-column align-items-center justify-content-center h-100 text-center">
                        <i className="bi bi-cart-x text-primary" style={{ fontSize: '4rem' }}></i>
                        <p className="mt-3 fs-5 text-muted">Giỏ hàng của bạn đang trống</p>
                        <button
                            type="button"
                            className="btn btn-primary mt-2"
                            onClick={() => handleNavigate('/cua-hang')}
                        >
                            <i className="bi bi-shop me-2"></i>
                            Bắt đầu mua sắm
                        </button>
                    </div>
                ) : (
                    <div className="flex-grow-1">
                        <ul className="list-group list-group-flush">
                            {cartItems.map((item) => (
                                <li key={item.id} className="list-group-item px-0 py-3 cart-item">
                                    <div className="d-flex align-items-center">
                                        <img
                                            src={
                                                (item.image_url || item.image)
                                                    ? `${import.meta.env.VITE_API_URL.replace(/\/$/, '')}/${(item.image_url || item.image).replace(/^\//, '')}`
                                                    : '/placeholder.jpg'
                                            }
                                            alt={item.name}
                                            className="rounded border"
                                            style={{ width: '80px', height: '80px', objectFit: 'cover', cursor: 'pointer' }}
                                            onClick={() => handleNavigate(`/cua-hang/${item.product_alias}`)}
                                        />
                                        <div className="ms-3 flex-grow-1">
                                            <div className="d-flex justify-content-between align-items-start">
                                                <a href={`/cua-hang/${item.product_alias}`} onClick={(e) => { e.preventDefault(); handleNavigate(`/cua-hang/${item.product_alias}`) }} className="fw-bold cart-item-name mb-1">
                                                    {item.name}
                                                </a>
                                                <button className="btn btn-link p-0 btn-remove-item" onClick={() => handleRemoveItem(item.id)}>
                                                    <i className="bi bi-trash-fill"></i>
                                                </button>
                                            </div>
                                            <p className="text-muted small mb-2">{formatPrice(item.price)}</p>
                                            <div className="d-flex justify-content-between align-items-center">
                                                <div className="input-group input-group-sm" style={{ width: '100px' }}>
                                                    <button className="btn btn-outline-secondary" type="button" onClick={() => handleQuantityChange(item.id, item.quantity - 1)}> – </button>
                                                    <input type="text" className="form-control text-center" value={item.quantity} readOnly />
                                                    <button className="btn btn-outline-secondary" type="button" onClick={() => handleQuantityChange(item.id, item.quantity + 1)}> + </button>
                                                </div>
                                                <span className="fw-bold">{formatPrice(item.price * item.quantity)}</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            ))}
                        </ul>
                    </div>
                )}
                {cartItems.length > 0 && (
                    <div className="mt-auto pt-3 border-top">
                        <div className="d-flex justify-content-between align-items-center mb-2">
                            <span className="text-muted">Tạm tính</span>
                            <span className="text-muted">{formatPrice(total)}</span>
                        </div>
                        <div className="d-flex justify-content-between align-items-center fw-bold fs-5 mb-3">
                            <span>Tổng cộng</span>
                            <span className="text-primary">{formatPrice(total)}</span>
                        </div>
                        <div className="d-grid gap-2">
                            <button
                                type="button"
                                className="btn btn-primary btn-lg"
                                onClick={() => handleNavigate('/gio-hang')}
                            >
                                <i className="bi bi-wallet2 me-2"></i>
                                Tiến hành thanh toán
                            </button>
                            <button
                                type="button"
                                className="btn btn-outline-secondary"
                                onClick={() => handleNavigate('/cua-hang')}
                            >
                                <i className="bi bi-arrow-left me-2"></i>
                                Tiếp tục mua sắm
                            </button>
                        </div>
                    </div>
                )}
            </div>
        </div>
    );
};

export default Cart;