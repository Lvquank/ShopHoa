// src/utils/axios.js

import axios from 'axios';
// QUAN TRỌNG: Import thư viện js-cookie ở đây
import Cookies from 'js-cookie';

// Tạo một instance của Axios
const apiClient = axios.create({
    baseURL: 'http://localhost:8000', // Hoặc import.meta.env.VITE_API_URL
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
});

// SỬA ĐỔI QUAN TRỌNG: Interceptor này sẽ đọc token từ Cookies
apiClient.interceptors.request.use(
    (config) => {
        // Đọc token từ Cookies thay vì localStorage
        const token = Cookies.get('authToken');

        // Nếu có token, gắn nó vào header Authorization
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }

        // Trả về config đã được chỉnh sửa để request tiếp tục
        return config;
    },
    (error) => {
        // Xử lý lỗi nếu có
        return Promise.reject(error);
    }
);

export default apiClient;