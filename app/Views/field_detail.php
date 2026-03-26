<?php include __DIR__ . "/partials/header.php" ?>

<main>
    <div class="container py-5 mt-2">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/list" class="text-success text-decoration-none">Danh Sách Sân</a>
                </li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($field->fieldName) ?></li>
            </ol>
        </nav>

        <div class="row g-4">

            <!-- Cột trái: thông tin sân -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <!-- Ảnh placeholder hoặc ảnh thật -->
                    <div class="ratio ratio-16x9 bg-success bg-opacity-10">
                        <?php if (!empty($field->image)): ?>
                            <img src="<?= htmlspecialchars($field->image) ?>" class="w-100 h-100 object-fit-cover"
                                alt="<?= htmlspecialchars($field->fieldName) ?>">
                        <?php else: ?>
                            <div
                                class="d-flex flex-column align-items-center justify-content-center text-success opacity-50">
                                <i class="bi bi-image display-1"></i>
                                <span class="small mt-2">Chưa có ảnh</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-body p-4">
                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
                            <div>
                                <span
                                    class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2 small mb-2">
                                    <?= htmlspecialchars($field->typeName ?? 'Không rõ') ?>
                                </span>
                                <h2 class="fw-bold text-dark mb-1"><?= htmlspecialchars($field->fieldName) ?></h2>
                                <p class="text-muted mb-0">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                    <?= htmlspecialchars($field->address) ?>
                                </p>
                            </div>
                            <span
                                class="badge <?= strtoupper($field->status) === 'ACTIVE' ? 'bg-success' : 'bg-secondary' ?> rounded-pill px-3 py-2">
                                <i class="bi bi-circle-fill me-1" style="font-size:8px"></i>
                                <?= strtoupper($field->status) === 'ACTIVE' ? 'Đang mở cửa' : 'Tạm đóng' ?>
                            </span>
                        </div>

                        <?php if (!empty($field->description)): ?>
                            <hr class="opacity-25">
                            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-info-circle me-2 text-success"></i>Giới thiệu
                            </h6>
                            <p class="text-muted lh-lg mb-0"><?= nl2br(htmlspecialchars($field->description)) ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Form gửi bình luận -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mt-4">
                    <h6 class="fw-bold text-dark mb-3">
                        <i class="bi bi-chat-dots-fill text-success me-2"></i>Bình Luận & Đánh Giá
                    </h6>
                    <form action="/reviews" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="field_id" value="<?= $field->fieldId ?>">
                        <div class="input-group shadow-sm">
                            <input type="text"
                                name="comment"
                                class="form-control border rounded-start-3 shadow-none"
                                placeholder="Nhập bình luận của bạn...">
                            <button type="submit" class="btn btn-success px-4 rounded-end-3 fw-bold">
                                <i class="bi bi-send-fill me-1"></i> Gửi
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Danh sách bình luận -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mt-3">
                    <h6 class="fw-bold text-dark mb-3">
                        <i class="bi bi-chat-square-text-fill text-success me-2"></i>
                        Tất Cả Bình Luận
                        <span class="badge bg-success rounded-pill ms-1"><?= count($reviews) ?></span>
                    </h6>

                    <?php if (empty($reviews)): ?>
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-chat-square display-4 opacity-25 d-block mb-2"></i>
                            <p class="mb-0">Chưa có bình luận nào.</p>
                            <small>Hãy là người đầu tiên bình luận!</small>
                        </div>
                    <?php else: ?>
                        <div class="d-flex flex-column gap-3">
                            <?php foreach ($reviews as $review): ?>
                                <div class="d-flex gap-3">

                                    <!-- Avatar -->
                                    <div class="flex-shrink-0">
                                        <?php if (!empty($review->avatar)): ?>
                                            <img src="<?= htmlspecialchars($review->avatar) ?>"
                                                alt="Avatar"
                                                class="rounded-circle object-fit-cover border border-2 border-success"
                                                style="width:42px; height:42px;">
                                        <?php else: ?>
                                            <div class="rounded-circle bg-success bg-opacity-10 border border-2 border-success
                                        d-flex align-items-center justify-content-center"
                                                style="width:42px; height:42px;">
                                                <i class="bi bi-person-fill text-success"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Nội dung -->
                                    <div class="flex-grow-1">
                                        <div class="bg-light rounded-3 p-3">

                                            <!-- Tên + nút hành động -->
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-semibold text-dark small">
                                                    <?= htmlspecialchars($review->fullName ?? 'Ẩn danh') ?>
                                                </span>

                                                <?php if (AUTHGUARD()->isUserLoggedIn() && $review->userId == AUTHGUARD()->user()->userId): ?>
                                                    <div class="d-flex gap-2" id="btn-group-<?= $review->reviewId ?>">
                                                        <!-- Nút Sửa -->
                                                        <button class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                                                            onclick="startEdit('<?= $review->reviewId ?>')">
                                                            <i class="bi bi-pencil me-1"></i> Sửa
                                                        </button>
                                                        <!-- Nút Xóa -->
                                                        <form action="/reviews/delete" method="POST"
                                                            onsubmit="return confirm('Bạn có chắc chắn xóa bình luận này? Hành động không thể hoàn tác!')">
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="review_id" value="<?= $review->reviewId ?>">
                                                            <input type="hidden" name="field_id" value="<?= $review->fieldId ?>">
                                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                                <i class="bi bi-trash me-1"></i> Xóa
                                                            </button>
                                                        </form>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Chế độ xem -->
                                            <p class="mb-0 text-muted small lh-lg"
                                                id="content-display-<?= $review->reviewId ?>">
                                                <?= nl2br(htmlspecialchars($review->content)) ?>
                                            </p>

                                            <!-- Chế độ sửa (ẩn mặc định) -->
                                            <form action="/reviews/edit" method="POST"
                                                class="d-none"
                                                id="content-edit-<?= $review->reviewId ?>">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="review_id" value="<?= $review->reviewId ?>">
                                                <input type="hidden" name="field_id" value="<?= $review->fieldId ?>">
                                                <div class="d-flex gap-2 mt-1">
                                                    <input type="text"
                                                        name="content"
                                                        class="form-control form-control-sm shadow-none"
                                                        value="<?= htmlspecialchars($review->content) ?>">
                                                    <!-- Nút xác nhận -->
                                                    <button type="submit"
                                                        class="btn btn-sm btn-success rounded-pill px-3 fw-bold">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                    <!-- Nút hủy -->
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                                                        onclick="cancelEdit('<?= $review->reviewId ?>')">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <script>
                    function startEdit(reviewId) {
                        // Ẩn nội dung + nút
                        document.getElementById('content-display-' + reviewId).classList.add('d-none');
                        document.getElementById('btn-group-' + reviewId).classList.add('d-none');
                        // Hiện form sửa
                        document.getElementById('content-edit-' + reviewId).classList.remove('d-none');
                    }

                    function cancelEdit(reviewId) {
                        // Hiện lại nội dung + nút
                        document.getElementById('content-display-' + reviewId).classList.remove('d-none');
                        document.getElementById('btn-group-' + reviewId).classList.remove('d-none');
                        // Ẩn form sửa
                        document.getElementById('content-edit-' + reviewId).classList.add('d-none');
                    }
                </script>
            </div>

            <!-- Cột phải: chọn khung giờ đặt sân -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h6 class="fw-bold text-dark mb-0">
                                <i class="bi bi-clock-fill me-2 text-success"></i>Chọn Khung Giờ
                            </h6>
                            <form action="" method="GET" class="d-inline-block">
                                <input type="date" name="date"
                                    class="form-control form-control-sm rounded-pill fw-semibold bg-light text-dark border-0 px-3 shadow-none w-auto"
                                    value="<?= htmlspecialchars($date ?? date('Y-m-d')) ?>"
                                    min="<?= date('Y-m-d') ?>"
                                    onchange="this.form.submit()">
                            </form>
                        </div>
                        <p class="text-muted small mt-1 mb-0">Nhấn vào khung giờ để đặt sân ngay.</p>
                    </div>

                    <div class="card-body p-4">

                        <?php if (empty($slots)): ?>
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-clock display-4 opacity-25 d-block mb-3"></i>
                                <p class="mb-0">Sân này chưa có khung giờ nào.</p>
                                <p class="small">Vui lòng thử lại sau.</p>
                            </div>

                        <?php else: ?>
                            <!-- Nhắc đăng nhập nếu chưa có tài khoản -->
                            <?php if (!AUTHGUARD()->isUserLoggedIn()): ?>
                                <div class="alert alert-warning border-0 rounded-3 small mb-4">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                    <a href="/login" class="text-warning fw-bold">Đăng nhập</a> để có thể đặt sân.
                                </div>
                            <?php endif; ?>

                            <div class="d-flex flex-column gap-3">
                                <?php foreach ($slots as $slot): ?>
                                    <?php $isBooked = in_array($slot->fieldSlotId, $bookedSlotIds ?? []); ?>
                                    <div class="border rounded-3 p-3 d-flex justify-content-between align-items-center gap-2
                                        <?= (strtoupper($field->status) !== 'ACTIVE' || $isBooked) ? 'opacity-50 bg-light' : '' ?>">
                                        <div>
                                            <div class="fw-semibold <?= $isBooked ? 'text-muted' : 'text-dark' ?>">
                                                <i class="bi bi-clock <?= $isBooked ? 'text-secondary' : 'text-success' ?> me-1"></i>
                                                <!-- &ndash là dấu - -->
                                                <?= htmlspecialchars(substr($slot->startTime, 0, 5)) ?>
                                                &ndash;
                                                <?= htmlspecialchars(substr($slot->endTime, 0, 5)) ?>
                                            </div>
                                            <?php if ($slot->label): ?>
                                                <span class="badge bg-light text-dark border ms-1"><?= htmlspecialchars($slot->label) ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                            <span class="fw-bold <?= $isBooked ? 'text-muted' : 'text-success' ?>">
                                                <?= number_format($slot->price, 0, ',', '.') ?>đ
                                                <small class="text-muted fw-normal">/giờ</small>
                                            </span>
                                            <?php if ($isBooked): ?>
                                                <button class="btn btn-outline-secondary btn-sm rounded-pill px-3" disabled>
                                                    Đã đặt
                                                </button>
                                            <?php elseif (AUTHGUARD()->isUserLoggedIn() && strtoupper($field->status) === 'ACTIVE'): ?>
                                                <a href="/bookings/create?field=<?= $field->fieldId ?>&slot=<?= $slot->fieldSlotId ?>&date=<?= htmlspecialchars($date ?? date('Y-m-d')) ?>"
                                                    class="btn btn-success btn-sm rounded-pill px-3 fw-bold shadow-sm">
                                                    Đặt ngay
                                                </a>
                                            <?php else: ?>
                                                <button class="btn btn-outline-secondary btn-sm rounded-pill px-3" disabled>
                                                    Đặt ngay
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
<script>

</script>
<?php include __DIR__ . "/partials/footer.php" ?>