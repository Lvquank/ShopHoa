// src/utils/axios.js

import axios from 'axios';
import Cookies from 'js-cookie';

// Tạo một instance của Axios với cấu hình cơ bản
const apiClient = axios.create({
    // Lấy URL của API từ biến môi trường, đây là cách làm tốt nhất
    baseURL: import.meta.env.VITE_API_URL,
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
});

// --- 1. INTERCEPTOR CHO REQUEST (YÊU CẦU GỬI ĐI) ---
// Interceptor này sẽ chạy TRƯỚC KHI mỗi yêu cầu được gửi lên server.
// Nhiệm vụ chính: Tự động gắn token xác thực vào header.
apiClient.interceptors.request.use(
    (config) => {
        // Đọc token từ Cookies
        const token = Cookies.get('authToken');

        // Nếu có token, gắn nó vào header 'Authorization'
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }

        // Trả về đối tượng config đã được chỉnh sửa để request tiếp tục
        return config;
    },
    (error) => {
        // Xử lý lỗi nếu có trong quá trình thiết lập request
        return Promise.reject(error);
    }
);


// --- 2. INTERCEPTOR CHO RESPONSE (PHẢN HỒI TỪ SERVER) ---
// Interceptor này sẽ chạy SAU KHI nhận được phản hồi từ server.
// Nhiệm vụ chính: Xử lý các lỗi chung, đặc biệt là lỗi 401 (Unauthorized).
apiClient.interceptors.response.use(
    // Hàm này sẽ chạy nếu response trả về mã trạng thái 2xx (Thành công)
    (response) => {
        // Không cần làm gì cả, chỉ cần trả về response
        return response;
    },
    // Hàm này sẽ chạy nếu response trả về lỗi (mã trạng thái không phải 2xx)
    (error) => {
        // Kiểm tra xem có phải lỗi 401 (Unauthorized) hay không
        if (error.response && error.response.status === 401) {
            // Nếu đúng là lỗi 401, thực hiện các bước đăng xuất người dùng

            // a. Xóa token khỏi cookies
            Cookies.remove('authToken');

            // b. Chuyển hướng người dùng về trang đăng nhập.
            // Dùng window.location.href để tải lại trang hoàn toàn,
            // đảm bảo mọi state của React được reset sạch sẽ.
            window.location.href = '/dang-nhap';

            // c. (Tùy chọn) Hiển thị thông báo cho người dùng
            // Bạn có thể dùng toast hoặc alert tùy vào thư viện UI
            // toast.error('Phiên đăng nhập đã hết hạn, vui lòng đăng nhập lại.');
        }

        // Quan trọng: Trả về lỗi để các hàm .catch() ở nơi gọi API có thể xử lý tiếp
        return Promise.reject(error);
    }
);

export default apiClient;
