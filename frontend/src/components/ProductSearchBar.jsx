import React from 'react';
import '../styles/components/ProductSearchBar.css'
const SearchBar = ({ category, styleType, productQuantity, keyword, onSortChange, currentSort }) => {
  // Map category/slug sang tên tiếng Việt
  const getCategoryName = (cat) => {
    if (!cat) return null;
    if (cat === 'ban-chay-nhat') return 'Bán chạy nhất';
    if (cat === 'hoa-khai-truong') return 'Hoa khai trương';
    if (cat === 'hoa-dam-tang') return 'Hoa đám tang';
    if (cat === 'hoa-gio') return 'Hoa giỏ';
    if (cat === 'hoa-bo') return 'Hoa bó';
    return cat;
  };
  const getStyleName = (cat, style) => {
    if (!style) return null;
    if (cat === 'hoa-khai-truong') {
      if (style === 'mau-truyen-thong') return 'Truyền thống';
      if (style === 'mau-hien-dai') return 'Hiện đại';
    }
    if (cat === 'hoa-dam-tang') {
      if (style === 'mau-truyen-thong') return 'Truyền thống';
      if (style === 'mau-hien-dai') return 'Hiện đại';
      if (style === 'hoa-dam-tang-cong-giao') return 'Công giáo';
    }
    return style;
  };

  return (
    <div className="py-3 wrapper-product-searchbar">
      <div className="row justify-content-between align-items-center">
        <div className="col-lg-8">
          <nav aria-label="breadcrumb">
            <ol className="breadcrumb mb-0">
              <li className="breadcrumb-item"><a href="/">Trang chủ</a></li>
              {category && category !== 'all' ? (
                <li className={`breadcrumb-item${!styleType ? ' active' : ''}`}>
                  {!styleType ? getCategoryName(category) : <a href={`/danh-muc/${category}`}>{getCategoryName(category)}</a>}
                </li>
              ) : !keyword ? (
                <li className="breadcrumb-item active">Cửa hàng</li>
              ) : null}
              {styleType && (
                <li className="breadcrumb-item active">{getStyleName(category, styleType)}</li>
              )}
              {keyword && (
                <li className="breadcrumb-item active">Kết quả tìm kiếm cho "{keyword}"</li>
              )}
            </ol>
          </nav>
        </div>
        <div className="col-lg-4 d-flex justify-content-end align-items-center">
          <p className="mb-0 text-nowrap me-3">{`Showing all ${productQuantity ?? 27} results`}</p>
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

export default SearchBar;