import { useEffect } from "react";
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import '../../styles/layout/Footer.css';
import SearchBar from "../../components/SearchBar";
import footerLogo from '../../assets/images/footer.png';
import telephone from '../../assets/images/icon-telephone.png';
import pTTT from '../../assets/images/phuongThucTT.png';
import { Tooltip } from 'bootstrap';

function Footer() {
    useEffect(() => {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltips = Array.from(tooltipTriggerList).map(tooltipTriggerEl => new Tooltip(tooltipTriggerEl));

        // Cleanup tooltips on unmount
        return () => {
            tooltips.forEach(tooltip => tooltip.dispose());
        };
    }, []);

    return (
        <footer className="footer-section">
            {/* Phần top của footer không đổi */}
            <div className="footer-top-section row align-items-center justify-content-center">
                <div className="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <img src={footerLogo} alt="Footer Logo" className="img-fluid footer-logo" />
                </div>
                <div className="col-md-6">
                    <SearchBar />
                </div>
            </div>

            {/* --- BẮT ĐẦU PHẦN NỘI DUNG ĐÃ TÁI CẤU TRÚC --- */}
            <div className="row text-dark footer-content">

                {/* Cột 1: Giới thiệu & Chính sách */}
                <div className="col-lg-4 col-md-12 mb-4 mb-lg-0">
                    <div className="row">
                        {/* Giới thiệu */}
                        <div className="col-6">
                            <h5 className="mb-4">Giới thiệu</h5>
                            <ul className="list-unstyled">
                                <li className="mb-2"><a href="#" className="text-decoration-none text-secondary">Về Chúng Tôi</a></li>
                                <li className="mb-2"><a href="#" className="text-decoration-none text-secondary">Liên hệ</a></li>
                                <li className="mb-2"><a href="#" className="text-decoration-none text-secondary">Blog & Tin tức</a></li>
                                <li className="mb-2"><a href="#" className="text-decoration-none text-secondary">Shop Hoa Gần Nhất</a></li>
                            </ul>
                        </div>
                        {/* Chính sách mua hàng */}
                        <div className="col-6">
                            <h5 className="mb-4">Chính sách</h5>
                            <ul className="list-unstyled">
                                <li className="mb-2">Đặt hàng: HotLine, Zalo</li>
                                <li className="mb-2">Thanh toán: Chuyển khoản</li>
                                <li className="mb-2">Nhận hàng: Tận nơi</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {/* Cột 2: Liên hệ & Thanh toán */}
                <div className="col-lg-4 col-md-12 mb-4 mb-lg-0">
                    <h5 className="mb-4">Hotline liên hệ:</h5>
                    <div className="d-flex align-items-center mb-4">
                        <img src={telephone} alt="Hotline" style={{ maxHeight: "20px" }} />
                        <div className="ms-3">
                            <a href="tel:0966183183" className="fw-bold text-dark text-decoration-none">0966 183 183</a>
                            <p className="mb-0 text-secondary">(Tất cả các ngày trong tuần)</p>
                        </div>
                    </div>

                    <h5 className="mb-3">Kết nối với chúng tôi</h5>
                    <div className="d-flex gap-2 mb-4">
                        <a href="#" className="social-icons" data-bs-toggle="tooltip" title="Facebook" style={{ backgroundColor: "#3A589D" }}><i className="bi bi-facebook"></i></a>
                        <a href="#" className="social-icons" data-bs-toggle="tooltip" title="Instagram" style={{ backgroundColor: "#3B6994" }}><i className="bi bi-instagram"></i></a>
                        <a href="#" className="social-icons" data-bs-toggle="tooltip" title="Email" style={{ backgroundColor: "#111111" }}><i className="bi bi-envelope"></i></a>
                        <a href="#" className="social-icons" data-bs-toggle="tooltip" title="Zalo" style={{ backgroundColor: "#51CB5A" }}><i className="bi bi-telephone-fill"></i></a>
                        <a href="#" className="social-icons" data-bs-toggle="tooltip" title="Youtube" style={{ backgroundColor: "#C33223" }}><i className="bi bi-youtube"></i></a>
                    </div>

                    <h5 className="mb-3">Chấp nhận thanh toán</h5>
                    <div className="payment-methods">
                        <img src={pTTT} alt="Phương thức thanh toán" className="img-fluid" />
                    </div>
                </div>

                {/* Cột 3: Hệ thống cửa hàng */}
                <div className="col-lg-4 col-md-12">
                    <h5 className="mb-4">Hệ thống cửa hàng</h5>
                    <div className="mb-3">
                        <h6 className="fw-semibold">Trụ sở Tp. Hà Nội</h6>
                        <p className="mb-0 text-secondary">37C Mễ Trì , Nam Từ Liêm, Hà Nội</p>
                    </div>
                    <div className="mb-3">
                        <h6 className="fw-semibold">Trụ sở Tp. HCM</h6>
                        <p className="mb-0 text-secondary">170A Đặng Văn Ngữ, Quận Phú Nhuận</p>
                    </div>
                    <div className="mb-3">
                        <h6 className="fw-semibold">Chi nhánh Đà Nẵng</h6>
                        <p className="mb-0 text-secondary">172A Trần Phú, Đà Nẵng</p>
                    </div>
                    <div>
                        <h6 className="fw-semibold">Cùng các chi nhánh liên kết trên toàn quốc</h6>
                        <p className="mb-0 text-secondary">Cần Thơ, Rạch Giá, Long Xuyên, Tiền Giang, Bình Dương, Bình Phước, Bến Tre, Vũng Tàu...</p>
                    </div>
                </div>
            </div>
        </footer>
    );
}

export default Footer;