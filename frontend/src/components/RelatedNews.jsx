import '../styles/components/RelatedNews.css'
import hoaKhaiTruong from "../assets/images/hoa-khai-truong.webp"
import hoaDamTang from "../assets/images/hoa-dam-tang.webp"
import hoaGioDiAn from "../assets/images/hoa-gio-di-an-150x150.webp"
import newsDamTang from "../assets/images/Hoa-Dam-Tang-Long-Huong.webp"
import hoaBoToneVang from "../assets/images/hoa-bo-tone-vang-150x150.webp"
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import { Link } from 'react-router-dom'

function RelatedNews() {
    const relatedArticles = [
        {
            id: 1,
            image: newsDamTang,
            title: "Đặt hoa 20/10 món quà ý nghĩa ngày phụ nữ Việt Nam.",
        },
        {
            id: 2,
            image: newsDamTang,
            title: "Đặt Hoa Đám Tang – Hoa Tang lễ Giao Tận Nơi",
        },
    ]

    // Data cho sản phẩm mới - với số điện thoại riêng
    const newProducts = [
        {
            id: 1,
            image: hoaGioDiAn,
            title: "Đặt hoa bó babi",
            phone: "0966183183",
        },
        {
            id: 2,
            image: hoaBoToneVang,
            title: "Đặt hoa bó tone vàng",
            phone: "0966183183",
        },
        {
            id: 3,
            image: hoaDamTang,
            title: "Đặt hoa bó hồng kem",
            phone: "0966183183",
        },
        {
            id: 4,
            image: hoaKhaiTruong,
            title: "Đặt Hoa Bó Hồng Đỏ",
            phone: "0966183183",
        },
        {
            id: 5,
            image: hoaBoToneVang,
            title: "Đặt hoa bó 20-10",
            phone: "0966183183",
        },
    ]
    return (

        <div className="sidebar">
            {/* Related Articles */}
            <div className="sidebar-section mb-4">
                <h4 className="sidebar-title mb-4">Bài viết liên quan</h4>
                <div className="related-articles">
                    {relatedArticles.map((article) => (
                        <Link to="/tin-tuc/chi-tiet/" key={article.id} className="text-decoration-none text-dark">
                            <div className="article-item d-flex mb-3">
                                <div className="article-image me-3">
                                    <img
                                        src={article.image || "/placeholder.svg"}
                                        alt={article.title}
                                        className="img-fluid rounded"
                                    />
                                </div>
                                <div className="article-content">
                                    <h6 className="article-title mb-0">{article.title}</h6>
                                </div>
                            </div>
                        </Link>
                    ))}
                </div>
            </div>

            {/* New Products */}
            <div className="sidebar-section">
                <h4 className="sidebar-title mb-4">Sản phẩm mới</h4>
                <div className="new-products">
                    {newProducts.map((product) => (
                        <div key={product.id} className="product-item d-flex mb-3">
                            <div className="product-image me-3">
                                <img
                                    src={product.image || "/placeholder.svg"}
                                    alt={product.title}
                                    className="img-fluid rounded"
                                />
                            </div>
                            <div className="product-content">
                                <h6 className="product-title mb-1">{product.title}</h6>
                                <p className="product-phone mb-0">{product.phone}</p>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
}
export default RelatedNews;