import FlowerCard from "./FlowerCard";
import "../styles/components/CategoryGrid.css";

const CategoryGrid = ({ categoryCard = {}, products = [] }) => {
  return (
    <section className="category-grid-section py-4">
      <div className="container">
        <div className="row g-4"> {/* Tăng khoảng cách giữa các phần tử */}

          {/* Cột 1: Thẻ Danh mục */}
          <div className="col-12 col-lg-3">
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
                  <div className="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-start justify-content-center">
                    <div className="category-title-wrapper bg-pink w-100">
                      <h3 className="category-title text-white fw-bold text-center mb-0">
                        {categoryCard.title.toUpperCase()}
                      </h3>
                    </div>
                  </div>
                )}
              </div>
            </div>
          </div>

          {/* Cột 2: Lưới các sản phẩm */}
          <div className="col-12 col-lg-9">
            <div className="row g-3">
              {/* Mỗi sản phẩm là một cột trong lưới con này */}
              {products.slice(0, 3).map((product) => (
                <div key={product.id} className="col-12 col-md-4 col-sm-6">
                  <FlowerCard
                    imageUrl={
                      product.image
                        ? product.image.replace("http://localhost:8000", import.meta.env.VITE_API_URL)
                        : "/api/placeholder/400/600"
                    }
                    title={product.title}
                    buttonText={product.buttonText}
                    buttonType={product.buttonType}
                    productId={product.id}
                    category={product.category}
                    link={`/cua-hang/${product.id}`}
                  />
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default CategoryGrid;