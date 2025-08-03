// src/main.jsx

import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App.jsx';
import './index.css';

import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { persistQueryClient } from '@tanstack/react-query-persist-client';
import { createSyncStoragePersister } from '@tanstack/query-sync-storage-persister';

// 1. Tạo QueryClient với các tùy chọn mặc định
const queryClient = new QueryClient({
  defaultOptions: {
    queries: {
      // Thời gian cache: Dữ liệu sẽ được giữ trong cache 24 giờ
      // ngay cả khi không có component nào sử dụng.
      // Đây là tùy chọn quan trọng nhất để giữ dữ liệu khi refresh.
      cacheTime: 1000 * 60 * 60 * 24, // 24 giờ

      // Thời gian dữ liệu được coi là "mới". Sau thời gian này,
      // nó vẫn sẽ hiển thị dữ liệu cũ từ cache nhưng sẽ âm thầm gọi lại API ở nền.
      staleTime: 1000 * 60 * 5, // 5 phút
    },
  },
});

// 2. Tạo một persister để lưu cache vào localStorage
const localStoragePersister = createSyncStoragePersister({
  storage: window.localStorage,
});

// 3. Liên kết persister với queryClient
// Đây là bước quan trọng để lưu và phục hồi cache
persistQueryClient({
  queryClient,
  persister: localStoragePersister,
});

// 4. Render ứng dụng
ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <QueryClientProvider client={queryClient}>
      <App />
    </QueryClientProvider>
  </React.StrictMode>,
);