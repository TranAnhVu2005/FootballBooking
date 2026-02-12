<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="hero text-center mb-5">
    <div class="container">
        <h1 class="display-3 fw-bold mb-3">Thỏa Đam Mê - Sân Sẵn Sàng</h1>
        <p class="lead mb-4">Tìm và đặt sân bóng đá nhanh chóng, tiện lợi chỉ với vài cú click.</p>
        <div class="bg-white p-3 rounded shadow-lg d-inline-block mx-auto" style="max-width: 800px;">
            <form class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="far fa-calendar-alt text-success"></i></span>
                        <input type="date" class="form-control border-start-0" value="<?= date('Y-m-d') ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select">
                        <option selected>Tất cả loại sân</option>
                        <option value="5">Sân 5 người</option>
                        <option value="7">Sân 7 người</option>
                        <option value="11">Sân 11 người</option>
                    </select>
                </div>
                <div class="col-md-4 d-grid">
                    <button type="submit" class="btn btn-success fw-bold">Tìm Sân Ngay</button>
                </div>
            </form>
        </div>
    </div>
</section>

<div class="container mb-5" id="pitches">
    <h2 class="text-center fw-bold mb-4 text-success text-uppercase">Sân Bóng Nổi Bật</h2>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card card-pitch h-100">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1529900748604-07564a03e7a6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="card-img-top" alt="Sân A" style="height: 200px; object-fit: cover;">
                    <span class="position-absolute top-0 end-0 bg-primary text-white badge m-2 p-2">Sân 5</span>
                </div>
                <div class="card-body">
                    <h5 class="card-title fw-bold">Sân Cỏ Nhân Tạo A1</h5>
                    <p class="card-text text-muted small"><i class="fas fa-map-marker-alt text-danger me-1"></i> Khu II, ĐH Cần Thơ</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-warning"><i class="fas fa-star"></i> 4.8 (25 đánh giá)</span>
                        <h6 class="text-success fw-bold mb-0">200.000đ/h</h6>
                    </div>
                    <ul class="list-unstyled small text-muted mb-3">
                        <li><i class="fas fa-check text-success me-1"></i> Cỏ nhân tạo mới</li>
                        <li><i class="fas fa-check text-success me-1"></i> Đèn LED đạt chuẩn</li>
                        <li><i class="fas fa-wifi text-success me-1"></i> Wifi & Trà đá Free</li>
                    </ul>
                </div>
                <div class="card-footer bg-white border-top-0 pb-3">
                    <a href="/bookings/create.php" class="btn btn-outline-success w-100 fw-bold">Đặt Sân</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-pitch h-100">
                <div class="position-relative">
                    <img src="https://thegioithethao.vn/upload_images/images/2023/01/10/kich-thuoc-san-bong-da-7-nguoi-tieu-chuan-fifa-min.jpg" class="card-img-top" alt="Sân B" style="height: 200px; object-fit: cover;">
                    <span class="position-absolute top-0 end-0 bg-warning text-dark badge m-2 p-2">Sân 7</span>
                </div>
                <div class="card-body">
                    <h5 class="card-title fw-bold">Sân B - Khu Liên Hợp</h5>
                    <p class="card-text text-muted small"><i class="fas fa-map-marker-alt text-danger me-1"></i> Đường 3/2, Ninh Kiều</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-warning"><i class="fas fa-star"></i> 5.0 (12 đánh giá)</span>
                        <h6 class="text-success fw-bold mb-0">350.000đ/h</h6>
                    </div>
                    <ul class="list-unstyled small text-muted mb-3">
                        <li><i class="fas fa-check text-success me-1"></i> Sân rộng tiêu chuẩn</li>
                        <li><i class="fas fa-check text-success me-1"></i> Có căn tin phục vụ</li>
                        <li><i class="fas fa-parking text-success me-1"></i> Bãi xe rộng</li>
                    </ul>
                </div>
                <div class="card-footer bg-white border-top-0 pb-3">
                    <a href="/bookings/create.php" class="btn btn-outline-success w-100 fw-bold">Đặt Sân</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-pitch h-100">
                <div class="position-relative">
                    <img src="https://img.freepik.com/free-photo/soccer-field-stadium_1112-1279.jpg" class="card-img-top" alt="Sân C" style="height: 200px; object-fit: cover;">
                    <span class="position-absolute top-0 end-0 bg-primary text-white badge m-2 p-2">Sân 5</span>
                </div>
                <div class="card-body">
                    <h5 class="card-title fw-bold">Sân C - Nhà Thi Đấu</h5>
                    <p class="card-text text-muted small"><i class="fas fa-map-marker-alt text-danger me-1"></i> Cái Răng, Cần Thơ</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-warning"><i class="fas fa-star"></i> 4.5 (8 đánh giá)</span>
                        <h6 class="text-success fw-bold mb-0">180.000đ/h</h6>
                    </div>
                    <ul class="list-unstyled small text-muted mb-3">
                        <li><i class="fas fa-check text-success me-1"></i> Giá rẻ sinh viên</li>
                        <li><i class="fas fa-check text-success me-1"></i> Mở cửa 24/7</li>
                    </ul>
                </div>
                <div class="card-footer bg-white border-top-0 pb-3">
                    <a href="/bookings/create.php" class="btn btn-outline-success w-100 fw-bold">Đặt Sân</a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="#" class="btn btn-success rounded-pill px-4">Xem tất cả sân <i class="fas fa-arrow-right ms-2"></i></a>
    </div>
</div>

<section class="bg-white py-5">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="p-3">
                    <i class="fas fa-calendar-check fa-3x text-success mb-3"></i>
                    <h4>Đặt Sân Dễ Dàng</h4>
                    <p class="text-muted">Giao diện thân thiện, đặt sân chỉ trong 3 bước đơn giản.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3">
                    <i class="fas fa-shield-alt fa-3x text-success mb-3"></i>
                    <h4>Uy Tín & Bảo Mật</h4>
                    <p class="text-muted">Thông tin được bảo mật tuyệt đối, sân bãi được xác thực.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3">
                    <i class="fas fa-headset fa-3x text-success mb-3"></i>
                    <h4>Hỗ Trợ 24/7</h4>
                    <p class="text-muted">Đội ngũ hỗ trợ luôn sẵn sàng giải đáp mọi thắc mắc của bạn.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>