<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FootballBooking</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

    <header class="sticky-top">
        <!-- ===================== THANH THÔNG TIN LIÊN HỆ (TOP BAR) ===================== -->
        <div class="bg-success text-white py-1 d-none d-lg-block" style="font-size: 0.8rem;">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="d-flex gap-4">
                    <span><i class="bi bi-telephone-fill me-1 opacity-75"></i> Hotline: 0359906510</span>
                    <span><i class="bi bi-envelope-fill me-1 opacity-75"></i> Email: trananhvu314159@gmail.com</span>
                </div>
                <div class="d-flex gap-3">
                    <a href="#" class="link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover opacity-75"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover opacity-75"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover opacity-75"><i class="bi bi-twitter"></i></a>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-2 shadow-sm">
            <div class="container-fluid px-2 px-sm-4 px-xl-5">

                <!-- ===================== THƯƠNG HIỆU & LOGO ===================== -->
                <a class="navbar-brand d-flex align-items-center gap-2 fw-bolder fs-4 py-0 text-nowrap" href="/">
                    <img src="/assets/images/logo.jpg" alt="FootballBooking Logo" width="45" height="45"
                        class="rounded-circle border border-2 border-success object-fit-cover shadow-sm p-1">
                    <span class="d-none d-sm-flex align-items-center">
                        <span class="text-success">Football</span><span class="text-dark">Booking</span>
                    </span>
                </a>

                <!-- Badge (Hiển thị số người dùng online nhận kết quả từ Server-Sent Events) -->
                <div id="online-users-badge" class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-25 ms-2 ms-xl-3 px-3 py-2 shadow-none d-none d-md-flex align-items-center gap-2 text-nowrap" style="font-size: 0.75rem;">
                    <span class="spinner-grow bg-success" style="width: 0.4rem; height: 0.4rem;" role="status"></span>
                    <span>Đang tải...</span>
                </div>

                <!-- ===================== NÚT MỞ RỘNG CHO THIẾT BỊ DI ĐỘNG ===================== -->
                <button class="navbar-toggler border-0 shadow-none px-2 text-success" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- ===================== DANH SÁCH LIÊN KẾT ĐIỀU HƯỚNG ===================== -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto gap-1 gap-xl-2 mt-3 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link px-3 py-2 rounded-pill fw-semibold text-nowrap <?= ($_SERVER['REQUEST_URI'] === '/') ? 'active text-success bg-success bg-opacity-10' : 'text-secondary' ?>"
                                href="/">
                                <i class="bi bi-house-door-fill me-1 <?= ($_SERVER['REQUEST_URI'] === '/') ? '' : 'text-success' ?>"></i>Trang Chủ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 py-2 rounded-pill fw-semibold text-nowrap <?= (str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/list')) ? 'active text-success bg-success bg-opacity-10' : 'text-secondary' ?>"
                                href="/list">
                                <i class="bi bi-grid-fill me-1 <?= (str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/list')) ? '' : 'text-success' ?>"></i>Sân Bóng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 py-2 rounded-pill fw-semibold text-nowrap <?= (str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/contact')) ? 'active text-success bg-success bg-opacity-10' : 'text-secondary' ?>"
                                href="/contact">
                                <i class="bi bi-envelope-fill me-1 <?= (str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/contact')) ? '' : 'text-success' ?>"></i>Liên Hệ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 py-2 rounded-pill fw-semibold text-nowrap <?= (str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/aboutus')) ? 'active text-success bg-success bg-opacity-10' : 'text-secondary' ?>"
                                href="/aboutus">
                                <i class="bi bi-info-circle-fill me-1 <?= (str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/aboutus')) ? '' : 'text-success' ?>"></i>Về Chúng Tôi
                            </a>
                        </li>
                    </ul>

                    <!-- ===================== NÚT CHỨC NĂNG & XÁC THỰC TÀI KHOẢN ===================== -->
                    <ul class="navbar-nav justify-content-end align-items-lg-center gap-2 gap-xl-3 mt-3 mt-lg-0 pt-3 pt-lg-0 border-top border-lg-0">

                        <?php if (AUTHGUARD()->isUserLoggedIn()): ?>

                            <?php if (AUTHGUARD()->user()->role === 'ADMIN'): ?>
                                <li class="nav-item">
                                    <a class="btn btn-dark btn-sm fw-bold px-3 py-2 rounded-pill shadow-sm d-flex align-items-center gap-2 text-nowrap" href="/admin">
                                        <i class="bi bi-shield-lock-fill text-warning"></i><span>AD</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Menu dropdown hiển thị quản lý khi người dùng đã đăng nhập -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 p-0 border-0 bg-transparent text-nowrap"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="position-relative flex-shrink-0">
                                        <?php if (!empty(AUTHGUARD()->user()->avatar)): ?>
                                            <img src="<?= htmlspecialchars(AUTHGUARD()->user()->avatar) ?>" alt="Avatar" width="40"
                                                height="40" class="rounded-circle object-fit-cover border border-2 border-success p-1">
                                        <?php else: ?>
                                            <!-- //Dùng mb hỗ trợ tốt hơn cho tiếng việt -->
                                            <?php $initial = mb_strtoupper(mb_substr(AUTHGUARD()->user()->fullname, 0, 1, 'UTF-8'), 'UTF-8') ?: '?'; ?>
                                            <span class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center fw-bold shadow-sm p-1 border border-2 border-white" style="width:40px;height:40px;font-size:16px;">
                                                <?= htmlspecialchars($initial) ?>
                                            </span>
                                        <?php endif; ?>
                                        <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle p-1 mb-1 me-1" title="Online"></span>
                                    </div>
                                    <div class="d-none d-lg-flex flex-column align-items-start ms-1 text-nowrap">
                                        <span class="fw-bold text-dark lh-1" style="font-size: 0.9rem;"><?= htmlspecialchars(AUTHGUARD()->user()->fullname) ?></span>
                                        <span class="text-success fw-semibold mt-1" style="font-size: 0.75rem;">Đang hoạt động</span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 mt-3 py-2" style="min-width: 220px;">
                                    <li>
                                        <div class="px-4 py-2 mb-1 d-lg-none border-bottom">
                                            <div class="fw-bold text-dark"><?= htmlspecialchars(AUTHGUARD()->user()->fullname) ?></div>
                                            <div class="text-success small fw-semibold">Đang hoạt động</div>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item px-4 py-2" href="/profile">
                                            <i class="bi bi-person-circle text-success me-2 fs-5 align-middle"></i>Hồ Sơ Cá Nhân
                                        </a>
                                    </li>
                                    <?php if (AUTHGUARD()->user()->role === 'OWNER'): ?>
                                        <li>
                                            <a class="dropdown-item px-4 py-2" href="/owner">
                                                <i class="bi bi-building-fill-gear text-warning me-2 fs-5 align-middle"></i>Quản Lý Sân
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <li>
                                        <a class="dropdown-item px-4 py-2" href="/bookings">
                                            <i class="bi bi-calendar2-check-fill text-primary me-2 fs-5 align-middle"></i>Lịch Đặt Sân
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider mx-3 my-2 opacity-10">
                                    </li>
                                    <li>
                                        <a class="dropdown-item px-4 py-2 text-danger" href="/logout"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bi bi-box-arrow-right me-2 fs-5 align-middle"></i>Đăng Xuất
                                        </a>
                                        <form id="logout-form" action="/logout" method="POST" class="d-none"><?= csrf_field() ?></form>
                                    </li>
                                </ul>
                            </li>

                        <?php else: ?>

                            <li class="nav-item">
                                <a class="btn btn-outline-success fw-bold px-4 py-2 rounded-pill shadow-sm text-nowrap" href="/login">
                                    Đăng Nhập
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-success fw-bold px-4 py-2 rounded-pill shadow-sm text-nowrap" href="/register">
                                    Đăng Ký
                                </a>
                            </li>

                        <?php endif; ?>

                    </ul>
                </div>

            </div>
        </nav>
    </header>
    <script>
        // Kiểm tra trình duyệt có hỗ trợ Server-Sent Events không
        if (typeof(EventSource) !== "undefined") {
            // Khởi tạo kết nối SSE tới server
            var source = new EventSource("/sse/stream");
            // Lắng nghe sự kiện từ server gửi về
            source.onmessage = function(event) {
                // Giải mã dữ liệu JSON nhận được
                var data = JSON.parse(event.data);
                // Lấy thẻ hiển thị số lượng người online
                var badge = document.getElementById("online-users-badge");
                if (badge) {
                    // Cập nhật nội dung hiển thị số người online
                    badge.innerHTML = '<span class="spinner-grow bg-success" style="width: 0.5rem; height: 0.5rem;" role="status"></span><span class="ms-1 fw-semibold">' + data.online_users + ' Đang Online</span>';
                }
            };
        }
    </script>