import { BrowserRouter } from "react-router-dom";
import AppRoutes from "./routes";
import "./App.css";
import ScrollToTop from "./components/ScrollToTop";
// THÊM: Import các Provider cần thiết
import { UserProvider } from './contexts/UserContext';
import { CartProvider } from './contexts/CartContext';
import { GoogleOAuthProvider } from '@react-oauth/google';

function App() {
  // Lấy Client ID từ file môi trường .env
  const googleClientId = import.meta.env.VITE_GOOGLE_CLIENT_ID;

  return (
    // THÊM: Bọc toàn bộ ứng dụng trong GoogleOAuthProvider để sử dụng xác thực Google
    <GoogleOAuthProvider clientId={googleClientId}>
      {/* THÊM: Bọc trong UserProvider để quản lý trạng thái người dùng toàn cục */}
      <UserProvider>
        <CartProvider>
          <BrowserRouter>
            <ScrollToTop />
            <div className="App">
              <AppRoutes />
            </div>
          </BrowserRouter>
        </CartProvider>
      </UserProvider>
    </GoogleOAuthProvider>
  );
}

export default App;
