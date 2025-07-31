import React, { useState, useEffect, useCallback, useMemo } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useUser } from '../../contexts/UserContext';
import { useCart } from '../../contexts/CartContext';
import apiClient from '../../utils/axios';
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import { Tooltip } from 'bootstrap';
import SearchBar from '../../components/SearchBar';
import Cart from '../../components/Cart';
import logoImg from '../../assets/images/logo.webp';
import '../../styles/layout/Header.css';

const Header = ({ isShowCategoryMenu = true }) => {
    const { user, logout } = useUser();
    const { cartCount } = useCart();
    const navigate = useNavigate();

    const [categories, setCategories] = useState([]);
    const [menuLoading, setMenuLoading] = useState(true);

    const [isMobileNavActive, setIsMobileNavActive] = useState(false);
    const [isScrolled, setIsScrolled] = useState(false);
    const [showCategoryMenu, setShowCategoryMenu] = useState(isShowCategoryMenu);
    const [isHovering, setIsHovering] = useState(false);
    const [expandedCategory, setExpandedCategory] = useState(null);
    const [showUserMenu, setShowUserMenu] = useState(false);

    useEffect(() => {
        const fetchMenuData = async () => {
            try {
                setMenuLoading(true);
                const categoriesRes = await apiClient.get('/api/categories');
                setCategories(categoriesRes.data.data || []);
            } catch (error) {
                console.error("Lỗi khi tải dữ liệu menu:", error);
            } finally {
                setMenuLoading(false);
            }
        };
        fetchMenuData();
    }, []);


    const throttle = useCallback((func, delay) => {
        let timeoutId;
        let lastExecTime = 0;
        return function (...args) {
            const currentTime = Date.now();
            if (currentTime - lastExecTime > delay) {
                func.apply(this, args);
                lastExecTime = currentTime;
            } else {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(() => {
                    func.apply(this, args);
                    lastExecTime = Date.now();
                }, delay - (currentTime - lastExecTime));
            }
        }
    }, []);

    const debounce = useCallback((func, delay) => {
        let timeoutId;
        return function (...args) {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => func.apply(this, args), delay);
        };
    }, []);

    useEffect(() => {
        setShowCategoryMenu(isShowCategoryMenu);
    }, [isShowCategoryMenu]);

    useEffect(() => {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltips = Array.from(tooltipTriggerList).map(tooltipTriggerEl => new Tooltip(tooltipTriggerEl));
        return () => {
            tooltips.forEach(tooltip => tooltip.dispose());
        };
    }, []);

    const prevScrolledRef = React.useRef(isScrolled);
    const prevShowCategoryMenuRef = React.useRef(showCategoryMenu);

    const handleScroll = useCallback(
        throttle(() => {
            requestAnimationFrame(() => {
                const currentScrollY = window.scrollY;
                const scrollThreshold = 256;
                const deadZone = 50;

                if (Math.abs(currentScrollY - scrollThreshold) <= deadZone) {
                    return;
                }

                let newIsScrolled = prevScrolledRef.current;
                if (!prevScrolledRef.current && currentScrollY > scrollThreshold + deadZone) {
                    newIsScrolled = true;
                } else if (prevScrolledRef.current && currentScrollY < scrollThreshold - deadZone) {
                    newIsScrolled = false;
                }

                if (prevScrolledRef.current !== newIsScrolled) {
                    setIsScrolled(newIsScrolled);
                    prevScrolledRef.current = newIsScrolled;
                }

                let newShowCategoryMenu = prevShowCategoryMenuRef.current;

                if (!isShowCategoryMenu) {
                    newShowCategoryMenu = isHovering;
                } else {
                    if (newIsScrolled) {
                        newShowCategoryMenu = isHovering;
                    } else {
                        newShowCategoryMenu = true;
                    }
                }

                if (prevShowCategoryMenuRef.current !== newShowCategoryMenu) {
                    setShowCategoryMenu(newShowCategoryMenu);
                    prevShowCategoryMenuRef.current = newShowCategoryMenu;
                }
            });
        }, 50),
        [isHovering, isShowCategoryMenu]
    );

    useEffect(() => {
        window.addEventListener("scroll", handleScroll, { passive: true });
        return () => window.removeEventListener("scroll", handleScroll);
    }, [handleScroll]);

    const toggleMobileNav = useCallback(() => {
        setIsMobileNavActive(prev => {
            const newState = !prev;
            document.body.classList.toggle('mobile-nav-active', newState);
            return newState;
        });
    }, []);

    const handleNavLinkClick = useCallback(() => {
        if (isMobileNavActive) {
            toggleMobileNav();
        }
    }, [isMobileNavActive, toggleMobileNav]);

    const toggleCategory = useCallback((category) => {
        setExpandedCategory(prev => prev === category ? null : category);
    }, []);

    const handleCategoryMouseEnter = useCallback(
        debounce(() => {
            setIsHovering(true);
            if (isScrolled || !isShowCategoryMenu) {
                setShowCategoryMenu(true);
            }
        }, 50),
        [isScrolled, isShowCategoryMenu]
    );

    const handleCategoryMouseLeave = useCallback(
        debounce(() => {
            setIsHovering(false);
            if (isScrolled || !isShowCategoryMenu) {
                setShowCategoryMenu(false);
            }
        }, 100),
        [isScrolled, isShowCategoryMenu]
    );

    const headerClass = useMemo(() => isScrolled ? 'scrolled' : '', [isScrolled]);
    const categoryDropdownClass = useMemo(() => `dropdown-menu category-dropdown ${showCategoryMenu ? 'show' : ''}`, [showCategoryMenu]);

    const handleLogout = (e) => {
        e.preventDefault();
        logout();
        navigate('/login');
    };

    return (
        <>
            <header className={headerClass}>
                {/* ... phần top bar và logo không đổi ... */}
                <div className="text-white py-2 d-none d-xl-block">
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
                            <div className="col-4 p-0">
                                <div className="d-flex justify-content-end auth-links">
                                    {user ? (
                                        <div
                                            className="user-menu position-relative"
                                            onMouseEnter={() => setShowUserMenu(true)}
                                            onMouseLeave={() => setShowUserMenu(false)}
                                        >
                                            <div className="d-flex align-items-center cursor-pointer">
                                                <img
                                                    src={user.avatar}
                                                    alt={user.username}
                                                    className="rounded-circle"
                                                    style={{ width: '32px', height: '32px', objectFit: 'cover' }}
                                                    referrerPolicy="no-referrer"
                                                />
                                                <span className="ms-2 text-white">{user.username}</span>
                                            </div>
                                            {showUserMenu && (
                                                <div className="position-absolute bg-white shadow p-2 rounded" style={{ top: '100%', right: 0, zIndex: 1000, minWidth: '200px' }}>
                                                    <Link to="/profile" className="d-block p-2 text-decoration-none text-dark">Thông tin tài khoản</Link>
                                                    <Link to="/orders" className="d-block p-2 text-decoration-none text-dark">Đơn hàng của tôi</Link>
                                                    <hr className="my-1" />
                                                    <a
                                                        href="#"
                                                        className="d-block p-2 text-decoration-none text-danger"
                                                        onClick={handleLogout}
                                                    >
                                                        Đăng xuất
                                                    </a>
                                                </div>
                                            )}
                                        </div>
                                    ) : (
                                        <>
                                            <Link to="/register" className="text-decoration-none" style={{ marginRight: '8px' }}>Đăng ký</Link>
                                            <span className="separator">|</span>
                                            <Link to="/login" className="text-decoration-none" style={{ marginLeft: '8px' }}>Đăng nhập</Link>
                                        </>
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="container">
                    <div className="d-flex d-xl-none align-items-center justify-content-between w-100">
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
                                {cartCount > 0 && (
                                    <span
                                        className="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                        style={{ fontSize: '0.75rem' }}
                                    >
                                        {cartCount}
                                    </span>
                                )}
                            </button>
                        </div>
                    </div>

                    <div className="row align-items-center d-none d-xl-flex">
                        <div className="col-xl-3">
                            <Link to="/" className="d-block">
                                <img src={logoImg} alt="Logo" className="img-fluid" style={{ maxHeight: '5.5rem' }} />
                            </Link>
                        </div>
                        <div className="col-xl-9">
                            <div className="d-flex align-items-center justify-content-start">
                                <SearchBar />
                                <div className="d-flex align-items-center justify-content-start text-white">
                                    <div className="d-none d-xl-flex align-items-center px-3 py-2">
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

                <nav className="navbar navbar-expand-xl d-none d-xl-block">
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
                                    className="btn-category d-xl-inline-flex align-items-center text-white"
                                    type="button">
                                    <i className="bi bi-list me-2"></i>
                                    Danh mục sản phẩm
                                </button>

                                <ul className={categoryDropdownClass}>
                                    {menuLoading ? (
                                        <li><span className="dropdown-item">Đang tải...</span></li>
                                    ) : (
                                        <>
                                            {/* SỬA ĐỔI: Thêm mục sản phẩm bán chạy */}
                                            <li>
                                                <Link className="dropdown-item" to="/danh-muc/ban-chay-nhat">
                                                    <i className="bi bi-fire me-2"></i>
                                                    Các Sản Phẩm Bán Chạy
                                                </Link>
                                            </li>

                                            {categories.map(category => {
                                                const categoryStyles = category.styles || [];
                                                const hasSubmenu = categoryStyles.length > 0;

                                                if (hasSubmenu) {
                                                    return (
                                                        <li key={category.id} className="dropdown-submenu">
                                                            <Link className="dropdown-item d-flex justify-content-between align-items-center" to={`/danh-muc/${category.alias}`}>
                                                                <div>
                                                                    {/* SỬA ĐỔI: Thay icon */}
                                                                    <i className="bi bi-cart me-2"></i>
                                                                    {category.name}
                                                                </div>
                                                                <i className="bi bi-chevron-right"></i>
                                                            </Link>
                                                            <ul className="dropdown-menu submenu">
                                                                {categoryStyles.map(style => (
                                                                    <li key={style.id}>
                                                                        <Link className="dropdown-item" to={`/danh-muc/${category.alias}/${style.alias}`}>
                                                                            {style.name}
                                                                        </Link>
                                                                    </li>
                                                                ))}
                                                            </ul>
                                                        </li>
                                                    );
                                                }

                                                return (
                                                    <li key={category.id}>
                                                        <Link className="dropdown-item" to={`/danh-muc/${category.alias}`}>
                                                            {/* SỬA ĐỔI: Thay icon */}
                                                            <i className="bi bi-cart me-2"></i>
                                                            {category.name}
                                                        </Link>
                                                    </li>
                                                );
                                            })}
                                        </>
                                    )}
                                </ul>
                            </div>
                        </div>

                        <div className="d-flex align-items-center justify-content-between flex-grow-1">
                            <div className={`navmenu ${isMobileNavActive ? 'active' : ''}`}>
                                <ul className="navbar-nav">
                                    <li className="nav-item"><Link className="nav-link" to="/" onClick={handleNavLinkClick}>Trang chủ</Link></li>
                                    <li className="nav-item"><Link className="nav-link" to="/gioi-thieu" onClick={handleNavLinkClick}>Giới thiệu</Link></li>
                                    <li className="nav-item"><Link className="nav-link" to="/cua-hang" onClick={handleNavLinkClick}>Sản phẩm</Link></li>
                                    <li className="nav-item"><Link className="nav-link" to="/he-thong-cua-hang" onClick={handleNavLinkClick}>Hệ thống cửa hàng</Link></li>
                                    <li className="nav-item"><Link className="nav-link" to="/gio-hang" onClick={handleNavLinkClick}>Thanh toán</Link></li>
                                    <li className="nav-item"><Link className="nav-link" to="/tin-tuc" onClick={handleNavLinkClick}>Tin tức</Link></li>
                                    <li className="nav-item"><Link className="nav-link" to="/lien-he" onClick={handleNavLinkClick}>Liên hệ</Link></li>
                                </ul>
                            </div>
                            <button
                                className="btn btn-outline-light position-relative ms-auto"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasCart"
                                aria-controls="offcanvasCart"
                            >
                                <i className="bi bi-cart"></i>
                                {cartCount > 0 && (
                                    <span
                                        className="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                        style={{ fontSize: '0.75rem' }}
                                    >
                                        {cartCount}
                                    </span>
                                )}
                            </button>
                        </div>
                    </div>
                </nav>
            </header>

            <div className="offcanvas offcanvas-start" tabIndex="-1" id="mobileNavOffcanvas" aria-labelledby="mobileNavOffcanvasLabel">
                <div className="offcanvas-header bg-light">
                    <h5 className="offcanvas-title text-success fw-bold" id="mobileNavOffcanvasLabel">
                        <i className="bi bi-list me-2"></i>
                        DANH MỤC
                    </h5>
                    <button type="button" className="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div className="offcanvas-body p-0">
                    <div className="list-group list-group-flush">
                        {menuLoading ? (
                            <div className="list-group-item">Đang tải...</div>
                        ) : (
                            <>
                                {/* SỬA ĐỔI: Thêm mục sản phẩm bán chạy cho mobile */}
                                <Link to="/danh-muc/ban-chay-nhat" className="list-group-item list-group-item-action d-flex align-items-center py-3">
                                    <i className="bi bi-fire me-3 text-warning"></i>
                                    <span className="text-uppercase fw-bold">CÁC SẢN PHẨM BÁN CHẠY</span>
                                </Link>

                                {categories.map(category => {
                                    const categoryStyles = category.styles || [];
                                    const hasSubmenu = categoryStyles.length > 0;

                                    if (hasSubmenu) {
                                        return (
                                            <div key={category.id} className="list-group-item p-0">
                                                <button
                                                    className="btn w-100 d-flex align-items-center justify-content-between py-3 px-3 border-0 bg-transparent text-start"
                                                    onClick={() => toggleCategory(category.id)}
                                                >
                                                    <div className="d-flex align-items-center">
                                                        {/* SỬA ĐỔI: Thay icon */}
                                                        <i className="bi bi-cart me-3"></i>
                                                        <span className="text-uppercase fw-bold">{category.name}</span>
                                                    </div>
                                                    <i className={`bi bi-chevron-${expandedCategory === category.id ? 'up' : 'down'}`}></i>
                                                </button>
                                                <div className={`collapse ${expandedCategory === category.id ? 'show' : ''}`}>
                                                    <div className="ps-4 pb-2">
                                                        {categoryStyles.map(style => (
                                                            <Link key={style.id} to={`/danh-muc/${category.alias}/${style.alias}`} className="d-block py-2 text-decoration-none text-dark">
                                                                {style.name}
                                                            </Link>
                                                        ))}
                                                    </div>
                                                </div>
                                            </div>
                                        );
                                    }

                                    return (
                                        <Link key={category.id} to={`/danh-muc/${category.alias}`} className="list-group-item list-group-item-action d-flex align-items-center py-3">
                                            {/* SỬA ĐỔI: Thay icon */}
                                            <i className="bi bi-cart me-3"></i>
                                            <span className="text-uppercase fw-bold">{category.name}</span>
                                        </Link>
                                    );
                                })}
                            </>
                        )}
                    </div>
                </div>
            </div>
            <Cart />
        </>
    );
}

export default Header;
