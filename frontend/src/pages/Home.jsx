import React from "react";
import { Link } from "react-router-dom";
import { useQuery } from "@tanstack/react-query";
import apiClient from "../utils/axios"; // Sử dụng axios instance đã cấu hình

// Import các components và assets
import "../styles/pages/Home.css";
import Intro from "../components/Intro";
import OpeningFlowersCard from "../components/OpeningFlowerCard";
import TitleSection from "../components/TitleSection";
import FlowerCard from "../components/FlowerCard";
import CategoryGrid from "../components/CategoryGrid";
import RelatedProducts from "../components/RelatedProducts";
import NewsCard from "../components/NewsCard";
import ServicesSection from "../components/ServicesSection";

// Import ảnh (giữ nguyên)
import hoaKhaiTruongDefault from "../assets/images/hoa-khai-truong.webp";
import hoaDamTangDefault from "../assets/images/hoa-dam-tang.webp";
import categoryHoaKhaiTruong from "../assets/images/hoakhaitruong-218x341-1.webp";
import categoryHoaDamTang from "../assets/images/hoadamtang-218x341-1.webp";
import categoryHoaGio from "../assets/images/hoa-gio.jpg";
import categoryHoaBo from "../assets/images/hoa-bo.webp";
import newsImageDefault from "../assets/images/hoa-gio.webp";
import openingFlowerImage from "../assets/images/banner-d2.webp";
import openingFlowerImage2 from "../assets/images/banner-d4.webp";

// --- CÁC HÀM FETCH DỮ LIỆU ---
// Hàm helper để tạo URL ảnh hoàn chỉnh
const formatImageUrl = (imagePath, defaultImage) => {
    if (!imagePath) return defaultImage;
    const VITE_API_URL = import.meta.env.VITE_API_URL;
    return `${VITE_API_URL.replace(/\/$/, '')}/${imagePath.replace(/^\//, '')}`;
};

// Hàm chung để fetch sản phẩm
const fetchProducts = async (endpoint, defaultImage) => {
    const { data } = await apiClient.get(endpoint);
    if (data.success && Array.isArray(data.data)) {
        return data.data.map(product => ({
            ...product,
            image: formatImageUrl(product.image, defaultImage),
        }));
    }
    // Ném lỗi để useQuery có thể bắt được
    throw new Error("Không thể tải sản phẩm");
};

// Hàm để fetch tin tức
const fetchPosts = async () => {
    const { data } = await apiClient.get('/api/posts');
    const posts = data.data || data;
    if (Array.isArray(posts)) {
        return posts.map(post => ({
            ...post,
            imageUrl: formatImageUrl(post.image, newsImageDefault),
            id: post.id,
            title: post.title,
            date: post.created_at,
            excerpt: post.content?.substring(0, 100) + '...'
        }));
    }
    // Ném lỗi để useQuery có thể bắt được
    throw new Error("Không thể tải tin tức");
};

// LỖI SỐ 1 ĐÃ SỬA: Đưa custom hook ra ngoài component
const useCategoryQuery = (categoryAlias, defaultImage) => {
    return useQuery({
        queryKey: ['products', categoryAlias],
        queryFn: () => fetchProducts(`/api/products/category/${categoryAlias}`, defaultImage),
    });
};


function Home() {
    // --- SỬ DỤNG useQuery ĐỂ GỌI API ---

    // 1. Query cho các sản phẩm bán chạy nhất
    const { data: topProductsData = [], isLoading: isLoadingTopProducts } = useQuery({
        queryKey: ['products', 'top'],
        queryFn: () => fetchProducts('/api/products/top', hoaKhaiTruongDefault),
    });

    // 2. Query cho các danh mục sản phẩm (sử dụng custom hook đã được đưa ra ngoài)
    const { data: productsKhaiTruong = [], isLoading: isLoadingKhaiTruong } = useCategoryQuery("hoa-khai-truong", hoaKhaiTruongDefault);
    const { data: productsDamTang = [], isLoading: isLoadingDamTang } = useCategoryQuery("hoa-dam-tang", hoaDamTangDefault);
    const { data: productsGio = [], isLoading: isLoadingGio } = useCategoryQuery("hoa-gio", newsImageDefault);
    const { data: productsBo = [], isLoading: isLoadingBo } = useCategoryQuery("hoa-bo", categoryHoaBo);

    // 3. Query cho tin tức
    const { data: newsData = [], isLoading: isLoadingNews } = useQuery({
        queryKey: ['posts'],
        queryFn: fetchPosts,
    });

    // --- DỮ LIỆU TĨNH VÀ DỮ LIỆU ĐƯỢC SUY RA ---
    const topSellingProducts = topProductsData.slice(0, 4);
    const relatedProducts = topProductsData.map(product => ({
        id: product.id,
        imageUrl: product.image,
        title: product.title,
    }));

    const categoryDataHoaKhaiTruong = { imageUrl: categoryHoaKhaiTruong, title: "HOA KHAI TRƯƠNG" };
    const categoryDataHoaDamTang = { imageUrl: categoryHoaDamTang, title: "HOA TANG LỄ" };
    const categoryDataHoaGio = { imageUrl: categoryHoaGio, title: "HOA GIỎ" };
    const categoryDataHoaBo = { imageUrl: categoryHoaBo, title: "HOA BÓ" };

    const OpeningFlower = [
        { imageUrl: hoaKhaiTruongDefault, title: "Hoa khai trương", productCount: productsKhaiTruong.length, link: "/danh-muc/hoa-khai-truong" },
        { imageUrl: hoaDamTangDefault, title: "Hoa đám tang", productCount: productsDamTang.length, link: "/danh-muc/hoa-dam-tang" },
    ];

    const topBanners = [
        { imageUrl: openingFlowerImage, title: "Hoa khai trương" },
        { imageUrl: openingFlowerImage2, title: "Hoa đám tang" },
    ];

    // Helper component để hiển thị skeleton loader
    const ProductSkeleton = () => (
        <div className="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            <div className="card border-0" aria-hidden="true">
                <div style={{ height: '250px', backgroundColor: '#f0f0f0' }} className="card-img-top rounded"></div>
                <div className="card-body text-center">
                    <h5 className="card-title placeholder-glow">
                        <span className="placeholder col-8"></span>
                    </h5>
                </div>
            </div>
        </div>
    );

    return (
        <div className="min-vh-100 d-flex flex-column">
            <div className="main-content flex-grow-1">
                {/* Intro Section */}
                <div className="intro-section mb-5">
                    <div className="row h-100">
                        <div className="col-lg-3"></div>
                        <div className="col-lg-9 col-md-12">
                            <Intro />
                        </div>
                    </div>
                </div>

                {/* Product Categories Section */}
                <div className="product-categories-section">
                    <div className="container">
                        <div className="row mb-4">
                            <div className="col-12 text-center">
                                <h2 className="section-title">SHOP HOA TƯƠI</h2>
                                <div className="title-underline"></div>
                            </div>
                        </div>
                        <div className="row justify-content-center">
                            {OpeningFlower.map((item, index) => (
                                <OpeningFlowersCard key={index} {...item} />
                            ))}
                        </div>
                    </div>
                </div>

                {/* Top Selling Section */}
                <TitleSection title="TOP BÁN CHẠY" />
                <div className="row mb-4">
                    {isLoadingTopProducts ? (
                        Array.from({ length: 4 }).map((_, index) => <ProductSkeleton key={index} />)
                    ) : (
                        topSellingProducts.map((product) => (
                            <div key={product.id} className="col-12 col-sm-6 col-md-3">
                                <FlowerCard
                                    imageUrl={product.image}
                                    title={product.title}
                                    buttonText="Đặt mua"
                                    buttonType="order"
                                    productId={product.id}
                                    category={product.category}
                                    link={`/cua-hang/${product.id}`}
                                />
                            </div>
                        ))
                    )}
                </div>

                {/* Banners */}
                <div className="row justify-content-center">
                    {topBanners.map((item, index) => (
                        <OpeningFlowersCard key={index} imageUrl={item.imageUrl} />
                    ))}
                </div>

                {/* Sections by Category */}
                <TitleSection title="HOA KHAI TRƯƠNG" linkTo={"danh-muc/hoa-khai-truong/"} />
                <CategoryGrid categoryCard={categoryDataHoaKhaiTruong} products={productsKhaiTruong} isLoading={isLoadingKhaiTruong} />

                <TitleSection title="HOA TANG LỄ" linkTo={"danh-muc/hoa-dam-tang/"} />
                <CategoryGrid categoryCard={categoryDataHoaDamTang} products={productsDamTang} isLoading={isLoadingDamTang} />

                <TitleSection title="HOA GIỎ" linkTo={"danh-muc/hoa-gio/"} />
                <CategoryGrid categoryCard={categoryDataHoaGio} products={productsGio} isLoading={isLoadingGio} />

                <TitleSection title="HOA BÓ" linkTo={"danh-muc/hoa-bo/"} />
                <CategoryGrid categoryCard={categoryDataHoaBo} products={productsBo} isLoading={isLoadingBo} />
            </div>

            {/* Related Products Section */}
            <div className="related-products">
                <RelatedProducts products={relatedProducts} title="CÓ THỂ BẠN QUAN TÂM :" isLoading={isLoadingTopProducts} />
            </div>

            {/* News Section */}
            <div className="related-products py-5">
                <div className="container">
                    <div className="col-12 text-center mb-4">
                        <h2 className="section-title">TIN TỨC - BÀI VIẾT - SHOP HOA</h2>
                        <div className="title-underline"></div>
                    </div>
                    <div className="row justify-content-center">
                        {isLoadingNews ? (
                            <p className="text-center">Đang tải tin tức...</p>
                        ) : (
                            newsData.slice(0, 3).map((article) => (
                                <NewsCard key={article.id} article={article} />
                            ))
                        )}
                    </div>
                    <div className="text-center mt-4">
                        <Link to="/tin-tuc" className="btn-primary-custom px-4 py-2">
                            Xem thêm
                        </Link>
                    </div>
                </div>
            </div>
            <ServicesSection />
        </div>
    )
}

export default Home;
