import React, { useEffect, useState } from 'react';
import { useNavigate, useLocation } from 'react-router-dom';
import ProductSearchBar from '../components/ProductSearchBar';
import ProductSidebar from '../components/ProductSidebar';
import FlowerCard from '../components/FlowerCard';
import hoaKhaiTruong from "../assets/images/hoa-khai-truong.webp"
import 'bootstrap/dist/css/bootstrap.min.css';
import '../styles/pages/Products.css';

const Products = () => {
  const [products, setProducts] = useState([]);
  const navigate = useNavigate();
  const location = useLocation();
  const searchParams = new URLSearchParams(location.search);
  const [currentSort, setCurrentSort] = useState(searchParams.get('sort') || 'newest');
  // Effect để load sản phẩm khi component mount hoặc URL thay đổi
  useEffect(() => {
    const category = searchParams.get('category');
    const keyword = searchParams.get('keyword');
    const sort = searchParams.get('sort') || 'newest';
    setCurrentSort(sort);

    // Xây dựng URL với tham số sắp xếp
    let url;
    if (category && category !== 'all') {
      url = `${import.meta.env.VITE_API_URL}/api/products/category/${category}?sort=${sort}`;
    } else if (keyword) {
      url = `${import.meta.env.VITE_API_URL}/api/products/search?category=${category || 'all'}&keyword=${keyword}&sort=${sort}`;
    } else {
      url = `${import.meta.env.VITE_API_URL}/api/products?sort=${sort}`;
    }

    // Gọi API
    fetch(url)
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          setProducts(data.data || []);
        }
      })
      .catch(err => console.error('Error fetching products:', err));
  }, [location.search]); // Effect sẽ chạy lại khi URL thay đổi

  // Xử lý khi người dùng thay đổi cách sắp xếp
  const handleSortChange = (sort) => {
    // Cập nhật URL với tham số sort mới
    const newSearchParams = new URLSearchParams(location.search);
    newSearchParams.set('sort', sort);
    navigate({ search: newSearchParams.toString() });
  };

  const handleProductClick = (id) => {
    navigate(`/cua-hang/${id}`);
  };

  return (
    <div style={{ overflowX: 'hidden' }}>
      <ProductSearchBar
        category={searchParams.get('category')}
        keyword={searchParams.get('keyword')}
        productQuantity={products.length}
        onSortChange={handleSortChange}
        currentSort={currentSort}
      />
      <div className="container-fluid wrapper-product">
        <div className="row">
          <div className="col-lg-3 col-md-12">
            <ProductSidebar />
          </div>
          <div className="col-lg-9 col-md-12">
            {products.length === 0 ? (
              <div style={{ fontSize: "18px" }}>
                Không tìm thấy sản phẩm nào khớp với lựa chọn của bạn.
              </div>
            ) : (
              <div className="row g-4">
                {products.map((product, index) => (
                  <div
                    key={product.id || index}
                    className="col-lg-3 col-md-6 col-6"
                    style={{ cursor: 'pointer' }}
                    onClick={() => handleProductClick(product.id)}
                  >
                    <FlowerCard
                      key={product.id || index}
                      imageUrl={
                        product.image
                          ? product.image.replace("http://localhost:8000", import.meta.env.VITE_API_URL)
                          : hoaKhaiTruong
                      }

                      title={product.title}
                      buttonText="Đặt mua"
                      buttonType="order"
                      productId={product.id}
                      category={product.category}
                    />
                  </div>
                ))}
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
};

export default Products;