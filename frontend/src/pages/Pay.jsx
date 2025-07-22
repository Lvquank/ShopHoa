import React, { useState, useEffect, useMemo } from 'react';
import { useNavigate } from 'react-router-dom';
import { useCart } from '../contexts/CartContext'; // Sửa đổi: Dùng CartContext
import { useUser } from '../contexts/UserContext'; // Sửa đổi: Dùng UserContext để lấy thông tin user
import apiClient from '../utils/axios'; // Sửa đổi: Dùng apiClient nhất quán

// Hàm tiện ích để định dạng tiền tệ
const formatVND = (amount) => {
    if (typeof amount !== 'number') return '0 ₫';
    return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
};

const Pay = () => {
    const navigate = useNavigate();

    // SỬA ĐỔI: Lấy dữ liệu giỏ hàng trực tiếp từ CartContext
    const { cartItems, fetchCart } = useCart();
    // SỬA ĐỔI: Lấy thông tin người dùng từ UserContext
    const { user } = useUser();

    // SỬA ĐỔI: Các state không cần thiết đã bị loại bỏ, chỉ giữ lại những state của trang Pay
    const [provinces, setProvinces] = useState([]);
    const [districts, setDistricts] = useState([]);
    const [wards, setWards] = useState([]);
    const [shipping, setShipping] = useState(0);
    const [isLoading, setIsLoading] = useState(true);
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [errors, setErrors] = useState({});

    // State cho form, tự động điền thông tin user nếu có
    const [formData, setFormData] = useState({
        name: '', phone_number: '', email: '',
        province_id: '', district_id: '', ward_id: '',
        address_detail: '', note: ''
    });

    // SỬA ĐỔI: Tính toán lại tổng tiền dựa trên cartItems từ context
    const cartTotalPrice = useMemo(() => {
        return cartItems.reduce((total, item) => total + (item.price * item.quantity), 0);
    }, [cartItems]);

    const totalAmount = useMemo(() => cartTotalPrice + shipping, [cartTotalPrice, shipping]);

    // SỬA ĐỔI: useEffect để fetch dữ liệu riêng của trang Pay (provinces) và điền form
    useEffect(() => {
        // Tự động điền thông tin người dùng vào form nếu đã đăng nhập
        if (user) {
            setFormData(prev => ({
                ...prev,
                name: user.name || '',
                email: user.email || '',
                phone_number: user.phone_number || ''
            }));
        }

        // Fetch dữ liệu checkout (chỉ cần lấy provinces, vì cart đã có từ context)
        apiClient.get('/api/checkout')
            .then(response => {
                if (response.data && response.data.provinces) {
                    setProvinces(response.data.provinces);
                }
            })
            .catch(error => {
                console.error("Lỗi khi tải danh sách tỉnh thành:", error);
                if (error.response && error.response.status === 401) {
                    alert('Vui lòng đăng nhập để tiếp tục.');
                    navigate('/dang-nhap');
                }
            })
            .finally(() => {
                setIsLoading(false);
            });
    }, [user, navigate]); // Chạy lại khi thông tin user thay đổi

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
        if (errors[name]) {
            setErrors(prev => ({ ...prev, [name]: null }));
        }
    };

    const handleProvinceChange = async (e) => {
        const provinceId = e.target.value;
        setFormData(prev => ({ ...prev, province_id: provinceId, district_id: '', ward_id: '' }));
        setDistricts([]);
        setWards([]);
        setShipping(0);

        if (provinceId) {
            const selectedProvince = provinces.find(p => p.id == provinceId);
            if (selectedProvince) {
                setShipping(Number(selectedProvince.shipping));
            }
            try {
                const response = await apiClient.get(`/api/get-districts/${provinceId}`);
                setDistricts(response.data.districts || []);
            } catch (error) {
                alert("Không thể tải danh sách quận/huyện.");
            }
        }
    };

    const handleDistrictChange = async (e) => {
        const districtId = e.target.value;
        setFormData(prev => ({ ...prev, district_id: districtId, ward_id: '' }));
        setWards([]);
        if (districtId) {
            try {
                const response = await apiClient.get(`/api/get-wards/${districtId}`);
                setWards(response.data || []);
            } catch (error) {
                alert("Không thể tải danh sách phường/xã.");
            }
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setIsSubmitting(true);
        setErrors({});

        try {
            const response = await apiClient.post('/api/order', formData);
            alert(response.data.message);
            await fetchCart(); // Cập nhật lại giỏ hàng (trống) sau khi đặt hàng thành công
            navigate('/dat-hang-thanh-cong', { state: { orderCode: response.data.order_code } });
        } catch (error) {
            if (error.response && error.response.status === 422) {
                setErrors(error.response.data.errors);
            } else {
                alert(error.response?.data?.message || 'Đã có lỗi xảy ra khi đặt hàng.');
            }
            console.error('Lỗi khi đặt hàng:', error);
        } finally {
            setIsSubmitting(false);
        }
    };

    if (isLoading) {
        return <div className="text-center py-5">Đang tải dữ liệu...</div>;
    }

    // Giao diện khi giỏ hàng trống sẽ được hiển thị tự động vì cartItems lấy từ context
    if (!user || cartItems.length === 0) {
        return (
            <div className="container py-5">
                <div className="row justify-content-center">
                    <div className="col-lg-8 text-center">
                        <p className="text-muted fs-5 mb-4">
                            {!user ? "Vui lòng đăng nhập để xem trang thanh toán." : "Chưa có sản phẩm nào trong giỏ hàng."}
                        </p>
                        <button
                            className="btn px-4 py-2 fw-bold text-uppercase text-white"
                            onClick={() => navigate(!user ? '/dang-nhap' : '/cua-hang')}
                            style={{ backgroundColor: '#ff5622', fontSize: '14px' }}
                        >
                            {!user ? 'ĐI ĐẾN TRANG ĐĂNG NHẬP' : 'QUAY TRỞ LẠI CỬA HÀNG'}
                        </button>
                    </div>
                </div>
            </div>
        );
    }

    return (
        <section className="checkout py-5">
            <div className="container-lg">
                <form onSubmit={handleSubmit} noValidate>
                    <div className="row">
                        {/* Cột Tóm tắt đơn hàng */}
                        <div className="col-lg-6 mb-5">
                            <h2 className="mb-4">Đơn hàng của bạn</h2>
                            <div className="my-order-summary p-3 border rounded">
                                {cartItems.map(item => (
                                    <p key={item.id} className="d-flex justify-content-between">
                                        <span>{item.name} <span className="text-muted">x{item.quantity}</span></span>
                                        <strong>{formatVND(item.price * item.quantity)}</strong>
                                    </p>
                                ))}
                                <hr />
                                <p className="d-flex justify-content-between">
                                    <span>Tạm tính</span>
                                    <strong>{formatVND(cartTotalPrice)}</strong>
                                </p>
                                <p className="d-flex justify-content-between">
                                    <span>Phí vận chuyển</span>
                                    <strong className="text-success">{formatVND(shipping)}</strong>
                                </p>
                                <hr />
                                <p className="d-flex justify-content-between fs-5">
                                    <strong>Tổng cộng</strong>
                                    <strong className="text-danger">{formatVND(totalAmount)}</strong>
                                </p>
                            </div>
                        </div>

                        {/* Cột Thông tin giao hàng */}
                        <div className="col-lg-6">
                            <h2 className="mb-4">Thông tin giao hàng</h2>
                            <div className="row g-3">
                                <div className="col-sm-6">
                                    <input className={`form-control ${errors.name ? 'is-invalid' : ''}`} type="text" placeholder="Họ và tên *" name="name" value={formData.name} onChange={handleInputChange} />
                                    {errors.name && <div className="invalid-feedback">{errors.name[0]}</div>}
                                </div>
                                <div className="col-sm-6">
                                    <input className={`form-control ${errors.phone_number ? 'is-invalid' : ''}`} type="tel" placeholder="Số điện thoại *" name="phone_number" value={formData.phone_number} onChange={handleInputChange} />
                                    {errors.phone_number && <div className="invalid-feedback">{errors.phone_number[0]}</div>}
                                </div>
                                <div className="col-12">
                                    <input className={`form-control ${errors.email ? 'is-invalid' : ''}`} type="email" placeholder="Email (không bắt buộc)" name="email" value={formData.email} onChange={handleInputChange} />
                                    {errors.email && <div className="invalid-feedback">{errors.email[0]}</div>}
                                </div>
                                <div className="col-sm-4">
                                    <select className={`form-select ${errors.province_id ? 'is-invalid' : ''}`} name="province_id" value={formData.province_id} onChange={handleProvinceChange}>
                                        <option value="" disabled>-- Tỉnh/Thành --</option>
                                        {provinces.map(p => <option key={p.id} value={p.id}>{p.name}</option>)}
                                    </select>
                                    {errors.province_id && <div className="invalid-feedback">{errors.province_id[0]}</div>}
                                </div>
                                <div className="col-sm-4">
                                    <select className={`form-select ${errors.district_id ? 'is-invalid' : ''}`} name="district_id" value={formData.district_id} onChange={handleDistrictChange} disabled={districts.length === 0}>
                                        <option value="" disabled>-- Quận/Huyện --</option>
                                        {districts.map(d => <option key={d.id} value={d.id}>{d.name}</option>)}
                                    </select>
                                    {errors.district_id && <div className="invalid-feedback">{errors.district_id[0]}</div>}
                                </div>
                                <div className="col-sm-4">
                                    <select className={`form-select ${errors.ward_id ? 'is-invalid' : ''}`} name="ward_id" value={formData.ward_id} onChange={handleInputChange} disabled={wards.length === 0}>
                                        <option value="" disabled>-- Phường/Xã --</option>
                                        {wards.map(w => <option key={w.id} value={w.id}>{w.name}</option>)}
                                    </select>
                                    {errors.ward_id && <div className="invalid-feedback">{errors.ward_id[0]}</div>}
                                </div>
                                <div className="col-12">
                                    <input className={`form-control ${errors.address_detail ? 'is-invalid' : ''}`} type="text" placeholder="Địa chỉ cụ thể (số nhà, tên đường,...)" name="address_detail" value={formData.address_detail} onChange={handleInputChange} />
                                    {errors.address_detail && <div className="invalid-feedback">{errors.address_detail[0]}</div>}
                                </div>
                                <div className="col-12">
                                    <textarea className="form-control" name="note" rows="3" placeholder="Ghi chú đơn hàng (không bắt buộc)" value={formData.note} onChange={handleInputChange}></textarea>
                                </div>
                                <div className="col-12">
                                    <button type="submit" className="btn w-100 py-2 text-white" style={{ backgroundColor: '#ff5622', fontSize: '18px' }} disabled={isSubmitting}>
                                        {isSubmitting ? 'ĐANG XỬ LÝ...' : 'ĐẶT HÀNG'}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    );
};

export default Pay;