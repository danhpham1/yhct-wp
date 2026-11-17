# Đưa website An Mộc Y Viện lên hosting AZDIGI

Tài liệu dành cho người triển khai (có chút kỹ thuật). Toàn bộ file cần dùng nằm cùng thư mục này:

| File | Dùng để làm gì |
|---|---|
| `anmoc-source.zip` (46 MB) | Toàn bộ mã nguồn website (WordPress + theme `anmoc` + ảnh). Đã bỏ `wp-config.php` và đã sửa sẵn `.htaccess` cho chạy ở thư mục gốc tên miền. |
| `yhct-database.sql` (1,4 MB) | Bản sao cơ sở dữ liệu: bài viết, dịch vụ, bác sĩ, cấu hình màu/chữ trong Tuỳ biến. |
| `wp-config-azdigi.php` | File cấu hình mẫu, đã sinh sẵn khoá bảo mật mới, chỉ cần điền thông tin database. |
| `doi-url.php` | Script đổi địa chỉ website từ `localhost` sang tên miền thật (an toàn với dữ liệu serialize). |
| `htaccess-goc.txt` | Bản `.htaccess` dự phòng, phòng khi cần dán lại thủ công. |

Thời gian làm: khoảng 45–60 phút, chưa tính thời gian tên miền trỏ về (có thể tới 24 giờ).

---

## 0. Trước khi bắt đầu

Cần có:

- Gói hosting AZDIGI dùng **cPanel** (các gói WordPress Hosting / Business Hosting đều được).
- Tên miền đã mua.
- Thông tin đăng nhập cPanel (AZDIGI gửi trong email bàn giao dịch vụ).
- Một phần mềm FTP, ví dụ **FileZilla** (miễn phí) — dùng khi File Manager của cPanel không cho upload file 46 MB.

Yêu cầu kỹ thuật của website:

- **PHP 8.1 trở lên** (khuyến nghị 8.2).
- MySQL 5.7+ hoặc MariaDB 10.4+.
- Module `mod_rewrite` (cPanel mặc định có).
- Dung lượng chiếm khoảng **150 MB**.

---

## 1. Trỏ tên miền về hosting

1. Đăng nhập trang quản lý dịch vụ AZDIGI (`my.azdigi.com`), mở dịch vụ hosting vừa mua.
2. Ghi lại **2 nameserver** mà AZDIGI cung cấp cho gói hosting đó (có trong email bàn giao và trong trang thông tin dịch vụ). Không đoán — mỗi cụm máy chủ một khác.
3. Vào nơi đang quản lý tên miền, đổi nameserver sang 2 giá trị đó.
4. Nếu tên miền mua ở chỗ khác và muốn giữ nameserver cũ: thay vì đổi nameserver, tạo bản ghi **A** cho `@` và `www` trỏ về **địa chỉ IP** của hosting (xem trong cPanel, mục *Shared IP Address* ở cột phải trang chủ).
5. Chờ cho đến khi tên miền đã trỏ đúng. Kiểm tra bằng Terminal trên máy:

```bash
dig +short tenmiencuaban.vn
```

Kết quả phải ra đúng IP của hosting. Trong lúc chờ, vẫn làm tiếp được bước 2–5.

---

## 2. Tạo database trên cPanel

Vào cPanel → **MySQL® Databases**:

1. **Create New Database**: gõ `yhct` → *Create Database*. cPanel sẽ tự thêm tiền tố, tên đầy đủ dạng `tenuser_yhct`. **Ghi lại tên đầy đủ này.**
2. **MySQL Users → Add New User**: tên `yhct`, bấm *Password Generator* để sinh mật khẩu mạnh → **lưu lại mật khẩu**.
3. **Add User To Database**: chọn user vừa tạo + database vừa tạo → *Add* → tick **ALL PRIVILEGES** → *Make Changes*.

Cuối bước này phải có trong tay 3 thông tin: tên database, tên user, mật khẩu.

---

## 3. Đặt phiên bản PHP

cPanel → **Select PHP Version** (hoặc *MultiPHP Manager*) → chọn **PHP 8.2** cho tên miền.

Trong tab *Extensions*, bảo đảm các mục sau được bật: `mysqli`, `mbstring`, `gd` hoặc `imagick`, `curl`, `zip`, `intl`, `exif`.

---

## 4. Tải mã nguồn lên

Website sẽ nằm ở thư mục gốc của tên miền: `public_html` (nếu là tên miền chính) hoặc `public_html/tenmien.vn` (nếu là addon domain).

**Cách A — File Manager (nhanh hơn, nếu hosting cho upload 46 MB):**

1. cPanel → **File Manager** → mở `public_html`.
2. Xoá hết file mặc định trong đó (`default.html`, `index.html`, `cgi-bin` giữ lại cũng được).
3. *Upload* → chọn `anmoc-source.zip` → chờ lên 100%.
4. Quay lại File Manager, chuột phải vào file zip → **Extract** → giải nén ngay trong `public_html`.
5. Giải nén xong, xoá file `anmoc-source.zip`.

**Cách B — FTP (khi File Manager báo quá dung lượng):**

1. Mở FileZilla, kết nối: Host = tên miền hoặc IP, Username/Password = tài khoản cPanel, Port = 21.
2. Giải nén `anmoc-source.zip` ra một thư mục trên máy, rồi kéo **toàn bộ nội dung bên trong** (không kéo cả thư mục cha) vào `public_html`.
3. Upload khoảng 4.300 file nên hơi lâu, cứ để chạy.

**Kiểm tra:** trong `public_html` phải thấy `wp-admin`, `wp-content`, `wp-includes`, `index.php`, `.htaccess` (bật *Settings → Show Hidden Files* trong File Manager mới thấy `.htaccess`).

---

## 5. Nạp database

cPanel → **phpMyAdmin** → chọn database `tenuser_yhct` ở cột trái → tab **Import**:

1. *Choose File* → chọn `yhct-database.sql`.
2. Format: **SQL**, Character set: **utf8mb4**.
3. Bấm **Go**. File chỉ 1,4 MB nên chạy vài giây.

Xong phải thấy khoảng 12 bảng bắt đầu bằng `wp_`. Nếu báo lỗi *Unknown collation*, mở file `.sql` bằng trình soạn thảo, thay `utf8mb4_0900_ai_ci` thành `utf8mb4_unicode_ci` rồi import lại.

---

## 6. Tạo file wp-config.php

1. Mở `wp-config-azdigi.php` bằng trình soạn thảo trên máy.
2. Sửa 3 dòng đầu cho khớp bước 2:

```php
define( 'DB_NAME',     'tenuser_yhct' );
define( 'DB_USER',     'tenuser_yhct' );
define( 'DB_PASSWORD', 'mat-khau-vua-sinh' );
```

`DB_HOST` để nguyên `localhost`.

3. Upload file lên `public_html`, rồi **đổi tên thành `wp-config.php`**.

Khoá bảo mật (AUTH_KEY, SALT…) trong file đã được sinh mới, khác với máy local — không cần làm gì thêm.

---

## 7. Đổi địa chỉ website từ localhost sang tên miền

Database đang chứa địa chỉ cũ `http://localhost:8888/yhct` ở rất nhiều chỗ: đường dẫn ảnh, cấu hình giao diện, menu. Phải đổi đúng cách, **không** được dùng Find & Replace thường của phpMyAdmin vì sẽ làm hỏng dữ liệu serialize (mất hết ảnh và màu trong Tuỳ biến).

1. Mở `doi-url.php`, sửa dòng:

```php
const NEW_URL = 'https://tenmiencuaban.vn';   // không có dấu / ở cuối
```

Nếu chưa cài SSL thì tạm để `http://`, sau khi cài SSL chạy lại script lần nữa với `https://`.

2. Upload `doi-url.php` vào `public_html`.
3. Mở trình duyệt: `https://tenmiencuaban.vn/doi-url.php?key=anmoc-doi-url`
   → script chạy **thử**, liệt kê những dòng sẽ sửa mà chưa ghi gì.
4. Xem danh sách thấy hợp lý thì bấm link `?key=anmoc-doi-url&run=1` ở cuối trang để ghi thật.
5. **Xoá ngay `doi-url.php` khỏi hosting** sau khi chạy xong.

> Nếu gói hosting có **Terminal** và cài sẵn WP-CLI thì nhanh hơn:
> ```bash
> wp search-replace 'http://localhost:8888/yhct' 'https://tenmiencuaban.vn' --all-tables --precise
> ```

---

## 8. Bật SSL và ép HTTPS

1. cPanel → **SSL/TLS Status** → chọn tên miền → **Run AutoSSL**. Chờ vài phút, cột *Certificate Status* chuyển sang xanh.
2. cPanel → **Domains** → bật công tắc **Force HTTPS Redirect** cho tên miền.
3. Nếu bước 7 đã chạy với `http://`, chạy lại script một lần nữa với `https://` rồi xoá file.

---

## 9. Kiểm tra permalink

Đăng nhập `https://tenmiencuaban.vn/wp-admin` (tài khoản và mật khẩu giống bản local).

Vào **Cài đặt → Đường dẫn tĩnh** → chọn **Tên bài viết** → **Lưu thay đổi** (kể cả khi đang đúng sẵn — thao tác này ghi lại `.htaccess` cho đúng máy chủ).

Mở thử vài trang con: `/dich-vu/`, `/bac-si/`, `/lien-he/`. Nếu bị 404 thì `.htaccess` chưa đúng — dán lại nội dung trong `htaccess-goc.txt`.

---

## 10. Cấu hình email cho form đặt lịch

Form đặt lịch gửi thông báo bằng `wp_mail()`. Hàm mail mặc định của hosting hay bị Gmail đánh vào spam, nên cấu hình SMTP:

1. Tạo email tên miền: cPanel → **Email Accounts** → tạo `lienhe@tenmiencuaban.vn`, lưu mật khẩu.
2. Cài plugin **FluentSMTP** (miễn phí) hoặc *WP Mail SMTP* trong Bảng tin → Plugin → Cài mới.
3. Khai báo:
   - SMTP Host: `mail.tenmiencuaban.vn`
   - Port: `465`, Encryption: `SSL` (hoặc `587` + `TLS`)
   - Username: `lienhe@tenmiencuaban.vn`, Password: mật khẩu email vừa tạo
   - From Email: chính địa chỉ đó
4. Bấm **Send Test Email** để thử.
5. Vào **Cài đặt → Tổng quan**, đặt *Địa chỉ email* là hộp thư muốn nhận thông báo đặt lịch.
6. Gửi thử một lịch hẹn ở trang Liên hệ, kiểm tra: đơn hiện trong **Đặt lịch** ở admin **và** email về đúng hộp thư.

---

## 11. Dọn dẹp và siết bảo mật

- [ ] Xoá `doi-url.php`, `anmoc-source.zip`, mọi file `.sql` còn sót trong `public_html`.
- [ ] Không upload thư mục `tai-lieu/` lên hosting (đã loại khỏi file zip rồi).
- [ ] Đổi mật khẩu tài khoản admin sang mật khẩu mạnh — mật khẩu `123123` của bản local tuyệt đối không giữ lại.
- [ ] Tạo thêm một tài khoản riêng cho khách hàng dùng hằng ngày (vai trò *Biên tập viên* nếu họ chỉ đăng bài). Xem chương 9 tài liệu hướng dẫn khách hàng.
- [ ] Bảng tin → Giao diện → xoá các theme không dùng, chỉ giữ `anmoc` và một theme mặc định làm dự phòng.
- [ ] Cài plugin bảo mật nhẹ (iThemes Security hoặc Wordfence bản free), bật giới hạn số lần đăng nhập sai.
- [ ] Bật sao lưu: AZDIGI có **JetBackup** trong cPanel — kiểm tra lịch backup đang chạy. Nên cài thêm UpdraftPlus đẩy backup về Google Drive.
- [ ] Trong file `wp-config.php`, bỏ dấu `//` ở dòng `DISALLOW_FILE_EDIT` để khoá chức năng sửa code trong admin.

---

## 12. Nội dung phải thay trước khi ra mắt

Dữ liệu hiện tại là **nội dung mẫu**. Những chỗ sau là số liệu giả, bắt buộc thay bằng thông tin thật của phòng khám:

- Số giấy phép hoạt động (`082/HCM-GPHĐ` là số bịa).
- Các con số thống kê ở trang chủ: 12.500 lượt khám, 4.9/5 đánh giá…
- Địa chỉ, số điện thoại, giờ làm việc, email.
- Tên và thông tin bác sĩ, ảnh chân dung.
- Lời chứng của khách hàng (phải có sự đồng ý của người thật).
- Trang Chính sách bảo mật: điền đúng thông tin pháp nhân.

Chương 10 của tài liệu `Huong-dan-quan-tri-website-An-Moc.docx` liệt kê chi tiết từng mục và chỉ chỗ sửa.

---

## 13. Nghiệm thu

| Kiểm tra | Đạt |
|---|---|
| Trang chủ mở được bằng `https://`, ổ khoá xanh | ☐ |
| `www.tenmien.vn` và `tenmien.vn` đều vào được | ☐ |
| Tất cả trang con mở được, không 404 | ☐ |
| Ảnh hiện đủ, không có ảnh vỡ | ☐ |
| Vào Tuỳ biến, màu sắc và font còn nguyên như bản local | ☐ |
| Menu trên và dưới chân trang đúng | ☐ |
| Gửi thử form đặt lịch → đơn vào admin + email về | ☐ |
| Mở trên điện thoại, menu hamburger chạy đúng | ☐ |
| Xem mã nguồn trang: không còn chuỗi `localhost:8888` | ☐ |
| Mật khẩu admin đã đổi, đã xoá `doi-url.php` | ☐ |

Kiểm tra nhanh chuỗi localhost còn sót:

```bash
curl -s https://tenmiencuaban.vn | grep -c "localhost:8888"
```

Kết quả phải là `0`.

---

## 14. Sự cố thường gặp

**Trắng trang / "Error establishing a database connection"**
Sai thông tin trong `wp-config.php`, hoặc quên gán user vào database ở bước 2.3. Kiểm tra lại cả 3 giá trị.

**Vào trang chủ được, trang con 404**
`.htaccess` thiếu hoặc sai `RewriteBase`. Vào Cài đặt → Đường dẫn tĩnh → Lưu lại; nếu vẫn lỗi, dán nội dung `htaccess-goc.txt`.

**Admin vào được nhưng trang ngoài vỡ hết giao diện**
Chưa chạy bước 7, hoặc chạy nhưng `NEW_URL` sai (thừa dấu `/` cuối, hoặc `http` trong khi site đã ép `https`). Chạy lại script với địa chỉ đúng.

**Ảnh mất hết sau khi đổi URL**
Dấu hiệu của việc dùng Find & Replace thường trên dữ liệu serialize. Import lại `yhct-database.sql` rồi làm lại bước 7 bằng `doi-url.php`.

**Đăng nhập xong bị đá ra ngay, lặp vô hạn**
Thường do `siteurl`/`home` trong bảng `wp_options` chưa khớp địa chỉ đang gõ. Sửa trực tiếp 2 dòng đó trong phpMyAdmin.

**Không nhận được email đặt lịch**
Xem lại mục 10. Kiểm tra thư mục Spam trước khi kết luận.

**Lỗi "Allowed memory size exhausted" khi upload ảnh**
Tăng `WP_MEMORY_LIMIT` lên `512M` trong `wp-config.php`, hoặc nhờ AZDIGI nâng `memory_limit` trong *Select PHP Version → Options*.
