import React from 'react';
import { Link, useNavigate } from 'react-router-dom';

const Pay = () => {
    const navigate = useNavigate();

    const handleBackToShop = () => {
        navigate('/cua-hang');
    };

    return (
        <div className="container py-5">
            <div className="row justify-content-center">
                <div className="col-lg-8">
                    {/* Breadcrumb */}
                    <nav aria-label="breadcrumb" className="mb-5">
                        <div className="text-center">
                            <span className="text-dark" style={{ fontSize: '25px' }}>GIỎ HÀNG</span>
                            <span className="mx-2 text-muted" style={{ fontSize: '25px' }}>&gt;</span>
                            <span style={{ fontSize: '25px', color: '#ff5622' }}>THANH TOÁN</span>
                            <span className="mx-2 text-muted" style={{ fontSize: '25px' }}>&gt;</span>
                            <span style={{ fontSize: '25px', color: '#ff5622' }}>HOÀN TẤT</span>
                        </div>
                    </nav>

                    {/* Empty Cart Content */}
                    <div className="text-center">
                        <div className="mb-4">
                            <p className="text-muted fs-5 mb-4">Chưa có sản phẩm nào trong giỏ hàng.</p>

                            <button
                                className="btn btn-danger px-4 py-2 fw-bold text-uppercase"
                                onClick={handleBackToShop}
                                style={{
                                    backgroundColor: '#ff5622',
                                    fontSize: '14px',
                                    letterSpacing: '0.5px'
                                }}
                            >
                                QUAY TRỞ LẠI CỬA HÀNG
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Pay;