import React, { useState, useRef, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';

function SearchBar() {
    const navigate = useNavigate();
    const [isOpen, setIsOpen] = useState(false);
    const [selectedCategory, setSelectedCategory] = useState('Danh mục sản phẩm');
    const [searchTerm, setSearchTerm] = useState('');
    const dropdownRef = useRef(null);

    // Đóng dropdown khi click bên ngoài
    useEffect(() => {
        const handleClickOutside = (event) => {
            if (dropdownRef.current && !dropdownRef.current.contains(event.target)) {
                setIsOpen(false);
            }
        };

        document.addEventListener('mousedown', handleClickOutside);
        return () => {
            document.removeEventListener('mousedown', handleClickOutside);
        };
    }, []);

    const toggleDropdown = () => {
        setIsOpen(!isOpen);
    };

    const handleSearch = () => {
        if (!searchTerm && selectedCategory === 'Danh mục sản phẩm') return;

        if (selectedCategory === 'Bán chạy nhất') {
            navigate(`/tim-kiem?type=top${searchTerm ? `&keyword=${encodeURIComponent(searchTerm)}` : ''}`);
            return;
        }

        let category = 'all';
        switch (selectedCategory) {
            case 'Hoa Bó':
                category = 'hoa-bo';
                break;
            case 'Hoa Đám Tang':
                category = 'hoa-dam-tang';
                break;
            case 'Hoa Giỏ':
                category = 'hoa-gio';
                break;
            case 'Hoa Khai Trương':
                category = 'hoa-khai-truong';
                break;
            case 'Khuyến mãi':
                category = 'khuyen-mai';
                break;
            default:
                category = 'all';
        }

        navigate(`/tim-kiem?category=${category}&keyword=${encodeURIComponent(searchTerm)}`);
    };

    const handleKeyPress = (e) => {
        if (e.key === 'Enter') {
            handleSearch();
        }
    };

    return (
        <div className="input-group bg-white">
            <div className="dropdown" ref={dropdownRef}>
                <button
                    className="btn dropdown-toggle"
                    style={{ fontWeight: '400' }}
                    type="button"
                    aria-expanded={isOpen}
                    onClick={toggleDropdown}
                >
                    {selectedCategory}
                </button>
                <ul className={`dropdown-menu ${isOpen ? 'show' : ''}`}>
                    <li>
                        <div
                            className="dropdown-item d-flex justify-content-between align-items-center"
                            onClick={() => {
                                setSelectedCategory('Danh mục sản phẩm');
                                setIsOpen(false);
                            }}
                            style={{ cursor: 'pointer' }}
                        >
                            <div>
                                Danh mục sản phẩm
                            </div>
                        </div>
                    </li>
                    <li>
                        <div
                            className="dropdown-item d-flex justify-content-between align-items-center"
                            onClick={() => {
                                setSelectedCategory('Bán chạy nhất');
                                setIsOpen(false);
                            }}
                            style={{ cursor: 'pointer' }}
                        >
                            <div>
                                Bán chạy nhất
                            </div>
                        </div>
                    </li>
                    <li>
                        <div
                            className="dropdown-item d-flex justify-content-between align-items-center"
                            onClick={() => {
                                setSelectedCategory('Hoa Bó');
                                setIsOpen(false);
                            }}
                            style={{ cursor: 'pointer' }}
                        >
                            <div>
                                Hoa Bó
                            </div>
                        </div>
                    </li>
                    <li>
                        <div
                            className="dropdown-item d-flex justify-content-between align-items-center"
                            onClick={() => {
                                setSelectedCategory('Hoa Đám Tang');
                                setIsOpen(false);
                            }}
                            style={{ cursor: 'pointer' }}
                        >
                            <div>
                                Hoa Đám Tang
                            </div>
                        </div>
                    </li>
                    <li>
                        <div
                            className="dropdown-item d-flex justify-content-between align-items-center"
                            onClick={() => {
                                setSelectedCategory('Hoa Giỏ');
                                setIsOpen(false);
                            }}
                            style={{ cursor: 'pointer' }}
                        >
                            <div>
                                Hoa Giỏ
                            </div>
                        </div>
                    </li>
                    <li>
                        <div
                            className="dropdown-item d-flex justify-content-between align-items-center"
                            onClick={() => {
                                setSelectedCategory('Hoa Khai Trương');
                                setIsOpen(false);
                            }}
                            style={{ cursor: 'pointer' }}
                        >
                            <div>
                                Hoa Khai Trương
                            </div>
                        </div>
                    </li>
                    <li>
                        <div
                            className="dropdown-item d-flex justify-content-between align-items-center"
                            onClick={() => {
                                setSelectedCategory('Khuyến mãi');
                                setIsOpen(false);
                            }}
                            style={{ cursor: 'pointer' }}
                        >
                            <div>
                                Khuyến mãi
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <input
                type="text"
                className="form-control border-0"
                placeholder="Tìm kiếm sản phẩm..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                onKeyPress={handleKeyPress}
            />
            <button
                className="btn btn-primary-color text-white"
                onClick={handleSearch}
            >
                <i className="bi bi-search"></i>
            </button>
        </div>
    );
}

export default SearchBar;