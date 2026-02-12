<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTU Sport Booking - Đặt Sân Bóng Online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #28a745;
            --dark-color: #343a40;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 1px;
        }

        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1579952363873-27f3bade9f55?ixlib=rb-4.0.3&auto=format&fit=crop&w=1935&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
        }

        .card-pitch {
            transition: transform 0.3s;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-pitch:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .status-badge {
            font-size: 0.8rem;
            padding: 5px 10px;
            border-radius: 20px;
        }

        .time-slot {
            cursor: pointer;
            border: 1px solid #ced4da;
            transition: all 0.2s;
        }

        .time-slot:hover {
            background-color: #e9ecef;
        }

        .time-slot.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .time-slot.disabled {
            background-color: #e9ecef;
            color: #adb5bd;
            cursor: not-allowed;
            text-decoration: line-through;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/home/index.php"><i class="fas fa-futbol me-2"></i>CTU SPORT</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link active" href="/home/index.php">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pitches">Danh sách sân</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Bảng giá</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Liên hệ</a></li>
                </ul>

                <div class="d-flex">
                    <a href="/auth/login.php" class="btn btn-outline-light me-2 btn-sm">Đăng nhập</a>
                    <a href="/auth/register.php" class="btn btn-light text-success btn-sm">Đăng ký</a>

                </div>
            </div>
        </div>
    </nav>