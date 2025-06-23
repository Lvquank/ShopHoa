import React from 'react';
import ProductSearchBar from '../components/ProductSearchBar';
import ProductSidebar from '../components/ProductSidebar';
import FlowerCard from '../components/FlowerCard';
import hoaKhaiTruong from "../assets/images/hoa-khai-truong.webp"
import 'bootstrap/dist/css/bootstrap.min.css';
import '../styles/pages/Products.css';
const Products = () => {
  const products = [
    {
      id: "kt01",
      imageUrl: hoaKhaiTruong,
      title: "Hoa Khai Trương Hiện Đại",
      buttonText: "Đọc tiếp",
      buttonType: "read",
      category: "hoa-khai-truong",
    },
    {
      id: "kt02",
      imageUrl: hoaKhaiTruong,
      title: "Hoa Khai Trương Truyền Thống",
      buttonText: "Đọc tiếp",
      buttonType: "read",
      category: "hoa-khai-truong",
    },
    {
      id: "kt03",
      imageUrl: hoaKhaiTruong,
      title: "Hoa Khai Trương - Shop hoa gần nhất",
      buttonText: "Đọc tiếp",
      buttonType: "read",
      category: "hoa-khai-truong",
    },
    {
      id: "kt04",
      imageUrl: hoaKhaiTruong,
      title: "Hoa Khai Trương - Shop hoa gần nhất",
      buttonText: "Đọc tiếp",
      buttonType: "read",
      category: "hoa-khai-truong",
    },
    {
      id: "kt05",
      imageUrl: hoaKhaiTruong,
      title: "Hoa Khai Trương - Shop hoa gần nhất",
      buttonText: "Đọc tiếp",
      buttonType: "read",
      category: "hoa-khai-truong",
    },
    {
      id: "kt06",
      imageUrl: hoaKhaiTruong,
      title: "Hoa Khai Trương - Shop hoa gần nhất",
      buttonText: "Đọc tiếp",
      buttonType: "read",
      category: "hoa-khai-truong",
    },
  ]
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
                <div key={index} className="col-lg-3 col-md-4 col-sm-6">
                  <FlowerCard
                    key={index}
                    imageUrl={product.imageUrl}
                    title={product.title}
                    buttonText={product.buttonText}
                    buttonType={product.buttonType}
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