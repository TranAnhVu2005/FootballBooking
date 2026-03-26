<?php include __DIR__ . "/partials/header.php" ?>

<div class="container py-5 mt-3 mb-5">
    <div class="row g-4">
        <!-- Khu vực hiển thị Profile -->
        <div class="col-md-4 text-center">
            <div class="card border-0 shadow-sm p-4 rounded-4 h-100">
                <form action="/profile" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="position-relative d-inline-block">
                        <?php if (!empty($user->avatar)): ?>
                            <img src="<?= htmlspecialchars($user->avatar) ?>" id="avatar-preview" alt="User Avatar"
                                width="150" height="150"
                                class="rounded-circle object-fit-cover border border-4 border-white shadow-sm">
                        <?php else: ?>
                            <!-- Ảnh mồi tự động tạo Initial khi chưa có avatar -->
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($user->fullname) ?>&background=e9ecef&color=198754&size=150"
                                id="avatar-preview" alt="Default Avatar" width="150" height="150"
                                class="rounded-circle object-fit-cover border border-4 border-white shadow-sm">
                        <?php endif; ?>

                        <label for="avatar-input"
                            class="btn btn-success position-absolute bottom-0 end-0 rounded-circle border border-2 border-white d-flex justify-content-center align-items-center p-2 shadow-sm"
                            title="Tải lên ảnh mới">
                            <i class="bi bi-camera-fill m-0 fs-5"></i>
                        </label>
                        <!-- Form nạp file dùng class d-none của Bootstrap thay vì display: none -->
                        <input type="file" class="d-none" name="avatar" id="avatar-input"
                            accept="image/png, image/jpeg, image/jpg, image/webp">
                    </div>

                    <h4 class="mt-4 fw-bold text-dark"><?= htmlspecialchars($user->fullname) ?></h4>
                    <p class="text-muted"><i class="bi bi-envelope-fill me-1 text-success"></i>
                        <?= htmlspecialchars($user->email) ?></p>

                    <hr class="text-muted opacity-25 mx-4">
                    <div class="text-start px-2 mt-3">
                        <p class="small text-uppercase text-muted fw-bold mb-2">Thông tin tài khoản</p>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="bi bi-phone text-secondary me-2"></i>
                                <span
                                    class="fw-medium text-dark"><?= htmlspecialchars($user->phone ?: 'Chưa cập nhật') ?></span>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-person-badge text-secondary me-2"></i>
                                <?php if ($user->role === 'ADMIN'): ?>
                                    <span class="badge bg-danger rounded-pill"><i class="bi bi-shield-lock-fill"></i> Quản
                                        trị viên</span>
                                <?php elseif ($user->role === "OWNER"): ?>
                                    <span class="badge bg-danger rounded-pill"><i class="bi bi-person-fill"></i>Chủ sân</span>
                                <?php else: ?>
                                    <span class="badge bg-success rounded-pill"><i class="bi bi-person-fill"></i> Khách
                                        Hàng</span>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
            </div>
        </div>

        <!-- Khu vực Form cập nhật Form thông tin -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 border-bottom-0 ps-4 pt-4 rounded-4 rounded-bottom-0">
                    <h5 class="mb-0 fw-bold text-success"><i class="bi bi-gear-fill me-2"></i>Chỉnh Sửa Thông Tin</h5>
                </div>
                <div class="card-body px-4 pb-4">
                    <?php if (isset($messages['success'])): ?>
                        <div class="alert alert-success border-0 rounded-4 shadow-sm"><i
                                class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($messages['success']) ?></div>
                    <?php endif; ?>

                    <?php if (isset($errors['avatar'])): ?>
                        <div class="alert alert-danger border-0 rounded-4 shadow-sm"><i
                                class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($errors['avatar']) ?></div>
                    <?php endif; ?>
                    <?php if (isset($errors['db'])): ?>
                        <div class="alert alert-danger border-0 rounded-4 shadow-sm"><i
                                class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($errors['db']) ?></div>
                    <?php endif; ?>

                    <div class="mb-4 mt-2">
                        <label class="form-label fw-semibold text-dark">Họ và Tên</label>
                        <div class="input-group input-group-lg shadow-sm rounded-4 overflow-hidden">
                            <span class="input-group-text bg-light border-0"><i
                                    class="bi bi-person text-muted"></i></span>
                            <input type="text" name="fullname"
                                class="form-control border-0 bg-light <?= isset($errors['fullname']) ? 'is-invalid' : '' ?>"
                                value="<?= htmlspecialchars($user->fullname) ?>">
                        </div>
                        <?php if (isset($errors['fullname'])): ?>
                            <div class="text-danger small mt-1 ms-2"><?= htmlspecialchars($errors['fullname']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">Số điện thoại</label>
                        <div class="input-group input-group-lg shadow-sm rounded-4 overflow-hidden">
                            <span class="input-group-text bg-light border-0"><i
                                    class="bi bi-telephone text-muted"></i></span>
                            <input type="text" name="phone"
                                class="form-control border-0 bg-light <?= isset($errors['phone']) ? 'is-invalid' : '' ?>"
                                value="<?= htmlspecialchars($user->phone) ?>">
                        </div>
                        <?php if (isset($errors['phone'])): ?>
                            <div class="text-danger small mt-1 ms-2"><?= htmlspecialchars($errors['phone']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">Địa chỉ Email (Mail đăng nhập)</label>
                        <div class="input-group input-group-lg rounded-4 overflow-hidden">
                            <span class="input-group-text bg-secondary text-white border-0"><i
                                    class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control text-muted bg-light"
                                value="<?= htmlspecialchars($user->email) ?>" disabled>
                        </div>
                    </div>

                    <div class="text-end mt-5">
                        <a href="/profile" class="btn btn-light px-4 me-2 border rounded-pill fw-bold">Hủy Thay
                            Đổi</a>
                        <button type="submit" class="btn btn-success px-5 rounded-pill fw-bold shadow-sm"><i
                                class="bi bi-save-fill me-2"></i> Lưu & Cập Nhật</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hiển thị file ảnh avatar trước khi submit-->
<script>
    /**
     * Lắng nghe sự kiện 'change' trên ô chọn file (input type="file").
     * Sự kiện này xảy ra ngay khi người dùng chọn một tấm ảnh từ máy tính của họ.
     */
    document.getElementById('avatar-input').addEventListener('change', function(e) {
        
        // Kiểm tra xem người dùng đã thực sự chọn file chưa và đảm bảo có ít nhất 1 file
        if (e.target.files && e.target.files[0]) {
            
            /**
             * FileReader là một đối tượng có sẵn trong trình duyệt (Web API),
             * cho phép chúng ta đọc nội dung của các tệp tin lưu trên máy tính người dùng 
             * mà không cần phải gửi chúng lên server ngay lập tức.
             */
            const reader = new FileReader();
            
            /**
             * Định nghĩa sự kiện onload: Đoạn code bên trong hàm này sẽ tự động chạy
             * ngay khi quá trình đọc file hoàn tất.
             */
            reader.onload = function(e) {
                /**
                 * e.target.result lúc này chứa "dữ liệu thô" của bức ảnh dưới dạng chuỗi Base64.
                 * Chúng ta gán chuỗi này vào thuộc tính 'src' của thẻ <img> (avatar-preview).
                 * Nhờ đó, người dùng có thể thấy ngay tấm ảnh họ vừa chọn trên giao diện.
                 */
                document.getElementById('avatar-preview').src = e.target.result;
            }
            
            /**
             * Lệnh này bắt đầu quá trình đọc file dưới dạng "Data URL" (chuỗi mã hóa Base64).
             * Đây là lệnh quan trọng nhất để kích hoạt FileReader xử lý file được chọn.
             */
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>

<?php include __DIR__ . "/partials/footer.php" ?>