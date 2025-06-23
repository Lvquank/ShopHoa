import React, { useState, useEffect } from 'react'
import { Link } from 'react-router-dom'
import 'bootstrap-icons/font/bootstrap-icons.css'
import SearchBar from '../../components/SearchBar'
import '../../styles/layout/Header.css'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import logoImg from '../../assets/images/logo.webp'
import { Tooltip } from 'bootstrap';
const Header = ({ isShowCategoryMenu = true }) => {
    const [isMobileNavActive, setIsMobileNavActive] = useState(false);
    const [isScrolled, setIsScrolled] = useState(false);
    const [showCategoryMenu, setShowCategoryMenu] = useState(isShowCategoryMenu);
    const [isHovering, setIsHovering] = useState(false);
    const [expandedCategory, setExpandedCategory] = useState(null);

    // Effect để cập nhật showCategoryMenu khi prop thay đổi
    useEffect(() => {
        setShowCategoryMenu(isShowCategoryMenu);
    }, [isShowCategoryMenu]);

    useEffect(() => {
        // Kích hoạt tooltip cho tất cả phần tử có data-bs-toggle="tooltip"
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach((el) => {
            new Tooltip(el);
        });
    }, []);

    useEffect(() => {
        const handleScroll = () => {
            const currentScrollY = window.scrollY;
            const newIsScrolled = currentScrollY > 256;
            setIsScrolled(newIsScrolled);

            if (isShowCategoryMenu) {
                if (newIsScrolled) {
                    setShowCategoryMenu(isHovering);
                } else {
                    setShowCategoryMenu(true);
                }
            }
        };

        window.addEventListener("scroll", handleScroll);
        return () => window.removeEventListener("scroll", handleScroll);
    }, [isHovering, isShowCategoryMenu]);

    // Mobile navigation handlers
    const toggleMobileNav = () => {
        setIsMobileNavActive(!isMobileNavActive);
        document.body.classList.toggle('mobile-nav-active');
    };

    const handleNavLinkClick = () => {
        if (isMobileNavActive) {
            toggleMobileNav();
        }
    };

    // Category hover handlers
    const handleCategoryMouseEnter = () => {
        setIsHovering(true);
        if (isScrolled && isShowCategoryMenu) {
            setShowCategoryMenu(true);
        }
    };

    const handleCategoryMouseLeave = () => {
        setIsHovering(false);
        if (isScrolled && isShowCategoryMenu) {
            setShowCategoryMenu(false);
        }
    };
    const toggleCategory = (category) => {
        setExpandedCategory(expandedCategory === category ? null : category);
    };
    return (
        <>
            <header className={isScrolled ? 'scrolled' : ''}>
                <div className="text-white py-2 d-none d-md-block">
                    <div className="container">
                        <div className="row">
                            <div className="col-8">
                                <div className="d-flex justify-content-between align-items-center">
                                    <div className="social-links">
                                        <a href="#" className="text-white me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Follow on Facebook"><i className="bi bi-facebook"></i></a>
                                        <a href="#" className="text-white me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Follow on Instagram"><i className="bi bi-instagram"></i></a>
                                        <a href="#" className="text-white me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Follow on Twitter"><i className="bi bi-twitter"></i></a>
                                        <a href="#" className="text-white me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Send Email"><i className="bi bi-envelope"></i></a>
                                        <a href="#" className="text-white me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Subscribe on YouTube"><i className="bi bi-youtube"></i></a>
                                    </div>
                                    <div className="contact-info">
                                        <span className="me-3" data-bs-toggle="tooltip" data-bs-placement="bottom" title="08:00 AM - 21:00 PM" style={{ cursor: 'pointer' }}>
                                            <i className="bi bi-clock me-1"></i> 08:00 AM - 21:00 PM
                                        </span>
                                        <span className="me-3" data-bs-toggle="tooltip" data-bs-placement="bottom" title="+84 0966183183" style={{ cursor: 'pointer' }}>
                                            <i className="bi bi-telephone-fill"></i> +84 0966183183
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="container">
                    {/* Mobile Header */}
                    <div className="d-flex d-md-none align-items-center justify-content-between w-100">
                        <button
                            className="btn text-white p-0"
                            type="button"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#mobileNavOffcanvas"
                            aria-controls="mobileNavOffcanvas"
                        >
                            <i className="bi bi-list fs-1"></i>
                        </button>
                        <Link to="/" className="mx-2">
                            <img
                                src={logoImg}
                                alt="Logo"
                                style={{ height: '50px', width: 'auto' }}
                            />
                        </Link>
                        <div className="d-flex align-items-center">
                            <button className="btn text-white me-2" type="button">
                                <i className="bi bi-search fs-4"></i>
                            </button>
                            <button
                                className="btn text-white position-relative"
                                type="button"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasCart"
                                aria-controls="offcanvasCart"
                            >
                                <i className="bi bi-cart fs-4"></i>
                                <span
                                    className="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                    style={{ fontSize: '0.75rem' }}
                                >
                                    3
                                </span>
                            </button>
                        </div>
                    </div>

                    {/* Desktop Header */}
                    <div className="row align-items-center d-none d-md-flex">
                        <div className="col-lg-3 col-md-3">
                            <Link to="/" className="d-block">
                                <img src={logoImg} alt="Logo" className="img-fluid" style={{ maxHeight: '5.5rem' }} />
                            </Link>
                        </div>
                        <div className="col-lg-9 col-md-6">
                            <div className="d-flex align-items-center justify-content-start">
                                <SearchBar />
                                <div className="d-flex align-items-center justify-content-start text-white">
                                    <div className="d-none d-lg-flex align-items-center px-3 py-2">
                                        <i className="bi bi-telephone-fill me-2"></i>
                                        <div className="small">
                                            <div className="text-nowrap">Gọi đặt hàng</div>
                                            <span className="fw-bold text-nowrap">0966.183.183</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <nav className="navbar navbar-expand-lg d-none d-md-block">
                    <div className="container d-flex align-items-center">
                        <div className="d-flex align-items-center">
                            <button className="navbar-toggler border-0 text-white p-0" type="button" onClick={toggleMobileNav}>
                                <i className={`bi ${isMobileNavActive ? 'bi-x' : 'bi-list'} fs-1`}></i>
                            </button>

                            <div
                                className="position-relative"
                                onMouseEnter={handleCategoryMouseEnter}
                                onMouseLeave={handleCategoryMouseLeave}
                            >
                                <button
                                    className="btn-category d-lg-inline-flex align-items-center text-white"
                                    type="button">
                                    <i className="bi bi-list me-2"></i>
                                    Danh mục sản phẩm
                                </button>

                                <ul className={`dropdown-menu category-dropdown ${showCategoryMenu ? 'show' : ''}`}>
                                    <li>
                                        <Link className="dropdown-item" to="/san-pham">
                                            <i className="bi bi-fire me-2"></i>
                                            Các Sản Phẩm Bán Chạy
                                        </Link>
                                    </li>
                                    <li className="dropdown-submenu">
                                        <Link className="dropdown-item d-flex justify-content-between align-items-center" to="/san-pham/hoa-khai-truong">
                                            <div>
                                                <i className="bi bi-cart me-2"></i>
                                                Hoa Khai Trương
                                            </div>
                                            <i className="bi bi-chevron-right"></i>
                                        </Link>
                                        <ul className="dropdown-menu submenu">
                                            <li>
                                                <Link className="dropdown-item" to="/san-pham/hoa-khai-truong/truyen-thong">
                                                    Mẫu Truyền Thống
                                                </Link>
                                            </li>
                                            <li>
                                                <Link className="dropdown-item" to="/san-pham/hoa-khai-truong/hien-dai">
                                                    Mẫu Hiện Đại
                                                </Link>
                                            </li>
                                        </ul>
                                    </li>
                                    <li className="dropdown-submenu">
                                        <Link className="dropdown-item d-flex justify-content-between align-items-center" to="/san-pham/hoa-dam-tang">
                                            <div>
                                                <i className="bi bi-cart me-2"></i>
                                                Hoa Đám Tang
                                            </div>
                                            <i className="bi bi-chevron-right"></i>
                                        </Link>
                                        <ul className="dropdown-menu submenu">
                                            <li>
                                                <Link className="dropdown-item" to="/san-pham/hoa-dam-tang/truyen-thong">
                                                    Mẫu Truyền Thống
                                                </Link>
                                            </li>
                                            <li>
                                                <Link className="dropdown-item" to="/san-pham/hoa-dam-tang/hien-dai">
                                                    Mẫu Hiện Đại
                                                </Link>
                                            </li>
                                            <li>
                                                <Link className="dropdown-item" to="/san-pham/hoa-dam-tang/cong-giao">
                                                    Hoa Đám Tang Công Giáo
                                                </Link>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <Link className="dropdown-item" to="/san-pham/hoa-gio">
                                            <i className="bi bi-cart me-2"></i>
                                            Hoa Giỏ
                                        </Link>
                                    </li>
                                    <li>
                                        <Link className="dropdown-item" to="/san-pham/hoa-bo">
                                            <i className="bi bi-cart me-2"></i>
                                            Hoa Bó
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div className="d-flex align-items-center justify-content-between flex-grow-1">
                            <div className={`navmenu ${isMobileNavActive ? 'active' : ''}`}>
                                <ul className="navbar-nav">
                                    <li className="nav-item">
                                        <Link className="nav-link" to="/" onClick={handleNavLinkClick}>
                                            Trang chủ
                                        </Link>
                                    </li>
                                    <li className="nav-item">
                                        <Link className="nav-link" to="/gioi-thieu/" onClick={handleNavLinkClick}>
                                            Giới thiệu
                                        </Link>
                                    </li>
                                    <li className="nav-item">
                                        <Link className="nav-link" to="/cua-hang/" onClick={handleNavLinkClick}>
                                            Sản phẩm
                                        </Link>
                                    </li>
                                    <li className="nav-item">
                                        <Link className="nav-link" to="/he-thong-cua-hang/" onClick={handleNavLinkClick}>
                                            Hệ thống cửa hàng
                                        </Link>
                                    </li>
                                    <li className="nav-item">
                                        <Link className="nav-link" to="/gio-hang/" onClick={handleNavLinkClick}>
                                            Thanh toán
                                        </Link>
                                    </li>
                                    <li className="nav-item">
                                        <Link className="nav-link" to="/tin-tuc/" onClick={handleNavLinkClick}>
                                            Tin tức
                                        </Link>
                                    </li>
                                    <li className="nav-item">
                                        <Link className="nav-link" to="/lien-he/" onClick={handleNavLinkClick}>
                                            Liên hệ
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                            {/* Cart button */}
                            <button
                                className="btn btn-outline-light position-relative ms-auto"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasCart"
                                aria-controls="offcanvasCart"
                            >
                                <i className="bi bi-cart"></i>
                                <span
                                    className="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                    style={{ fontSize: '0.75rem' }}
                                >
                                    3
                                </span>
                            </button>
                        </div>
                    </div>
                </nav>
            </header>
            {/* Mobile Navigation Offcanvas */}
            <div className="offcanvas offcanvas-start" tabIndex="-1" id="mobileNavOffcanvas" aria-labelledby="mobileNavOffcanvasLabel">
                <div className="offcanvas-header bg-light">
                    <h5 className="offcanvas-title text-success fw-bold" id="mobileNavOffcanvasLabel">
                        <i className="bi bi-list me-2"></i>
                        DANH MUC
                    </h5>
                    <button type="button" className="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div className="offcanvas-body p-0">
                    <div className="list-group list-group-flush">
                        {/* Các sản phẩm bán chạy */}
                        <a href="/san-pham" className="list-group-item list-group-item-action d-flex align-items-center py-3">
                            <i className="bi bi-fire me-3 text-warning"></i>
                            <span className="text-uppercase fw-bold">CÁC SẢN PHẨM BÁN CHẠY</span>
                        </a>

                        {/* Hoa Khai Trương */}
                        <div className="list-group-item p-0">
                            <button
                                className="btn w-100 d-flex align-items-center justify-content-between py-3 px-3 border-0 bg-transparent text-start"
                                onClick={() => toggleCategory('khai-truong')}
                            >
                                <div className="d-flex align-items-center">
                                    <i className="bi bi-cart me-3"></i>
                                    <span className="text-uppercase fw-bold">HOA KHAI TRƯƠNG</span>
                                </div>
                                <i className={`bi bi-chevron-${expandedCategory === 'khai-truong' ? 'up' : 'down'}`}></i>
                            </button>
                            <div className={`collapse ${expandedCategory === 'khai-truong' ? 'show' : ''}`}>
                                <div className="ps-4 pb-2">
                                    <a href="/san-pham/hoa-khai-truong/truyen-thong" className="d-block py-2 text-decoration-none text-dark">
                                        Mẫu Truyền Thống
                                    </a>
                                    <a href="/san-pham/hoa-khai-truong/hien-dai" className="d-block py-2 text-decoration-none text-dark">
                                        Mẫu Hiện Đại
                                    </a>
                                </div>
                            </div>
                        </div>

                        {/* Hoa Đám Tang */}
                        <div className="list-group-item p-0">
                            <button
                                className="btn w-100 d-flex align-items-center justify-content-between py-3 px-3 border-0 bg-transparent text-start"
                                onClick={() => toggleCategory('dam-tang')}
                            >
                                <div className="d-flex align-items-center">
                                    <i className="bi bi-cart me-3"></i>
                                    <span className="text-uppercase fw-bold">HOA ĐÁM TANG</span>
                                </div>
                                <i className={`bi bi-chevron-${expandedCategory === 'dam-tang' ? 'up' : 'down'}`}></i>
                            </button>
                            <div className={`collapse ${expandedCategory === 'dam-tang' ? 'show' : ''}`}>
                                <div className="ps-4 pb-2">
                                    <a href="/san-pham/hoa-dam-tang/truyen-thong" className="d-block py-2 text-decoration-none text-dark">
                                        Mẫu Truyền Thống
                                    </a>
                                    <a href="/san-pham/hoa-dam-tang/hien-dai" className="d-block py-2 text-decoration-none text-dark">
                                        Mẫu Hiện Đại
                                    </a>
                                    <a href="/san-pham/hoa-dam-tang/cong-giao" className="d-block py-2 text-decoration-none text-dark">
                                        Hoa Đám Tang Công Giáo
                                    </a>
                                </div>
                            </div>
                        </div>

                        {/* Hoa Giỏ */}
                        <a href="/san-pham/hoa-gio" className="list-group-item list-group-item-action d-flex align-items-center py-3">
                            <i className="bi bi-cart me-3"></i>
                            <span className="text-uppercase fw-bold">HOA GIỎ</span>
                        </a>

                        {/* Hoa Bó */}
                        <a href="/san-pham/hoa-bo" className="list-group-item list-group-item-action d-flex align-items-center py-3">
                            <i className="bi bi-cart me-3"></i>
                            <span className="text-uppercase fw-bold">HOA BÓ</span>
                        </a>
                    </div>
                </div>
            </div>
            {/* Offcanvas Cart */}
            <div className="offcanvas offcanvas-end" data-bs-scroll="true" tabIndex="-1" id="offcanvasCart">
                <div className="offcanvas-header justify-content-center">
                    <h5 className="offcanvas-title text-primary">GIỎ HÀNG</h5>
                    <button type="button" className="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div className="offcanvas-body">
                    <div className="order-md-last">
                        <h4 className="d-flex justify-content-between align-items-center mb-3">
                            <span className="text-primary">Giỏ hàng của bạn</span>
                            <span className="badge bg-primary rounded-pill">3</span>
                        </h4>
                        <ul className="list-group mb-3">
                            <li className="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 className="my-0">Hoa khai trương</h6>
                                    <small className="text-body-secondary">Mẫu truyền thống</small>
                                </div>
                                <span className="text-body-secondary">500,000₫</span>
                            </li>
                            <li className="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 className="my-0">Hoa bó</h6>
                                    <small className="text-body-secondary">Hoa hồng đỏ</small>
                                </div>
                                <span className="text-body-secondary">300,000₫</span>
                            </li>
                            <li className="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 className="my-0">Hoa giỏ</h6>
                                    <small className="text-body-secondary">Hoa tươi mix</small>
                                </div>
                                <span className="text-body-secondary">200,000₫</span>
                            </li>
                            <li className="list-group-item d-flex justify-content-between">
                                <span>Tổng cộng (VNĐ)</span>
                                <strong>1,000,000₫</strong>
                            </li>
                        </ul>

                        <button className="w-100 btn btn-primary btn-lg" type="submit">Tiến hành thanh toán</button>
                    </div>
                </div>
            </div>
        </>
    );
}

export default Header;