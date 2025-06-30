import React, { useEffect, useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import ProductSearchBar from '../components/ProductSearchBar';
import ProductSidebar from '../components/ProductSidebar';
import FlowerCard from '../components/FlowerCard';
import hoaKhaiTruong from "../assets/images/hoa-khai-truong.webp"
import 'bootstrap/dist/css/bootstrap.min.css';
import '../styles/pages/Products.css';

const Category = () => {
    const [products, setProducts] = useState([]);
    const { category, style } = useParams();
    const navigate = useNavigate();

    useEffect(() => {
        if (!category) return;
        let apiUrl = '';
        console.log(category)
        if (category === 'ban-chay-nhat') {
            apiUrl = 'http://127.0.0.1:8000/api/products/top';
        } else {
            apiUrl = `http://localhost:8000/api/products/category/${category}`;
            if (style) {
                apiUrl += `/${style}`;
            }
        }
        fetch(apiUrl)
            .then(res => res.json())
            .then(data => setProducts(data.data || []))
            .catch(err => console.error('Error fetching products:', err));
    }, [category, style]);

    const handleProductClick = (id) => {
        navigate(`/cua-hang/${id}`);
    };

    return (
        <div style={{ overflowX: 'hidden' }}>
            <ProductSearchBar />
            <div className="row" style={{ padding: '2rem 12rem 4rem 12rem', backgroundColor: '#EFF0F3' }}>
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

export default Category;