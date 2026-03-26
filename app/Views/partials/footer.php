<footer class="bg-dark text-white pt-5 pb-3">
    <div class="container">

        <div class="row g-4 pb-4">

            <!-- Cột 1: Thương hiệu + mô tả ngắn -->
            <div class="col-lg-4 col-md-6">
                <a href="/" class="d-flex align-items-center gap-2 text-decoration-none mb-3">
                    <img src="/assets/images/logo.jpg" alt="CTUSport Logo" width="40" height="40"
                        class="rounded-circle border border-secondary object-fit-cover">
                    <span class="fw-bold fs-5">
                        <span class="text-white">Football</span><span class="text-warning">Booking</span>
                    </span>
                </a>
                <p class="text-secondary small lh-lg mb-3">
                    Nền tảng đặt sân bóng trực tuyến dành cho sinh viên và cộng đồng thể thao
                    tại khu vực TP. Cần Thơ. Tra cứu, so sánh và đặt sân chỉ trong vài giây.
                </p>
                <!-- Mạng xã hội -->
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle p-2 lh-1" title="Facebook">
                        <i class="bi bi-facebook fs-6"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle p-2 lh-1" title="Zalo">
                        <i class="bi bi-chat-dots-fill fs-6"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle p-2 lh-1" title="YouTube">
                        <i class="bi bi-youtube fs-6"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle p-2 lh-1" title="Instagram">
                        <i class="bi bi-instagram fs-6"></i>
                    </a>
                </div>
            </div>

            <!-- Cột 2: Điều hướng nhanh -->
            <div class="col-lg-2 col-md-6 offset-lg-1">
                <h6 class="fw-bold text-white text-uppercase mb-3 border-bottom border-secondary pb-2">
                    Điều Hướng
                </h6>
                <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                    <li>
                        <a href="/" class="text-secondary text-decoration-none small hover-text-white">
                            <i class="bi bi-chevron-right text-success me-1"></i>Trang Chủ
                        </a>
                    </li>
                    <li>
                        <a href="/list" class="text-secondary text-decoration-none small">
                            <i class="bi bi-chevron-right text-success me-1"></i>Danh Sách Sân
                        </a>
                    </li>
                    <li>
                        <a href="/contact" class="text-secondary text-decoration-none small">
                            <i class="bi bi-chevron-right text-success me-1"></i>Liên Hệ
                        </a>
                    </li>
                    <li>
                        <a href="/register" class="text-secondary text-decoration-none small">
                            <i class="bi bi-chevron-right text-success me-1"></i>Đăng Ký
                        </a>
                    </li>
                    <li>
                        <a href="/login" class="text-secondary text-decoration-none small">
                            <i class="bi bi-chevron-right text-success me-1"></i>Đăng Nhập
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Cột 3: Thông tin liên hệ -->
            <div class="col-lg-4 col-md-6 offset-lg-1">
                <h6 class="fw-bold text-white text-uppercase mb-3 border-bottom border-secondary pb-2">
                    Liên Hệ
                </h6>
                <ul class="list-unstyled d-flex flex-column gap-3 mb-0">
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-geo-alt-fill text-success mt-1 flex-shrink-0"></i>
                        <span class="text-secondary small">Khu II, Đường 3/2, Phường Ninh Kiều, Thành phố Cần
                            Thơ</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-telephone-fill text-success flex-shrink-0"></i>
                        <a href="tel:19001234" class="text-secondary text-decoration-none small">0359906510</a>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-envelope-fill text-success flex-shrink-0"></i>
                        <a href="mailto:support@ctusport.vn"
                            class="text-secondary text-decoration-none small">trananhvu314159@gmail.com</a>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-clock-fill text-success flex-shrink-0"></i>
                        <span class="text-secondary small">Hỗ trợ: 06:00 – 22:00 mỗi ngày</span>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Đường kẻ ngang + bản quyền -->
        <hr class="border-secondary opacity-25 mb-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <p class="text-secondary small mb-0">
                &copy; 2026 <span class="text-white fw-medium">FootballBooking</span> — Đồng hành cùng từng cú sút.
            </p>
            <p class="text-secondary small mb-0">
                Xây dựng bởi
                <span class="text-warning fw-medium">Trần Anh Vũ và Trần Thiện Toàn</span>
                &nbsp;·&nbsp; CT275 Web Technology
            </p>
        </div>

    </div>
</footer>

<!-- Bootstrap bundle (bao gồm cả Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Khởi động tooltip cho toàn trang nếu có dùng data-bs-toggle="tooltip"
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    tooltips.forEach(el => new bootstrap.Tooltip(el))
</script>