import { useState, useEffect } from "react"
import FlowerCard from "./FlowerCard"
import "../styles/components/RelatedProducts.css"

const RelatedProducts = ({ products = [], title = "CÓ THỂ BẠN QUAN TÂM :" }) => {
  const [currentIndex, setCurrentIndex] = useState(0)
  const [itemsPerPage, setItemsPerPage] = useState(4)

  useEffect(() => {
    const handleResize = () => {
      // Điều chỉnh breakpoint để phù hợp với iPad Mini
      if (window.innerWidth <= 576) {
        setItemsPerPage(2) // Mobile: 2 cột
      } else if (window.innerWidth <= 767) {
        setItemsPerPage(2) // Tablet nhỏ: 2 cột
      } else if (window.innerWidth <= 1024) {
        setItemsPerPage(3) // iPad và Tablet: 3 cột
      } else {
        setItemsPerPage(4) // Desktop: 4 cột
      }
    }

    // Set initial value
    handleResize()

    // Thêm debounce để tránh gọi quá nhiều lần khi resize
    let timeoutId = null;
    const debouncedResize = () => {
      if (timeoutId) {
        clearTimeout(timeoutId);
      }
      timeoutId = setTimeout(handleResize, 250);
    };

    window.addEventListener('resize', debouncedResize)

    // Cleanup
    return () => {
      window.removeEventListener('resize', debouncedResize)
      if (timeoutId) {
        clearTimeout(timeoutId);
      }
    }
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
              <div key={currentIndex + index} className="col-6 col-sm-6 col-md-4 col-xl-3">
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
