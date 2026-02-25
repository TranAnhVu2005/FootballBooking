<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="hero text-center mb-5">
    <div class="container hero-content">
        <h1 class="display-4 fw-bold">Đặt Sân Bóng Nhanh Chóng - Tiện Lợi</h1>
        <p class="lead">Tìm sân và đặt lịch chỉ trong vài phút</p>
        <a href="" class="btn btn-success btn-lg mt-3">Đặt ngay</a>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Tìm kiếm sân bóng</h2>
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Nhập khu vực...">
            </div>
            <div class="col-md-4">
                <input type="date" class="form-control">
            </div>
            <div class="col-md-4">
                <button class="btn btn-success w-100">Tìm sân</button>
            </div>
        </div>
    </div>
</section>

<div class="container mb-5" id="pitches">
    <h2 class="text-center fw-bold mb-4 text-success text-uppercase">Sân Bóng Đề Xuất</h2>

    <!-- để thông tin sân vào đây -->

    <div class="text-center mt-4">
        <a href="#" class="btn btn-success rounded-pill px-4">Xem tất cả sân <i class="fas fa-arrow-right ms-2"></i></a>
    </div>
</div>

<section class="py-5 bg-success text-white text-center">
    <div class="container">
        <h2 class="mb-5">Quy Trình Đặt Sân</h2>
        <div class="row">
            <div class="col-md-4">
                <i class="bi bi-search display-4"></i>
                <h5 class="mt-3">Tìm Sân</h5>
                <p>Chọn khu vực và thời gian phù hợp</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-calendar-check display-4"></i>
                <h5 class="mt-3">Đặt Lịch</h5>
                <p>Chọn giờ và xác nhận đặt sân</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-credit-card display-4"></i>
                <h5 class="mt-3">Thanh Toán</h5>
                <p>Thanh toán online nhanh chóng</p>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>