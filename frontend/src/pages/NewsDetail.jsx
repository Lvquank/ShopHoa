import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import RelatedNews from "../components/RelatedNews"
import CommentForm from '../components/CommentForm';
import flowerImg from "../assets/images/hoa-bo-2.webp"
import HoaBoHongDo from "../assets/images/hoa-bo-hong-do.webp"
import Hoa_20_10 from "../assets/images/hoa-20-10.webp"
import Hoa_Bo_1_1 from "../assets/images/hoa-bo-1-1.webp"
import 'bootstrap-icons/font/bootstrap-icons.css';
const NewsDetail = () => {
    return (
        <div style={{ padding: '0 12rem', backgroundColor: '#ffffff' }}>
            <div className="py-5">
                <div className="row">
                    <div className="col-lg-8 col-md-12 border-end border-gray">
                        <div className="mb-4">
                            <p className="text-uppercase text-secondary fw-bold mb-1">Tin tức</p>
                            <h3 className="fw-semibold mb-2">
                                Đặt hoa 20/10 món quà ý nghĩa ngày phụ nữ Việt Nam.
                            </h3>
                            <p className="text-muted mb-4">
                                POSTED ON 03/10/2022 BY <strong className="text-dark">NGUYỄN TẤN HÙNG</strong>
                            </p>

                            <h5 className="fw-bold">
                                Hoa 20/10 món quà thay cho lời cảm ơn và sự quan tâm sâu sắc đến người phụ nữ yêu thương.
                            </h5>
                            <p>
                                Có bao giờ bạn tự hỏi nếu không có nàng Eva xuất hiện từ chiếc xương sườn thứ 7 của Adam thì cuộc sống sẽ ra sao chưa?
                            </p>
                            <p>
                                Đó là câu hỏi mà Chúa là người đầu tiên biết câu trả lời. Người tạo ra nàng Eva xinh đẹp, khéo léo và trí tuệ.
                                Khiến thế ngày càng rực rỡ, tràn đầy sức sống. Chính vì vậy, người ta thường nói phụ nữ là món quà tuyệt vời nhất mà Chúa ban tặng
                                và cũng là điều đáng trân trọng nhất.
                            </p>

                            <h5 className="fw-bold mt-4">Ý nghĩa của ngày 20/10</h5>
                            <p>
                                Trải qua hàng ngàn năm, phụ nữ thế giới nói chung và phụ nữ Việt Nam nói riêng đã trải qua rất nhiều lần thăng trầm lịch sử.
                                Dưới kiến trúc chế độ và quốc gia, họ là tầng bị áp bức, bóc lột và chịu nhiều bất công. Nhưng không chịu dừng số phận,
                                người phụ nữ Việt Nam vươn lên đấu tranh. Từ thiêu thân nơi chiến khu cho đến Đảng và Bác Hồ. Trở thành những chiến sĩ dũng cảm,
                                người lao động cần cù, sáng tạo. Là đặc biệt người giữ vai trò quan trọng trong việc giữ gìn, phát triển bản sắc và tình hoa văn hóa dân tộc.
                                Là những người mẹ hiền, trung hậu, đảm đang.
                            </p>
                            <p>
                                Ngày 20/10/1930, Hội Liên hiệp phụ nữ chính thức được thành lập. Đảng cộng sản Việt Nam đã quyết định lựa chọn ngày này
                                kỷ niệm và tôn vinh phụ nữ Việt Nam, lấy tên là <strong>“Ngày Phụ nữ Việt Nam”.</strong> Nhân ngày 20/10 năm nay, hãy chọn một bó hoa
                                chúc mừng ngày 20/10 thật đẹp, ý nghĩa. Tỏ dành tặng cho người phụ nữ mà bạn yêu mến. Đây là món quà tinh thần tuy
                                mang giá trị rất nhỏ nhưng vẫn thể hiện được tình yêu, sự biết ơn và sự quan trọng.
                            </p>
                            <div className="text-center mt-4 mb-4">
                                <img
                                    src={flowerImg}
                                    alt="Bó hoa ngày 20/10"
                                    className="img-fluid rounded"
                                    style={{ maxWidth: "600px" }}
                                />
                            </div>
                            <h4 className="fw-bold mb-3">
                                Ý nghĩa hoa 20/10 trong ngày phụ nữ Việt Nam
                            </h4>
                            <p>
                                Hoa tặng ngày <strong>20/10</strong> là món quà thường được lựa chọn hàng đầu trong các dịp, sự kiện quan trọng như ngày Phụ nữ Việt Nam.
                                Bởi từng loại hoa luôn mang trong mình những câu chuyện, những thông điệp có nghĩa. Và trong bó hoa đẹp ngày 20/10 như hoa lan, hoa hồng,
                                hoa cúc, hoa hướng dương, hoa cát tường, hoa mẫu đơn ... rất được ưa chuộng. Ngoài vẻ đẹp lộng lẫy, sự sang trọng quý phái cũng như ý nghĩa
                                đặc biệt. Hãy cùng chúng tôi đi tìm hiểu ý nghĩa các loài hoa thường dùng trong bó <strong>hoa 20/10</strong> nhé:
                            </p>

                            <h6 className="fw-bold mt-4">Hoa Lily – hoa tặng ngày 20/10 cao quý:</h6>
                            <p>
                                Theo thần thoại Hy Lạp, hoa Lily được tạo ra từ những giọt sữa ngọt ngào của thần Hera. Nữ thần hôn nhân, bảo vệ cho thánh thiện và
                                bền vững chắc cho cuộc sống gia đình. Vì vậy hoa Lily chính là biểu tượng của sắc đẹp, sự tinh khiết, thanh cao và đức hạnh.
                                Ngoài ra, màu sắc hoa lại có những ý nghĩa đặc biệt như: Hoa ly trắng đại diện cho thủy chung, đức hạnh thanh cao. Hoa ly cam mang ý
                                nghĩa cầu mong cho ai đó hạnh phúc và thịnh vượng. Hoa ly vàng thể hiện sự biết ơn, hoa ly hồng thì sức sống, sự trẻ trung, năng động.
                            </p>
                            <p>
                                Hoa chúc mừng ngày 20/10 sử dụng Hoa Lily có thể kết thành bó hoa tặng mẹ ngày 20/10. Hay kết hợp cùng các loại hoa khác nhau
                                thành hoa tặng vợ ngày 20/10 hoặc tặng bạn bè, hoa 20/10 tặng sếp nữ, đồng nghiệp nữ. Nói chung là <strong>hoa 20/10</strong> rất ý nghĩa.
                            </p>

                            <h6 className="fw-bold mt-4">Hoa hồng – hoa tặng ngày 20/10 yêu thương:</h6>
                            <p>
                                Hoa hồng từ lâu là loài hoa tượng trưng cho tình yêu, sự tôn kính, trường tồn vĩnh cửu. Hoa hồng thích hợp làm <strong>hoa 20/10</strong> có thể tặng cho
                                rất nhiều người. Tùy chọn người nhận và hệ thống kết nối mức độ mà bạn nên chọn màu sắc và số lượng hoa sẽ được tặng.
                            </p>
                            <p>
                                Ví dụ: Hoa tặng mẹ ngày 20/10 có thể chọn hoa hồng vàng, hồng phấn ... Một bó hoa tặng mẹ ngày 20/10 được kết từ hoa hồng vàng thể
                                hiện lời cảm ơn, sự yêu thương trọn vẹn dành tặng mẹ. Sẽ luôn tồn tại, luôn chân thành, không bao giờ dối trá và thay đổi.
                                Một giỏ hoa ngày 20/10 Hoa hồng phấn như tình yêu mẹ dành cho con, luôn dịu dàng, ngọt ngào và ấm áp. Hương thơm nhẹ nhàng như sự bao dung,
                                che chở cho người mẹ hạnh phúc.
                            </p>
                            <div className="text-center mt-4 mb-4">
                                <img
                                    src={HoaBoHongDo}
                                    alt="Bó hoa ngày 20/10"
                                    className="img-fluid rounded"
                                    style={{ maxWidth: "600px" }}
                                />
                            </div>
                            <h6 className="fw-bold">
                                Hoa lan – hoa đẹp ngày 20/10 đẳng cấp:
                            </h6>
                            <p>
                                Hoa lan là loài hoa sang trọng bậc nhất bởi vẻ đẹp cao quý, hương thơm thanh khiết và giá thành cao.
                                Hoa đặc biệt kiểu dáng sang trong cùng độ cao. Có thể nở và giữ được vẻ đẹp cùng mùi thơm trong thời gian dài.
                                Người xưa có câu: “Huệ chất lan tâm.” Ý chỉ sự thanh khiết cao của một người con gái đẹp.
                                Một vẻ đẹp cao sang, quý phái, thanh nhã. Màu trắng tinh khiết của loài hoa này thể hiện lòng biết ơn,
                                tình cảm chân thành của người tặng với người phụ nữ yêu thương.
                            </p>
                            <div className="text-center mt-4 mb-4">
                                <img
                                    src={Hoa_20_10}
                                    alt="Bó hoa ngày 20/10"
                                    className="img-fluid rounded"
                                    style={{ maxWidth: "600px" }}
                                />
                            </div>
                            <p>
                                Hoa lan được thiết kế thành giỏ hoa đẹp ngày 20/10 tặng mẹ, tặng vợ, tặng sếp nữ, đồng nghiệp ...
                                Vừa chân thành vừa đẳng cấp. Lại mang nhiều ý nghĩa phong thủy về tài lộc và thịnh vượng.
                            </p>

                            <h6 className="fw-bold mt-3">Hoa mẫu đơn – hoa tặng ngày 20/10 quốc sắc thiên hương:</h6>
                            <p>
                                Với sự nhẹ nhàng tinh tế của mình, hoa mẫu đơn là biểu tượng cho tình mẫu tử, thể hiện sự bao dung của lòng mẹ.
                                Dù con có làm bao nhiêu việc lớn lao, thành đạt như thế nào thì trong lòng mẹ, con vẫn mãi là con bé bỏng của mẹ.
                            </p>
                            <p>
                                Hoa mẫu đơn còn được mệnh danh là quốc sắc thiên hương: <em>“Quốc sắc thiên hương”</em> tức là sắc nước hương trời.
                                Sắc đẹp nước, hương thơm thanh khiết chỉ có trên trời. Ý chỉ toàn vẻ đẹp hoàn toàn như người phụ nữ.
                            </p>
                            <p>
                                Một bó hoa tặng ngày 20/10 từ hoa Mẫu đơn là sự lựa chọn hoàn chỉnh cho món quà sang trọng, đẳng cấp.
                            </p>
                            <div className="text-center mt-4 mb-4">
                                <img
                                    src={Hoa_Bo_1_1}
                                    alt="Bó hoa ngày 20/10"
                                    className="img-fluid rounded"
                                    style={{ maxWidth: "600px" }}
                                />
                            </div>
                            <h5 className="fw-bold mb-3">
                                Lời chúc kèm theo một bó hoa chúc mừng ngày 20/10 ý nghĩa
                            </h5>
                            <p>
                                Khi đã chọn xong một bó hoa chúc mừng ngày 20/10. Thì một lời chúc thật ý nghĩa sẽ làm món quà của chúng ta thêm phần đặc biệt và độc đáo hơn.
                                Điện Hoa Hải Hà xin gợi ý cho các bạn một số lời chúc sau:
                            </p>
                            <ul className="list-inline">
                                <li className="list-inline-item">- Nhân ngày 20/10, chúc bà / mẹ / cô luôn vui vẻ, tươi trẻ và dồi dào sức khỏe.</li>
                                <li className="list-inline-item">- Nhân ngày Phụ nữ Việt Nam <strong>20/10</strong>, Công ty xin chúc các chị em nhân viên luôn xinh tươi, khỏe mạnh, công việc tốt.</li>
                                <li className="list-inline-item">- Chúc em / vợ luôn xinh đẹp, trẻ trung và vui vẻ, hạnh phúc.</li>
                                <li className="list-inline-item">- Chúc các bạn nữ ở lớp luôn xinh đẹp, yêu đời và tràn đầy nhiệt huyết.</li>
                                <li className="list-inline-item">- Chúc mừng ngày Phụ nữ Việt Nam (Cách đơn giản nhất)</li>
                            </ul>

                            <h5 className="fw-bold mt-4 mb-3">
                                Địa chỉ đặt hoa 20/10 uy tín, chất lượng, cam kết làm khách hàng hài lòng.
                            </h5>
                            <p>
                                Chúng tôi có hơn 100 cửa hàng hoa trên toàn quốc và có <strong>dịch vụ điện hoa</strong> tại Hà Nội, HCM và tại 63 tỉnh thành của cả nước.
                                Từ Bắc đến Nam như An Giang, Bà Rịa – Vũng Tàu, Bắc Giang, Bắc Kạn, Bạc Liêu, Bắc Ninh. Bến Tre, Bình Định, Bình Dương, Bình Phước,
                                Bình Thuận. Cà Mau, Cao Bằng, Đắk Lắk, Đắk Nông, Điện Biên, Đồng Nai, Đồng Tháp. Gia Lai, Hà Giang, Hà Nam, Hà Nội, Hải Dương, Hà Giang,
                                Hòa Bình, Hưng Yên, Khánh Hòa, Kiên Giang. Kon Tum, Lai Châu, Lâm Đồng, Lạng Sơn, Lào Cai, Long An, Nam Định, Nghệ An, Ninh Bình,
                                Ninh Thuận, Phú Thọ, Quảng Bình, Quảng Nam, Quảng Ngãi, Quảng Ninh. Quảng Trị, Sóc Trăng, Sơn La, Tây Ninh, Thái Bình, Thái Nguyên,
                                Thanh Hóa, Thừa Thiên Huế, Tiền Giang, Trà Vinh, Tuyên Quang, Vĩnh Long, Vĩnh Phúc. Yên Bái, Phú Yên, Cần Thơ, Đà Nẵng, Hải Phòng,
                                Hà Nội, TP HCM.
                            </p>
                            <div className="d-flex flex-wrap align-items-center gap-3 pt-2">
                                <div className="d-flex gap-2 ms-2">
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