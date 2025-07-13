import { useEffect } from "react";
import Header from "./components/Header";
import Footer from "./components/Footer";
import "../styles/layout/Layout.css";

const Layout = ({ children, isShowCategoryMenu = false }) => {
    // Scroll-top button effect
    useEffect(() => {
        const handleScroll = () => {
            const scrollBtn = document.getElementById('scroll-top');
            if (!scrollBtn) return;
            if (window.scrollY > 200) {
                scrollBtn.classList.add('active');
            } else {
                scrollBtn.classList.remove('active');
            }
        };
        window.addEventListener('scroll', handleScroll);
        // Clean up
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    // Scroll to top on click
    useEffect(() => {
        const scrollBtn = document.getElementById('scroll-top');
        if (!scrollBtn) return;
        const handleClick = (e) => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        };
        scrollBtn.addEventListener('click', handleClick);
        return () => scrollBtn.removeEventListener('click', handleClick);
    }, []);

    return (
        <div className="d-flex flex-column min-vh-100">
            <Header isShowCategoryMenu={isShowCategoryMenu} />
            <main className="flex-grow-1">
                {children}
            </main>
            <Footer />

            {/* Floating Social Icons */}
            <div className="floating-social-icons">
                <a href="https://m.me/yourpage" target="_blank" rel="noopener noreferrer" className="social-icon messenger">
                    <i className="bi bi-messenger" style={{ fontSize: '1.5rem', color: '#fff' }}></i>
                    <span className="icon-label">Facebook Messenger</span>
                </a>
                <a href="https://zalo.me/yourzalo" target="_blank" rel="noopener noreferrer" className="social-icon zalo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Icon_of_Zalo.svg" alt="Zalo" />
                    <span className="icon-label">Chat với chúng tôi qua Zalo</span>
                </a>
                <a href="tel:0966183183" className="social-icon phone">
                    <i className="bi bi-telephone-fill" style={{ fontSize: '1.5rem', color: '#fff' }}></i>
                    <span className="icon-label">Gọi ngay</span>
                </a>
            </div>

            <a href="#" id="scroll-top" className="scroll-top d-flex align-items-center justify-content-center"><i className="bi bi-chevron-up"></i></a>
        </div>
    );
}

export default Layout;
