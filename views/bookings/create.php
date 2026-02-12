<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container my-5">
    <div class="row g-5">
        <div class="col-lg-4">
            <div class="card shadow border-0">
                <img src="https://images.unsplash.com/photo-1529900748604-07564a03e7a6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="card-img-top" alt="Sân A">
                <div class="card-body">
                    <h3 class="fw-bold text-success">Sân Cỏ Nhân Tạo A1</h3>
                    <p class="text-muted mb-3"><i class="fas fa-map-marker-alt me-2"></i>Khu II, ĐH Cần Thơ</p>

                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                        <span>Loại sân:</span>
                        <span class="fw-bold">Sân 5 người</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                        <span>Giờ mở cửa:</span>
                        <span class="fw-bold">05:00 - 23:00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Giá thuê:</span>
                        <span class="fw-bold text-danger fs-5">200.000đ/h</span>
                    </div>

                    <h6 class="fw-bold"><i class="fas fa-concierge-bell me-2"></i>Dịch vụ đi kèm:</h6>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="badge bg-light text-dark border">Wifi</span>
                        <span class="badge bg-light text-dark border">Trà đá</span>
                        <span class="badge bg-light text-dark border">Giữ xe</span>
                        <span class="badge bg-light text-dark border">Thuê giày</span>
                        <span class="badge bg-light text-dark border">Trọng tài</span>
                    </div>
                </div>
            </div>

            <div class="alert alert-info mt-3 shadow-sm border-0">
                <i class="fas fa-info-circle me-1"></i>
                Đặt cọc <strong>30%</strong> để giữ chỗ. Hoàn cọc nếu hủy trước 2 giờ.
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0 fw-bold"><i class="far fa-calendar-check me-2 text-success"></i>Thông Tin Đặt Sân</h4>
                </div>
                <div class="card-body p-4">
                    <form action="/bookings/history.php" method="GET">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Ngày đặt</label>
                                <input type="date" class="form-control" value="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Thời gian thuê</label>
                                <select class="form-select">
                                    <option>60 phút</option>
                                    <option>90 phút</option>
                                    <option>120 phút</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Chọn khung giờ trống</label>
                                <p class="small text-muted mb-2">
                                    <span class="badge bg-light text-dark border me-1">Trống</span>
                                    <span class="badge bg-secondary text-white me-1">Đã đặt</span>
                                    <span class="badge bg-success text-white">Đang chọn</span>
                                </p>
                                <div class="row row-cols-2 row-cols-md-4 g-2" id="time-slots">
                                    <div class="col">
                                        <div class="p-2 text-center rounded time-slot disabled" title="Đã có người đặt">16:00 - 17:00</div>
                                    </div>
                                    <div class="col">
                                        <div class="p-2 text-center rounded time-slot" onclick="selectSlot(this)">17:00 - 18:00</div>
                                    </div>
                                    <div class="col">
                                        <div class="p-2 text-center rounded time-slot" onclick="selectSlot(this)">18:00 - 19:00</div>
                                    </div>
                                    <div class="col">
                                        <div class="p-2 text-center rounded time-slot" onclick="selectSlot(this)">19:00 - 20:00</div>
                                    </div>
                                    <div class="col">
                                        <div class="p-2 text-center rounded time-slot disabled">20:00 - 21:00</div>
                                    </div>
                                    <div class="col">
                                        <div class="p-2 text-center rounded time-slot" onclick="selectSlot(this)">21:00 - 22:00</div>
                                    </div>
                                </div>
                                <input type="hidden" name="selected_slot" id="selected_slot_input">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Ghi chú thêm</label>
                                <textarea class="form-control" rows="3" placeholder="Ví dụ: Cần thuê 2 đôi giày size 40..."></textarea>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded mb-3">
                            <span class="fw-bold">Tổng tạm tính:</span>
                            <span class="h4 text-success mb-0" id="total-price">0đ</span>
                        </div>

                        <div class="d-grid">
                            <button type="button" class="btn btn-success btn-lg fw-bold" onclick="confirmBooking()">
                                Xác Nhận & Thanh Toán
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function selectSlot(element) {
        // Xóa active cũ
        document.querySelectorAll('.time-slot').forEach(el => el.classList.remove('active'));
        // Thêm active mới
        element.classList.add('active');
        // Cập nhật giá tiền giả lập
        document.getElementById('total-price').innerText = '200.000đ';
    }

    function confirmBooking() {
        if (!document.querySelector('.time-slot.active')) {
            alert('Vui lòng chọn khung giờ!');
            return;
        }
        if (confirm('Bạn có chắc chắn muốn đặt khung giờ này?')) {
            window.location.href = '/bookings/history.php'; // Chuyển hướng sang trang lịch sử
        }
    }
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>