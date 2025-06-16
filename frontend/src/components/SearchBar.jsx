import React from 'react';
import { Link } from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';

function SearchBar() {
    return (
        <div className="input-group bg-white">
            <div className="dropdown">
                <button className="btn dropdown-toggle" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Danh mục sản phẩm
                </button>
                <ul className="dropdown-menu">
                    <li>
                        <Link className="dropdown-item d-flex justify-content-between align-items-center" to="/san-pham/ban-chay">
                            <div>
                                Danh mục sản phẩm
                            </div>
                        </Link>
                    </li>
                    <li>
                        <Link className="dropdown-item d-flex justify-content-between align-items-center" to="/san-pham/ban-chay">
                            <div>
                                Bán chạy nhất
                            </div>
                        </Link>
                    </li>
                    <li>
                        <Link className="dropdown-item d-flex justify-content-between align-items-center" to="/san-pham/hoa-bo">
                            <div>
                                Hoa Bó
                            </div>
                        </Link>
                    </li>
                    <li>
                        <Link className="dropdown-item d-flex justify-content-between align-items-center" to="/san-pham/hoa-dam-tang">
                            <div>
                                Hoa Đám Tang
                            </div>
                        </Link>
                    </li>
                    <li>
                        <Link className="dropdown-item d-flex justify-content-between align-items-center" to="/san-pham/hoa-gio">
                            <div>
                                Hoa Giỏ
                            </div>
                        </Link>
                    </li>
                    <li>
                        <Link className="dropdown-item d-flex justify-content-between align-items-center" to="/san-pham/hoa-khai-truong">
                            <div>
                                Hoa Khai Trương
                            </div>
                        </Link>
                    </li>
                    <li>
                        <Link className="dropdown-item d-flex justify-content-between align-items-center" to="/san-pham/khuyen-mai">
                            <div>
                                Khuyến mãi
                            </div>
                        </Link>
                    </li>
                </ul>
            </div>
            <input type="text" className="form-control border-0" placeholder="Tìm kiếm sản phẩm..." />
            <button className="btn btn-primary-color text-white">
                <i className="bi bi-search"></i>
            </button>
        </div>
    );
}

export default SearchBar;
