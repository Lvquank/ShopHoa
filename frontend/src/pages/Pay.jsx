import React, { useState, useEffect, useMemo } from 'react';
import { useNavigate } from 'react-router-dom';
import { useCart } from '../contexts/CartContext';
import { useUser } from '../contexts/UserContext';
import apiClient from '../utils/axios';
import { toast } from 'react-toastify';
import '../styles/pages/Pay.css';

// Hàm tiện ích để định dạng tiền tệ
const formatVND = (amount) => {
    if (typeof amount !== 'number') return '0 ₫';
    return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
};

const Pay = () => {
    const navigate = useNavigate();
    const { cartItems, fetchCart } = useCart();
    const { user } = useUser();

    const [provinces, setProvinces] = useState([]);
    const [districts, setDistricts] = useState([]);
    const [wards, setWards] = useState([]);
    const [shipping, setShipping] = useState(0);
    const [isLoading, setIsLoading] = useState(true);
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [errors, setErrors] = useState({});

    const [formData, setFormData] = useState({
        name: '', phone_number: '', email: '',
        province_id: '', district_id: '', ward_id: '',
        address_detail: '', note: ''
    });

    const cartTotalPrice = useMemo(() => {
        return cartItems.reduce((total, item) => total + (item.price * item.quantity), 0);
    }, [cartItems]);

    const totalAmount = useMemo(() => cartTotalPrice + shipping, [cartTotalPrice, shipping]);

    useEffect(() => {
        // KIỂM TRA TRƯỚC KHI GỌI API
        // Nếu có người dùng, điền thông tin vào form và gọi API để lấy dữ liệu
        if (user) {
            setFormData(prev => ({
                ...prev,
                name: user.name || '',
                email: user.email || '',
                phone_number: user.phone_number || ''
            }));

            apiClient.get('/api/checkout')
                .then(response => {
                    if (response.data && response.data.provinces) {
                        setProvinces(response.data.provinces);
                    }
                })
                .catch(error => {
                    // Lỗi 401 đã được xử lý tự động, chỉ cần log các lỗi khác
                    console.error("Lỗi khi tải dữ liệu trang thanh toán:", error);
                })
                .finally(() => {
                    setIsLoading(false);
                });
        } else {
            // Nếu không có người dùng, KHÔNG gọi API và chỉ cần dừng trạng thái loading.
            // Điều này sẽ ngăn việc tự động chuyển trang.
            setIsLoading(false);
        }
    }, [user]);


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

        if (errors.province_id) {
            setErrors(prev => ({ ...prev, province_id: null }));
        }

        if (provinceId) {
            const selectedProvince = provinces.find(p => p.id == provinceId);
            if (selectedProvince) {
                setShipping(Number(selectedProvince.shipping));
            }
            try {
                const response = await apiClient.get(`/api/get-districts/${provinceId}`);
                setDistricts(response.data.districts || []);
            } catch (error) {
                toast.error("Không thể tải danh sách quận/huyện.");
            }
        }
    };

    const handleDistrictChange = async (e) => {
        const districtId = e.target.value;
        setFormData(prev => ({ ...prev, district_id: districtId, ward_id: '' }));
        setWards([]);

        if (errors.district_id) {
            setErrors(prev => ({ ...prev, district_id: null }));
        }

        if (districtId) {
            try {
                const response = await apiClient.get(`/api/get-wards/${districtId}`);
                setWards(response.data || []);
            } catch (error) {
                toast.error("Không thể tải danh sách phường/xã.");
            }
        }
    };

    const handleWardChange = (e) => {
        const wardId = e.target.value;
        setFormData(prev => ({ ...prev, ward_id: wardId }));
        if (errors.ward_id) {
            setErrors(prev => ({ ...prev, ward_id: null }));
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setIsSubmitting(true);
        setErrors({});

        try {
            const response = await apiClient.post('/api/order', formData);

            toast.success(response.data.message || 'Đặt hàng thành công!');

            setTimeout(async () => {
                await fetchCart();
                navigate('/cua-hang', { state: { orderCode: response.data.order_code } });
            }, 2000);

        } catch (error) {
            if (error.response && error.response.status === 422) {
                setErrors(error.response.data.errors);
                toast.error('Vui lòng kiểm tra lại các thông tin bắt buộc.');
            } else {
                const errorMessage = error.response?.data?.message || 'Đã có lỗi xảy ra khi đặt hàng.';
                toast.error(errorMessage);
            }
            console.error('Lỗi khi đặt hàng:', error);
            setIsSubmitting(false);
        }
    };

    if (isLoading) {
        return <div className="text-center py-5">Đang tải dữ liệu...</div>;
    }

    // 1. Ưu tiên kiểm tra trạng thái đăng nhập
    if (!user) {
        return (
            <section className="checkout py-5">
                <div className="container">
                    <div className="row justify-content-center">
                        <div className="col-lg-8 text-center">
                            <p className="text-muted fs-5 mb-4">
                                Vui lòng đăng nhập để xem trang thanh toán.
                            </p>
                            <button
                                className="btn px-4 py-2 fw-bold text-uppercase text-white"
                                onClick={() => navigate('/login')}
                                style={{ backgroundColor: '#ff5622', fontSize: '14px' }}
                            >
                                ĐI ĐẾN TRANG ĐĂNG NHẬP
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        );
    }

    // 2. Nếu đã đăng nhập, kiểm tra giỏ hàng có trống không
    if (cartItems.length === 0) {
        return (
            <section className="checkout py-5">
                <div className="container">
                    <div className="row justify-content-center">
                        <div className="col-lg-8 text-center">
                            <p className="text-muted fs-5 mb-4">
                                Chưa có sản phẩm nào trong giỏ hàng.
                            </p>
                            <button
                                className="btn px-4 py-2 fw-bold text-uppercase text-white"
                                onClick={() => navigate('/cua-hang')}
                                style={{ backgroundColor: '#ff5622', fontSize: '14px' }}
                            >
                                QUAY TRỞ LẠI CỬA HÀNG
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        );
    }

    // 3. Nếu mọi thứ đều ổn, hiển thị form thanh toán
    return (
        <section className="checkout py-5">
            <div className="container-lg">
                <form onSubmit={handleSubmit} noValidate>
                    <div className="row">
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
                                    <select className={`form-select ${errors.ward_id ? 'is-invalid' : ''}`} name="ward_id" value={formData.ward_id} onChange={handleWardChange} disabled={wards.length === 0}>
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