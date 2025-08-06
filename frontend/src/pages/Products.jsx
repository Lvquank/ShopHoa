import React, { useState } from 'react';
import { useNavigate, useLocation } from 'react-router-dom';
import { useQuery } from '@tanstack/react-query';
import apiClient from '../utils/axios';
import ProductSearchBar from '../components/ProductSearchBar';
import ProductSidebar from '../components/ProductSidebar';
import FlowerCard from '../components/FlowerCard';
import hoaKhaiTruong from "../assets/images/hoa-khai-truong.webp";
import 'bootstrap/dist/css/bootstrap.min.css';
import '../styles/pages/Products.css';

// --- Hàm Fetch dữ liệu được đưa ra ngoài component ---
const fetchFilteredProducts = async ({ queryKey }) => {
  // queryKey sẽ là ['products', { category, keyword, sort }]
  const [_key, filters] = queryKey;
  const { category, keyword, sort } = filters;

  // Xây dựng URL dựa trên các bộ lọc
  let url;
  if (category && category !== 'all') {
    url = `/api/products/category/${category}?sort=${sort}`;
  } else if (keyword) {
    url = `/api/products/search?category=${category || 'all'}&keyword=${keyword}&sort=${sort}`;
  } else {
    url = `/api/products?sort=${sort}`;
  }

  const { data } = await apiClient.get(url);

  if (data.success && Array.isArray(data.data)) {
    // Xử lý lại URL ảnh
    return data.data.map(product => ({
      ...product,
      image: product.image
        ? `${import.meta.env.VITE_API_URL.replace(/\/$/, '')}/${product.image.replace(/^\//, '')}`
        : hoaKhaiTruong
    }));
  }

  // Nếu API không trả về success hoặc data không phải mảng, trả về mảng rỗng
  return [];
};

// --- Component Skeleton Loader ---
const ProductSkeleton = () => (
  <div className="col-xl-3 col-lg-4 col-sm-6 col-6">
    <div className="card border-0 product-card" aria-hidden="true">
      <div style={{ height: '250px', backgroundColor: '#f0f0f0' }} className="card-img-top rounded"></div>
      <div className="card-body text-center">
        <h5 className="card-title placeholder-glow">
          <span className="placeholder col-8"></span>
        </h5>
      </div>
    </div>
  </div>
);


const Products = () => {
  const navigate = useNavigate();
  const location = useLocation();

  // Lấy các tham số từ URL
  const searchParams = new URLSearchParams(location.search);
  const category = searchParams.get('category') || 'all';
  const keyword = searchParams.get('keyword') || '';
  const sort = searchParams.get('sort') || 'newest';

  // Sử dụng useQuery để tải dữ liệu
  const {
    data: products = [], // Mặc định là mảng rỗng
    isLoading,
    isError,
    error
  } = useQuery({
    // queryKey phải chứa tất cả các tham số ảnh hưởng đến kết quả
    queryKey: ['products', { category, keyword, sort }],
    queryFn: fetchFilteredProducts,
    // Giữ lại dữ liệu cũ trong khi tải dữ liệu mới để tránh màn hình trắng
    keepPreviousData: true,
  });

  const handleSortChange = (newSort) => {
    const newSearchParams = new URLSearchParams(location.search);
    newSearchParams.set('sort', newSort);
    navigate({ search: newSearchParams.toString() });
  };

  if (isError) {
    return <div className="container text-center py-5 text-danger">Đã có lỗi xảy ra: {error.message}</div>
  }

  return (
    <div style={{ overflowX: 'hidden' }}>
      <ProductSearchBar
        category={category}
        keyword={keyword}
        productQuantity={products.length}
        onSortChange={handleSortChange}
        currentSort={sort}
      />
      <div className="container-fluid wrapper-product">
        <div className="row">
          <div className="col-xl-3 col-lg-3 col-md-12">
            <div className="product-sidebar">
              <ProductSidebar />
            </div>
          </div>
          <div className="col-xl-9 col-lg-9 col-md-12">
            <div className="row g-3 g-md-4">
              {isLoading ? (
                // Hiển thị skeleton loader khi đang tải
                Array.from({ length: 8 }).map((_, index) => <ProductSkeleton key={index} />)
              ) : products.length === 0 ? (
                <div className="col-12" style={{ fontSize: "18px" }}>
                  Không tìm thấy sản phẩm nào khớp với lựa chọn của bạn.
                </div>
              ) : (
                products.map((product, index) => (
                  <div
                    key={product.id || index}
                    className="col-xl-3 col-lg-4 col-sm-6 col-6"
                  >
                    <FlowerCard
                      imageUrl={product.image}
                      title={product.title}
                      buttonText="Đặt mua"
                      buttonType="order"
                      productId={product.id}
                      category="cua-hang"
                    />
                  </div>
                ))
              )}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Products;
