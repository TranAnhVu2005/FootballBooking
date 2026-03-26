<?php include __DIR__ . "/../partials/header.php" ?>

<div class="container py-5 mt-3 mb-5">
    <div class="row">
        <div class="col-12">
            <h4 class="fw-bold mb-4 text-dark"><i class="bi bi-calendar2-check-fill text-success me-2"></i>Lịch Sử Đặt Sân</h4>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <?php if (empty($bookings)): ?>
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-calendar-x display-1 mb-3 d-block opacity-25"></i>
                            <h5 class="fw-bold">Bạn chưa có lịch sử đặt sân nào</h5>
                            <p class="mb-4">Hãy đặt sân ngay để trải nghiệm dịch vụ của chúng tôi.</p>
                            <a href="/list" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm">Tìm & Đặt Sân Ngay</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table align-middle table-hover m-0">
                                <thead class="table-light text-muted small">
                                    <tr>
                                        <th class="fw-semibold ps-4 py-3">CƠ SỞ / SÂN</th>
                                        <th class="fw-semibold py-3">NGÀY ĐẶT</th>
                                        <th class="fw-semibold py-3">KHUNG GIỜ</th>
                                        <th class="fw-semibold py-3">TỔNG TIỀN</th>
                                        <th class="fw-semibold py-3">TRẠNG THÁI</th>
                                        <th class="fw-semibold text-end pe-4 py-3">THAO TÁC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bookings as $b): ?>
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3 d-none d-md-block">
                                                        <?php if ($b->fieldImage): ?>
                                                            <img src="<?= htmlspecialchars($b->fieldImage) ?>" class="rounded-3 object-fit-cover shadow-sm bg-light" style="width: 60px; height: 60px" alt="">
                                                        <?php else: ?>
                                                            <div class="rounded-3 bg-light text-muted d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px">
                                                                <i class="bi bi-image" style="font-size: 1.5rem"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark mb-1"><?= htmlspecialchars($b->fieldName) ?></div>
                                                        <div class="text-muted small" style="font-size: 0.85rem">
                                                            <i class="bi bi-geo-alt-fill text-danger me-1"></i><?= htmlspecialchars($b->fieldAddress) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <span class="badge bg-light text-dark border px-2 py-1 fs-6 fw-medium shadow-sm">
                                                    <?= date('d/m/Y', strtotime($b->bookingDate)) ?>
                                                </span>
                                            </td>
                                            <td class="py-3">
                                                <div class="fw-bold text-dark mb-1">
                                                    <?= htmlspecialchars(substr($b->startTime, 0, 5)) ?> &ndash; <?= htmlspecialchars(substr($b->endTime, 0, 5)) ?>
                                                </div>
                                                <?php if ($b->slotLabel): ?>
                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 form-text m-0 p-1 px-2 rounded-1"><?= htmlspecialchars($b->slotLabel) ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-3 fw-bold text-success fs-6">
                                                <?= number_format($b->totalPrice, 0, ',', '.') ?>đ
                                            </td>
                                            <td class="py-3">
                                                <?php
                                                $statusClass = 'bg-success';
                                                if ($b->status === 'Đã hủy') $statusClass = 'bg-danger';
                                                elseif ($b->status === 'Hoàn thành') $statusClass = 'bg-primary';
                                                ?>
                                                <span class="badge <?= $statusClass ?> rounded-pill px-3 shadow-sm mb-1"><?= htmlspecialchars($b->status) ?></span>
                                                <br>
                                                <small class="text-muted fw-medium border px-2 py-1 rounded d-inline-block mt-1 bg-light" style="font-size: 11px">
                                                    <?= htmlspecialchars($b->paymentStatus) ?>
                                                </small>
                                            </td>
                                            <td class="pe-4 py-3 text-end">
                                                <?php
                                                // Cho phép hủy nếu trạng thái là Đã đặt và ngày đặt >= hôm nay
                                                $canCancel = ($b->status === 'Đã đặt' && strtotime($b->bookingDate) >= strtotime(date('Y-m-d')));
                                                ?>

                                                <?php if ($canCancel): ?>
                                                    <form action="/bookings/<?= $b->bookingId ?>/cancel" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đặt sân này không? Hành động này không thể hoàn tác.');">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill fw-bold px-3">
                                                            <i class="bi bi-x-circle me-1"></i>Hủy
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <button class="btn btn-outline-secondary btn-sm rounded-pill fw-bold px-3" disabled>
                                                        <i class="bi bi-slash-circle me-1"></i>Hủy
                                                    </button>
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

            <?php if (isset($messages['success'])): ?>
                <div class="alert alert-success mt-4 border-0 rounded-4 shadow-sm">
                    <i class="bi bi-check-circle-fill me-2"></i><?= $messages['success'] ?>
                </div>
            <?php endif; ?>
            <?php if (isset($errors['system'])): ?>
                <div class="alert alert-danger mt-4 border-0 rounded-4 shadow-sm">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $errors['system'] ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../partials/footer.php" ?>