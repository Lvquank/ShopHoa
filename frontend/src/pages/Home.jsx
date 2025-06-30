import "../styles/pages/Home.css"
import Intro from "../components/Intro"
import OpeningFlowersCard from "../components/OpeningFlowerCard"
import hoaKhaiTruong from "../assets/images/hoa-khai-truong.webp"
import hoaDamTang from "../assets/images/hoa-dam-tang.webp"
import TitleSection from "../components/TitleSection"
import FlowerCard from "../components/FlowerCard"
import CategoryGrid from "../components/CategoryGrid"
import RelatedProducts from "../components/RelatedProducts"
import NewsCard from "../components/NewsCard"
import { Link } from "react-router-dom"
import ServicesSection from "../components/ServicesSection"
import { useEffect, useState } from "react"
import categoryHoaKhaiTruong from "../assets/images/hoakhaitruong-218x341-1.webp"
import categoryHoaDamTang from "../assets/images/hoadamtang-218x341-1.webp"
import categoryHoaGio from "../assets/images/hoa-gio.jpg"
import categoryHoaBo from "../assets/images/hoa-bo.webp"
function Home() {
    const [topSellingProducts, setTopSellingProducts] = useState([])
    const [categoryProducts, setCategoryProducts] = useState([])
    const [productsKhaiTruong, setProductsKhaiTruong] = useState([])
    const [productsDamTang, setProductsDamTang] = useState([])
    const [productsGio, setProductsGio] = useState([])
    const [productsBo, setProductsBo] = useState([])

    useEffect(() => {
        // Lấy top sản phẩm bán chạy (is_on_top = true)
        fetch("http://localhost:8000/api/products/top")
            .then(res => res.json())
            .then(data => {
                if (data.success) setTopSellingProducts(data.data)
            })
    }, [])

    // Hàm lấy sản phẩm theo category truyền vào
    const fetchCategoryProducts = (category, setProducts) => {
        fetch(`http://localhost:8000/api/products/category/${category}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    setProducts(data.data)
                }
            })
    }

    // Ví dụ sử dụng cho hoa khai trương
    useEffect(() => {
        fetchCategoryProducts("hoa-khai-truong", setProductsKhaiTruong)
        fetchCategoryProducts("hoa-dam-tang", setProductsDamTang)
        fetchCategoryProducts("hoa-gio", setProductsGio)
        fetchCategoryProducts("hoa-bo", setProductsBo)
    }, [])

    const categoryDataHoaKhaiTruong =
    {
        imageUrl: categoryHoaKhaiTruong,
        title: "HOA KHAI TRƯƠNG"
    }
    const categoryDataHoaDamTang =
    {
        imageUrl: categoryHoaDamTang,
        title: "HOA TANG LỄ"
    }
    const categoryDataHoaGio =
    {
        imageUrl: categoryHoaGio,
        title: "HOA GIỎ"
    }
    const categoryDataHoaBo =
    {
        imageUrl: categoryHoaBo,
        title: "HOA BÓ"
    }

    const OpeningFlower = [
        {
            imageUrl: hoaKhaiTruong,
            title: "Hoa khai trương",
            productCount: 3,
        },
        {
            imageUrl: hoaDamTang,
            title: "Hoa đám tang",
            productCount: 14,
        },
    ]

    const relatedProducts = [
        {
            id: "hg01",
            imageUrl: hoaDamTang,
            title: "Đặt Hoa Giỏ Dĩ An 0966183183",
        },
        {
            id: "hg02",
            imageUrl: hoaKhaiTruong,
            title: "Đặt Hoa Giỏ Phú Nhuận 0966183183",
        },
        {
            id: "hg03",
            imageUrl: hoaDamTang,
            title: "Đặt Hoa Giỏ Tân Phú 0966183183",
        },
        {
            id: "hg04",
            imageUrl: hoaKhaiTruong,
            title: "Đặt hoa bó babi - 0966183183",
        },
        {
            id: "hg05",
            imageUrl: hoaDamTang,
            title: "Đặt Hoa Giỏ Bình Dương 0966183183",
        },
        {
            id: "hg06",
            imageUrl: hoaKhaiTruong,
            title: "Đặt Hoa Giỏ Thủ Đức 0966183183",
        },
    ]
    const newsData = [
        {
            id: "news01",
            imageUrl: hoaKhaiTruong,
            title: "Đặt hoa 20/10 món quà ý nghĩa ngày phụ nữ Việt Nam.",
            date: "03/10/2022",
            excerpt: "Hoa 20/10 món quà thay cho lời cảm ơn và sự quan ...",
        },
        {
            id: "news02",
            imageUrl: hoaDamTang,
            title: "Đặt Hoa Đám Tang – Hoa Tang lễ Giao Tận Nơi",
            date: "28/09/2022",
            excerpt: "Đặt hoa đám tang - Hoa tang lễ giao tận nơi ...",
        },
        {
            id: "news03",
            imageUrl: hoaKhaiTruong,
            title: "Hướng dẫn chọn hoa khai trương phù hợp",
            date: "25/09/2022",
            excerpt: "Cách chọn hoa khai trương đẹp và ý nghĩa ...",
        },
        {
            id: "news04",
            imageUrl: hoaDamTang,
            title: "Ý nghĩa của các loại hoa trong đám cưới",
            date: "20/09/2022",
            excerpt: "Tìm hiểu ý nghĩa của từng loại hoa ...",
        },
    ]
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
                        {/* Title */}
                        <div className="row mb-4">
                            <div className="col-12 text-center">
                                <h2 className="section-title">SHOP HOA TƯƠI</h2>
                                <div className="title-underline"></div>
                            </div>
                        </div>

                        {/* Product Cards */}
                        <div className="row justify-content-center">
                            {OpeningFlower.map((item, index) => (
                                <OpeningFlowersCard
                                    key={index}
                                    imageUrl={item.imageUrl}
                                    title={item.title}
                                    productCount={item.productCount}
                                />
                            ))}
                        </div>
                    </div>
                </div>
                <TitleSection title="TOP BÁN CHẠY" />
                <div className="row mb-4">
                    {topSellingProducts.map((product, index) => (
                        <div key={index} className="col-12 col-sm-6 col-md-4 col-lg-3">
                            <FlowerCard
                                key={index}
                                imageUrl={product.image}
                                title={product.title}
                                buttonText="Đặt mua"
                                buttonType="order"
                                productId={product.id}
                                category={product.category}
                            />
                        </div>
                    ))}
                </div>
                <div className="row justify-content-center">
                    {OpeningFlower.map((item, index) => (
                        <OpeningFlowersCard
                            key={index}
                            imageUrl={item.imageUrl}
                        />
                    ))}
                </div>
                <TitleSection title="HOA KHAI TRƯƠNG" linkTo={"danh-muc/hoa-khai-truong/"} />
                <CategoryGrid categoryCard={categoryDataHoaKhaiTruong} products={productsKhaiTruong} />
                <TitleSection title="HOA TANG LỄ" linkTo={"danh-muc/hoa-dam-tang/"} />
                <CategoryGrid categoryCard={categoryDataHoaDamTang} products={productsDamTang} />
                <TitleSection title="HOA GIỎ" linkTo={"danh-muc/hoa-gio/"} />
                <CategoryGrid categoryCard={categoryDataHoaGio} products={productsGio} />
                <TitleSection title="HOA BÓ" linkTo={"danh-muc/hoa-bo/"} />
                <CategoryGrid categoryCard={categoryDataHoaBo} products={productsBo} />
            </div>
            <div className="related-products">
                <RelatedProducts products={relatedProducts} title="CÓ THỂ BẠN QUAN TÂM :" />
            </div>
            <div className="related-products">
                <div className="col-12 text-center">
                    <h2 className="section-title">TIN TỨC - BÀI VIẾT - SHOP HOA</h2>
                    <div className="title-underline"></div>
                </div>
                <section className="related-products py-5">
                    <div className="container">
                        <div className="row">
                            {newsData.slice(0, 2).map((article, index) => (
                                <NewsCard key={article.id} article={article} />
                            ))}
                        </div>

                        {/* Xem thêm Button */}
                        <div className="text-center mt-4">
                            <Link to="/tin-tuc" className="btn-primary-custom px-4 py-2">
                                Xem thêm
                            </Link>
                        </div>
                    </div>
                </section>

            </div>
            <ServicesSection />
        </div>
    )
}

export default Home
