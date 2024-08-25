import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  server: {
    host: '0.0.0.0',  // 允許外部連接到 Vite 開發伺服器
    port: 3000,        // 確保使用正確的端口
    strictPort: true,
    hmr: {
      host: 'localhost',  // 或者設置為你的 Docker 容器名稱，比如 "vite"
    },
  },
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
});
