"use client"

import { Link } from "react-router-dom"
import "../styles/components/TitleSection.css"

const TitleSection = ({ title = "TOP BÁN CHẠY", icon = "bi-gift", linkTo = null }) => {
  return (
    <section className="top-ban-chay-section">
      <div className="container">
        <div className="section-header">
          <div className="section-line"></div>
          <div className="section-content">
            <i className={`bi ${icon} section-icon`}></i>
            <h2 className="section-title">{title}</h2>
          </div>
          <div className="section-line"></div>
          {linkTo && (
              <Link to={linkTo} className="section-arrow-link">
                <i className="bi bi-chevron-right section-arrow"></i>
              </Link>
            )}
        </div>
      </div>
    </section>
  )
}

export default TitleSection
