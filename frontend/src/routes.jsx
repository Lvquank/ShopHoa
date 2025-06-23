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
        path="/tin-tuc/chi-tiet/"
        element={
          <Layout isShowCategoryMenu={false}>
            <NewsDetail />
          </Layout>
        }
      />
    </Routes>
  );
}

export default AppRoutes;
