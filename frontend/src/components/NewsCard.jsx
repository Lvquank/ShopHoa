import React from 'react';
import { Link } from 'react-router-dom';
import '../styles/components/NewsCard.css'; // Đảm bảo bạn đã tạo và import file CSS này

const NewsCard = ({ article }) => {
  if (!article) {
    return null;
  }

  // Định dạng lại ngày tháng
  const formattedDate = new Date(article.date).toLocaleDateString('vi-VN', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  });

  return (
    <div className="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 mb-4">
      <Link to={`/tin-tuc/${article.id}`} className="news-card-link">
        <div className="news-card h-100">
          <div className="news-img-wrapper overflow-hidden">
            <img src={article.imageUrl || "/placeholder.svg"} alt={article.title} className="news-img w-100" />
          </div>
          <div className="news-content p-4">
            <h5 className="news-title mb-3">{article.title}</h5>
            <p className="news-date text-muted mb-3">{formattedDate}</p>
            <p className="news-excerpt text-muted mb-0">{article.excerpt}</p>
          </div>
        </div>
      </Link>
    </div>
  );
};

export default NewsCard;
