import "../styles/components/ServicesSection.css"
import srv1 from "../assets/images/srv_1.png"
import srv2 from "../assets/images/srv_2.png"
import srv3 from "../assets/images/srv_3.png"

const ServicesSection = () => {
  const services = [
    {
      icon: srv1,
      title: "Giao hàng cực nhanh",
      description: "Miễn phí với đơn hàng tại các khu vực .....",
    },
    {
      icon: srv2,
      title: "Thanh toán linh hoạt",
      description: "Thanh toán bằng chuyển khoản .....",
    },
    {
      icon: srv3,
      title: "Cam kết hoa tươi 100%",
      description: "Các sản phẩm của shophoa.shop được cam từ hoa tươi mới 100%",
    },
  ]

  return (
    <section className="services-section py-4">
      <div className="container">
        <div className="services-wrapper">
          <div className="row g-0">
            {services.map((service, index) => (
              <div key={index} className="col-lg-4 col-md-12">
                <div className="service-item d-flex align-items-center p-3">
                  <div className="service-icon me-3">
                    <img src={service.icon || "/placeholder.svg"} alt={service.title} className="service-img" />
                  </div>
                  <div className="service-content">
                    <h6 className="service-title mb-1">{service.title}</h6>
                    <p className="service-desc mb-0">{service.description}</p>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  )
}

export default ServicesSection
