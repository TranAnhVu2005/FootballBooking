<?php include __DIR__ . "/../partials/header.php" ?>
<main class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <form method="POST" action="/login" class="card p-4 mt-5">
                <?= csrf_field() ?>
                <h3 class="text-center fw-bold mb-4">Đăng nhập</h3>

                <?php if (isset($errors)): ?>
                    <div class="alert alert-danger rounded-3">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- // Hiện dòng đăng ký thành công, vui lòng đăng nhập -->
                <?php if (isset($messages['success'])): ?>
                    <div class="alert alert-success rounded-3">
                        <?= htmlspecialchars($messages['success']) ?>
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="login_id" class="form-label fw-semibold">Email hoặc Số điện thoại</label>
                    <input type="text" id="login_id" name="login_id" class="form-control"
                        placeholder="Nhập email hoặc số điện thoại" required
                        value="<?= htmlspecialchars($old['login_id'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Mật khẩu</label>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Nhập mật khẩu" required>
                </div>

                <div class="d-flex justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                        <label class="form-check-label text-muted" for="rememberMe">Nhớ đăng nhập</label>
                    </div>
                    <a href="#" class="text-success text-decoration-none fw-semibold">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold mb-3">Đăng Nhập</button>

                <p class="text-center text-muted mb-0">Bạn chưa có tài khoản?
                    <a href="/register" class="fw-bold text-success text-decoration-none ms-1">Đăng ký tại đây</a>
                </p>
            </form>
        </div>
    </div>
</main>
<?php include __DIR__ . "/../partials/footer.php" ?>