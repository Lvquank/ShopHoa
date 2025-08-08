import React, { useState, useEffect, useRef, useCallback } from 'react';
// THÊM MỚI: import useLocation
import { Link, useNavigate, useLocation } from 'react-router-dom';
import apiClient from '../utils/axios';

function debounce(func, delay) {
    let timeout;
    return function (...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), delay);
    };
}

function SearchBar() {
    const navigate = useNavigate();
    // THÊM MỚI: Lấy thông tin URL hiện tại
    const location = useLocation();

    const [searchTerm, setSearchTerm] = useState('');
    const [results, setResults] = useState([]);
    const [loading, setLoading] = useState(false);
    const [isOpen, setIsOpen] = useState(false);
    const [categories, setCategories] = useState([]);
    const [menuLoading, setMenuLoading] = useState(true);
    const [selectedCategory, setSelectedCategory] = useState({ name: 'Tất cả danh mục', alias: 'all' });
    const searchContainerRef = useRef(null);

    // THÊM MỚI: useEffect để đồng bộ state từ URL
    useEffect(() => {
        // Cập nhật ô tìm kiếm từ query param 'keyword'
        const params = new URLSearchParams(location.search);
        const keywordFromUrl = params.get('keyword') || '';
        setSearchTerm(keywordFromUrl);

        // Cập nhật danh mục được chọn từ pathname
        const pathParts = location.pathname.split('/').filter(Boolean);
        if (pathParts[0] === 'danh-muc' && pathParts[1]) {
            const categoryFromUrl = categories.find(c => c.alias === pathParts[1]);
            if (categoryFromUrl) {
                setSelectedCategory(categoryFromUrl);
            }
        } else {
            setSelectedCategory({ name: 'Tất cả danh mục', alias: 'all' });
        }
    }, [location.pathname, location.search, categories]); // Chạy lại khi URL hoặc danh sách category thay đổi


    // Effect tải danh mục (giữ nguyên)
    useEffect(() => {
        const fetchCategories = async () => {
            setMenuLoading(true);
            try {
                const response = await apiClient.get('/api/categories');
                setCategories(response.data.data || []);
            } catch (error) {
                console.error("Lỗi khi tải danh mục:", error);
            } finally {
                setMenuLoading(false);
            }
        };
        fetchCategories();
    }, []);

    // Effect đóng dropdown khi click ra ngoài (giữ nguyên)
    useEffect(() => {
        const handleClickOutside = (event) => {
            if (searchContainerRef.current && !searchContainerRef.current.contains(event.target)) {
                setIsOpen(false);
                setResults([]);
            }
        };
        document.addEventListener('mousedown', handleClickOutside);
        return () => document.removeEventListener('mousedown', handleClickOutside);
    }, []);

    // Live search (giữ nguyên)
    const debouncedSearch = useCallback(
        debounce(async (term, category) => {
            if (!term.trim()) {
                setResults([]);
                return;
            }
            setLoading(true);
            try {
                const params = new URLSearchParams();
                if (category.alias !== 'all') params.append('category', category.alias);
                params.append('keyword', term);
                const response = await apiClient.get(`/api/products/search?${params.toString()}`);
                if (response.data.success) {
                    setResults(response.data.data);
                } else {
                    setResults([]);
                }
            } catch (error) {
                console.error("Lỗi live search:", error);
            } finally {
                setLoading(false);
            }
        }, 300),
        []
    );

    useEffect(() => {
        debouncedSearch(searchTerm, selectedCategory);
    }, [searchTerm, selectedCategory, debouncedSearch]);

    // Navigation search (giữ nguyên)
    const handleNavigationSearch = () => {
        setResults([]);
        const keywordParam = searchTerm.trim() ? `?keyword=${encodeURIComponent(searchTerm.trim())}` : '';

        if (selectedCategory.alias === 'all') {
            navigate(`/cua-hang${keywordParam}`);
        } else {
            navigate(`/danh-muc/${selectedCategory.alias}${keywordParam}`);
        }
        // Không cần xóa searchTerm ở đây nữa vì nó sẽ được cập nhật từ URL
    };

    const handleKeyPress = (e) => {
        if (e.key === 'Enter') {
            handleNavigationSearch();
        }
    };

    const handleResultClick = () => {
        setResults([]);
        setSearchTerm('');
    };

    return (
        <div className="input-group" ref={searchContainerRef}>
            <div className="input-group bg-white">
                <div className="dropdown">
                    <button className="btn dropdown-toggle" style={{ fontWeight: '400' }} type="button" onClick={() => setIsOpen(!isOpen)}>
                        {selectedCategory.name}
                    </button>
                    <ul className={`dropdown-menu rounded-0 ${isOpen ? 'show' : ''}`} style={{ cursor: 'pointer' }}>
                        {menuLoading ? (
                            <li><span className="dropdown-item">Đang tải...</span></li>
                        ) : (
                            <>
                                <li onClick={() => { setSelectedCategory({ name: 'Tất cả danh mục', alias: 'all' }); setIsOpen(false); }}>
                                    <div className="dropdown-item">Tất cả danh mục</div>
                                </li>
                                {categories.map(cat => (
                                    <li key={cat.id} onClick={() => { setSelectedCategory(cat); setIsOpen(false); }}>
                                        <div className="dropdown-item">{cat.name}</div>
                                    </li>
                                ))}
                            </>
                        )}
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
                <button className="btn btn-primary-color text-white" onClick={handleNavigationSearch}>
                    <i className="bi bi-search"></i>
                </button>
            </div>

            {(loading || (results.length > 0 && searchTerm)) && (
                <div className="list-group position-absolute w-100" style={{ zIndex: 1000, top: '100%', borderRadius: 0 }}>
                    {loading ? (
                        <div className="list-group-item" style={{ borderRadius: 0 }}>Đang tìm...</div>
                    ) : results.length > 0 ? (
                        results.map(product => (
                            <Link
                                key={product.id}
                                to={`/cua-hang/${product.id}`}
                                className="list-group-item list-group-item-action d-flex align-items-center"
                                style={{ borderRadius: 0 }}
                                onClick={handleResultClick}
                            >
                                <img
                                    src={import.meta.env.VITE_API_URL.replace(/\/$/, '') + '/' + product.image}
                                    alt={product.title}
                                    style={{
                                        width: '50px',
                                        height: '50px',
                                        objectFit: 'cover',
                                        marginRight: '15px',
                                        borderRadius: '4px'
                                    }}
                                    onError={(e) => { e.target.onerror = null; e.target.src = "https://via.placeholder.com/50"; }}
                                />
                                <span>{product.title}</span>
                            </Link>
                        ))
                    ) : (
                        <div className="list-group-item" style={{ borderRadius: 0 }}>Không tìm thấy kết quả.</div>
                    )}
                </div>
            )}
        </div>
    );
}

export default SearchBar;