import React from 'react';
import { Routes, Route } from 'react-router-dom';
import Home from './pages/Home';
import Layout from './components/layout/Layout';
function AppRoutes() {
    return (
        <Routes>
            <Route path="/" element={
                <Layout enableScroll={true}><Home /></Layout>
            } />
        </Routes>
    );
}

export default AppRoutes;