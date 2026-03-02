<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="py-5">
    <div class="container">

        <div class="row">
            <!-- Hình ảnh sân -->
            <div class="col-md-6 mb-4">
                <img src="https://images.unsplash.com/photo-1517927033932-b3d18e61fb3a"
                     class="img-fluid rounded shadow"
                     style="width:100%; height:400px; object-fit:cover;">
            </div>

            <!-- Thông tin sân -->
            <div class="col-md-6">
                <h2 class="fw-bold text-success">Sân Mini Quận 7</h2>
                <p class="text-muted">
                    <i class="bi bi-geo-alt"></i> Quận 7, TP.HCM
                </p>

                <h4 class="text-success fw-bold mb-3">
                    300.000đ / giờ
                </h4>

                <div class="mb-3">
                    <span class="badge bg-success">Sân 5 người</span>
                    <span class="badge bg-secondary">Cỏ nhân tạo</span>
                    <span class="badge bg-warning text-dark">Có đèn</span>
                </div>

                <p>
                    Sân đạt tiêu chuẩn thi đấu, mặt cỏ mới, hệ thống chiếu sáng hiện đại.
                    Phù hợp tổ chức giải đấu nhỏ và luyện tập thường xuyên.
                </p>

                <!-- Chọn ngày giờ -->
                <div class="card shadow-sm p-3 mt-4">
                    <h5 class="fw-bold mb-3">Đặt lịch sân</h5>

                    <div class="mb-3">
                        <label class="form-label">Chọn ngày</label>
                        <input type="date" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Chọn khung giờ</label>
                        <select class="form-select">
                            <option>17:00 - 18:00</option>
                            <option>18:00 - 19:00</option>
                            <option>19:00 - 20:00</option>
                            <option>20:00 - 21:00</option>
                        </select>
                    </div>

                    <button class="btn btn-success w-100 fw-bold">
                        Đặt ngay
                    </button>
                </div>
            </div>
        </div>

        <!-- Thông tin bổ sung -->
        <div class="row mt-5">
            <div class="col-md-8">
                <h4 class="fw-bold mb-3">Mô tả chi tiết</h4>
                <p>
                    Sân có bãi giữ xe rộng rãi, phòng thay đồ sạch sẽ,
                    wifi miễn phí và khu vực nghỉ ngơi cho khán giả.
                    Hệ thống đèn LED đảm bảo đủ ánh sáng cho các trận đấu buổi tối.
                </p>
            </div>

            <div class="col-md-4">
                <h4 class="fw-bold mb-3">Tiện ích</h4>
                <ul class="list-group">
                    <li class="list-group-item">
                        <i class="bi bi-check-circle text-success"></i> Bãi giữ xe
                    </li>
                    <li class="list-group-item">
                        <i class="bi bi-check-circle text-success"></i> Phòng thay đồ
                    </li>
                    <li class="list-group-item">
                        <i class="bi bi-check-circle text-success"></i> Wifi miễn phí
                    </li>
                    <li class="list-group-item">
                        <i class="bi bi-check-circle text-success"></i> Căng tin
                    </li>
                </ul>
            </div>
        </div>

    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>