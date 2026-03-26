<?php include __DIR__ . "/../partials/header.php" ?>

<main>
    <div class="container py-5 mt-2">

        <!-- Tiêu đề trang -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <h4 class="fw-bold text-dark mb-1"><i class="bi bi-building me-2 text-success"></i>Quản Lý Sân Của Tôi</h4>
                <p class="text-muted small mb-0">Xin chào, <strong><?= htmlspecialchars(AUTHGUARD()->user()->fullname) ?></strong> — chủ sân</p>
            </div>
            <div class="d-flex gap-2">
                <a href="/owner/bookings" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                    <i class="bi bi-calendar2-check-fill me-1"></i> Quản Lý Lịch Đặt
                </a>
                <a href="/owner/fields/create" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm">
                    <i class="bi bi-plus-circle-fill me-1"></i> Thêm Sân Mới
                </a>
            </div>
        </div>

        <!-- Thông báo -->
        <?php if (!empty($messages['success'])): ?>
            <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4">
                <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($messages['success']) ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($errors['db'])): ?>
            <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($errors['db']) ?>
            </div>
        <?php endif; ?>

        <?php if (empty($fields)): ?>
            <!-- Trạng thái trống -->
            <div class="card border-0 shadow-sm rounded-4 py-5 text-center">
                <div class="card-body">
                    <i class="bi bi-geo-alt text-success opacity-50 display-1 mb-3 d-block"></i>
                    <h5 class="fw-bold text-dark mb-2">Bạn chưa có sân nào</h5>
                    <p class="text-muted mb-4">Nhấn nút bên dưới để bắt đầu đăng ký sân bóng của mình.</p>
                    <a href="/owner/fields/create" class="btn btn-success rounded-pill px-5 fw-bold shadow-sm">
                        <i class="bi bi-plus-circle-fill me-1"></i> Thêm Sân Đầu Tiên
                    </a>
                </div>
            </div>

        <?php else: ?>
            <!-- Bảng danh sách sân -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-success text-white">
                            <tr>
                                <th class="py-3 ps-4">#</th>
                                <th class="py-3">Tên Sân</th>
                                <th class="py-3">Loại</th>
                                <th class="py-3">Địa Chỉ</th>
                                <th class="py-3 text-center">Trạng Thái</th>
                                <th class="py-3 text-center">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($fields as $i => $field): ?>
                                <tr>
                                    <td class="ps-4 text-muted small"><?= $i + 1 ?></td>
                                    <td>
                                        <span class="fw-semibold text-dark"><?= htmlspecialchars($field->fieldName) ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 border border-success border-opacity-25 small">
                                            <?= htmlspecialchars($field->typeName ?? 'Không rõ') ?>
                                        </span>
                                    </td>
                                    <td class="text-muted small">
                                        <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                        <?= htmlspecialchars($field->address) ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if (strtoupper($field->status) === 'ACTIVE'): ?>
                                            <span class="badge bg-success rounded-pill px-3"><i class="bi bi-check-circle me-1"></i>Đang mở</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary rounded-pill px-3"><i class="bi bi-pause-circle me-1"></i>Tạm đóng</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="/owner/fields/<?= $field->fieldId ?>/edit"
                                                class="btn btn-sm btn-outline-secondary rounded-pill px-3" title="Sửa sân">
                                                <i class="bi bi-pencil me-1"></i>Sửa
                                            </a>
                                            <form action="/owner/fields/<?= $field->fieldId ?>/delete" method="POST"
                                                onsubmit="return confirm('Xóa sân này? Hành động không thể hoàn tác.')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                    <i class="bi bi-trash me-1"></i>Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php include __DIR__ . "/../partials/footer.php" ?>