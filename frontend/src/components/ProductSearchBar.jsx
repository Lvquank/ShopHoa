import React from 'react';

const SearchBar = () => {
  return (
    <div className="container py-3">
      <div className="row justify-content-between align-items-center">
        <div className="col-lg-8">
          <nav aria-label="breadcrumb">
            <ol className="breadcrumb mb-0">
              <li className="breadcrumb-item"><a href="/">Trang chủ</a></li>
              <li className="breadcrumb-item active">Cửa hàng</li>
            </ol>
          </nav>
        </div>
        <div className="col-lg-4 d-flex justify-content-end align-items-center">
          <p className="mb-0 text-nowrap me-3">Showing all 29 results</p>
          <select className="form-select" defaultValue="Thứ tự mặc định">
            <option value="Thứ tự mặc định">Thứ tự mặc định</option>
            <option value="Giá: Thấp đến cao">Giá: Thấp đến cao</option>
            <option value="Giá: Cao đến thấp">Giá: Cao đến thấp</option>
            <option value="Mới nhất">Mới nhất</option>
          </select>
        </div>
      </div>
    </div>
  );
};

export default SearchBar;