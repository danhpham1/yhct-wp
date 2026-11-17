# Hướng dẫn chạy website An Mộc trên máy tính của bạn

Hướng dẫn này dành cho người **không rành kỹ thuật**. Bạn không cần gõ lệnh nào: chỉ cần tải về, bấm chuột và chép thư mục.
Làm lần đầu mất khoảng **20–30 phút**.

> 💡 **Có dùng Claude?** Cách dễ nhất là để Claude dẫn bạn đi từng bước. Xem [Cách A](#cách-a--để-claude-làm-giúp-dễ-nhất).
> Không dùng Claude thì làm theo [Cách B](#cách-b--tự-làm-từng-bước).

---

## Bạn cần chuẩn bị

- Máy tính **Windows 10/11** hoặc **Mac** (macOS 12 trở lên), còn trống khoảng **3 GB**.
- Có **mạng Internet**.
- Khoảng 30 phút không bị gián đoạn.

---

## Cách A – Để Claude làm giúp (dễ nhất)

1. **Tải code về máy**
   1. Mở trang https://github.com/danhpham1/yhct-wp
   2. Bấm nút màu xanh lá **Code** → chọn **Download ZIP**.
   3. Mở thư mục **Downloads** (Tải về), nhấp đúp vào file `yhct-wp-main.zip` để giải nén. Bạn sẽ có thư mục **`yhct-wp-main`**.
      - Windows: nhấp chuột phải vào file → **Extract All…** (Giải nén tất cả) → **Extract**.
2. **Mở app Claude**, vào tab **Code**, chọn thư mục `yhct-wp-main` vừa giải nén.
3. Gõ vào khung chat:

   > Giúp tôi chạy website này trên máy tính của tôi. Tôi không rành kỹ thuật, hướng dẫn từng bước giúp tôi.

4. Claude sẽ hướng dẫn từng bước: cài app **Local**, tạo trang web, tự chép giao diện vào đúng chỗ, rồi nhờ bạn bấm vài nút. Cứ làm theo. Chỗ nào không hiểu thì **chụp màn hình gửi cho Claude**.

> ⚠️ **Không bao giờ gửi mật khẩu vào khung chat.** Khi máy hỏi mật khẩu, bạn tự gõ vào ô của máy.

---

## Cách B – Tự làm từng bước

### Bước 1. Cài app Local

**Local** là phần mềm miễn phí giúp chạy website WordPress ngay trên máy của bạn.

1. Mở trình duyệt, vào **https://localwp.com**
2. Bấm **Download for free** (Tải miễn phí).
3. Chọn hệ điều hành:
   - **Windows**: chọn Windows.
   - **Mac**: bấm vào quả táo  ở góc trên bên trái → **About This Mac** (Giới thiệu về máy Mac này).
     - Thấy chữ **Apple M1/M2/M3/M4…** thì chọn **Mac – Apple silicon**.
     - Thấy chữ **Intel** thì chọn **Mac – Intel**.
4. Trang web hỏi thông tin: điền **email** của bạn (bắt buộc), các ô khác bỏ trống cũng được → bấm **Get it now!**
5. Mở file vừa tải về (thường nằm trong **Downloads**):
   - **Windows**: nhấp đúp file `local-…-windows.exe` → bấm **Next** → **Install** → **Finish**.
   - **Mac**: nhấp đúp file `local-…-mac.dmg` → kéo biểu tượng **Local** vào thư mục **Applications**.
6. Mở app **Local**:
   - Windows: menu Start.
   - Mac: Launchpad hoặc thư mục Applications.
   - Mac có thể hỏi *"Local is an app downloaded from the Internet. Are you sure…?"* → bấm **Open**.
7. Lần đầu mở, app có thể:
   - Hỏi gửi báo cáo lỗi (**error reporting**): chọn gì cũng được.
   - Mời đăng nhập/tạo tài khoản: **không cần**, bấm dấu **X** để đóng.

### Bước 2. Tạo một trang web mới trong Local

1. Ở **góc dưới bên trái** của app Local, bấm nút **⊕** (dấu cộng trong vòng tròn).
2. Chọn **Create a new site** (Tạo trang mới) → bấm **Continue** (Tiếp tục).
3. Ô **What's your site's name?** (Tên trang web): gõ **`anmoc`** → bấm **Continue**.
4. Chọn **Preferred** (đã chọn sẵn) → bấm **Continue**.
5. Màn hình **Set up WordPress**, điền 3 ô:

   | Ô | Điền gì |
   |---|---|
   | **WordPress username** | `admin` (hoặc tên bạn thích) |
   | **WordPress password** | Mật khẩu bạn tự đặt. **Ghi lại ra giấy**, lát nữa cần dùng để đăng nhập. |
   | **WordPress email** | Email của bạn |

   → Bấm **Add Site** (Thêm trang).
6. Máy có thể hỏi quyền. Đều là bình thường:
   - **Mac**: hiện ô xin **mật khẩu máy Mac** (mật khẩu bạn dùng để mở máy). Gõ vào rồi bấm OK.
   - **Windows**: hiện cửa sổ **Windows Security / Firewall**. Bấm **Allow access** (Cho phép), hoặc **Yes**.
7. Chờ 1–3 phút. Xong khi bên trái có dòng **anmoc**, và góc trên bên phải có 2 nút **WP Admin** và **Open site**.

### Bước 3. Tải giao diện An Mộc về máy

1. Mở trang https://github.com/danhpham1/yhct-wp
2. Bấm nút màu xanh lá **Code** → **Download ZIP**.
3. Vào thư mục **Downloads**, giải nén file `yhct-wp-main.zip`:
   - **Mac**: nhấp đúp vào file.
   - **Windows**: nhấp chuột phải → **Extract All…** → **Extract**.
4. Mở thư mục vừa giải nén theo đường dẫn: **`yhct-wp-main` → `wp-content` → `themes`**.
   Trong đó có thư mục **`anmoc`**. Đây là giao diện của website.

### Bước 4. Chép giao diện vào trang web vừa tạo

1. Quay lại app **Local**, bấm vào site **anmoc** ở cột bên trái.
2. Ngay dưới chữ **anmoc** to ở phía trên có dòng chữ nhỏ **Go to site folder** (Mở thư mục trang web). Bấm vào đó.
   Một cửa sổ thư mục mở ra (Finder trên Mac, File Explorer trên Windows).
3. Trong cửa sổ đó, lần lượt mở: **`app` → `public` → `wp-content` → `themes`**.
4. **Chép thư mục `anmoc`** (ở Bước 3, mục 4) **vào trong thư mục `themes` này**:
   - Cách dễ nhất: mở 2 cửa sổ cạnh nhau, rồi **kéo thả** thư mục `anmoc` sang.
   - Hoặc nhấp chuột phải vào `anmoc` → **Copy** (Sao chép), sang thư mục `themes` → nhấp chuột phải vào chỗ trống → **Paste** (Dán).
5. Kiểm tra: trong `themes` giờ có thư mục **`anmoc`**, mở ra thấy các file như `style.css`, `functions.php` và các thư mục `assets`, `inc`.

> ❗ Phải chép **cả thư mục `anmoc`**, không chép mỗi các file bên trong. Cũng không chép nhầm thư mục `themes` hay `yhct-wp-main`.

### Bước 5. Bật giao diện An Mộc

1. Trong app Local, bấm nút **WP Admin** (góc trên bên phải). Trình duyệt mở trang đăng nhập.
2. Đăng nhập bằng **username** và **mật khẩu** đã đặt ở Bước 2.
3. Ở menu đen bên trái, rê chuột vào **Appearance** (Giao diện) → bấm **Themes** (Giao diện).
4. Tìm ô có tên **An Mộc Y Viện**, rê chuột vào → bấm nút **Activate** (Kích hoạt).
5. ⏳ **Chờ trang tải xong** (10 giây đến 1 phút). Lúc này giao diện đang tự tạo các trang, menu, dịch vụ, bác sĩ, bài viết mẫu và nhập ảnh. **Đừng tắt trình duyệt hay bấm lung tung.**

### Bước 6. Xem website

- Trong app Local, bấm **Open site**. Trình duyệt mở địa chỉ `http://anmoc.local`.
- Bạn sẽ thấy trang chủ An Mộc có đủ ảnh và menu **Về An Mộc · Trị liệu · Đội ngũ · Kiến thức · Hoạt động**. 🎉

---

## Sửa nội dung website

1. Đăng nhập (nút **WP Admin** trong Local), rồi mở trang web.
2. Bấm **Sửa nội dung trang** trên thanh đen ở trên cùng. Hoặc trong trang quản trị, bấm **Nội dung website** ở menu bên trái.
3. Một khung xem trước hiện ra:
   - Bấm vào **cây bút xanh** cạnh chữ để sửa chữ.
   - Rê chuột lên ảnh rồi bấm **Đổi ảnh** để thay ảnh.
   - Màu sắc và font chữ nằm trong các mục ở cột bên trái.
4. Sửa xong, bấm **Publish** (Xuất bản) màu xanh ở trên cùng. **Chưa bấm thì chưa lưu.**

Hướng dẫn đầy đủ, có hình minh hoạ: file **`tai-lieu/Huong-dan-quan-tri-website-An-Moc.docx`** trong thư mục đã giải nén. Mở bằng Word hoặc Google Docs.

---

## Những lần sau mở lại website

1. Mở app **Local**.
2. Bấm vào site **anmoc** → bấm **Start site** (Bật trang) nếu nút này hiện ra.
3. Bấm **Open site** để xem, **WP Admin** để quản trị.

Tắt máy hay tắt Local thì web cũng tắt theo. **Dữ liệu không mất.**

---

## Gặp lỗi? Thử theo bảng này

| Bạn thấy | Cách xử lý |
|---|---|
| Trang chủ trông như blog trắng trơn, có bài "Hello world", không có menu An Mộc | Vào **WP Admin → Appearance → Dữ liệu mẫu** → bấm **Nạp dữ liệu mẫu**. Bấm lại cũng an toàn: không tạo trùng. |
| Một số ô ảnh bị trống | Cũng bấm **Nạp dữ liệu mẫu** như trên. Nó nhập tiếp các ảnh còn thiếu. |
| Bấm vào menu thì báo **Not Found** / **Không tìm thấy** | **WP Admin → Settings → Permalinks** (Cài đặt → Đường dẫn tĩnh) → chọn **Post name** → bấm **Save Changes**. |
| Không thấy **An Mộc Y Viện** trong danh sách Themes | Thư mục chép sai chỗ. Kiểm tra lại Bước 4: phải là `…/app/public/wp-content/themes/anmoc/style.css`. |
| Trang Themes báo *"Broken Themes"* / *"Stylesheet is missing"* | Bị lồng thư mục, ví dụ `themes/anmoc/anmoc` hoặc `themes/yhct-wp-main`. Xoá thư mục chép sai, chép lại đúng thư mục `anmoc` như Bước 4. |
| Trình duyệt không mở được `anmoc.local` | Trong Local, mở **Preferences** (Mac: menu **Local** trên cùng; Windows: nút ☰ góc trên trái) → **Advanced** → **Router mode** → chọn **localhost**. Bấm lại **Open site**. |
| Local báo lỗi khi bật site | Bấm **Stop site** rồi **Start site**. Không được thì tắt hẳn app Local, mở lại. |
| Chữ hiện font xấu, khác thiết kế | Kiểm tra mạng Internet: font chữ được tải từ Google. |
| Quên mật khẩu WordPress | Trong Local, bật **One-click admin** ở trang site, chọn tài khoản admin. Từ đó bấm **WP Admin** là vào thẳng, không cần mật khẩu. |

Vẫn không được: chụp màn hình gửi cho người phụ trách, hoặc gửi cho Claude.

---

## Khi có bản cập nhật giao diện mới

1. Tải lại code: **Code → Download ZIP** như Bước 3 rồi giải nén.
2. Vào thư mục `themes` của site (như Bước 4). **Đổi tên** thư mục `anmoc` cũ thành `anmoc-cu`.
3. Chép thư mục `anmoc` mới vào.
4. Mở web xem. Ổn rồi thì xoá thư mục `anmoc-cu`.

**Không cần** kích hoạt lại. Những gì bạn đã sửa trong phần Nội dung website **vẫn giữ nguyên**.
