# Hướng dẫn cho Claude – Website An Mộc Y Viện

Repo này chứa **theme WordPress `anmoc`** (thư mục `wp-content/themes/anmoc/`) và tài liệu (`tai-lieu/`).
Repo **không** có WordPress core, database hay `wp-config.php`.

## 0. Trước tiên: đang ở máy nào?

- Nếu ở thư mục gốc repo **có file `wp-config.php`**, đây là máy của lập trình viên chính, nơi WordPress đã chạy sẵn (MAMP).
  → **Bỏ qua toàn bộ phần "Cài đặt cho người mới"** bên dưới và làm việc bình thường theo yêu cầu.
- Nếu **không có `wp-config.php`**, nhiều khả năng người dùng vừa tải code từ GitHub về (thư mục thường tên `yhct-wp-main`) và muốn chạy web trên máy mình.
  → Làm theo phần "Cài đặt cho người mới".

---

## Cài đặt cho người mới (không rành kỹ thuật)

### Cách nói chuyện với người dùng

- Người dùng **không rành kỹ thuật**. Nói tiếng Việt, câu ngắn, không dùng thuật ngữ. Nếu buộc phải dùng (ví dụ "theme"), giải thích một câu.
- **Mỗi lần chỉ đưa 1 bước.** Chờ họ báo "xong" hoặc gửi ảnh chụp màn hình rồi mới sang bước sau.
- Khi nhắc tới chữ trên màn hình, viết **đúng chữ tiếng Anh** họ sẽ thấy (app Local chỉ có tiếng Anh), kèm nghĩa tiếng Việt.
  Ví dụ: bấm nút **Add Site** (Thêm trang web).
- Nếu họ bí, mời họ **chụp màn hình gửi vào khung chat**.
- Việc nào tự làm được (tìm thư mục, chép file, kiểm tra trang web đã chạy chưa) thì tự làm, đừng bắt họ gõ lệnh.

### Không được làm

- **Không hỏi, không nhận, không gõ mật khẩu** của người dùng: mật khẩu máy tính, mật khẩu WordPress hay bất kỳ mật khẩu nào. Khi máy hỏi mật khẩu, bảo họ tự gõ vào ô của máy, không gửi vào chat.
- Không sửa code trong `wp-content/themes/anmoc/` trừ khi người dùng yêu cầu rõ ràng.
- Không `git push`, không tạo tài khoản GitHub, không đưa code đi đâu cả.
- Không cài MAMP, XAMPP, Docker, Homebrew hay PHP rời. Chỉ dùng **Local** (localwp.com).
- Không xoá site Local nào ngoài site `anmoc` do chính các bước này tạo ra.

### Bước 1 – Kiểm tra máy đã có app Local chưa

Local là app miễn phí, tạo web WordPress chạy ngay trên máy, không cần cấu hình.

- macOS: kiểm tra `/Applications/Local.app`.
- Windows: thường ở `%LOCALAPPDATA%\Programs\Local\Local.exe` hoặc `C:\Program Files\Local\Local.exe`. Không chắc thì hỏi họ: "Trong menu Start có app tên Local không?"

Nếu chưa có, hướng dẫn họ cài:

1. Mở trình duyệt, vào **https://localwp.com**, bấm **Download for free**.
2. Chọn hệ điều hành (**macOS** hoặc **Windows**).
   - Trên Mac: Apple menu → About This Mac. Ghi "Apple M…" thì chọn **Apple silicon**, ghi "Intel" thì chọn **Intel**.
3. Trang web có thể hỏi tên/email. Chỉ email là bắt buộc, họ tự điền. Bạn không điền thay.
4. Mở file vừa tải về:
   - Mac: kéo biểu tượng Local vào thư mục Applications.
   - Windows: bấm Next → Install.
5. Mở app Local.
   - Lần đầu, app hỏi có gửi báo cáo lỗi không: chọn tuỳ ý.
   - App có thể hỏi đăng nhập tài khoản Local: **không cần**, đóng hoặc bỏ qua được.

### Bước 2 – Tạo site WordPress trong Local

Hướng dẫn từng bước:

1. Ở góc **dưới bên trái** app Local, bấm nút **+** (dấu cộng tròn).
2. Chọn **Create a new site** (Tạo site mới) → bấm **Continue**.
3. Ô **What's your site's name?**: gõ `anmoc` → **Continue**.
4. Chọn **Preferred** (cấu hình mặc định) → **Continue**.
5. Màn hình **Set up WordPress**:
   - **WordPress username**: ví dụ `admin`
   - **WordPress password**: họ **tự đặt và tự ghi lại** (giấy hoặc ghi chú trên máy). Không gửi vào chat.
   - **WordPress email**: email bất kỳ của họ.
   - Bấm **Add Site**.
6. Mac có thể hiện hộp thoại xin mật khẩu máy tính, Windows có thể hỏi cho phép qua tường lửa. Đều bình thường: họ tự gõ mật khẩu máy hoặc bấm **Allow / Cho phép**.
7. Chờ 1–3 phút đến khi site `anmoc` hiện trong danh sách bên trái và có nút **Open site** / **WP Admin** ở góc trên bên phải.

### Bước 3 – Chép theme vào site (bạn tự làm)

Tìm thư mục site vừa tạo:

- macOS: `~/Local Sites/anmoc/app/public/wp-content/themes/`
- Windows: `C:\Users\<tên-user>\Local Sites\anmoc\app\public\wp-content\themes\`

Nếu không thấy:

- Nhờ họ bấm dòng chữ đường dẫn ngay dưới tên site trong Local (**Go to site folder**) rồi chụp màn hình thanh địa chỉ thư mục.
- Hoặc tìm các thư mục có tên `Local Sites` trong thư mục người dùng.
- Họ có thể đã đặt tên khác `anmoc`: dùng đúng tên đó.

Chép **cả thư mục** `wp-content/themes/anmoc` của repo vào thư mục `themes` đó, để có `.../themes/anmoc/style.css`.

- Nếu đã có `themes/anmoc` (cài lại hoặc cập nhật), đổi tên bản cũ thành `anmoc-cu` trước, rồi chép bản mới. Nội dung web đã sửa nằm trong database, không mất.

Kiểm tra lại cho chắc:

- `themes/anmoc/style.css` có dòng `Theme Name: An Mộc Y Viện`.
- Có `themes/anmoc/functions.php`.

### Bước 4 – Kích hoạt theme (người dùng bấm)

**Phải kích hoạt trong trang quản trị khi đang đăng nhập admin.** Lúc kích hoạt, theme tự tạo trang, menu, dịch vụ, bác sĩ, bài viết mẫu và nhập ảnh. Kích hoạt bằng cách khác có thể không tạo dữ liệu mẫu.

1. Trong Local, chọn site `anmoc`, bấm nút **WP Admin** (góc trên bên phải). Trình duyệt mở trang đăng nhập.
2. Đăng nhập bằng username/mật khẩu ở Bước 2.
3. Ở menu bên trái trang quản trị, rê chuột vào **Appearance** (Giao diện) → bấm **Themes** (Giao diện).
   - Nếu WordPress đang hiện tiếng Việt thì đó là **Giao diện → Giao diện**.
4. Tìm ô **An Mộc Y Viện**, rê chuột vào → bấm **Activate** (Kích hoạt).
5. **Chờ trang tải xong.** Có thể mất 10–60 giây vì đang nhập khoảng 15 ảnh. Không tắt trình duyệt giữa chừng.

### Bước 5 – Kiểm tra web đã chạy (bạn tự làm, rồi nhờ họ xem)

1. Tải trang chủ, ví dụ `curl -s http://anmoc.local/`. Nếu họ đặt tên khác thì là `http://<tên>.local/`; địa chỉ đúng nằm ở mục **Site domain** trong Local.
   Trang chủ phải có:
   - chữ `An Mộc`
   - menu gồm `Về An Mộc`, `Trị liệu`, `Đội ngũ`, `Kiến thức`, `Hoạt động`
   - ảnh dạng `wp-content/uploads/.../anmoc-*.jpg`
2. Lấy các link trong menu của trang chủ (thẻ `a.nav-link`) rồi tải thử từng link. Link nào cũng phải trả về 200.
   - Không tự đoán đường dẫn: tuỳ cài đặt permalink, link có thể là `/ve-an-moc/` hoặc `/index.php/ve-an-moc/`, kiểu nào cũng đúng.
3. Nhờ họ bấm **Open site** trong Local để tự xem web.

Nếu trang chủ vẫn là trang trắng kiểu blog "Hello world" hoặc không có menu, tức là dữ liệu mẫu chưa được tạo:

- Nhờ họ vào **Appearance → Dữ liệu mẫu** (trang quản trị) → bấm **Nạp dữ liệu mẫu**.
- Nút này an toàn khi bấm lại: mục nào đã có thì giữ nguyên, không tạo trùng.

Nếu thiếu ảnh (ô ảnh trống): bấm lại **Nạp dữ liệu mẫu**, nó nhập tiếp phần ảnh còn thiếu.

Nếu link trang con báo "Not Found":

- Nhờ họ vào **Settings → Permalinks** (Cài đặt → Đường dẫn tĩnh), chọn **Post name**, bấm **Save Changes** (Lưu).

Nếu trình duyệt báo không mở được `anmoc.local`:

- Trong Local: **Local** menu (Mac) hoặc ☰ (Windows) → **Preferences → Advanced → Router mode** → chọn **localhost**.
- Local sẽ cấp địa chỉ dạng `http://localhost:100xx`. Dùng địa chỉ đó.

Nếu Local báo lỗi khởi động site:

- Bấm **Stop site** rồi **Start site**, hoặc khởi động lại app Local.
- Vẫn lỗi thì nhờ họ chụp màn hình thông báo.

### Bước 6 – Chỉ cách sửa nội dung

Sau khi web chạy, hướng dẫn ngắn:

- Đang đăng nhập admin, mở trang web, bấm **Sửa nội dung trang** trên thanh đen ở trên cùng.
  Hoặc vào trang quản trị → **Nội dung website**.
- Trong khung xem trước:
  - bấm **cây bút xanh** cạnh chữ để sửa chữ
  - rê chuột lên ảnh rồi bấm **Đổi ảnh** để thay ảnh
- Chưa bấm **Publish** (Xuất bản) thì chưa lưu.
- Tài liệu đầy đủ: `tai-lieu/Huong-dan-quan-tri-website-An-Moc.docx` (mở bằng Word hoặc Google Docs).

Hằng ngày chạy lại web: mở app Local → chọn site `anmoc` → **Start site** → **Open site**.

### Cập nhật khi có bản theme mới

1. Tải code mới từ GitHub (**Code → Download ZIP**) và giải nén.
2. Làm lại Bước 3 (đổi tên bản cũ thành `anmoc-cu`, chép bản mới).
3. **Không cần** kích hoạt lại. Không bấm Nạp dữ liệu mẫu nếu không cần.
4. Tải lại trang web để kiểm tra, rồi xoá `anmoc-cu` khi mọi thứ ổn.

Nội dung đã sửa trong **Tùy biến** nằm trong database nên không bị mất.

---

## Ghi chú kỹ thuật (cho Claude)

- **Theme:** `wp-content/themes/anmoc`.
  - Yêu cầu WordPress ≥ 6.4, PHP ≥ 7.4.
  - Không cần plugin nào.
  - Font tải từ Google Fonts, nên cần có mạng khi xem web.
- **Dữ liệu mẫu:** `inc/seed.php`.
  - Chạy ở hook `after_switch_theme` và chỉ khi user hiện tại có `manage_options`.
  - Đánh dấu xong bằng option `anmoc_seeded`.
  - Ảnh lấy từ `assets/images/*.jpg`; ánh xạ ảnh lưu ở option `anmoc_seed_images`.
  - Chạy lại tại **Giao diện → Dữ liệu mẫu**.
- **Không kích hoạt theme bằng WP-CLI.** `wp theme activate` chỉ đổi theme. Hook `after_switch_theme` chạy ở request kế tiếp, và nếu request đó không phải của admin thì dữ liệu mẫu bị bỏ qua.
  - Nếu đã lỡ dùng WP-CLI, chạy thêm `wp eval 'delete_option("anmoc_seeded"); anmoc_seed();' --user=<admin>` trong **Open site shell** của Local (nhấp chuột phải vào site trong Local).
- **Nơi lưu nội dung:**
  - Toàn bộ chữ, ảnh, màu, font: theme mods, chỉnh trong Customizer (`inc/fields.php`, `inc/customizer*.php`).
  - Dịch vụ, bác sĩ, cảm nhận, FAQ: custom post types (`inc/post-types.php`).
- **Không đưa lên GitHub** (repo public): `wp-config.php`, file `.sql`, `tai-lieu/deploy/wp-config-azdigi.php`, `tai-lieu/deploy/doi-url.php`, các file `.zip`.
