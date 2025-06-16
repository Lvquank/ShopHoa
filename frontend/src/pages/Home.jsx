import React from "react";
import "../styles/pages/Home.css";
import Intro from "../components/Intro";
import OpeningFlowersCard from "../components/OpeningFlowerCard"
function Home() {
    const OpeningFlower = [
        {
            imageUrl: "../images/hoa-khai-truong.webp",
            title: "Hoa khai trương",
            productCount: 3,
        },
        {
            imageUrl: "../images/hoa-dam-tang.webp",
            title: "Hoa đám tang",
            productCount: 14,
        },
    ];
    return (
        <div className="min-vh-100 d-flex flex-column">
            <div className="main-content flex-grow-1">
                <div className="row h-100">
                    <div className="col-lg-3">
                    </div>
                    <div className="col-lg-9 col-md-12">
                        <Intro />
                    </div>
                </div>
                <div className="row">
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
    );
}
export default Home;