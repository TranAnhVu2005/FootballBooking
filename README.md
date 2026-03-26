# Dự Án FootBallBooking (Đặt Sân Bóng Đá Trực Tuyến)

**Học phần:** Công nghệ Web (CT275) - Học kỳ 2, Năm học 2025-2026

**Nhóm sinh viên thực hiện:**

- **Trần Anh Vũ** (MSSV: B2306603)
- **Trần Thiện Toàn** (MSSV: B2306591)
- Lớp học phần: CT275/01

---

## 1. Mở Đầu

FootBallBooking là một hệ thống web đặt sân bóng đá trực tuyến toàn diện, được xây dựng theo kiến trúc **MVC (Model-View-Controller)** sử dụng hoàn toàn **PHP thuần (Vanilla PHP)** kết hợp với **PDO**, **Composer** và **Bootstrap 5**. Dự án **không** phụ thuộc vào bất kỳ một web framework hoàn chỉnh nào (như Laravel/Symfony) nhằm đáp ứng trọn vẹn yêu cầu đồ án môn học.

## 2. Các Công Nghệ & Kỹ Thuật Nổi Bật

- **Routing & MVC:** Sử dụng `bramus/router` để thiết lập URL sạch (Clean URL) và `league/plates` hỗ trợ hiển thị (Template Engine). Toàn bộ luồng dữ liệu tuân thủ nghiêm ngặt mô hình MVC. Thư mục `public/` được tách biệt làm Document Root nhằm ngăn chặn triệt để việc truy cập mã nguồn trực tiếp.
- **Autoloading:** Tuân thủ chuẩn **PSR-4** thông qua Composer, giúp tự động nạp lớp (controllers, models) không cần sử dụng `include/require` thủ công.
- **Bảo mật chuyên sâu:**
  - **SQL Injection:** 100% câu truy vấn CSDL đều dùng `PDO Prepared Statements` với tham số ràng buộc ẩn (`:param`).
  - **CSRF:** Có cơ chế tạo ngẫu nhiên `csrf_token` (Session-based) cho mỗi biểu mẫu POST và đối chiếu khắt khe thông qua hàm `verify_csrf_token()`.
  - **XSS:** Tất cả dữ liệu đầu ra được đẩy lên trình duyệt đều đi qua hàm `htmlspecialchars()` bảo vệ, loại trừ rủi ro chèn script độc hại.
  - **IDOR / Phân Quyền:** Kiểm tra chặt ID người dùng hiện tại trước khi thực thi Update/Delete đối tượng, kết hợp phân quyền rõ rệt. Mã mật khẩu đều băm (`password_hash`) chuẩn công nghiệp.
- **Biểu mẫu Bootstrap 5:** Hơn 10 trang web (Giao diện Khách, User, Owner, Admin) được dàn trang 100% bằng grid của Bootstrap 5, bao gồm thẻ Card, Modal, Carousel, Validation, Navbar hoạt động hoàn hảo trên Di động (Responsive).
- **Tính năng nâng cao (Đạt đủ 3/3):**
  - **Upload Tập Tin:** Nhận diện loại tệp tin thực tế (hàm `mime_content_type`) chống tải mã độc ngụy trang. Cấp quyền Chủ sân và Người dùng tải lên hình ảnh minh họa/ảnh ghép cá nhân.
  - **HTTP Caching & Mã 304:** Điều phối bộ nhớ đệm qua `public/.htaccess` với `mod_expires` (đệm tĩnh 1 năm). Phần động sử dụng băm MD5 làm thẻ `ETag`, nếu trình duyệt khớp sẽ trả về mã `304 Not Modified` tối ưu băng thông (hàm `Controller::sendPage()`).
  - **Server-Sent Events (SSE):** Áp dụng dữ liệu thời gian thực không làm mới trang. Xây dựng bộ đếm tổng số kết nối đang hoạt động trực tiếp (cập nhật từng giây trên thanh điều hướng).

## 3. Kiến Trúc Cơ Sở Dữ Liệu

Cơ sở dữ liệu PostgreSQL gồm 7 bảng liên kết chặt chẽ (Mức độ bảng > 5):

1. `USERS`: Quản lý tài khoản (ID, email, mật khẩu băm, vai trò, trạng thái khóa).
2. `FIELD_TYPES`: Danh mục phân loại sân Bóng (Futsal, Sân 5, Sân 7...).
3. `FIELDS`: Thực thể sân bóng do Chủ sân quản lý (N-1 với USERS và FIELD_TYPES).
4. `SLOT_TEMPLATES`: Quản lý danh mục khung giờ chuẩn mặc định.
5. `FIELD_SLOTS`: Biểu diễn bảng giá.
6. `BOOKINGS`: Phiếu đặt lịch tự động, chống "Đặt lặp lịch" qua ràng buộc CSDL (UNIQUE field_id, slot_id, booking_date).
7. `REVIEWS`: Khu vực chứa bình luận đối với sân.

## 4. Phân Quyền & Luồng Nghiệp Vụ Chuyên Sâu

### A. Khách vãng lai (Guest)

- Truy cập trang chủ xem các sân nổi bật và thông tin giới thiệu.
- Truy vấn Tìm kiếm trực tiếp danh sách sân qua từ khóa (Tên/Địa chỉ) hoặc qua Loại Sân bóng.
- Khách buộc phải hoàn thành quá trình **Đăng ký / Đăng nhập** để kích hoạt chức năng tương tác chuyên sâu.

### B. Người dùng (User)

- Thêm Đơn / Đặt sân trên khung thời gian chọn lọc của từng sân bóng.
- Hủy bỏ đơn đặt nếu muốn đối với các lịch tương lai.
- Quản trị giao diện Hồ sơ (Đổi avatar, hotline liên hệ).

### C. Chủ Sân (Owner)

- Toàn quyền đối với tài sản (Sân bóng): Thêm sân, Chỉnh sửa thông tin, Xóa sân.
- Thống kê Đơn đặt, duyệt trạng thái thanh toán đối với Từng khách hàng theo Đơn đặt sân.

### D. Quản Trị Viên (Admin)

- Xem danh sách toàn hệ thống (Users, Owners).
- Được cấp quyền Tối thượng: Thay đổi Vai trò (Nâng lên/Hạ xuống quyền Owner).
- Tạm khóa các tài khoản lừa đảo (Deactivate). Tài khoản bị khóa sẽ lập tức bị chặn quá trình đăng nhập qua hàm `LoginController`.
