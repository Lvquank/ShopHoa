import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';
import '../styles/components/ProductSidebar.css';
const SidebarFilter = () => {
    const [expandedItems, setExpandedItems] = useState({
        hoaKhaiTruong: true,
        hoaDamTang: false
    });

    const toggleExpand = (item) => {
        setExpandedItems(prev => ({
            ...prev,
            [item]: !prev[item]
        }));
    };

    return (
        <div className="sidebar bg-light p-3">

            <div className="list-group list-group-flush">
                {/* Các Sản Phẩm Bán Chạy */}
                <div className="list-group-item border-0 bg-transparent px-0 py-2">
                    <Link className="text-decoration-none text-dark d-flex align-items-center sidebar-item px-2 py-1" to="/san-pham">
                        <span className="me-2" style={{ fontSize: '14px', color: '#6c757d' }}>♦</span>
                        <span className="fw-bold">Các Sản Phẩm Bán Chạy</span>
                    </Link>
                </div>

                {/* Hoa Khai Trương */}
                <div className="list-group-item border-0 bg-transparent px-0 py-1">
                    <div className="d-flex justify-content-between align-items-center sidebar-item px-2 py-1">
                        <Link className="text-decoration-none d-flex align-items-center flex-grow-1" to="/san-pham/hoa-khai-truong">
                            <i className="bi bi-cart me-2" style={{ fontSize: '14px', color: '#6c757d' }}></i>
                            <span className="text-dark">Hoa Khai Trương</span>
                        </Link>
                        <i
                            className={`bi ${expandedItems.hoaKhaiTruong ? 'bi-chevron-up' : 'bi-chevron-down'} chevron-btn`}
                            style={{ fontSize: '12px', color: '#6c757d' }}
                            onClick={() => toggleExpand('hoaKhaiTruong')}
                        ></i>
                    </div>
                    {/* Submenu */}
                    <div className={`ms-4 mt-1 submenu-collapse ${expandedItems.hoaKhaiTruong ? 'submenu-expanded' : 'submenu-collapsed'}`}>
                        <div className="py-1 submenu-item px-2">
                            <Link className="text-decoration-none text-muted small" to="/san-pham/hoa-khai-truong/truyen-thong">
                                Mẫu truyền Thống
                            </Link>
                        </div>
                        <div className="py-1 submenu-item px-2">
                            <Link className="text-decoration-none text-muted small" to="/san-pham/hoa-khai-truong/hien-dai">
                                Mẫu Hiện Đại
                            </Link>
                        </div>
                    </div>
                </div>

                {/* Hoa Đám Tang */}
                <div className="list-group-item border-0 bg-transparent px-0 py-1">
                    <div className="d-flex justify-content-between align-items-center sidebar-item px-2 py-1">
                        <Link className="text-decoration-none d-flex align-items-center flex-grow-1" to="/san-pham/hoa-dam-tang">
                            <i className="bi bi-cart me-2" style={{ fontSize: '14px', color: '#6c757d' }}></i>
                            <span className="text-dark">Hoa Đám Tang</span>
                        </Link>
                        <i
                            className={`bi ${expandedItems.hoaDamTang ? 'bi-chevron-up' : 'bi-chevron-down'} chevron-btn`}
                            style={{ fontSize: '12px', color: '#6c757d' }}
                            onClick={() => toggleExpand('hoaDamTang')}
                        ></i>
                    </div>
                    {/* Submenu */}
                    <div className={`ms-4 mt-1 submenu-collapse ${expandedItems.hoaDamTang ? 'submenu-expanded' : 'submenu-collapsed'}`}>
                        <div className="py-1 submenu-item px-2">
                            <Link className="text-decoration-none text-muted small" to="/san-pham/hoa-dam-tang/truyen-thong">
                                Mẫu Truyền Thống
                            </Link>
                        </div>
                        <div className="py-1 submenu-item px-2">
                            <Link className="text-decoration-none text-muted small" to="/san-pham/hoa-dam-tang/hien-dai">
                                Mẫu Hiện Đại
                            </Link>
                        </div>
                        <div className="py-1 submenu-item px-2">
                            <Link className="text-decoration-none text-muted small" to="/san-pham/hoa-dam-tang/cong-giao">
                                Hoa Đám Tang Công Giáo
                            </Link>
                        </div>
                    </div>
                </div>

                {/* Hoa Giỏ */}
                <div className="list-group-item border-0 bg-transparent px-0 py-1">
                    <Link className="text-decoration-none d-flex align-items-center sidebar-item px-2 py-1" to="/san-pham/hoa-gio">
                        <i className="bi bi-cart me-2" style={{ fontSize: '14px', color: '#6c757d' }}></i>
                        <span className="text-dark">Hoa Giỏ</span>
                    </Link>
                </div>

                {/* Hoa Bó */}
                <div className="list-group-item border-0 bg-transparent px-0 py-1">
                    <Link className="text-decoration-none d-flex align-items-center sidebar-item px-2 py-1" to="/san-pham/hoa-bo">
                        <i className="bi bi-cart me-2" style={{ fontSize: '14px', color: '#6c757d' }}></i>
                        <span className="text-dark">Hoa Bó</span>
                    </Link>
                </div>
            </div>
        </div>
    );
};

export default SidebarFilter;