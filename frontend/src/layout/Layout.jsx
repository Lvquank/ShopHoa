import React from "react";
import Header from "./components/Header";
import Footer from "./components/Footer";

const Layout = ({ children, isShowCategoryMenu = false }) => {
    return (
        <div className="d-flex flex-column min-vh-100">
            <Header isShowCategoryMenu={isShowCategoryMenu} />
            <main className="flex-grow-1">
                {children}
            </main>
            <Footer />
        </div>
    );
}

export default Layout;
