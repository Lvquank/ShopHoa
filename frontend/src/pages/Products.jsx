import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import ProductSearchBar from '../components/ProductSearchBar';
import ProductSidebar from '../components/ProductSidebar';
import FlowerCard from '../components/FlowerCard';
import hoaKhaiTruong from "../assets/images/hoa-khai-truong.webp"
import 'bootstrap/dist/css/bootstrap.min.css';
import '../styles/pages/Products.css';

const Products = () => {
  const [products, setProducts] = useState([]);
  const navigate = useNavigate();

  useEffect(() => {
    fetch('http://localhost:8000/api/products')
      .then(res => res.json())
      .then(data => setProducts(data.data || []))
      .catch(err => console.error('Error fetching products:', err));
  }, []);

  const handleProductClick = (id) => {
    navigate(`/cua-hang/${id}`);
  };

  return (
    <div>
      <ProductSearchBar />
      <div className="wrapper row">
        <div className="col-lg-3">
          <ProductSidebar />
        </div>
        <div className="col-lg-9">
          <div className="container">
            <div className="row g-4">
              {products.map((product, index) => (
                <div
                  key={product.id || index}
                  className="col-lg-3 col-md-4 col-sm-6"
                  style={{ cursor: 'pointer' }}
                  onClick={() => handleProductClick(product.id)}
                >
                  <FlowerCard
                    key={product.id || index}
                    imageUrl={product.image || hoaKhaiTruong}
                    title={product.title}
                    buttonText="Đặt mua"
                    buttonType="order"
                    productId={product.id}
                    category={product.category}
                  />
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Products;