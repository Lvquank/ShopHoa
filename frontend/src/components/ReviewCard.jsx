import React from "react";
import 'bootstrap/dist/css/bootstrap.min.css';
const ReviewCard = () => {
    return (
        <div className="bg-light p-4">
            <h5 className="fw-bold">Để lại một bình luận</h5>
            <p className="text-muted">
                Email của bạn sẽ không được hiển thị công khai. Các trường bắt buộc được đánh dấu *
            </p>

            <form>
                <div className="mb-3">
                    <label htmlFor="comment" className="form-label fw-bold">
                        Bình luận *
                    </label>
                    <textarea className="form-control" id="comment" rows="5" required></textarea>
                </div>

                <div className="row mb-3">
                    <div className="col-md-4">
                        <label htmlFor="name" className="form-label fw-bold">Tên *</label>
                        <input type="text" className="form-control" id="name" required />
                    </div>
                    <div className="col-md-4">
                        <label htmlFor="email" className="form-label fw-bold">Email *</label>
                        <input type="email" className="form-control" id="email" required />
                    </div>
                    <div className="col-md-4">
                        <label htmlFor="website" className="form-label fw-bold">Trang web</label>
                        <input type="text" className="form-control" id="website" />
                    </div>
                </div>

                <div className="form-check mb-3">
                    <input className="form-check-input" type="checkbox" id="saveInfo" />
                    <label className="form-check-label" htmlFor="saveInfo">
                        Lưu tên của tôi, email, và trang web trong trình duyệt này cho lần bình luận kế tiếp của tôi.
                    </label>
                </div>

                <button type="submit" className="btn btn-warning text-white fw-bold px-4">
                    GỬI BÌNH LUẬN
                </button>
            </form>
        </div>
    );
};

export default ReviewCard;
