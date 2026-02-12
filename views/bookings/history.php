<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container my-5">
    <h2 class="fw-bold mb-4 border-start border-success border-5 ps-3">Lịch Sử Đặt Sân Của Tôi</h2>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 ps-4">Mã Đơn</th>
                            <th class="py-3">Thông Tin Sân</th>
                            <th class="py-3">Thời Gian</th>
                            <th class="py-3">Tổng Tiền</th>
                            <th class="py-3">Trạng Thái</th>
                            <th class="py-3 text-end pe-4">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-4 fw-bold">#BK8821</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://images.unsplash.com/photo-1529900748604-07564a03e7a6?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" class="rounded me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                    <div>
                                        <div class="fw-bold">Sân A1</div>
                                        <div class="small text-muted">Sân 5 người</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>20/10/2025</div>
                                <div class="small text-muted">17:00 - 18:00</div>
                            </td>
                            <td class="fw-bold text-success">200.000đ</td>
                            <td><span class="badge bg-warning text-dark status-badge">Chờ duyệt</span></td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-outline-danger" title="Hủy đơn"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>

                        <tr>
                            <td class="ps-4 fw-bold">#BK8810</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://thegioithethao.vn/upload_images/images/2023/01/10/kich-thuoc-san-bong-da-7-nguoi-tieu-chuan-fifa-min.jpg" class="rounded me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                    <div>
                                        <div class="fw-bold">Sân B (VIP)</div>
                                        <div class="small text-muted">Sân 7 người</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>15/10/2025</div>
                                <div class="small text-muted">19:00 - 20:30</div>
                            </td>
                            <td class="fw-bold text-success">525.000đ</td>
                            <td><span class="badge bg-success status-badge">Đã xác nhận</span></td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-outline-primary" title="Xem chi tiết"><i class="fas fa-eye"></i></button>
                            </td>
                        </tr>

                        <tr>
                            <td class="ps-4 fw-bold text-muted">#BK8700</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-secondary rounded me-2 d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px;"><i class="fas fa-futbol"></i></div>
                                    <div>
                                        <div class="fw-bold text-muted">Sân C</div>
                                        <div class="small text-muted">Sân 5 người</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted">01/10/2025</div>
                                <div class="small text-muted">20:00 - 21:00</div>
                            </td>
                            <td class="fw-bold text-muted text-decoration-line-through">180.000đ</td>
                            <td><span class="badge bg-danger status-badge">Đã hủy</span></td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-outline-secondary" disabled>Đã hủy</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3">
            <nav>
                <ul class="pagination justify-content-center mb-0">
                    <li class="page-item disabled"><a class="page-link" href="#">Trước</a></li>
                    <li class="page-item active"><a class="page-link bg-success border-success" href="#">1</a></li>
                    <li class="page-item"><a class="page-link text-success" href="#">2</a></li>
                    <li class="page-item"><a class="page-link text-success" href="#">3</a></li>
                    <li class="page-item"><a class="page-link text-success" href="#">Sau</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>