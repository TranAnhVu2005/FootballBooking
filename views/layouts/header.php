<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTU Sport Booking - Đặt Sân Bóng Online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

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
            background: url('https://c.wallhere.com/photos/6e/33/stadium_Real_Madrid_Santiago_Bernabeu_Stadium_soccer-133298.jpg!d') center/cover no-repeat;
            height: 90vh;
            display: flex;
            align-items: center;
            color: white;
            position: relative;
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.6);
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="">⚽Đặt Sân Bóng</a>
            <button class="navbar-toggler" type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="list.php">Danh sách sân</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Liên hệ</a></li>
                    <li class="nav-item"><a class="btn btn-light" href="login.php">Đăng nhập</a></li>
                </ul>
            </div>
        </div>
    </nav>
</body>

    