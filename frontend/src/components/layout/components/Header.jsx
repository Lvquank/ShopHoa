import React, { useState, useEffect, useRef } from 'react'
import { Link } from 'react-router-dom'
import 'bootstrap-icons/font/bootstrap-icons.css'
import SearchBar from '../../SearchBar'
import '../../../styles/layout/Header.css'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import logoImg from '../../../images/logo.webp'

const Header = (enableScroll = true,) => {
    const [isMobileNavActive, setIsMobileNavActive] = useState(false);
    const [isScrolled, setIsScrolled] = useState(false);
    const [showCategoryMenu, setShowCategoryMenu] = useState(true); // Mặc định hiện
    const [isHovering, setIsHovering] = useState(false);

    useEffect(() => {

        if (!enableScroll) {
            setIsScrolled(true);
            setShowCategoryMenu(false);
        }

        const handleScroll = () => {
            if (!enableScroll) return;

            const currentScrollY = window.scrollY;
            const wasScrolled = isScrolled;
            const newIsScrolled = currentScrollY > 256;

            setIsScrolled(newIsScrolled);

            // Logic mới cho category menu
            if (newIsScrolled) {
                // Khi scroll xuống > 256px, chỉ hiện menu khi hover
                setShowCategoryMenu(isHovering);
            } else {
                // Khi scroll <= 256px, luôn hiện menu
                setShowCategoryMenu(true);
            }
        };

        window.addEventListener("scroll", handleScroll);
        return () => window.removeEventListener("scroll", handleScroll);
    }, [enableScroll, isHovering, isScrolled]);

    // Xử lý hover cho category button khi đã scroll
    const handleCategoryMouseEnter = () => {
        setIsHovering(true);
        if (isScrolled) {
            setShowCategoryMenu(true);
        }
    };

    const handleCategoryMouseLeave = () => {
        setIsHovering(false);
        if (isScrolled) {
            setShowCategoryMenu(false);
        }
    };

    // Xử lý click outside để đóng menu (chỉ khi chưa scroll)
    useEffect(() => {
        const handleClickOutside = (e) => {
            if (!isScrolled && !e.target.closest('.btn-category') && !e.target.closest('.category-dropdown')) {
                setShowCategoryMenu(true); // Trở về trạng thái mặc định là hiện
            }
        };

        document.addEventListener('mousedown', handleClickOutside);
        return () => document.removeEventListener('mousedown', handleClickOutside);
    }, [isScrolled]);

    const mobileNavToggle = () => {
        setIsMobileNavActive(!isMobileNavActive);
        document.body.classList.toggle('mobile-nav-active');
    };

    const handleNavLinkClick = () => {
        if (isMobileNavActive) {
            mobileNavToggle();
        }
    };

    // Close menu when clicking outside
    // useEffect(() => {
    //     const handleClickOutside = (e) => {
    //         if (isMobileNavActive &&
    //             !e.target.closest('.navmenu') &&
    //             !e.target.closest('.mobile-nav-toggle')) {
    //             mobileNavToggle();
    //         }
    //     };

    //     if (isMobileNavActive) {
    //         document.addEventListener('mousedown', handleClickOutside);
    //     }

    //     return () => {
    //         document.removeEventListener('mousedown', handleClickOutside);
    //     };
    // }, [isMobileNavActive]);

    return (
        <header className={isScrolled ? 'scrolled' : ''}>
            <div className="text-white py-2 d-none d-md-block">
                <div className="container">
                    <div className="row">
                        <div className="col-8">
                            <div className="d-flex justify-content-between align-items-center">
                                <div className="social-links">
                                    <a href="#" className="text-white me-2"><i className="bi bi-facebook"></i></a>
                                    <a href="#" className="text-white me-2"><i className="bi bi-instagram"></i></a>
                                    <a href="#" className="text-white me-2"><i className="bi bi-twitter"></i></a>
                                    <a href="#" className="text-white me-2"><i className="bi bi-youtube"></i></a>
                                </div>
                                <div className="contact-info">
                                    <span className="me-3"><i className="bi bi-clock me-1"></i> 08:00 AM - 21:00 PM</span>
                                    <span><i className="bi bi-telephone-fill me-1"></i> +84 0966183183</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div className="container">
                {/* Mobile Header */}
                <div className="d-flex d-md-none align-items-center justify-content-between w-100">
                    <button className="navbar-toggler border-0 text-white p-0" type="button" onClick={mobileNavToggle}>
                        <i className={`bi ${isMobileNavActive ? 'bi-x' : 'bi-list'} fs-1`}></i>
                    </button>
                    <Link to="/" className="mx-2">
                        <img
                            src={logoImg}
                            alt="Logo"
                            style={{ height: '50px', width: 'auto' }}
                        />
                    </Link>
                    <div className="d-flex align-items-center">
                        <button className="btn me-2" type="button">
                            <i className="bi bi-search"></i>
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
                        <button className="navbar-toggler border-0 text-white p-0" type="button" onClick={mobileNavToggle}>
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
                                    <Link className="nav-link" to="/gioi-thieu" onClick={handleNavLinkClick}>
                                        Giới thiệu
                                    </Link>
                                </li>
                                <li className="nav-item">
                                    <Link className="nav-link" to="/san-pham" onClick={handleNavLinkClick}>
                                        Sản phẩm
                                    </Link>
                                </li>
                                <li className="nav-item">
                                    <Link className="nav-link" to="/he-thong" onClick={handleNavLinkClick}>
                                        Hệ thống cửa hàng
                                    </Link>
                                </li>
                                <li className="nav-item">
                                    <Link className="nav-link" to="/thanh-toan" onClick={handleNavLinkClick}>
                                        Thanh toán
                                    </Link>
                                </li>
                                <li className="nav-item">
                                    <Link className="nav-link" to="/tin-tuc" onClick={handleNavLinkClick}>
                                        Tin tức
                                    </Link>
                                </li>
                                <li className="nav-item">
                                    <Link className="nav-link" to="/lien-he" onClick={handleNavLinkClick}>
                                        Liên hệ
                                    </Link>
                                </li>
                            </ul>
                        </div>
                        <Link to="/cart" className="btn btn-outline-light position-relative ms-auto">
                            <i className="bi bi-cart"></i>
                            <span className="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                style={{ fontSize: '0.75rem' }}>
                                0
                            </span>
                        </Link>
                    </div>
                </div>
            </nav>
        </header>
    );
}

export default Header;