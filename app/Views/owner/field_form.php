<?php include __DIR__ . "/../partials/header.php" ?>

<main>
    <div class="container py-5 mt-2">

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/owner" class="text-success text-decoration-none">Quản Lý Sân</a></li>
                <li class="breadcrumb-item active"><?= !empty($field) ? 'Chỉnh Sửa Sân' : 'Thêm Sân Mới' ?></li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                        <h5 class="fw-bold text-success mb-0">
                            <i class="bi bi-<?= !empty($field) ? 'pencil-square' : 'plus-circle-fill' ?> me-2"></i>
                            <?= !empty($field) ? 'Chỉnh Sửa Thông Tin Sân' : 'Đăng Ký Sân Mới' ?>
                        </h5>
                        <p class="text-muted small mt-1 mb-0">Điền đầy đủ thông tin bên dưới để <?= !empty($field) ? 'cập nhật' : 'đăng ký' ?> sân.</p>
                    </div>

                    <div class="card-body p-4">

                        <?php if (!empty($errors['db'])): ?>
                            <div class="alert alert-danger border-0 rounded-3 mb-4">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($errors['db']) ?>
                            </div>
                        <?php endif; ?>

                        <!-- enctype=multipart bắt buộc khi có upload file -->
                        <!-- Kiểm tra có biến và biến có dữ liệu -->
                        <form action="<?= !empty($field) ? '/owner/fields/' . $field->fieldId : '/owner/fields' ?>"
                            method="POST" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <!-- Tên sân -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Tên Sân <span class="text-danger">*</span></label>
                                <div class="input-group rounded-3 overflow-hidden border <?= !empty($errors['field_name']) ? 'border-danger' : '' ?>">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-building text-success"></i></span>
                                    <!-- 1. Giá trị cũ dùng luôn
                                    2. Sửa sân
                                    3. Tạo sân mới -->
                                    <input type="text" name="field_name" class="form-control border-0 bg-light"
                                        placeholder="VD: Sân Bóng Phượng Hoàng"
                                        value="<?= htmlspecialchars($old['field_name'] ?? (!empty($field) ? $field->fieldName : '')) ?>">
                                </div>
                                <?php if (!empty($errors['field_name'])): ?>
                                    <div class="text-danger small mt-1 ms-1"><?= htmlspecialchars($errors['field_name']) ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Loại sân -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Loại Sân <span class="text-danger">*</span></label>
                                <div class="input-group rounded-3 overflow-hidden border <?= !empty($errors['type_id']) ? 'border-danger' : '' ?>">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-diagram-3 text-success"></i></span>
                                    <select name="type_id" class="form-select border-0 bg-light">
                                        <option value="">-- Chọn loại sân --</option>
                                        <?php foreach ($types as $t): ?>
                                            <?php
                                            $selectedTypeId = $old['type_id'] ?? (!empty($field) ? $field->typeId : '');
                                            ?>
                                            <option value="<?= htmlspecialchars($t['type_id']) ?>"
                                                <?= $selectedTypeId === $t['type_id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($t['type_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <?php if (!empty($errors['type_id'])): ?>
                                    <div class="text-danger small mt-1 ms-1"><?= htmlspecialchars($errors['type_id']) ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Địa chỉ -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Địa Chỉ <span class="text-danger">*</span></label>
                                <div class="input-group rounded-3 overflow-hidden border <?= !empty($errors['address']) ? 'border-danger' : '' ?>">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-geo-alt text-success"></i></span>
                                    <input type="text" name="address" class="form-control border-0 bg-light"
                                        placeholder="VD: 123 Đường 3/2, Q. Ninh Kiều, Cần Thơ"
                                        value="<?= htmlspecialchars($old['address'] ?? (!empty($field) ? $field->address : '')) ?>">
                                </div>
                                <?php if (!empty($errors['address'])): ?>
                                    <div class="text-danger small mt-1 ms-1"><?= htmlspecialchars($errors['address']) ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Ảnh sân -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Ảnh Sân <span class="text-muted fw-normal small">(JPG, PNG, WebP — tối đa 5MB)</span>
                                </label>

                                <!-- Preview ảnh cũ khi sửa -->
                                <!-- //Nhỡ field = false -->
                                <?php if (!empty($field) && !empty($field->image)): ?>
                                    <div class="mb-2">
                                        <img src="<?= htmlspecialchars($field->image) ?>"
                                            class="rounded-3 border"
                                            style="max-height: 180px; object-fit: cover;"
                                            alt="Ảnh hiện tại">
                                        <p class="text-muted small mt-1 mb-0"><i class="bi bi-info-circle me-1"></i>Chọn file mới để thay thế ảnh này.</p>
                                    </div>
                                <?php endif; ?>

                                <input type="file" name="image" id="imageInput"
                                    class="form-control bg-light border rounded-3 <?= !empty($errors['image']) ? 'border-danger' : '' ?>"
                                    accept="image/jpeg,image/png,image/webp"
                                    onchange="previewImage(this)">

                                <!-- Preview ảnh vừa chọn -->
                                <div id="imagePreviewWrapper" class="mt-2 d-none">
                                    <img id="imagePreview" src="" class="rounded-3 border"
                                        style="max-height: 180px; object-fit: cover;" alt="Preview">
                                </div>

                                <?php if (!empty($errors['image'])): ?>
                                    <div class="text-danger small mt-1 ms-1"><?= htmlspecialchars($errors['image']) ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Mô tả -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Mô Tả <span class="text-muted fw-normal small">(tùy chọn)</span></label>
                                <textarea name="description" rows="4"
                                    class="form-control bg-light border rounded-3"
                                    placeholder="Mô tả tiện ích, đặc điểm nổi bật của sân..."><?= htmlspecialchars($old['description'] ?? (!empty($field) ? ($field->description ?? '') : '')) ?></textarea>
                            </div>

                            <!-- Trạng thái — chỉ hiện khi đang sửa -->
                            <?php if (!empty($field)): ?>
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Trạng Thái</label>
                                    <select name="status" class="form-select bg-light border rounded-3">
                                        <option value="ACTIVE" <?= $field->status === 'ACTIVE'   ? 'selected' : '' ?>>Đang mở</option>
                                        <option value="INACTIVE" <?= $field->status === 'INACTIVE' ? 'selected' : '' ?>>Tạm đóng</option>
                                    </select>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex justify-content-end gap-2 mt-4 pt-2 border-top">
                                <a href="/owner" class="btn btn-light px-4 rounded-pill border fw-bold">Hủy</a>
                                <button type="submit" class="btn btn-success px-5 rounded-pill fw-bold shadow-sm">
                                    <i class="bi bi-save-fill me-1"></i>
                                    <?= !empty($field) ? 'Lưu Thay Đổi' : 'Đăng Ký Sân' ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    /**
     * Hàm xử lý việc hiển thị ảnh xem trước (Preview) ngay khi người dùng chọn file.
     * Kỹ thuật này giúp người dùng biết mình đã chọn đúng ảnh chưa mà không cần chờ upload lên server.
     */
    function previewImage(input) {
        // Lấy thẻ div bao bọc ảnh xem trước và thẻ img hiển thị ảnh
        const wrapper = document.getElementById('imagePreviewWrapper');
        const preview = document.getElementById('imagePreview');

        // Kiểm tra xem người dùng đã thực sự chọn tệp tin nào chưa
        if (input.files && input.files[0]) {
            /**
             * FileReader là API của trình duyệt dùng để đọc nội dung file từ máy tính người dùng.
             */
            const reader = new FileReader();

            /**
             * onload: Sự kiện này sẽ chạy khi trình duyệt đã đọc xong file vào bộ nhớ.
             */
            reader.onload = e => {
                // Gán dữ liệu ảnh (dưới dạng chuỗi Base64) vào thuộc tính src của thẻ img
                preview.src = e.target.result;
                // Loại bỏ class 'd-none' (display: none) để hiện vùng xem trước lên
                wrapper.classList.remove('d-none');
            };

            /**
             * Bắt đầu đọc file dưới dạng DataURL (Base64 string).
             * Sau khi đọc xong, sự kiện onload ở trên sẽ được kích hoạt.
             */
            reader.readAsDataURL(input.files[0]);
        } else {
            // Nếu người dùng hủy chọn hoặc xóa file, ẩn vùng xem trước đi
            wrapper.classList.add('d-none');
        }
    }
</script>

<?php include __DIR__ . "/../partials/footer.php" ?>