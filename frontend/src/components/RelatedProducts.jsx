import { useState, useEffect } from "react"
import FlowerCard from "./FlowerCard"
import "../styles/components/RelatedProducts.css"

const RelatedProducts = ({ products = [], title = "CÓ THỂ BẠN QUAN TÂM :" }) => {
  const [currentIndex, setCurrentIndex] = useState(0)
  const [itemsPerPage, setItemsPerPage] = useState(4)

  useEffect(() => {
    const handleResize = () => {
      if (window.innerWidth <= 768) {
        setItemsPerPage(2)
      } else if (window.innerWidth <= 820) {
        setItemsPerPage(3)
      } else {
        setItemsPerPage(4)
      }
    }

    // Set initial value
    handleResize()

    // Add event listener
    window.addEventListener('resize', handleResize)

    // Cleanup
    return () => window.removeEventListener('resize', handleResize)
  }, [])

  const nextSlide = () => {
    if (currentIndex + itemsPerPage < products.length) {
      setCurrentIndex(currentIndex + itemsPerPage)
    }
  }

  const prevSlide = () => {
    if (currentIndex > 0) {
      setCurrentIndex(currentIndex - itemsPerPage)
    }
  }

  const currentProducts = products.slice(currentIndex, currentIndex + itemsPerPage)

  return (
    <section className="related-products-section py-4">
      <div className="container">
        {/* Title */}
        <div className="mb-4">
          <h3 className="related-title text-uppercase fw-bold">{title}</h3>
        </div>

        {/* Products Grid with Navigation */}
        <div className="related-grid-wrapper position-relative">
          <div className="row g-3">
            {currentProducts.map((product, index) => (
              <div key={currentIndex + index} className="col-6 col-md-4 col-lg-3 custom-col">
                <FlowerCard
                  imageUrl={
                    product.imageUrl
                      ? product.imageUrl.replace("http://localhost:8000", import.meta.env.VITE_API_URL)
                      : hoaKhaiTruong
                  }
                  title={product.title}
                  buttonText={product.buttonText || "Xem chi tiết"}
                  buttonType={product.buttonType || "read"}
                  productId={product.id}
                  category={product.category || "cua-hang"}
                />
              </div>
            ))}
          </div>

          {/* Navigation Buttons */}
          {currentIndex > 0 && (
            <div className="related-nav-btn related-nav-prev" onClick={prevSlide}>
              <i className="bi bi-chevron-left"></i>
            </div>
          )}

          {currentIndex + itemsPerPage < products.length && (
            <div className="related-nav-btn related-nav-next" onClick={nextSlide}>
              <i className="bi bi-chevron-right"></i>
            </div>
          )}
        </div>
      </div>
    </section>
  )
}

export default RelatedProducts
