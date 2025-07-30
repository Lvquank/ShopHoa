import React from 'react';
import { Routes, Route } from 'react-router-dom';
import Home from './pages/Home';
import Layout from './layout/Layout';
import About from './pages/About';
import Products from './pages/Products';
import ChainStores from './pages/ChainStores';
import Pay from './pages/Pay';
import News from './pages/News';
import Contact from './pages/Contact';
import NewsDetail from './pages/NewsDetail';
import ProductDetail from './pages/ProductDetail';
import Category from './pages/Category';
import Login from './pages/Login';
import Register from './pages/Register';
import AuthCallback from './pages/AuthCallback';
import ResetPassword from './pages/ResetPassword';
import ForgotPassword from './pages/ForgotPassword';
function AppRoutes() {
  return (
    <Routes>
      <Route
        path="/"
        element={
          <Layout isShowCategoryMenu={true}>
            <Home />
          </Layout>
        }
      />
      <Route
        path="/gioi-thieu/"
        element={
          <Layout isShowCategoryMenu={false}>
            <About />
          </Layout>
        }
      />
      <Route
        path="/cua-hang/"
        element={
          <Layout isShowCategoryMenu={false}>
            <Products />
          </Layout>
        }
      />
      <Route
        path="/he-thong-cua-hang/"
        element={
          <Layout isShowCategoryMenu={false}>
            <ChainStores />
          </Layout>
        }
      />
      <Route
        path="/gio-hang/"
        element={
          <Layout isShowCategoryMenu={false}>
            <Pay />
          </Layout>
        }
      />
      <Route
        path="/tin-tuc/"
        element={
          <Layout isShowCategoryMenu={false}>
            <News />
          </Layout>
        }
      />
      <Route
        path="/lien-he/"
        element={
          <Layout isShowCategoryMenu={false}>
            <Contact />
          </Layout>
        }
      />
      <Route
        path="/tin-tuc/:id" // Sử dụng :id để khớp với /tin-tuc/1, /tin-tuc/2, v.v.
        element={
          <Layout isShowCategoryMenu={false}>
            <NewsDetail />
          </Layout>
        }
      />
      <Route
        path="/cua-hang/:productId"
        element={
          <Layout isShowCategoryMenu={false}>
            <ProductDetail />
          </Layout>
        }
      />
      <Route
        path="/danh-muc/:category"
        element={
          <Layout isShowCategoryMenu={false}>
            <Category />
          </Layout>
        }
      />
      <Route
        path="/danh-muc/:category/:style?"
        element={
          <Layout isShowCategoryMenu={false}>
            <Category />
          </Layout>
        }
      />
      <Route
        path="/tim-kiem"
        element={
          <Layout isShowCategoryMenu={false}>
            <Products />
          </Layout>
        }
      />
      <Route
        path="/login"
        element={
          <Layout isShowCategoryMenu={false}>
            <Login />
          </Layout>
        }
      />
      <Route
        path="/register"
        element={
          <Layout isShowCategoryMenu={false}>
            <Register />
          </Layout>
        }
      />
      <Route
        path="/auth/callback"
        element={
          <Layout isShowCategoryMenu={false}>
            <AuthCallback />
          </Layout>
        }
      />
      <Route
        path="/forgot-password"
        element={
          <Layout isShowCategoryMenu={false}>
            <ForgotPassword />
          </Layout>
        }
      />
      <Route
        path="/reset-password/:token"
        element={
          <Layout isShowCategoryMenu={false}>
            <ResetPassword />
          </Layout>
        }
      />
    </Routes>
  );
}

export default AppRoutes;
