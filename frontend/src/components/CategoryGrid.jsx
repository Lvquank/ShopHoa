import FlowerCard from "./FlowerCard"
import "../styles/components/CategoryGrid.css"

const CategoryGrid = ({ categoryCard = {}, products = [] }) => {
  return (
    <section className="category-grid-section py-4">
      <div className="container">
        <div className="row g-3">
          {/* Category Card - Chiếm 1/4 chiều rộng */}
          <div className="col-12 col-sm-6 col-md-4 col-lg-3">
            <div className="category-card h-100">
              <div className="position-relative h-100 overflow-hidden">
                {categoryCard.imageUrl && (
                  <img
                    src={categoryCard.imageUrl || "/placeholder.svg"}
                    alt={categoryCard.title || "Category"}
                    className="category-img w-100 h-100"
                  />
                )}
                {categoryCard.title && (
                  <div className="category-overlay position-absolute top-0 start-0 w-100 h-100">
                    <div className="category-title-wrapper bg-pink">
                      <h3 className="category-title text-white fw-bold mb-0 w-100 d-flex justify-content-center">{categoryCard.title.toUpperCase()}</h3>
                    </div>
                  </div>
                )}
              </div>
            </div>
          </div>

          {/* Product Cards - Mỗi card chiếm 1/4 chiều rộng */}
          {products.slice(0, 3).map((product, index) => (
            <div key={index} className="col-12 col-sm-6 col-md-4 col-lg-3">
              <FlowerCard
                key={index}
                imageUrl={product.imageUrl}
                title={product.title}
                buttonText={product.buttonText}
                buttonType={product.buttonType}
                productId={product.id}
                category={product.category}
              />
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}

export default CategoryGrid
