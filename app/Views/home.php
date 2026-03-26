<?php include __DIR__ . "\partials\header.php" ?>

<main>
    <!-- ===================== HERO CAROUSEL ===================== -->
    <section>
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

            <!-- Chỉ số dots ở dưới -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            <div class="carousel-inner">

                <!-- Slide 1: ảnh background thật -->
                <div class="carousel-item active">
                    <img src="/assets/images/background.jpg"
                         class="d-block w-100 object-fit-cover"
                         style="height: 100vh; max-height: 700px;"
                         alt="Sân bóng CTUSport">
                    <!-- Lớp phủ tối để chữ nổi lên -->
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center h-100 top-0 start-0 end-0 bottom-0 position-absolute"
                         style="background: linear-gradient(to bottom, rgba(0,0,0,0.45) 0%, rgba(0,30,10,0.7) 100%);">
                        <span class="badge bg-success bg-opacity-75 text-white mb-3 px-4 py-2 rounded-pill fs-6 border border-success border-opacity-50">
                            <i class="bi bi-patch-check-fill me-1"></i> Nền Tảng Đặt Sân Uy Tín #1 Cần Thơ
                        </span>
                        <h1 class="display-3 fw-bold text-white mb-3 text-shadow">Tốc Độ · Tiện Lợi · Chuyên Nghiệp</h1>
                        <p class="lead text-white mb-5 fw-normal opacity-90 col-lg-7">
                            Tra cứu, so sánh tình trạng mặt sân và đặt lịch ngay trong khu vực của bạn — chỉ vài cú click.
                        </p>
                        <a href="/list" class="btn btn-warning btn-lg px-5 rounded-pill shadow fw-bold text-dark text-uppercase mb-5">
                            Bắt đầu ngay <i class="bi bi-arrow-right-circle-fill ms-2"></i>
                        </a>

                        <!-- Thanh tìm kiếm nằm trong slide -->
                        <div class="col-lg-10 col-xl-9 w-100" style="max-width: 860px;">
                            <div class="card border-0 shadow-lg rounded-4 p-3 bg-white text-start">
                                <form action="/list" method="GET">
                                    <div class="row g-2 align-items-end">
                                        <div class="col-md-5">
                                            <label class="form-label text-muted fw-bold small text-uppercase ms-1">Tên Sân / Vị Trí</label>
                                            <div class="input-group input-group-lg bg-light rounded-3 overflow-hidden border">
                                                <span class="input-group-text bg-light border-0"><i class="bi bi-geo-alt text-success"></i></span>
                                                <input type="text" name="keyword" class="form-control border-0 bg-light shadow-none px-1" placeholder="Nhập khu vực...">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted fw-bold small text-uppercase ms-1">Loại Sân</label>
                                            <div class="input-group input-group-lg bg-light rounded-3 overflow-hidden border">
                                                <span class="input-group-text bg-light border-0"><i class="bi bi-diagram-3 text-success"></i></span>
                                                <select name="type" class="form-select border-0 bg-light shadow-none px-1">
                                                    <option value="">-- Tất cả loại sân --</option>
                                                    <?php foreach ($types ?? [] as $t): ?>
                                                        <option value="<?= htmlspecialchars($t['type_id']) ?>">
                                                            <?= htmlspecialchars($t['type_name']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-warning btn-lg w-100 rounded-3 fw-bold shadow-sm text-dark">
                                                <i class="bi bi-search me-1"></i> Tìm Gấp
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2: dùng lại ảnh, khác nội dung chữ -->
                <div class="carousel-item">
                    <img src="/assets/images/background.jpg"
                         class="d-block w-100 object-fit-cover"
                         style="height: 100vh; max-height: 700px; filter: hue-rotate(30deg) brightness(0.9);"
                         alt="Sân bóng về đêm">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center h-100 top-0 start-0 end-0 bottom-0 position-absolute"
                         style="background: linear-gradient(to bottom, rgba(0,50,20,0.5) 0%, rgba(0,20,0,0.75) 100%);">
                        <span class="badge bg-warning text-dark mb-3 px-4 py-2 rounded-pill fs-6">
                            <i class="bi bi-lightning-charge-fill me-1"></i> Đặt Sân Nhanh — Không Chờ Đợi
                        </span>
                        <h1 class="display-3 fw-bold text-white mb-3">Hàng Trăm Sân Bóng Đang Chờ Bạn</h1>
                        <p class="lead text-white mb-5 opacity-90 col-lg-7">
                            Sân cỏ tự nhiên, sân futsal, sân 5-7-11 người — đầy đủ loại hình, giá hợp lý, đặt ngay hôm nay.
                        </p>
                        <a href="/list" class="btn btn-success btn-lg px-5 rounded-pill shadow fw-bold text-white text-uppercase">
                            Xem Tất Cả Sân <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Slide 3: tone khác -->
                <div class="carousel-item">
                    <img src="/assets/images/background.jpg"
                         class="d-block w-100 object-fit-cover"
                         style="height: 100vh; max-height: 700px; filter: saturate(1.3) brightness(0.85);"
                         alt="Đặt sân online">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center h-100 top-0 start-0 end-0 bottom-0 position-absolute"
                         style="background: linear-gradient(135deg, rgba(0,80,0,0.55) 0%, rgba(0,0,0,0.7) 100%);">
                        <span class="badge bg-light text-success mb-3 px-4 py-2 rounded-pill fs-6 border border-light">
                            <i class="bi bi-star-fill text-warning me-1"></i> Được Đánh Giá 4.9/5 Sao
                        </span>
                        <h1 class="display-3 fw-bold text-white mb-3">Đăng Ký · Đặt Sân · Lên Sân</h1>
                        <p class="lead text-white mb-5 opacity-90 col-lg-7">
                            Quy trình 3 bước siêu đơn giản. Không cần gọi điện, không cần chờ xác nhận lâu.
                        </p>
                        <a href="/register" class="btn btn-outline-light btn-lg px-5 rounded-pill shadow fw-bold text-uppercase">
                            Tạo Tài Khoản Miễn Phí <i class="bi bi-person-plus-fill ms-2"></i>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Nút điều hướng trái / phải -->
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Trước</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Sau</span>
            </button>

        </div>
    </section>

    <!-- Sân Nổi Bật: lấy từ DB (tối đa 4 sân) -->
    <section class="py-5 bg-light" id="pitches">
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h6 class="text-success fw-bold text-uppercase mb-2"><i class="bi bi-star-fill text-warning me-1"></i> Không Thể Bỏ Lỡ</h6>
                    <h2 class="fw-bold mb-0 text-dark">Sân Bóng Được Đề Xuất</h2>
                </div>
                <a href="/list" class="btn btn-outline-success rounded-pill px-4 d-none d-md-inline-block fw-bold shadow-sm">
                    Khám phá toàn bộ <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="row g-4 mt-2">
                <?php if (!empty($featuredFields)): ?>
                    <?php foreach ($featuredFields as $f): ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                            <div class="position-relative">
                                <?php if (!empty($f->image)): ?>
                                    <div class="ratio ratio-4x3">
                                        <img src="<?= htmlspecialchars($f->image) ?>"
                                             class="w-100 h-100 object-fit-cover"
                                             alt="<?= htmlspecialchars($f->fieldName) ?>">
                                    </div>
                                <?php else: ?>
                                    <div class="bg-success bg-opacity-10 ratio ratio-4x3">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="bi bi-image text-success opacity-50 display-1"></i>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <span class="badge bg-success position-absolute top-0 end-0 m-2 shadow-sm rounded-pill px-3 py-2 fw-bold">
                                    <i class="bi bi-check-circle-fill me-1"></i>Đang Mở
                                </span>
                            </div>
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-block mb-3">
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 border border-success border-opacity-25">
                                        <?= htmlspecialchars($f->typeName ?? 'Sân Bóng') ?>
                                    </span>
                                </div>
                                <h5 class="fw-bold mb-2 text-dark"><?= htmlspecialchars($f->fieldName) ?></h5>
                                <p class="text-muted small mb-4 flex-grow-1">
                                    <i class="bi bi-geo-alt-fill me-1 text-danger"></i>
                                    <?= htmlspecialchars($f->address) ?>
                                </p>
                                <hr class="text-muted opacity-25 mt-0">
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <span class="text-success fw-bold fs-5">
                                        <small class="text-muted fw-medium fs-6">Liên hệ</small>
                                    </span>
                                    <a href="/field/<?= htmlspecialchars($f->fieldId) ?>"
                                       class="btn btn-success btn-sm rounded-pill px-4 py-2 fw-bold shadow-sm">
                                        Xem ngay <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                <?php else: ?>
                    <!-- Hiển thị khi DB chưa có sân nào -->
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-geo-alt text-success opacity-25 display-1 d-block mb-3"></i>
                        <h5 class="text-muted">Chưa có sân nào trong hệ thống</h5>
                        <p class="text-muted small mb-4">Hãy đăng ký tài khoản chủ sân để thêm sân bóng của bạn.</p>
                        <a href="/list" class="btn btn-success rounded-pill px-5 fw-bold shadow-sm">Xem Danh Sách Sân</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Nút xem thêm trên mobile -->
            <div class="text-center mt-5 d-md-none">
                <a href="/list" class="btn btn-outline-success rounded-pill px-5 fw-bold">
                    Xem Tất Cả Sân <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Hướng Dẫn - Work Process Section -->
    <section class="py-5 bg-white pb-5 mb-3">

        <div class="container py-4">
            <div class="text-center mb-5">
                <h6 class="text-success fw-bold text-uppercase mb-2"><i class="bi bi-lightning-charge-fill text-warning"></i> Nhanh Gọn Xuyên Suốt</h6>
                <h2 class="fw-bold text-dark display-6">Giải Pháp Lên Sân 3 Bước</h2>
            </div>
            
            <div class="row g-4 text-center mt-2">
                <div class="col-md-4">
                    <div class="bg-success bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-lg mb-4 p-4">
                        <i class="bi bi-search display-5 m-0" style="width: 50px; height: 50px;"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-3">Tìm Vị Trí Lí Tưởng</h5>
                    <p class="text-muted px-4">Gõ khu vực bạn muốn, hệ thống sẽ tự động chỉ điểm hàng chục sân bóng đang trống lịch.</p>
                </div>
                <div class="col-md-4">
                    <div class="bg-success bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-lg mb-4 p-4">
                        <i class="bi bi-calendar2-check-fill display-5 m-0" style="width: 50px; height: 50px;"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-3">Giữ Chỗ Gửi Yêu Cầu</h5>
                    <p class="text-muted px-4">Click bấm trực tiếp vào lưới Giờ của Sân Bóng, đơn sẽ được gửi sang bảng chờ xử lý.</p>
                </div>
                <div class="col-md-4">
                    <div class="bg-warning bg-gradient text-dark rounded-circle d-inline-flex align-items-center justify-content-center shadow-lg mb-4 p-4">
                        <i class="bi bi-trophy-fill display-5 m-0" style="width: 50px; height: 50px;"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-3">Tỏa Sáng Cùng Đồng Đội</h5>
                    <p class="text-muted px-4">Báo giá được thông qua ở Menu Cá Nhân. Mang giày ra sân, xỏ tất và vung chân sút thôi nào!</p>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include __DIR__ . "\partials\\footer.php" ?>