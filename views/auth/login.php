<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-5">
                    <h3 class="text-center fw-bold text-success mb-4">Đăng Nhập</h3>
                    <form action="/home/index.php" method="GET">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Địa chỉ Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Mật khẩu</label>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rememberMe">
                                <label class="form-check-label small" for="rememberMe">Ghi nhớ đăng nhập</label>
                            </div>
                            <a href="#" class="small text-decoration-none text-success">Quên mật khẩu?</a>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-success btn-lg fw-bold" type="submit">Đăng Nhập</button>
                        </div>
                        <hr class="my-4">
                        <div class="text-center">
                            <p class="small mb-0">Chưa có tài khoản? <a href="/auth/register.php" class="text-success fw-bold text-decoration-none">Đăng ký ngay</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>