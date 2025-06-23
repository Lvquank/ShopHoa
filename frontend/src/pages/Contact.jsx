import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import icon1 from '../assets/images/icon-lienhe-1.png';
import icon2 from '../assets/images/icon-lienhe-2.png';
import icon3 from '../assets/images/icon-lienhe-3.png';

const Contact = () => {
    const title = "170A Đặng Văn Ngữ, Quận Phú Nhuận, TPHCM";

    // URL với marker đỏ cho địa chỉ cụ thể
    const mapWithMarkerUrl = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.0632434447034!2d106.68315431533468!3d10.831442661420783!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529456d4c432f%3A0x8e863e8b1c8a9b6e!2s170A%20%C4%90%E1%BA%B7ng%20V%C4%83n%20Ng%E1%BB%AF%2C%20Ph%C6%B0%E1%BB%9Dng%2012%2C%20Ph%C3%BA%20Nhu%E1%BA%ADn%2C%20Th%C3%A0nh%20ph%E1%BB%91%20H%E1%BB%93%20Ch%C3%AD%20Minh%20700000%2C%20Vi%E1%BB%87t%20Nam!5e0!3m2!1svi!2s!4v1640995200000!5m2!1svi!2s";

    // URL dự phòng với place mode (đảm bảo có marker)
    const backupMapUrl = "https://maps.google.com/maps?q=170A+Đặng+Văn+Ngữ,+Quận+Phú+Nhuận,+TPHCM&t=&z=16&ie=UTF8&iwloc=&output=embed";

    // URL với query search (luôn hiển thị marker đỏ)
    const searchMapUrl = "https://www.google.com/maps/embed/v1/search?key=&q=170A+Đặng+Văn+Ngữ,+Phú+Nhuận,+TPHCM";

    return (
        <div className="py-5" style={{ padding: '0 12rem', backgroundColor: '#ffffff' }}>
            <div className="mb-4" data-aos="fade-up" data-aos-delay="200">
                <iframe
                    style={{
                        border: 0,
                        width: '100%',
                        height: '270px',
                        borderRadius: '8px',
                        boxShadow: '0 4px 12px rgba(0,0,0,0.1)'
                    }}
                    src={mapWithMarkerUrl}
                    frameBorder="0"
                    allowFullScreen=""
                    loading="lazy"
                    referrerPolicy="no-referrer-when-downgrade"
                    title={title}
                />
            </div>

            {/* Fallback: Nếu map không load, hiển thị link */}
            {/* <div className="text-center mb-4">
                <a
                    href="https://www.google.com/maps/search/170A+Đặng+Văn+Ngữ,+Quận+Phú+Nhuận,+TPHCM"
                    target="_blank"
                    rel="noopener noreferrer"
                    className="btn btn-outline-primary btn-sm"
                >
                    <i className="fas fa-map-marker-alt me-2"></i>
                    Xem trên Google Maps
                </a>
            </div> */}

            <div className="row justify-content-center">
                <div className="col-lg-6">
                    {/* Header */}
                    <div className="mb-5">
                        <h2 className="fw-bold text-uppercase mb-4" style={{ color: '#333', fontSize: '24px' }}>
                            LIÊN HỆ
                        </h2>

                        {/* Service Description */}
                        <div className="mb-4">
                            <h4 className="fw-bold mb-3" style={{ color: '#666', fontSize: '18px' }}>
                                DỊCH VỤ ĐIỆN HOA TRỰC TUYẾN
                            </h4>
                            <p className="text-muted lh-lg" style={{ fontSize: '15px' }}>
                                SHOP HOA TƯƠI – Điện hoa 24/7 nhận đặt hoa online các loại Hoa Khai Trương, Hoa
                                Sinh Nhật, Hoa Đám Tang, Hoa Tang Lễ, Hoa Bó, Hoa Giỏ – Giao nhanh tận nơi tại 63
                                tỉnh thành VN.
                            </p>
                        </div>

                        {/* Address Section */}
                        <div className="mb-4">
                            <div className="d-flex align-items-start mb-3">
                                <img src={icon1} alt="Address Icon" className="me-3 mt-1" style={{ width: '20px', height: '20px' }} />
                                <div>
                                    <div className="mb-2">
                                        <strong>Địa Chỉ Miền Nam:</strong> 170A Đặng Văn Ngữ, Quận Phú Nhuận, TPHCM.
                                    </div>
                                    <div className="mb-2">
                                        <strong>Địa Chỉ Miền Bắc:</strong> 37C Mễ Trì , Nam Từ Liêm, Hà Nội
                                    </div>
                                    <div className="mb-3">
                                        <strong>Địa chỉ Miền Trung:</strong> N2 Lavender, Đồng Nai, Việt Nam
                                    </div>
                                    <p className="text-muted mb-0" style={{ fontSize: '15px' }}>
                                        <strong>Cùng các chi nhánh liên kết trên toàn quốc</strong> Cần Thơ, Rạch Giá, Long
                                        Xuyên, Tiền Giang, Bình Dương, Bình Phước, Bến Tre, Vũng Tàu, Phan
                                        Thiết, Phan Rang ...
                                    </p>
                                </div>
                            </div>
                        </div>

                        {/* Contact Info */}
                        <div className="mb-4">
                            <div className="d-flex align-items-center mb-3">
                                <img src={icon2} alt="Phone Icon" className="me-3" style={{ width: '20px', height: '20px' }} />
                                <div>
                                    <strong>Hotline:</strong> <span>0966 183 183</span>
                                </div>
                            </div>
                        </div>

                        {/* Zalo Chat */}
                        <div className="mb-4">
                            <div className="d-flex align-items-center">
                                <img src={icon3} alt="Zalo Icon" className="me-3" style={{ width: '20px', height: '20px' }} />
                                <div>
                                    <strong>Chat trực tiếp với chúng tôi trên Zalo</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-lg-6"></div>
            </div>
        </div>
    );
};

export default Contact;