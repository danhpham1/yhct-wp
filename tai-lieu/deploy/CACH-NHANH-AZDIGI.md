# Đưa website lên AZDIGI — cách nhanh (chỉ cần file anmoc.zip)

Theme tự tạo toàn bộ nội dung mẫu ngay khi kích hoạt: 8 trang, menu, 6 dịch vụ, 3 bác sĩ,
3 cảm nhận, 4 câu hỏi, 7 bài viết, 15 ảnh. **Không cần đụng database, không cần đổi URL.**

Đã thử trên một WordPress trắng: kết quả giống bản local 100% (so từng trang).

File cần dùng: **`anmoc.zip`** (4 MB) — nằm cùng thư mục này.

---

## Bước 1 — Mua hosting + tên miền

Mua **cùng ở AZDIGI** để tên miền tự gắn vào hosting, khỏi trỏ DNS.
Gói đề xuất: **AZ Pro 2** (12 tháng) + tên miền `.vn` hoặc `.com`.

## Bước 2 — Cài WordPress trắng (2 phút)

cPanel → **WordPress Manager by Softaculous** (hoặc **WP Toolkit**, tuỳ gói) → **Install**:

| Ô | Điền |
|---|---|
| Protocol | `https://` |
| Domain | tên miền của mày |
| Directory | **để trống** (xoá chữ `wp` nếu có) |
| Site Name | `An Mộc Y Viện` |
| Admin Username | đừng dùng `admin`, đặt tên khác |
| Admin Password | mật khẩu mạnh, lưu lại |
| Select Language | **Tiếng Việt** |

Bấm **Install**, chờ xong.

> Nếu trình duyệt báo "không an toàn": cPanel → **SSL/TLS Status** → **Run AutoSSL**, chờ vài phút.

## Bước 3 — Cài theme (1 phút)

1. Vào `https://tenmien.vn/wp-admin`, đăng nhập bằng tài khoản vừa tạo ở bước 2.
2. **Giao diện → Thêm giao diện → Tải giao diện lên** → chọn `anmoc.zip` → **Cài đặt**.
3. Bấm **Kích hoạt**. Chờ 10–30 giây (theme đang chép ảnh và tạo nội dung) — **đừng tắt trang**.

Xong. Mở trang chủ là thấy website hoàn chỉnh.

## Bước 4 — Mấy việc nhỏ sau đó

- **Cài đặt → Đường dẫn tĩnh** → chọn **Tên bài viết** → **Lưu thay đổi**.
- **Email đặt lịch:** tạo email `lienhe@tenmien.vn` trong cPanel → cài plugin **FluentSMTP** → khai báo SMTP (host `mail.tenmien.vn`, port 465, SSL) → gửi thử.
  Rồi vào **Cài đặt → Tổng quan** đặt *Địa chỉ email* là hộp thư nhận thông báo đặt lịch.
- **Plugin → Plugin đã cài**: xoá những plugin Softaculous cài kèm mà không dùng (Hello Dolly…). **Giữ LiteSpeed Cache** — nó giúp web nhanh.
- Tạo tài khoản riêng cho khách hàng (vai trò *Biên tập viên* nếu họ chỉ đăng bài).
- Thay nội dung mẫu bằng thông tin thật: số giấy phép, số liệu thống kê, địa chỉ, điện thoại, bác sĩ, lời chứng khách hàng. Chương 10 trong tài liệu hướng dẫn khách hàng có danh sách đầy đủ.

---

## Nếu có trục trặc

**Bấm Kích hoạt xong trang trắng hoặc quay mãi** (hosting cắt vì chạy lâu):
vào **Giao diện → Dữ liệu mẫu** → bấm **Nạp dữ liệu mẫu**. Nó làm tiếp phần còn thiếu, cái gì có rồi thì bỏ qua, không tạo trùng.

**Báo "Liên kết bạn theo dõi đã hết hạn" khi tải zip lên:** file vượt giới hạn upload.
cPanel → **Select PHP Version → Options** → tăng `upload_max_filesize` và `post_max_size` lên `64M`.

**Sửa trong Tuỳ biến, bấm Đăng mà ngoài web chưa đổi:** do cache.
Thanh trên cùng của admin → **LiteSpeed Cache → Purge All**.

**Trang con báo 404:** làm lại mục *Đường dẫn tĩnh* ở bước 4.

---

## Khi nào KHÔNG dùng được cách này

Cách này dựng lại website từ **nội dung mặc định của theme**. Nó không mang theo những gì đã sửa trên máy local.

Hiện tại bản local **chưa sửa gì** so với mặc định, nên dùng cách này là đúng y hệt.

Từ giờ trở đi: **nhập nội dung thật thẳng trên hosting**, đừng nhập ở local rồi mới chuyển.
Nếu lỡ đã nhập nhiều trên local, dùng cách đầy đủ trong `HUONG-DAN-DEPLOY-AZDIGI.md`
(hoặc cài plugin **All-in-One WP Migration** ở cả 2 bên: Xuất ở local → Nhập ở hosting).
