import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import '../styles/components/OpeningFlowersCard.css';


const OpeningFlowersCard = ({ imageUrl, title, productCount }) => {
    return (
        <div className="card opening-flowers-card mb-3 shadow-sm">
            <div className="row g-0">
                <div className="col-md-7">
                    <img
                        src={imageUrl}
                        alt={title}
                        className="card-img opening-flowers-img"
                    />
                </div>
                <div className="col-md-5 d-flex align-items-center justify-content-center text-center">
                    <div className="card-body">
                        <h5 className="card-title opening-flowers-title mb-2">
                            {title.toUpperCase()}
                        </h5>
                        <p className="card-text opening-flowers-product-count">
                            {`${productCount} SẢN PHẨM`}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default OpeningFlowersCard;