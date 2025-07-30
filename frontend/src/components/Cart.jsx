import React, { useEffect } from 'react';
import { useNavigate } from 'react-router-dom'; // << THAY ĐỔI: Import useNavigate
import { useCart } from '../contexts/CartContext';

const Cart = () => {
    const { cartItems, loading, error, fetchCart, updateCartItem, removeFromCart, clearError } = useCart();
    const navigate = useNavigate(); // << THAY ĐỔI: Sử dụng hook useNavigate

    // << THAY ĐỔI: useEffect được đơn giản hóa để lấy dữ liệu khi component được render
    // Logic fetch giỏ hàng nên được quản lý bởi Context, không nên phụ thuộc vào sự kiện của Bootstrap
    useEffect(() => {
        fetchCart();
    }, [fetchCart]);

    const handleQuantityChange = async (productId, newQuantity) => {
        if (newQuantity < 1) return;
        await updateCartItem(productId, newQuantity);
    };

    const handleRemoveItem = async (productId) => {
        // Có thể thay thế confirm() bằng một modal custom để đẹp hơn
        if (!window.confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) return;
        await removeFromCart(productId);
    };

    // << THAY ĐỔI: Hàm điều hướng thủ công để giải quyết xung đột
    const handleNavigate = (path) => {
        // Bootstrap sẽ tự động đóng offcanvas thông qua data-bs-dismiss
        navigate(path);
    };

    const formatPrice = (price) => {
        if (!price) return '0 ₫';
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(price);
    };

    const total = cartItems.reduce((sum, item) => sum + item.price * item.quantity, 0);

    return (
        <div className="offcanvas offcanvas-end" data-bs-scroll="true" tabIndex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
            <div className="offcanvas-header justify-content-center">
                <h5 className="offcanvas-title text-dark">GIỎ HÀNG</h5>
                <button type="button" className="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div className="offcanvas-body">
                <div className="order-md-last">
                    <h4 className="d-flex justify-content-between align-items-center mb-3">
                        <span className="text-gray">Giỏ hàng của bạn</span>
                        <span className="badge rounded-pill" style={{ backgroundColor: '#ff5622' }}>{cartItems.length}</span>
                    </h4>
                    {error && (
                        <div className="alert alert-danger" role="alert">
                            {error}
                            <button
                                type="button"
                                className="btn-close float-end"
                                onClick={clearError}
                            ></button>
                        </div>
                    )}
                    {loading ? (
                        <div className="text-center py-4">
                            <div className="spinner-border" style={{ color: '#ff5622' }} role="status">
                                <span className="visually-hidden">Đang tải...</span>
                            </div>
                            <p className="mt-2">Đang cập nhật giỏ hàng...</p>
                        </div>
                    ) : cartItems.length === 0 ? (
                        <div className="text-center py-4">
                            <div className="text-center mb-3">
                                <i className="bi bi-cart-x" style={{ fontSize: '3rem', color: '#ff5622' }}></i>
                            </div>
                            <p className="mb-3">Giỏ hàng của bạn đang trống</p>
                            {/* << THAY ĐỔI: Dùng button và onClick */}
                            <button
                                type="button"
                                className="btn"
                                style={{ backgroundColor: '#ff5622', color: 'white' }}
                                data-bs-dismiss="offcanvas"
                                onClick={() => handleNavigate('/cua-hang')}
                            >
                                <i className="bi bi-shop me-2"></i>
                                Tiếp tục mua sắm
                            </button>
                        </div>
                    ) : (
                        <>
                            <ul className="list-group mb-3">
                                {cartItems.map((item) => (
                                    <li key={item.id} className="list-group-item">
                                        <div className="d-flex justify-content-between align-items-center mb-2">
                                            <div className="d-flex align-items-center">
                                                {/* << THAY ĐỔI: Dùng div và onClick */}
                                                <div
                                                    className="text-decoration-none"
                                                    data-bs-dismiss="offcanvas"
                                                    onClick={() => handleNavigate(`/cua-hang/${item.id}`)}
                                                    style={{ cursor: 'pointer' }}
                                                >
                                                    <img
                                                        src={
                                                            (item.image_url || item.image)
                                                                ? `${import.meta.env.VITE_API_URL.replace(/\/$/, '')}/${(item.image_url || item.image).replace(/^\//, '')}`
                                                                : '/path/to/default-image.png' // Thay thế bằng ảnh mặc định của bạn
                                                        }
                                                        alt={item.name}
                                                        className="rounded border"
                                                        style={{ width: '70px', height: '70px', objectFit: 'cover' }}
                                                        onError={(e) => {
                                                            e.target.onerror = null;
                                                            e.target.src = '/placeholder.jpg';
                                                        }}
                                                    />
                                                </div>
                                                <div className="ms-3">
                                                    {/* << THAY ĐỔI: Dùng div và onClick */}
                                                    <div
                                                        className="text-decoration-none"
                                                        data-bs-dismiss="offcanvas"
                                                        onClick={() => handleNavigate(`/cua-hang/${item.id}`)}
                                                        style={{ cursor: 'pointer' }}
                                                    >
                                                        <h6 className="my-0 text-dark hover-primary">{item.name}</h6>
                                                    </div>
                                                    <small className="text-primary fw-bold">{formatPrice(item.price)}</small>
                                                </div>
                                            </div>
                                            <button
                                                className="btn btn-link text-danger p-0"
                                                onClick={() => handleRemoveItem(item.id)}
                                                title="Xóa sản phẩm"
                                            >
                                                <i className="bi bi-trash-fill"></i>
                                            </button>
                                        </div>
                                        <div className="d-flex justify-content-between align-items-center">
                                            <div className="d-flex align-items-center gap-3">
                                                <div className="input-group input-group-sm" style={{ width: '100px' }}>
                                                    <button
                                                        className="btn btn-outline-primary"
                                                        type="button"
                                                        onClick={() => handleQuantityChange(item.id, item.quantity - 1)}
                                                        disabled={loading}
                                                    >
                                                        <i className="bi bi-dash"></i>
                                                    </button>
                                                    <input
                                                        type="text"
                                                        className="form-control text-center border-primary px-0"
                                                        value={item.quantity}
                                                        readOnly
                                                        style={{ backgroundColor: 'white' }}
                                                    />
                                                    <button
                                                        className="btn btn-outline-primary"
                                                        type="button"
                                                        onClick={() => handleQuantityChange(item.id, item.quantity + 1)}
                                                        disabled={loading}
                                                    >
                                                        <i className="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                                <span className="text-primary fw-bold" style={{ minWidth: '100px', textAlign: 'right' }}>
                                                    {formatPrice(item.price * item.quantity)}
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                ))}
                                <li className="list-group-item border-0 px-0">
                                    <div className="d-flex justify-content-between align-items-center fw-bold mb-2">
                                        <span>Tạm tính:</span>
                                        <span>{formatPrice(total)}</span>
                                    </div>
                                    <div className="d-flex justify-content-between align-items-center text-primary fw-bold fs-5">
                                        <span>Tổng cộng:</span>
                                        <span>{formatPrice(total)}</span>
                                    </div>
                                </li>
                            </ul>

                            <div className="d-grid gap-2">
                                {/* << THAY ĐỔI: Dùng button và onClick */}
                                <button
                                    type="button"
                                    className="btn btn-lg"
                                    style={{ backgroundColor: '#ff5622', color: 'white' }}
                                    data-bs-dismiss="offcanvas"
                                    onClick={() => handleNavigate('/gio-hang')}
                                >
                                    <i className="bi bi-wallet2 me-2"></i>
                                    Tiến hành thanh toán
                                </button>
                                <button
                                    type="button"
                                    className="btn btn-outline-secondary"
                                    data-bs-dismiss="offcanvas"
                                    onClick={() => handleNavigate('/cua-hang')}
                                >
                                    <i className="bi bi-arrow-left me-2"></i>
                                    Tiếp tục mua sắm
                                </button>
                            </div>
                        </>
                    )}
                </div>
            </div>
        </div>
    );
};

export default Cart;