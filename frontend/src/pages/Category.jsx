import React, { useEffect, useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import ProductSearchBar from '../components/ProductSearchBar';
import ProductSidebar from '../components/ProductSidebar';
import FlowerCard from '../components/FlowerCard';
import hoaKhaiTruong from "../assets/images/hoa-khai-truong.webp"
import 'bootstrap/dist/css/bootstrap.min.css';
import '../styles/pages/Products.css';
import '../styles/pages/Category.css'

const Category = () => {
    const [products, setProducts] = useState([]);
    const { category, style } = useParams();
    const navigate = useNavigate();

    useEffect(() => {
        if (!category) return;
        let apiUrl = '';
        if (category === 'ban-chay-nhat') {
            apiUrl = `${import.meta.env.VITE_API_URL}/api/products/top`;
        } else {
            apiUrl = `${import.meta.env.VITE_API_URL}/api/products/category/${category}`;
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

    // Hàm lấy tiêu đề hiển thị theo category và style
    const getCategoryTitle = () => {
        if (!category) return '';
        let title = '';
        if (category === 'hoa-khai-truong') title = 'Hoa khai trương : Điện hoa mừng Khi người thân, đối tác hay khách hàng khai trương công ty, cửa hàng, làm lễ động thổ, khánh thành,…thường sẽ gửi các kệ hoa hay giỏ hoa để chúc mừng…các mẫu hoa mừng khai trương đa dạng thiết kế từ giỏ, lẵng, bó đến các kệ 1 tầng, 2 tầng kết hợp màu sắc nổi bật.';
        else if (category === 'hoa-dam-tang') title = 'Hoa Đám Tang hay hoa tang lễ dùng để viếng người đã khuất giúp giảm bớt không khí tang thương với gia quyến và thể hiện tình cảm đối với người đã khuất. <br> Các mẫu hoa đám tang đa dạng thiết kế từ giỏ, lẵng, bó đến các kệ 1 tầng, 2 tầng kết hợp màu sắc nổi bật. <br>Dù là nhiều hình dáng, kiểu cách nhưng tất cả đều thể hiện tấm lòng chân thành của người còn sống dâng lên người đã khuất.';
        else if (category === 'hoa-gio') title = 'Hoa giỏ là hoa dùng để tặng người thân, đối tác,bạn bè hay khách hàng vào dịp kỷ niệm ngày vui hoặc một sự kiện quan trọng của họ nhằm để thể hiện tình cảm quý trọng với nhau. <br> Các mẫu hoa giỏ đa dạng thiết kế từ giỏ, lẵng, kết hợp màu sắc nổi bật.';
        else if (category === 'hoa-bo') title = 'Hoa Bó là hoa dùng để tặng người thân, đối tác, bạn bè hay khách hàng vào dịp kỷ niệm ngày vui hoặc một sự kiện quan trọng của họ nhằm để thể hiện tình cảm quý trọng với nhau .';
        else if (category === 'ban-chay-nhat') title = 'Bán chạy nhất';
        if (style) {
            if (category === 'hoa-khai-truong') {
                if (style === 'mau-truyen-thong') title = 'Hoa Khai Trương Truyền Thống';
                else if (style === 'mau-hien-dai') title = 'Hoa Khai Trương Hiện Đại';
            }
            else {
                if (style === 'mau-truyen-thong') title = 'Hoa Đám Tang Truyền Thống';
                else if (style === 'mau-hien-dai') title = 'Hoa Đám Tang Hiện Đại';
                else title = 'Hoa Đám Tang Công Giáo';
            }
        }
        return title;
    };

    return (
        <div style={{ overflowX: 'hidden' }}>
            <ProductSearchBar category={category} styleType={style} productQuantity={products.length} />
            <div className="row wrapper-category">
                {/* ProductSidebar: ẩn trên mobile với d-none d-lg-block */}
                <div className="col-lg-3 d-none d-lg-block">
                    <ProductSidebar />
                </div>
                <div className="col-lg-9 col-12">
                    <div className="container">
                        <p dangerouslySetInnerHTML={{ __html: getCategoryTitle() }}></p>
                        <div className="row g-4">
                            {products.map((product, index) => (
                                <div
                                    key={product.id || index}
                                    className="col-lg-3 col-md-4 col-6"
                                    style={{ cursor: 'pointer' }}
                                    onClick={() => handleProductClick(product.id)}
                                >
                                    <FlowerCard
                                        key={product.id || index}
                                        imageUrl={
                                            product.image
                                                ? product.image.replace(
                                                    "http://localhost:8000",
                                                    import.meta.env.VITE_API_URL
                                                )
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
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Category;