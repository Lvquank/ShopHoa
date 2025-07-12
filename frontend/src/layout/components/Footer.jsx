import { useEffect } from "react";
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import '../../styles/layout/Footer.css';
import SearchBar from "../../components/SearchBar";
import footerLogo from '../../assets/images/footer.png';
import telephone from '../../assets/images/icon-telephone.png';
import pTTT from '../../assets/images/phuongThucTT.png';
import { Tooltip } from 'bootstrap';

function Footer() {
    useEffect(() => {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltips = [];

        tooltipTriggerList.forEach((el) => {
            tooltips.push(new Tooltip(el));
        });

        // Cleanup tooltips on unmount
        return () => {
            tooltips.forEach(tooltip => tooltip.dispose());
        };
    }, []);
    return (
        <footer className="footer-section" >
            <div className="footer-top-section row align-items-center justify-content-center mb-4">
                <div className="col-md-6">
                    <img src={footerLogo} alt="Footer Logo" className="img-fluid footer-logo" />
                </div>
                <div className="col-md-6">
                    <SearchBar />
                </div>
            </div>
            <div className="row text-dark footer-content">
                <div className="col-lg-6 col-md-12">
                    <div className="row">
                        <div className="col-5">
                            <h5 className="mb-4">Giới thiệu</h5>
                            <ul className="list-unstyled">
                                <li className="mb-2"><a href="#" className="text-decoration-none text-secondary">Về Chúng Tôi</a></li>
                                <li className="mb-2"><a href="#" className="text-decoration-none text-secondary">Liên hệ</a></li>
                                <li className="mb-2"><a href="#" className="text-decoration-none text-secondary">Hoa Đám Tang</a></li>
                                <li className="mb-2"><a href="#" className="text-decoration-none text-secondary">Shop Hoa Gần Nhất</a></li>
                                <li className="mb-2"><a href="#" className="text-decoration-none text-secondary">Liên kết</a></li>
                                <li className="mb-2"><a href="#" className="text-decoration-none text-secondary">Blog & Tin tức</a></li>
                            </ul>
                        </div>
                        <div className="col-7">
                            <h5 className="mb-4">Chính sách mua hàng</h5>
                            <ul className="list-unstyled">
                                <li className="mb-2">Hình thức đặt hàng: HotLine và Zalo</li>
                                <li className="mb-2">Hình thức thanh toán: Chuyển khoản</li>
                                <li className="mb-2">Phương thức nhận hàng: Giao hàng tận nơi</li>
                            </ul>
                        </div>
                        <h5 className="mb-4 mt-4">Chấp nhận thanh toán:</h5>
                        <div className="d-flex gap-2 payment-methods">
                            <img src={pTTT} alt="Phương thức thanh toán" className="img-fluid footer-logo" />
                        </div>
                    </div>
                </div>
                <div className="col-lg-3 col-md-6">
                    <h5 className="mb-4">Hotline liên hệ:</h5>
                    <div className="d-flex align-items-center mb-3">
                        <img src={telephone} alt="Hotline" style={{ maxHeight: "20px" }} />
                        <div className="ms-3">
                            <a href="tel:0966183183">0966 183 183</a>
                            <p className="mb-0 text-secondary">(Tất cả các ngày trong tuần)</p>
                        </div>
                    </div>
                    <h5 className="mb-3 mt-4">Kết nối với chúng tôi</h5>
                    <div className="d-flex gap-2 ms-2">
                        <a href="#" className="d-flex align-items-center justify-content-center rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Follow on Facebook" style={{ width: 36, height: 36, backgroundColor: "#3A589D" }} >
                            <i className="bi bi-facebook fs-5" style={{ color: '#ffffff' }}></i>
                        </a>
                        <a href="#" className="d-flex align-items-center justify-content-center rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Follow on Instagram" style={{ width: 36, height: 36, backgroundColor: "#3B6994" }}>
                            <i className="bi bi-instagram fs-5" style={{ color: '#ffffff' }}></i>
                        </a>
                        <a href="#" className="d-flex align-items-center justify-content-center rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Send us an email" style={{ width: 36, height: 36, backgroundColor: "#111111" }}>
                            <i className="bi bi-envelope fs-5" style={{ color: '#ffffff' }}></i>
                        </a>
                        <a href="#" className="d-flex align-items-center justify-content-center rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Call us" style={{ width: 36, height: 36, backgroundColor: "#51CB5A" }}>
                            <i className="bi bi-telephone-fill fs-5" style={{ color: '#ffffff' }}></i>
                        </a>
                        <a href="#" className="d-flex align-items-center justify-content-center rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Follow on Youtube" style={{ width: 36, height: 36, backgroundColor: "#C33223" }}>
                            <i className="bi bi-youtube fs-5" style={{ color: '#ffffff' }}></i>
                        </a>
                    </div>
                    <p className="mt-3 mb-0 text-secondary">Giờ mở cửa : 7:00-22:00 hàng ngày</p>
                </div>
                <div className="col-lg-3 col-md-6">
                    <h5 className="mb-4">Hệ thống cửa hàng</h5>
                    <div className="mb-4">
                        <h6 className="fw-semibold">Trụ sở Tp. Hà Nội</h6>
                        <p className="mb-0">37C Mễ Trì , Nam Từ Liêm, Hà Nội</p>
                    </div>
                    <div className="mb-4">
                        <h6 className="fw-semibold">Trụ sở Tp. HCM</h6>
                        <p className="mb-0">170A Đặng Văn Ngữ, Quận Phú Nhuận</p>
                    </div>
                    <div className="mb-4">
                        <h6 className="fw-semibold">Chi nhánh Đà Nẵng</h6>
                        <p className="mb-0">172A Trần Phú, Đà Nẵng</p>
                    </div>
                    <div>
                        <h6 className="fw-semibold">Cùng các chi nhánh liên kết trên toàn quốc</h6>
                        <p className="mb-0">Cần Thơ, Rạch Giá, Long Xuyên, Tiền Giang, Bình Dương, Bình Phước, Bến Tre, Vũng Tàu, Phan Thiết, Phan Rang ...</p>
                    </div>
                </div>
            </div>
        </footer>
    );
}

export default Footer;