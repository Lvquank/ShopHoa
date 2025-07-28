import { BrowserRouter } from "react-router-dom";
import AppRoutes from "./routes";
import "./App.css";
import ScrollToTop from "./components/ScrollToTop";
import { UserProvider } from './contexts/UserContext';
import { CartProvider } from './contexts/CartContext';
import { GoogleOAuthProvider } from '@react-oauth/google';

import { ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

function App() {
  const googleClientId = import.meta.env.VITE_GOOGLE_CLIENT_ID;

  return (
    <GoogleOAuthProvider clientId={googleClientId}>
      <UserProvider>
        <CartProvider>
          <BrowserRouter>
            <ScrollToTop />
            <div className="App">
              <AppRoutes />
            </div>
            <ToastContainer
              position="top-right"
              autoClose={3000}
              hideProgressBar={false}
              newestOnTop={false}
              closeOnClick
              rtl={false}
              pauseOnFocusLoss
              draggable
              pauseOnHover
              theme="light"
            />
          </BrowserRouter>
        </CartProvider>
      </UserProvider>
    </GoogleOAuthProvider>
  );
}

export default App;