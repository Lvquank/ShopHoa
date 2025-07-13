import "../styles/components/NewsCard.css"
import { Link } from "react-router-dom"

const NewsCard = ({ article }) => {
  if (!article) return null

  const linkTo = `/tin-tuc/${article.id}`

  return (
    <div className="col-lg-6 col-md-6">
      <Link to={linkTo} style={{ textDecoration: 'none' }}>
        <div className="news-card h-100">
          <div className="news-img-wrapper overflow-hidden">
            <img src={article.imageUrl || "/placeholder.svg"} alt={article.title} className="news-img w-100" />
          </div>
          <div className="news-content p-4">
            <h4 className="news-title mb-3">{article.title}</h4>
            <p className="news-date text-muted mb-3">{article.date}</p>
            <p className="news-excerpt text-muted mb-0">{article.excerpt}</p>
          </div>
        </div>
      </Link>
    </div>
  )
}

export default NewsCard
