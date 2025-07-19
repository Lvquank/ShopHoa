import { BrowserRouter } from "react-router-dom";
import AppRoutes from "./routes";
import "./App.css";
import ScrollToTop from "./components/ScrollToTop";
// THÊM: Import các Provider cần thiết
import { UserProvider } from './context/UserContext';
import { CartProvider } from './context/CartContext';
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
