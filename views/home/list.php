<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="hero text-center mb-5">
    <div class="container hero-content">
        <h1 class="display-4 fw-bold">Danh Sách Sân Bóng</h1>
        <p class="lead">Lựa chọn sân phù hợp với bạn</p>
    </div>
</section>


<section class="py-4 bg-light">
    <div class="container">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Nhập khu vực...">
            </div>
            <div class="col-md-4">
                <select class="form-select">
                    <option selected>Loại sân</option>
                    <option>Sân 5 người</option>
                    <option>Sân 7 người</option>
                    <option>Sân 11 người</option>
                </select>
            </div>
            <div class="col-md-4">
                <button class="btn btn-success w-100">Tìm sân</button>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">
    <div class="row g-4">

        <!-- thông tin sân -->
        

    </div>

    <nav class="mt-5">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link">Trước</a>
            </li>
            <li class="page-item active">
                <a class="page-link">1</a>
            </li>
            <li class="page-item">
                <a class="page-link">Sau</a>
            </li>
        </ul>
    </nav>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>