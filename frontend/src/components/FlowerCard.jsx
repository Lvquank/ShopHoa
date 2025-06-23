import { Link } from "react-router-dom"
import "../styles/components/FlowerCard.css"

const FlowerCard = ({
  imageUrl,
  title,
  buttonText = "Đọc tiếp",
  buttonType = "read", // "read" hoặc "order"
  productId,
  category = "san-pham",
}) => {
  const buttonClass = buttonType === "order" ? "btn-order" : "btn-read"
  const linkTo = productId ? `/${category}/${productId}` : `/${category}`

  return (
      <div className="card flower-card border-0 shadow-sm h-100">
        <div className="card-img-wrapper overflow-hidden">
          <img src={imageUrl || "/placeholder.svg"} alt={title} className="card-img-top flower-img" />
        </div>
        <div className="card-body d-flex flex-column p-3">
          <h6 className="card-title flower-title text-dark flex-grow-1">{title}</h6>
          <Link to={linkTo} className={`${buttonClass} text-white text-decoration-none`}>
            {buttonText}
          </Link>
        </div>
      </div>
  )
}

export default FlowerCard
