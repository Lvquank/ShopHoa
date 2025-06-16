import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import '../styles/components/Intro.css';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Pagination, Autoplay, Navigation } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import intro1 from '../images/intro1.webp';
import intro2 from '../images/intro2.webp';
import intro3 from '../images/intro3.webp';
import intro4 from '../images/intro4.webp';
import intro1_2 from '../images/intro1-2.webp';
function Intro() {
    return (
        <div className="container h-100">
            <div className="row h-100">
                <div className="col-md-8 d-flex flex-column">
                    <div className="image-top mb-4">
                        <Swiper
                            modules={[Pagination, Autoplay, Navigation]}
                            pagination={{ clickable: true }}
                            navigation={true}
                            autoplay={{
                                delay: 3000,
                                disableOnInteraction: false,
                            }}
                            loop={true}
                            className="h-100"
                        >
                            <SwiperSlide>
                                <img src={intro1}
                                    className="img-fluid w-100 h-100 object-fit-cover"
                                    alt="Flowers and Gift 1"
                                />
                            </SwiperSlide>
                            <SwiperSlide>
                                <img src={intro1_2}
                                    className="img-fluid w-100 h-100 object-fit-cover"
                                    alt="Flowers and Gift 2"
                                />
                            </SwiperSlide>
                        </Swiper>
                    </div>                    <div className="image-bottom d-none d-md-block">
                        <div className="row g-3">
                            <div className="col-6">
                                <img src={intro2}
                                    className="img-fluid w-100 h-100 object-fit-cover"
                                    alt="Rose and Sheet Music"
                                />
                            </div>
                            <div className="col-6">
                                <img src={intro3}
                                    className="img-fluid w-100 h-100 object-fit-cover"
                                    alt="Love Image"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-md-4 h-100 d-none d-md-flex">
                    <img src={intro4}
                        className="img-fluid w-100 h-100 object-fit-cover"
                        alt="Girl with Red Hat"
                    />
                </div>
            </div>
        </div>
    );
};

export default Intro;
