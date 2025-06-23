import "../styles/components/Intro.css"
import { Swiper, SwiperSlide } from "swiper/react"
import { Pagination, Autoplay, Navigation } from "swiper/modules"
import "swiper/css"
import "swiper/css/pagination"
import "swiper/css/navigation"
import intro1 from "../assets/images/intro1.webp"
import intro2 from "../assets/images/intro2.webp"
import intro3 from "../assets/images/intro3.webp"
import intro4 from "../assets/images/intro4.webp"
import intro1_2 from "../assets/images/intro1-2.webp"

function Intro() {
  return (
    <div className="container-fluid h-100">
      <div className="row h-100 g-3">
        <div className="col-md-8 d-flex flex-column">
          <div className="mb-3 flex-grow-1 overflow-hidden intro-swiper">
            <Swiper
              modules={[Pagination, Autoplay, Navigation]}
              pagination={{ clickable: true }}
              navigation={true}
              autoplay={{
                delay: 3000,
                disableOnInteraction: false,
              }}
              loop={true}
              className="h-100 w-100"
            >
              <SwiperSlide>
                <img
                  src={intro1 || "/placeholder.svg"}
                  className="w-100 h-100 intro-img"
                  alt="Flowers and Gift 1"
                  style={{ objectFit: "cover" }}
                />
              </SwiperSlide>
              <SwiperSlide>
                <img
                  src={intro1_2 || "/placeholder.svg"}
                  className="w-100 h-100 intro-img"
                  alt="Flowers and Gift 2"
                  style={{ objectFit: "cover" }}
                />
              </SwiperSlide>
            </Swiper>
          </div>

          <div className="d-none d-md-block">
            <div className="row g-2">
              <div className="col-6">
                <div className="overflow-hidden intro-img-container">
                  <img
                    src={intro2 || "/placeholder.svg"}
                    className="w-100 h-100 intro-img"
                    alt="Rose and Sheet Music"
                    style={{ height: "150px", objectFit: "cover" }}
                  />
                </div>
              </div>
              <div className="col-6">
                <div className="overflow-hidden intro-img-container">
                  <img
                    src={intro3 || "/placeholder.svg"}
                    className="w-100 h-100 intro-img"
                    alt="Love Image"
                    style={{ height: "150px", objectFit: "cover" }}
                  />
                </div>
              </div>
            </div>
          </div>
        </div>

        <div className="col-md-4 h-100 d-none d-md-flex">
          <div className="overflow-hidden w-100 h-100 intro-img-container">
            <img
              src={intro4 || "/placeholder.svg"}
              className="w-100 h-100 intro-img"
              alt="Girl with Red Hat"
              style={{ objectFit: "cover" }}
            />
          </div>
        </div>
      </div>
    </div>
  )
}

export default Intro
