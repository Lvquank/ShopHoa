import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import RelatedNews from "../components/RelatedNews"
import CommentForm from '../components/CommentForm';
import flowerImg from "../assets/images/Dat-Hoa-Dam-Tang-Chanh-My.webp"
import flowerImg2 from "../assets/images/Hoa-dam-tang-tone-tim-2.webp"
import flowerImg3 from "../assets/images/Hoa-Dam-Tang-Thai-Hoa.webp"
import flowerImg4 from "../assets/images/Hoa-Dam-Tang-Phuong-Binh-Nham.webp"
import flowerImg5 from "../assets/images/Hoa-Dam-Tang-Tuong-Binh-Hiep.webp"
import flowerImg6 from "../assets/images/Hoa-Dam-Tang-Hoa-Tang-Le6.webp"
import flowerImg7 from "../assets/images/Hoa-Dam-Tang-Long-Huong.webp"
import flowerImg8 from "../assets/images/Hoa-Dam-Tang-Hoa-Long.webp"
import flowerImg9 from "../assets/images/hoa-dam-tang-quan-5.jpg"
import 'bootstrap-icons/font/bootstrap-icons.css';
import '../styles/pages/NewsDetail2.css';
import { Link } from 'react-router-dom';
const NewsDetail = () => {
    return (
        <div style={{ padding: '0 12rem', backgroundColor: '#ffffff' }}>
            <div className="py-5">
                <div className="row">
                    <div className="col-lg-8 col-md-12 border-end border-gray">
                        <div className="mb-4">
                            <p className="text-uppercase text-secondary fw-bold mb-1">Tin tức</p>
                            <h3 className="mb-2">
                                Đặt Hoa Đám Tang – Hoa Tang lễ Giao Tận Nơi
                            </h3>
                            <p className="text-muted mb-4">
                                Posted on 28/09/2022 BY <strong className="text-dark">NGUYỄN TẤN HÙNG</strong>
                            </p>

                            <h4 className="fw-semibold">
                                Đặt hoa đám tang – Hoa tang lễ giao tận nơi
                            </h4>
                            <div className="text-center mt-4 mb-4">
                                <img
                                    src={flowerImg}
                                    alt="Bó hoa ngày 20/10"
                                    className="img-fluid rounded"
                                    style={{ maxWidth: "600px" }}
                                />
                            </div>
                            <p>
                                Ngày nay việc đặt hoa tươi online trở nên thông dụng trong thời đại 4.0 chính vì vậy việc Bạn chọn đơn vị cung cấp hoa đám tang không quá khó. Quỳnh Flowers thấu hiểu được việc đặt và giao <strong>hoa đám tang</strong> tận nơi bằng những cái click chuột. Chúng em có hệ thống cửa hàng hoa đám tang tại Gò Vấp và các quận của Sài Gòn nên việc chuyển hoa sẽ được shop linh hoạt và thuận tiện để hoa được di chuyển ngắn nhất và nhanh nhất.
                            </p>
                            <p>
                                Với nhiều năm kinh nghiệm trong việc cung cấp hoa đám tang tại TPHCM và các tỉnh nên việc cắm hoa và giao hoa đã quá quen thuộc với nhiều khách hàng khi chọn Quỳnh Flowers.
                            </p>
                            <p>Chúng em luôn luôn quan niệm việc gửi hoa đám tang của Khách hàng vào những lúc quan trọng này cũng chính là trách nhiệm của bản thân nên việc chọn hoa tươi mới và câu chữ cho phù hợp nhất làm sao để hạn chế tối đa những sai sót ngoài ý muốn.</p>

                            <h5 className="fw-bold mt-4">Hoa đám tang truyền thống</h5>
                            <p>
                                Với mẫu <strong> hoa đám tang </strong>truyền thống sẽ khá quen thuộc với nhiều khách hàng do mức độ ưa chuộng từ lâu nay.
                            </p>
                            <Link to="/tin-tuc" className="more-link">
                                Tham khảo thêm
                            </Link>
                            <h5 className="fw-bold mt-4">Hoa đám tang hiện đại</h5>
                            <p>
                                Sự kết hợp những cánh hoa những chi tiết hoa đệm theo một phong cách mới phong cách của các nước sẽ tạo ra mẫu hoa đám tang hiện đại.
                            </p>
                            <Link to="/tin-tuc" className="more-link">
                                Tham khảo thêm
                            </Link>
                            <h5 className="fw-bold mt-4">Hoa đám tang công giáo</h5>
                            <p>
                                Cây thánh giá được coi là biểu tượng thiêng liêng của người Công Giáo chính vì vậy các mẫu hoa đám tang công giáo đa số sử dụng hình ảnh của thánh giá.
                            </p>
                            <Link to="/tin-tuc" className="more-link">
                                Tham khảo thêm
                            </Link>
                            <h4 className="fw-semibold" style={{ marginTop: '2rem' }}>
                                Shop hoa đám tang tại TPHCM và hệ thống cửa hàng hoa đám tang tại 63 tỉnh
                            </h4>
                            <p>
                                Đặt hoa đám tang tại TPHCM và các tỉnh trở nên dễ dàng thuận tiện hơn khi đặt online và thanh toán trực tuyến cho việc gửi hoa tang lễ tận nơi.
                            </p>
                            <h4 className="fw-semibold">
                                Shop hoa đám tang uy tín ?
                            </h4>
                            <div className="text-center mt-4 mb-4">
                                <img
                                    src={flowerImg2}
                                    alt="Bó hoa ngày 20/10"
                                    className="img-fluid rounded"
                                    style={{ maxWidth: "600px" }}
                                />
                            </div>
                            <p>
                                Việc chọn được shop hoa uy tín về mặt chất lượng hoa thời gian giao hoa và mọi thứ đã trở thành câu hỏi chung của người đặt hoa online. Thấu hiểu nổi lo toang của việc đặt hoa online nên hệ thống hoa tươi Quỳnh Flowers sẽ giúp Bạn từ khâu chọn hoa thời gian giao hoa, gửi hình ảnh hoa trước và sau khi giao hoa hoàn tất để Bạn an tâm là hoa đã được gửi đến đúng nơi cần gửi. Tại TPHCM khi Bạn chọn Quỳnh Flowers chúng em sẽ free ship tận nơi, các tỉnh việc vận chuyển hoa sẽ phụ thuộc vào vị trí địa lý nên thời gian di chuyển của hoa sẽ chậm hơn nhưng vẫn free ship khu vực nội thành.
                            </p>

                            <h4 className="fw-semibold">
                                Đặt hoa đám tang Gò Vấp có dễ không ?
                            </h4>
                            <p>
                                Tại Gò Vấp việc đặt <strong>hoa đám tang</strong> và giao tận nơi hết sức dễ dàng. Do tính chuyên nghiệp của việc cắm hoa nên shop hoa tươi Quỳnh Flower sẽ giúp Bạn gửi hoa tận nơi tại <strong>Gò Vấp</strong> và free ship. Thời gian giao hoa trung bình tầm 60 phút sẽ tùy thuộc vào mẫu và điều kiện giao thông tại thời điểm giao.
                            </p>
                            <div className="text-center mt-4 mb-4">
                                <img
                                    src={flowerImg3}
                                    alt="Bó hoa ngày 20/10"
                                    className="img-fluid rounded"
                                    style={{ maxWidth: "600px" }}
                                />
                            </div>
                            <h5 className="fw-bold mt-4">Hoa đám tang nhà tang lễ Phạm Ngũ Lão</h5>
                            <p>
                                Nhà tang lễ Phạm Ngũ Lão tọa lạc tại số 5 Phạm Ngũ Lão, P3, Quận Gò Vấp nơi chuyên tổ chức tang lễ cho cấp cán bộ và người dân. Với việc giao hoa đám tang tại nhà tang lễ Phạm Ngũ Lão  ( Bộ Quốc Phòng) sẽ nhanh chóng bởi nơi đây việc tổ chức tang lễ rất thông thoáng. Hoa đám tang khi giao tại nhà tang lễ Phạm Ngũ Lão cũng sẽ được chụp hình và gửi ảnh xác nhận cho Khách hàng.
                            </p>
                            <div className="text-center mt-4 mb-4">
                                <img
                                    src={flowerImg4}
                                    alt="Bó hoa ngày 20/10"
                                    className="img-fluid rounded"
                                    style={{ maxWidth: "600px" }}
                                />
                            </div>
                            <h4 className="fw-semibold">
                                Shop hoa đám tang tại Quận Tân Phú
                            </h4>
                            <p>
                                Nằm ngay trung tâm của Quận Tân Phú nên việc vận chuyển hoa đám tang sẽ được nhanh chóng nhất. Với tiêu chí hoa tươi mới mỗi ngày nên Quỳnh Flowers luôn nhập hoa mỗi ngày và hoa sẽ được cắm khi khách hàng đã chốt đơn điều này giúp hoa sẽ tươi lâu hơn thay vì hoa đã cắm sẳn.
                            </p>

                            <p>
                                Tại Quận Tân Phú <strong>hoa đám tang</strong> sẽ được free ship tất cả các phường và khu vực lân cận. Giao hoa đúng giờ để kịp giờ khách hàng vào viếng là phương châm của chúng em.
                            </p>
                            <div className="text-center mt-4 mb-4">
                                <img
                                    src={flowerImg5}
                                    alt="Bó hoa ngày 20/10"
                                    className="img-fluid rounded"
                                    style={{ maxWidth: "600px" }}
                                />
                            </div>
                            <h4 className="fw-semibold">
                                Chất lượng hoa đám tang khi giao tận nơi
                            </h4>
                            <div className="text-center mt-4 mb-4">
                                <img
                                    src={flowerImg6}
                                    alt="Bó hoa ngày 20/10"
                                    className="img-fluid rounded"
                                    style={{ maxWidth: "600px" }}
                                />
                            </div>
                            <p>
                                Khi đặt hoa và giao tận nơi có lẽ việc vận chuyển cũng sẽ làm Bạn phân vân nhưng với Quỳnh Flowers việc vận chuyển hoa sẽ là chuyên nghiệp bởi shipper là nhân viên của shop thay vì thuê ship thời vụ, do đó khi hoa đến nơi các bạn sẽ có trách nhiệm chỉnh sửa hoa do quá trình di chuyển. Sau khi kiểm tra hoa và banner được chỉnh chu thì ảnh ảnh <strong>hoa đám tang</strong> tận nơi sẽ được gửi về shop để chuyển cho khách hàng. Do đặc thù của <strong>hoa đám tang</strong> đòi hỏi phải trang nghiêm và chỉnh chu nên việc giao hoa được xem là yếu tố quan trọng quyết định đến chất lượng hoa tại đám.
                            </p>
                            <h4 className="fw-semibold">
                                Giao nhanh hoa đám tang Tân Bình
                            </h4>
                            <p>
                                <strong>Hoa đám tang nhà tang lễ bệnh viện Thống Nhất</strong> hay các địa chỉ tại Quận Tân Bình sẽ được giao nhanh và free ship.
                            </p>
                            <p>
                                Với mẫu hoa đám tang các khách hàng thường chọn tại nhà tang lễ sẽ phong phú về kiểu dáng và mẫu mã.
                            </p>
                            <div className="text-center mt-4 mb-4">
                                <img
                                    src={flowerImg7}
                                    alt="Bó hoa ngày 20/10"
                                    className="img-fluid rounded"
                                    style={{ maxWidth: "600px" }}
                                />
                            </div>
                            <h5 className="fw-semibold mb-3">
                                Màu sắc của hoa đám tang
                            </h5>
                            <p>
                                Tùy vào giai đoạn sẽ có những xu hướng hoa xu hướng màu hoa khác nhau nhưng tất cả hoa đám tang cũng thường sẽ xoay quanh hai màu thông dụng và chủ đạo là tone tím và trắng. Việc chọn tone màu hoa đám tang sẽ phụ thuộc vào vùng miền và màu yêu thích lúc người mất còn sống như tưởng nhớ và đưa tiễn. Nhưng tất cả cũng chỉ là lòng tiếc thương và tiễn đưa về nơi vĩnh hằng.
                            </p>
                            <div className="text-center mt-4 mb-4">
                                <img
                                    src={flowerImg8}
                                    alt="Bó hoa ngày 20/10"
                                    className="img-fluid rounded"
                                    style={{ maxWidth: "600px" }}
                                />
                            </div>
                            <h4 className="fw-semibold">
                                Nơi đặt vòng hoa đám tang tại quận 5
                            </h4>
                            <p>
                                Nhắc đến <strong>hoa đám tang</strong> tại Quận 5 chúng ta sẽ hay chú ý nhiều nhất đến 2 nhà tang lễ của Quận: Nhà tang lễ An Bình và nhà tang lễ Nguyễn Tri Phương nơi được khá nhiều khách hàng tổ chức tang gia bởi do đcặ thù nhà chật hẹp hoặc chung cư không thể tổ chức tang lễ.
                            </p>
                            <p>Bên cạnh nhà tang lễ An Bình thường sẽ được người Hoa khu vực Quận 5 Chợ Lớn ưu tiên chọn. Khi Bạn cần gửi hoa viếng tại Quận 5 nói chung hay tại 2 nhà tang lễ trên thì Quỳnh Flowers luôn đáp ứng số lượng cũng như thời gian giao hoa.</p>
                            <div className="text-center mt-4 mb-4">
                                <img
                                    src={flowerImg9}
                                    alt="Bó hoa ngày 20/10"
                                    className="img-fluid rounded"
                                    style={{ maxWidth: "600px" }}
                                />
                            </div>

                            <div className="d-flex gap-2 ms-2 justify-content-center">
                                <a href="#" className="d-flex align-items-center justify-content-center border border-2 border-secondary rounded-circle bg-white social-icon" style={{ width: 36, height: 36 }}>
                                    <i className="bi bi-facebook fs-5" style={{ color: '#b0b0b0' }}></i>
                                </a>
                                <a href="#" className="d-flex align-items-center justify-content-center border border-2 border-secondary rounded-circle bg-white social-icon" style={{ width: 36, height: 36 }}>
                                    <i className="bi bi-twitter fs-5" style={{ color: '#b0b0b0' }}></i>
                                </a>
                                <a href="#" className="d-flex align-items-center justify-content-center border border-2 border-secondary rounded-circle bg-white social-icon" style={{ width: 36, height: 36 }}>
                                    <i className="bi bi-envelope fs-5" style={{ color: '#b0b0b0' }}></i>
                                </a>
                                <a href="#" className="d-flex align-items-center justify-content-center border border-2 border-secondary rounded-circle bg-white social-icon" style={{ width: 36, height: 36 }}>
                                    <i className="bi bi-pinterest fs-5" style={{ color: '#b0b0b0' }}></i>
                                </a>
                                <a href="#" className="d-flex align-items-center justify-content-center border border-2 border-secondary rounded-circle bg-white social-icon" style={{ width: 36, height: 36 }}>
                                    <i className="bi bi-linkedin fs-5" style={{ color: '#b0b0b0' }}></i>
                                </a>
                            </div>

                            <hr />
                            <p className="text-muted">
                                This entry was posted in Tin tức and tagged hoa 20/10.
                            </p>
                            <hr />
                        </div>
                        <CommentForm />
                    </div>
                    <div className="col-lg-4 col-md-12">
                        <RelatedNews />
                    </div>

                </div>
            </div>
        </div>
    );
}

export default NewsDetail;