import "../styles/pages/About.css"
import logoImg from "../assets/images/logo.webp"
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import RelatedNews from "../components/RelatedNews"
import ImageNews1 from "../assets/images/hoa-gio.webp"
import ImageNews2 from "../assets/images/Hoa-Dam-Tang-Long-Huong.webp"
import { Link } from "react-router-dom"
function About() {

    return (
        <div className="about-page">
            <div className="container py-5">
                <div className="row">
                    <div className="col-lg-9 col-md-12 border-end border-gray">
                        <div className="row g-4">
                            {/* Article 1 */}
                            <div className="col-12">
                                <Link to="/tin-tuc/1" className="text-decoration-none text-dark">
                                    <div className="card border-0 shadow-sm h-100">
                                        <div className="row g-0">
                                            <div className="col-md-4">
                                                <div className="position-relative">
                                                    <img
                                                        src={ImageNews1}
                                                        className="img-fluid rounded-start h-100 object-fit-cover"
                                                        alt="Hoa 20/10"
                                                    />
                                                    <div className="position-absolute top-0 start-0 bg-danger text-white px-2 py-1 rounded-end">
                                                        <small className="fw-bold">03<br />TH10</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="col-md-8 d-flex align-items-center">
                                                <div className="card-body">
                                                    <h5 className="card-title fw-bold text-dark">
                                                        Đặt hoa 20/10 món quà ý nghĩa ngày phụ nữ Việt Nam.
                                                    </h5>
                                                    <p className="card-text text-muted">
                                                        Hoa 20/10 món quà thay cho lời cảm ơn và sự quan tâm sâu sắc ...
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </Link>
                            </div>

                            {/* Article 2 */}
                            <div className="col-12">
                                <Link to="/tin-tuc/2" className="text-decoration-none text-dark">
                                    <div className="card border-0 shadow-sm h-100">
                                        <div className="row g-0">
                                            <div className="col-md-4">
                                                <div className="position-relative">
                                                    <img
                                                        src={ImageNews2}
                                                        className="img-fluid rounded-start h-100 object-fit-cover"
                                                        alt="Hoa đám tang"
                                                    />
                                                    <div className="position-absolute top-0 start-0 bg-danger text-white px-2 py-1 rounded-end">
                                                        <small className="fw-bold">28<br />TH9</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="col-md-8 d-flex align-items-center">
                                                <div className="card-body">
                                                    <h5 className="card-title fw-bold text-dark">
                                                        Đặt Hoa Đám Tang – Hoa Tang Lễ Giao Tận Nơi
                                                    </h5>
                                                    <p className="card-text text-muted">
                                                        Đặt hoa đám tang – Hoa tang lễ giao tận nơi   Ngày nay việc ...
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </Link>
                            </div>
                        </div>
                    </div>
                    <div className="col-lg-3 col-md-12">
                        <RelatedNews />
                    </div>

                </div>
            </div>
        </div>
    )
}

export default About
