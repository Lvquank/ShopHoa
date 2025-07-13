import { Link } from "react-router-dom"
import "../styles/components/FlowerCard.css"

const FlowerCard = ({
  imageUrl,
  title,
  buttonText = "Đọc tiếp",
  buttonType = "read", // "read" hoặc "order"
  productId,
  category = "san-pham",
  link,
}) => {
  const buttonClass = buttonType === "order" ? "btn-order" : "btn-read"
  const linkTo = link || (productId ? `/${category}/${productId}` : `/${category}`)

  const cardContent = (
    <div className="flower-card border-0 shadow-sm h-100">
      <div className="card-img-wrapper overflow-hidden">
        <img src={imageUrl || "/placeholder.svg"} alt={title} className="card-img-top flower-img" />
      </div>
      <div className="card-body d-flex flex-column p-3">
        <h6 className="card-title flower-title text-dark flex-grow-1">{title}</h6>
        <span className={`${buttonClass} text-white text-decoration-none text-center`} style={{ cursor: 'pointer' }}>
          {buttonText}
        </span>
      </div>
    </div>
  )

  return linkTo ? (
    <Link to={linkTo} style={{ textDecoration: 'none' }}>
      {cardContent}
    </Link>
  ) : cardContent
}

export default FlowerCard
