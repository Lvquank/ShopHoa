import "../styles/pages/About.css"
import logoImg from "../assets/images/logo.webp"
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import RelatedNews from "../components/RelatedNews"
function About() {

  return (
    <div className="about-page">
      <div className="container py-5">
        <div className="row">
          <div className="col-lg-8 col-md-12 border-end border-gray">
            <div className="about-content">
              {/* Header */}
              <h1 className="about-title mb-4">Xin chào bạn !</h1>

              {/* Introduction */}
              <div className="about-intro mb-5">
                <p className="mb-3">
                  Lời đầu tiên, cho phép Shophoa.shop được gửi tới quý khách, quý thân nhân và bạn bè lời chúc sức khỏe,
                  thành đạt và hạnh phúc !
                </p>
                <p className="mb-4">
                  Là một website chuyên cung cấp dịch vụ điện hoa, quà tặng... chuyên nghiệp giao hoa đến khắp các tỉnh,
                  thành phố trên cả nước.
                </p>
              </div>

              {/* Logo Section */}
              <div className="logo-section text-center mb-5">
                <div className="about-logo-wrapper">
                  <div className="about-logo">
                    <img src={logoImg || "/placeholder.svg"} alt="Shop Hoa Tươi Logo" className="logo-image" />
                  </div>
                </div>
              </div>

              {/* Activities Section */}
              <div className="activities-section mb-5">
                <h3 className="section-title mb-4">Các định hướng hoạt động của shophoa.shop</h3>
                <ul className="activities-list">
                  <li className="mb-3">
                    * Liên kết, hỗ trợ các shop hoa tươi trên cả nước trong việc cung cấp các dịch vụ trong lĩnh vực hoa
                    tươi.
                  </li>
                  <li className="mb-3">
                    * Xây dựng mạng lưới điện hoa chuyên nghiệp trải rộng khắp các tỉnh, thành phố trên toàn quốc.
                  </li>
                  <li className="mb-3">* Hoàn thiện các quy trình kiểm tra chất lượng và giao nhận.</li>
                </ul>
              </div>

              {/* Products Introduction Section */}
              <div className="products-intro-section mb-5">
                <h3 className="section-title mb-4">Giới Thiệu đến Quý khách các sản phẩm của shop</h3>
                <p className="mb-3">Chúng tôi chuyên cung cấp các sản phẩm hoa tươi :</p>
                <ul className="products-list">
                  <li className="mb-2">* Hoa Khai Trương</li>
                  <li className="mb-2">* Hoa Chúc mừng.</li>
                  <li className="mb-2">* Hoa Sinh nhật.</li>
                  <li className="mb-2">* Hoa Đám Tang ( Hoa Tang Lễ)</li>
                  <li className="mb-2">* Hoa Bó</li>
                  <li className="mb-2">* Hoa Giỏ</li>
                </ul>
                <p className="mb-3">
                  Bao gồm nhiều mẫu mã mới, hiện đại, cùng với đội ngũ cắm hoa chuyên nghiệp được đào tạo bài bản.
                </p>
              </div>

              {/* Conclusion */}
              <div className="conclusion-section mb-4">
                <p className="mb-3">
                  Chúng tôi hướng đến một dịch vụ chuyên nghiệp trong việc truyền tải những thông điệp, cảm xúc của
                  người tặng đến người nhận.
                </p>
                <p className="mb-3">
                  Shop hoa tươi Quynh Flower chúng tôi quyết tâm không ngừng học hỏi và sáng tạo để cho ra đời những tác
                  phẩm nghệ thuật từ hoa tươi, đem lại niềm vui và hạnh phúc cho mọi người.
                </p>
                <p className="mb-3">Xin cảm ơn sự tin tương và ủng hộ của quý khách trong thời gian qua.</p>
                <p className="mb-0 text-end">
                  <em>Trân trọng !</em>
                </p>
              </div>
            </div>
          </div>
          <div className="col-lg-4 col-md-12">
            <RelatedNews />
          </div>

        </div>
      </div>
    </div>
  )
}

export default About
