# An Mộc Y Viện – WordPress

Theme `anmoc` (WordPress) cho website An Mộc Y Viện.

- `wp-content/themes/anmoc/` – mã nguồn theme (tự tạo trang, dữ liệu mẫu và ảnh khi kích hoạt).
- `tai-lieu/` – hướng dẫn quản trị (.docx) và hướng dẫn deploy lên AZDIGI.

**Chạy thử trên máy tính (người không rành kỹ thuật):** xem [HUONG-DAN-CHAY-LOCAL.md](HUONG-DAN-CHAY-LOCAL.md). Dùng Claude thì chỉ cần mở thư mục này và nhờ Claude "giúp tôi chạy website này trên máy" — Claude đọc [CLAUDE.md](CLAUDE.md) và dẫn từng bước.

Cài lên hosting: nén thư mục `wp-content/themes/anmoc` thành `anmoc.zip`, vào **Giao diện → Theme → Thêm mới → Tải lên**, rồi kích hoạt.

Không có trong repo: WordPress core, `wp-config.php`, database, file `wp-config-azdigi.php` / `doi-url.php` (chứa khoá bí mật).
