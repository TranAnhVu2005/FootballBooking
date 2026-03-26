<?php include __DIR__ . "\partials\header.php" ?>

<main>

    <!-- ===================== HERO BANNER ===================== -->
    <section class="bg-success text-white text-center pt-5 pb-4 bg-gradient">
        <div class="container pt-4 pb-3">
            <span class="badge bg-light text-success mb-3 px-4 py-2 rounded-pill shadow-sm fs-6 border border-light">
                <i class="bi bi-grid-3x3-gap-fill me-1"></i> Toàn Bộ Sân Bóng
            </span>
            <h1 class="display-5 fw-bold mb-2">Danh Sách Sân Bóng</h1>
            <p class="lead fw-normal mb-4 opacity-75">Khám phá hàng trăm sân bóng chất lượng trong khu vực của bạn</p>

            <!-- Search Bar -->
            <div class="row justify-content-center">
                <div class="col-lg-9 col-xl-8">
                    <div class="card border-0 shadow-lg rounded-4 p-3 bg-white text-start">
                        <form action="/list" method="GET">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-5">
                                    <label class="form-label text-muted fw-bold small text-uppercase ms-1">Tên Sân / Khu
                                        Vực</label>
                                    <div
                                        class="input-group input-group-lg bg-light rounded-3 overflow-hidden border border-1">
                                        <span class="input-group-text bg-light border-0"><i
                                                class="bi bi-geo-alt text-success"></i></span>
                                        <input type="text" name="keyword"
                                            class="form-control border-0 bg-light shadow-none px-1"
                                            placeholder="Nhập tên sân hoặc khu vực..."
                                            value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted fw-bold small text-uppercase ms-1">Loại Sân</label>
                                    <select name="type"
                                        class="form-select form-select-lg bg-light border rounded-3 shadow-none">
                                        <option value="">-- Tất cả loại sân --</option>
                                        <?php foreach ($types ?? [] as $t): ?>
                                            <option value="<?= htmlspecialchars($t['type_id']) ?>" <?= (isset($selectedType) && $selectedType === $t['type_id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($t['type_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit"
                                        class="btn btn-warning btn-lg w-100 rounded-3 fw-bold shadow-sm text-dark">
                                        <i class="bi bi-search me-1"></i> Tìm Sân
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== MAIN CONTENT ===================== -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">

                <!-- ============ SIDEBAR BỘ LỌC ============ -->
                <div class="col-lg-3">

                    <!-- Filter Card -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-success text-white rounded-top-4 py-3 px-4">
                            <h6 class="fw-bold mb-0"><i class="bi bi-funnel-fill me-2"></i>Bộ Lọc Tìm Kiếm</h6>
                        </div>
                        <div class="card-body p-4">
                            <form method="GET" action="/list">
                                <input type="hidden" name="keyword" value="<?= htmlspecialchars($keyword ?? '') ?>">

                                <!-- Loại sân -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark small text-uppercase">
                                        <i class="bi bi-trophy-fill text-success me-1"></i> Loại Sân
                                    </label>
                                    <div class="d-flex flex-column gap-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type" id="typeAll"
                                                value="" <?= empty($selectedType) ? 'checked' : '' ?>>
                                            <label class="form-check-label text-muted" for="typeAll">Tất cả</label>
                                        </div>
                                        <?php foreach ($types ?? [] as $i => $t): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type" id="type_<?= $i ?>"
                                                    value="<?= htmlspecialchars($t['type_id']) ?>" <?= (isset($selectedType) && $selectedType === $t['type_id']) ? 'checked' : '' ?>>
                                                <label class="form-check-label text-muted" for="type_<?= $i ?>">
                                                    <?= htmlspecialchars($t['type_name']) ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success fw-bold rounded-pill shadow-sm">
                                        <i class="bi bi-funnel me-1"></i> Áp Dụng Bộ Lọc
                                    </button>
                                    <a href="/list" class="btn btn-outline-secondary rounded-pill small">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Xóa Bộ Lọc
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Hotline Card -->
                    <div class="card border-0 rounded-4 bg-success text-white shadow-sm">
                        <div class="card-body p-4 text-center">
                            <i class="bi bi-headset display-5 mb-3 d-block"></i>
                            <h6 class="fw-bold mb-1">Cần Hỗ Trợ?</h6>
                            <p class="small opacity-75 mb-3">Liên hệ chúng tôi để được tư vấn sân phù hợp nhất.</p>
                            <a href="tel:0359906510"
                                class="btn btn-warning btn-sm fw-bold text-dark rounded-pill px-4 shadow-sm">
                                <i class="bi bi-telephone-fill me-1"></i> 0359906510
                            </a>
                        </div>
                    </div>

                </div>
                <!-- END SIDEBAR -->

                <!-- ============ DANH SÁCH SÂN ============ -->
                <div class="col-lg-9">

                    <!-- Thanh điều khiển kết quả -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
                        <div>
                            <h5 class="fw-bold text-dark mb-0">
                                Tìm thấy <span class="text-success"><?= number_format($totalRecords ?? 0) ?> sân</span>
                            </h5>
                            <p class="text-muted small mb-0">Cập nhật lúc <?= date('H:i, d/m/Y') ?></p>
                        </div>
                    </div>

                    <!-- Grid Thẻ Sân -->
                    <div class="row g-4">

                        <?php if (!empty($listFields)): ?>
                            <?php foreach ($listFields as $field): ?>
                                <!-- Thẻ sân (dữ liệu thật) -->
                                <div class="col-md-6 col-xl-4">
                                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                                        <!-- Ảnh sân hoặc placeholder -->
                                        <div class="position-relative">
                                            <?php if (!empty($field->image)): ?>
                                                <div class="ratio ratio-4x3">
                                                    <img src="<?= htmlspecialchars($field->image) ?>"
                                                        class="w-100 h-100 object-fit-cover"
                                                        alt="<?= htmlspecialchars($field->fieldName ?? '') ?>">
                                                </div>
                                            <?php else: ?>
                                                <div class="bg-success bg-opacity-10 ratio ratio-4x3">
                                                    <div class="d-flex align-items-center justify-content-center flex-column">
                                                        <i class="bi bi-image text-success opacity-50 display-1"
                                                            title="<?= htmlspecialchars($field->fieldName ?? '') ?>"></i>
                                                        <span class="small text-muted mt-1"><?= htmlspecialchars($field->fieldName ?? '') ?></span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <span class="badge bg-success position-absolute top-0 end-0 m-2 shadow-sm rounded-pill px-3 py-2 fw-bold">
                                                <i class="bi bi-check-circle-fill me-1"></i>Đang Mở
                                            </span>
                                        </div>


                                        <!-- Nội dung thẻ -->
                                        <div class="card-body p-4 d-flex flex-column">
                                            <div class="d-block mb-2">
                                                <span
                                                    class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 border border-success border-opacity-25">
                                                    <i
                                                        class="bi bi-trophy-fill me-1"></i><?= htmlspecialchars($field->typeName ?? 'Sân Bóng') ?>
                                                </span>
                                            </div>
                                            <h5 class="fw-bold mb-2 text-dark">
                                                <?= htmlspecialchars($field->fieldName ?? 'Sân Bóng') ?>
                                            </h5>
                                            <p class="text-muted small mb-3 flex-grow-1">
                                                <i class="bi bi-geo-alt-fill me-1 text-danger"></i>
                                                <?= htmlspecialchars($field->address ?? '') ?>
                                            </p>


                                            <hr class="text-muted opacity-25 mt-0 mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <a href="/field/<?= htmlspecialchars($field->fieldId ?? '#') ?>"
                                                    class="btn btn-success btn-sm rounded-pill px-4 py-2 fw-bold shadow-sm">
                                                    Xem ngay <i class="bi bi-arrow-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        <?php else: ?>


                        <?php endif; ?>
                    </div>
                    <!-- END Grid -->

                    <!-- ============ PHÂN TRANG ============ -->
                    <?php if (isset($totalPages) && $totalPages > 1): ?>
                        <nav class="mt-5" aria-label="Phân trang danh sách sân">
                            <ul class="pagination justify-content-center">
                                <?php
                                $queryParams = $_GET; // Lấy params hiện tại (keyword, type)
                                ?>

                                <!-- Nút Trước -->
                                <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>">
                                    <?php $queryParams['page'] = $currentPage - 1; ?>
                                    <a class="page-link rounded-start-pill px-4" href="?<?= http_build_query($queryParams) ?>" <?= ($currentPage <= 1) ? 'tabindex="-1"' : '' ?>>
                                        <i class="bi bi-chevron-left me-1"></i> Trước
                                    </a>
                                </li>

                                <!-- Các trang -->
                                <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                                    <?php $queryParams['page'] = $p; ?>
                                    <li class="page-item <?= ($p === $currentPage) ? 'active' : '' ?>">
                                        <a class="page-link" href="?<?= htmlspecialchars(http_build_query($queryParams)) ?>"><?= $p ?></a>
                                    </li>
                                <?php endfor; ?>

                                <!-- Nút Sau -->
                                <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
                                    <?php $queryParams['page'] = $currentPage + 1; ?>
                                    <a class="page-link rounded-end-pill px-4" href="?<?= http_build_query($queryParams) ?>" <?= ($currentPage >= $totalPages) ? 'tabindex="-1"' : '' ?>>
                                        Sau <i class="bi bi-chevron-right ms-1"></i>
                                    </a>
                                </li>
                            </ul>
                            <!-- Tính min để, nếu người dùng nhập bậy lên url, vẫn xử lý đúng kết quả, nếu ở trang cuối chỉ có 25 sân, mà ở trang 3 thì 3*limit có thể bằng 36 mặc dù có 25 sân -->
                            <p class="text-center text-muted small mt-2">
                                Hiển thị <?= min(($currentPage - 1) * $limit + 1, $totalRecords) ?>–<?= min($currentPage * $limit, $totalRecords) ?> trong <?= number_format($totalRecords) ?> sân
                            </p>
                        </nav>
                    <?php endif; ?>

                </div>
                <!-- END DANH SÁCH SÂN -->

            </div>
        </div>
    </section>

</main>

<?php include __DIR__ . "\partials\\footer.php" ?>