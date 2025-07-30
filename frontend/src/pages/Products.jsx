import React, { useState, useEffect } from 'react';
import { useNavigate, useLocation, Link } from 'react-router-dom';
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

  useEffect(() => {
    const category = searchParams.get('category');
    const keyword = searchParams.get('keyword');
    const sort = searchParams.get('sort') || 'newest';
    setCurrentSort(sort);

    let url;
    if (category && category !== 'all') {
      url = `${import.meta.env.VITE_API_URL}/api/products/category/${category}?sort=${sort}`;
    } else if (keyword) {
      url = `${import.meta.env.VITE_API_URL}/api/products/search?category=${category || 'all'}&keyword=${keyword}&sort=${sort}`;
    } else {
      url = `${import.meta.env.VITE_API_URL}/api/products?sort=${sort}`;
    }

    fetch(url)
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          setProducts(data.data || []);
        }
      })
      .catch(err => console.error('Error fetching products:', err));
  }, [location.search]);

  const handleSortChange = (sort) => {
    const newSearchParams = new URLSearchParams(location.search);
    newSearchParams.set('sort', sort);
    navigate({ search: newSearchParams.toString() });
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
                  >
                    <FlowerCard
                      imageUrl={
                        product.image
                          ? import.meta.env.VITE_API_URL.replace(/\/$/, '') + '/' + product.image.replace(/^\//, '')
                          : hoaKhaiTruong
                      }
                      title={product.title}
                      buttonText="Đặt mua"
                      buttonType="order"
                      productId={product.id}
                      category="cua-hang" // Đảm bảo category đúng
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