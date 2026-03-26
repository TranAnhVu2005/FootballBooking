<?php include __DIR__ . "/../partials/header.php" ?>
<main class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <form method="POST" action="/register" class="card p-4 mt-5">
                <?= csrf_field() ?>
                <h3 class="text-center fw-bold mb-4">Đăng ký</h3>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger rounded-3">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="fullname" class="form-label fw-semibold">Họ và tên</label>
                    <input type="text" id="fullname" name="fullname"
                        class="form-control <?= isset($errors['fullname']) ? 'is-invalid' : '' ?>"
                        placeholder="Nhập họ và tên"
                        value="<?= htmlspecialchars($old['fullname'] ?? '') ?>">
                    <?php if (isset($errors['fullname'])): ?>
                        <div class="invalid-feedback"><?= htmlspecialchars($errors['fullname']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" id="email" name="email"
                        class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                        placeholder="Nhập email"
                        value="<?= htmlspecialchars($old['email'] ?? '') ?>">
                    <?php if (isset($errors['email'])): ?>
                        <div class="invalid-feedback"><?= htmlspecialchars($errors['email']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label fw-semibold">Số điện thoại</label>
                    <input type="tel" id="phone" name="phone"
                        class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>"
                        placeholder="Nhập số điện thoại"
                        value="<?= htmlspecialchars($old['phone'] ?? '') ?>">
                    <?php if (isset($errors['phone'])): ?>
                        <div class="invalid-feedback"><?= htmlspecialchars($errors['phone']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Mật khẩu</label>
                    <input type="password" id="password" name="password"
                        class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                        placeholder="Nhập mật khẩu">
                    <?php if (isset($errors['password'])): ?>
                        <div class="invalid-feedback"><?= htmlspecialchars($errors['password']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label for="confirm_password" class="form-label fw-semibold">Xác nhận mật khẩu</label>
                    <input type="password" id="confirm_password" name="confirm_password"
                        class="form-control <?= isset($errors['password_confirmation']) ? 'is-invalid' : '' ?>"
                        placeholder="Nhập lại mật khẩu">
                    <?php if (isset($errors['password_confirmation'])): ?>
                        <div class="invalid-feedback"><?= htmlspecialchars($errors['password_confirmation']) ?></div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold">Đăng ký</button>

                <p class="text-center text-muted mb-0 mt-3">Đã có tài khoản?
                    <a href="/login" class="fw-bold text-success text-decoration-none ms-1">Đăng nhập tại đây</a>
                </p>
            </form>
        </div>
    </div>
</main>
<?php include __DIR__ . "/../partials/footer.php" ?>