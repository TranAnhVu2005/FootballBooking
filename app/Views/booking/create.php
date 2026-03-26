<?php include __DIR__ . "/../partials/header.php" ?>

<div class="container py-5 mt-3 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-success bg-gradient text-white pt-4 pb-3 px-4 border-0">
                    <h5 class="fw-bold mb-0"><i class="bi bi-cart-check-fill me-2"></i>Xác nhận Đặt Sân</h5>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <?php if (isset($errors['system'])): ?>
                        <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $errors['system'] ?>
                        </div>
                    <?php endif; ?>

                    <div class="row mb-4 g-4">
                        <div class="col-md-5">
                            <?php if (!empty($field->image)): ?>
                                <img src="<?= htmlspecialchars($field->image) ?>" class="w-100 rounded-3 object-fit-cover shadow-sm" style="aspect-ratio: 4/3;" alt="<?= htmlspecialchars($field->fieldName) ?>">
                            <?php else: ?>
                                <div class="w-100 rounded-3 bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center shadow-sm text-secondary" style="aspect-ratio: 4/3;">
                                    <i class="bi bi-image display-4 opacity-50"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-7">
                            <h4 class="fw-bold text-dark mb-1"><?= htmlspecialchars($field->fieldName) ?></h4>
                            <p class="text-muted small mb-3">
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                <?= htmlspecialchars($field->address) ?>
                            </p>
                            
                            <hr class="opacity-25 my-3">
                            
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-success bg-opacity-10 text-success rounded px-2 py-1 me-3">
                                    <i class="bi bi-calendar-event fw-bold"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-0">Ngày đặt</p>
                                    <p class="fw-bold text-dark mb-0"><?= date('d/m/Y', strtotime($date)) ?></p>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-success bg-opacity-10 text-success rounded px-2 py-1 me-3">
                                    <i class="bi bi-clock fw-bold"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-0">Khung giờ</p>
                                    <p class="fw-bold text-dark mb-0">
                                        <?= htmlspecialchars(substr($slot->startTime, 0, 5)) ?> &ndash; <?= htmlspecialchars(substr($slot->endTime, 0, 5)) ?>
                                        <?php if ($slot->label): ?>
                                            <span class="badge bg-light text-dark fw-normal border ms-1"><?= htmlspecialchars($slot->label) ?></span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="/bookings" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="field_id" value="<?= $field->fieldId ?>">
                        <input type="hidden" name="slot_id" value="<?= $slot->fieldSlotId ?>">
                        <input type="hidden" name="date" value="<?= htmlspecialchars($date) ?>">

                        <div class="bg-light rounded-4 p-4 mb-4 border shadow-sm">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Giá thuê sân:</span>
                                <span class="fw-bold text-dark fs-5"><?= number_format($slot->price, 0, ',', '.') ?> đ</span>
                            </div>
                            
                            <hr class="opacity-25 my-3">
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-dark fw-bold">Tổng cộng:</span>
                                <span class="fw-bold text-success fs-4"><?= number_format($slot->price, 0, ',', '.') ?> đ</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Phương thức thanh toán <span class="text-danger">*</span></label>
                            <select name="payment_method" class="form-select form-select-lg border-0 bg-light shadow-sm cursor-pointer" required>
                                <option value="Tiền mặt" selected>Thanh toán tại sân (Tiền mặt)</option>
                                <option value="Chuyển khoản">Chuyển khoản (Xác nhận sau)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Ghi chú (Tùy chọn)</label>
                            <textarea name="note" class="form-control border-0 bg-light shadow-sm w-100" rows="3" placeholder="Ví dụ: Cần mượn thêm bóng, mượn áo bíp..."></textarea>
                        </div>

                        <div class="d-flex gap-2 justify-content-end mt-4">
                            <a href="/field/<?= $field->fieldId ?>?date=<?= htmlspecialchars($date) ?>" class="btn btn-light px-4 rounded-pill fw-bold border">Quay lại</a>
                            <button type="submit" class="btn btn-success px-5 rounded-pill fw-bold shadow-sm">
                                <i class="bi bi-check-circle-fill me-2"></i>Xác nhận Đặt Sân
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../partials/footer.php" ?>
