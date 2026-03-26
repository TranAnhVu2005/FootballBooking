<?php include __DIR__ . "/../partials/header.php" ?>

<div class="container py-5 mt-3 mb-5">
    <div class="row mb-4 align-items-center">
        <div class="col-8">
            <h4 class="fw-bold mb-1 text-dark">
                <i class="bi bi-calendar2-check-fill text-primary me-2"></i>Quản lý Tất Cả Lịch Đặt Sân
            </h4>
            <p class="text-muted small mb-0">Xem và quản lý đơn đặt của tất cả hệ thống sân của bạn</p>
        </div>
        <div class="col-4 text-end">
            <a href="/owner" class="btn btn-light border rounded-pill fw-bold shadow-sm px-4">
                <i class="bi bi-arrow-left me-1"></i>Trở lại
            </a>
        </div>
    </div>

    <?php if (isset($messages['success'])): ?>
        <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($messages['success']) ?>
        </div>
    <?php endif; ?>
    <?php if (isset($errors['system'])): ?>
        <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($errors['system']) ?>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <?php if (empty($bookings)): ?>
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox display-1 mb-3 d-block opacity-25"></i>
                    <h5 class="fw-bold">Chưa có người nào đặt sân của bạn</h5>
                    <p class="mb-0">Các đơn đặt sân mới sẽ hiển thị tại đây.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table align-middle table-hover m-0">
                        <thead class="table-light text-muted small text-uppercase">
                            <tr>
                                <th class="fw-semibold ps-4 py-3">Khách Hàng</th>
                                <th class="fw-semibold py-3">Sân Bóng & Loại</th>
                                <th class="fw-semibold py-3">Giờ & Giá</th>
                                <th class="fw-semibold py-3 text-center">Tình Trạng</th>
                                <th class="fw-semibold py-3 text-end pe-4">Thanh Toán</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $b): ?>
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="fw-bold text-dark mb-1">
                                            <i class="bi bi-person-circle text-muted me-1"></i><?= htmlspecialchars($b->fullname ?? 'Khách ngoài') ?>
                                        </div>
                                        <div class="text-muted small" style="font-size: 0.85rem">
                                            <i class="bi bi-telephone-fill text-success me-1"></i><?= htmlspecialchars($b->phone ?? 'Không có SĐT') ?>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="fw-bold text-dark mb-1">
                                            <i class="bi bi-geo-alt-fill text-primary me-1"></i><?= htmlspecialchars($b->fieldName) ?>
                                        </div>
                                        <span class="badge bg-light text-dark border px-2 py-1 fs-6 fw-medium shadow-sm mt-1">
                                            <i class="bi bi-calendar-event text-primary me-1"></i><?= date('d/m/Y', strtotime($b->bookingDate)) ?>
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div class="fw-bold text-dark mb-1">
                                            <i class="bi bi-clock me-1 text-secondary"></i>
                                            <?= htmlspecialchars(substr($b->startTime, 0, 5)) ?> &ndash; <?= htmlspecialchars(substr($b->endTime, 0, 5)) ?>
                                        </div>
                                        <div class="fw-bold text-success fs-6 mt-1">
                                            <?= number_format($b->totalPrice, 0, ',', '.') ?>đ
                                            <?php if ($b->paymentMethod === 'Chuyển khoản'): ?>
                                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 ms-1 fw-normal" style="font-size: 0.75rem">CK</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="py-3 text-center">
                                        <?php
                                        $statusClass = 'bg-success';
                                        if ($b->status === 'Đã hủy') $statusClass = 'bg-danger';
                                        elseif ($b->status === 'Hoàn thành') $statusClass = 'bg-primary';
                                        ?>
                                        <span class="badge <?= $statusClass ?> rounded-pill px-3 shadow-sm mb-1"><?= htmlspecialchars($b->status) ?></span>

                                        <?php if ($b->note): ?>
                                            <div class="text-start mt-2 p-2 bg-light rounded small border">
                                                <strong>Ghi chú:</strong> <?= htmlspecialchars($b->note) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <?php if ($b->status !== 'Đã hủy'): ?>
                                            <!-- Do form submit qua _POST nên cần gửi booking_id trên route -->
                                            <form action="/owner/bookings/<?= $b->bookingId ?>/payment-status" method="POST" class="d-inline-flex flex-column align-items-end">
                                                <?= csrf_field() ?>
                                                <select name="payment_status" class="form-select form-select-sm mb-2 shadow-sm fw-bold <?= $b->paymentStatus === 'Đã thanh toán' ? 'bg-success bg-opacity-10 text-success border-success' : 'bg-light text-dark' ?>" style="width: 150px" onchange="this.form.submit()">
                                                    <option value="Chưa thanh toán" <?= $b->paymentStatus === 'Chưa thanh toán' ? 'selected' : '' ?>>Chưa thanh toán</option>
                                                    <option value="Đã thanh toán" <?= $b->paymentStatus === 'Đã thanh toán' ? 'selected' : '' ?>>Đã thanh toán</option>
                                                </select>
                                            </form>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted border px-2 py-1">Đã hủy</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../partials/footer.php" ?>