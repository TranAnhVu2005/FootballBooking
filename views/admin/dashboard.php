<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - CTU Sport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background-color: #343a40;
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            font-weight: 500;
            color: #ced4da;
            padding: 10px 20px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .main-content {
            margin-left: 240px;
            padding: 20px;
        }

        .card-stat {
            border-radius: 10px;
            border: none;
            transition: .3s;
        }

        .card-stat:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">ADMIN PANEL</a>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="/home/index.php">Về trang chủ</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3 sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-list me-2"></i> Quản lý Đơn đặt</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-futbol me-2"></i> Quản lý Sân bóng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-users me-2"></i> Người dùng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-chart-bar me-2"></i> Báo cáo</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Tổng Quan Hệ Thống</h1>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card card-stat bg-primary text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Đơn đặt hôm nay</h6>
                                        <h2 class="fw-bold">12</h2>
                                    </div>
                                    <i class="fas fa-calendar-check fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-stat bg-success text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Doanh thu tháng</h6>
                                        <h2 class="fw-bold">15.2M</h2>
                                    </div>
                                    <i class="fas fa-dollar-sign fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-stat bg-warning text-dark h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Sân đang hoạt động</h6>
                                        <h2 class="fw-bold">8/10</h2>
                                    </div>
                                    <i class="fas fa-futbol fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-stat bg-info text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Thành viên mới</h6>
                                        <h2 class="fw-bold">5</h2>
                                    </div>
                                    <i class="fas fa-user-plus fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Đơn đặt mới nhất</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Khách hàng</th>
                                        <th>Sân</th>
                                        <th>Thời gian</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>101</td>
                                        <td>Nguyễn Văn A</td>
                                        <td>Sân A1</td>
                                        <td>Hôm nay, 17:00</td>
                                        <td><span class="badge bg-warning text-dark">Chờ duyệt</span></td>
                                        <td><button class="btn btn-sm btn-success">Duyệt</button></td>
                                    </tr>
                                    <tr>
                                        <td>102</td>
                                        <td>Trần Thị B</td>
                                        <td>Sân B (VIP)</td>
                                        <td>Ngày mai, 19:00</td>
                                        <td><span class="badge bg-success">Đã cọc</span></td>
                                        <td><button class="btn btn-sm btn-primary">Chi tiết</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>