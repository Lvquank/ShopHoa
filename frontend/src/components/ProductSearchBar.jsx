import React, { useState, useEffect, useMemo } from 'react';
import { Link } from 'react-router-dom'; // THAY ĐỔI: Dùng Link để không reload trang
import apiClient from '../utils/axios'; // THAY ĐỔI: Import apiClient để gọi API
import '../styles/components/ProductSearchBar.css';

const ProductSearchBar = ({ category, styleType, productQuantity, keyword, onSortChange, currentSort }) => {
  // THAY ĐỔI: State để lưu dữ liệu categories từ API
  const [categoriesData, setCategoriesData] = useState([]);

  // THAY ĐỔI: useEffect để gọi API khi component được tạo
  useEffect(() => {
    const fetchAllCategories = async () => {
      try {
        const response = await apiClient.get('/api/categories');
        setCategoriesData(response.data.data || []);
      } catch (error) {
        console.error("Lỗi khi tải danh sách danh mục:", error);
        setCategoriesData([]); // Đảm bảo state là một mảng nếu có lỗi
      }
    };

    fetchAllCategories();
  }, []); // Mảng rỗng đảm bảo effect chỉ chạy 1 lần

  // THAY ĐỔI: Dùng useMemo để tìm tên category một cách hiệu quả
  const categoryName = useMemo(() => {
    if (!category) return null;
    // Giữ lại trường hợp đặc biệt cho sản phẩm bán chạy
    if (category === 'ban-chay-nhat') return 'Sản phẩm bán chạy nhất';

    const foundCategory = categoriesData.find(c => c.alias === category);
    return foundCategory ? foundCategory.name : category; // Nếu không tìm thấy, hiển thị slug
  }, [category, categoriesData]); // Tính toán lại khi category hoặc dữ liệu thay đổi

  // THAY ĐỔI: Dùng useMemo để tìm tên style một cách hiệu quả
  const styleName = useMemo(() => {
    if (!styleType || !category) return null;

    const foundCategory = categoriesData.find(c => c.alias === category);
    if (foundCategory && foundCategory.styles) {
      const foundStyle = foundCategory.styles.find(s => s.alias === styleType);
      return foundStyle ? foundStyle.name : styleType; // Nếu không tìm thấy, hiển thị slug
    }
    return styleType;
  }, [category, styleType, categoriesData]); // Tính toán lại khi props hoặc dữ liệu thay đổi


  return (
    <div className="py-3 wrapper-product-searchbar">
      <div className="row justify-content-between align-items-center">
        <div className="col-lg-8">
          <nav aria-label="breadcrumb">
            <ol className="breadcrumb mb-0">
              {/* THAY ĐỔI: Dùng Link */}
              <li className="breadcrumb-item"><Link to="/">Trang chủ</Link></li>

              {category && category !== 'all' ? (
                <li className={`breadcrumb-item${!styleType ? ' active' : ''}`}>
                  {/* THAY ĐỔI: Dùng categoryName và Link */}
                  {!styleType ? categoryName : <Link to={`/danh-muc/${category}`}>{categoryName}</Link>}
                </li>
              ) : !keyword ? (
                <li className="breadcrumb-item active">Cửa hàng</li>
              ) : null}

              {styleType && (
                // THAY ĐỔI: Dùng styleName
                <li className="breadcrumb-item active">{styleName}</li>
              )}

              {keyword && (
                <li className="breadcrumb-item active">Kết quả tìm kiếm cho "{keyword}"</li>
              )}
            </ol>
          </nav>
        </div>
        <div className="col-lg-4 d-flex justify-content-end align-items-center">
          <p className="mb-0 text-nowrap me-3">{`Hiển thị tất cả ${productQuantity ?? 0} kết quả`}</p>
          <select
            className="form-select"
            value={currentSort || 'newest'}
            onChange={(e) => onSortChange(e.target.value)}
          >
            <option value="newest">Mới nhất</option>
            <option value="popularity">Thứ tự theo mức độ phổ biến</option>
            <option value="price_asc">Thứ tự theo giá: thấp đến cao</option>
            <option value="price_desc">Thứ tự theo giá: cao đến thấp</option>
          </select>
        </div>
      </div>
    </div>
  );
};

export default ProductSearchBar;