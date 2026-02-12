<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-5">
                    <h3 class="text-center fw-bold text-success mb-4">Tạo Tài Khoản Mới</h3>
                    <form>
                        <div class="row g-2 mb-3">
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingName" placeholder="Tên của bạn">
                                    <label for="floatingName">Họ và Tên</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="tel" class="form-control" id="floatingPhone" placeholder="Số điện thoại">
                                    <label for="floatingPhone">Số điện thoại</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Địa chỉ Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Mật khẩu</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingConfirmPassword" placeholder="Confirm Password">
                            <label for="floatingConfirmPassword">Xác nhận mật khẩu</label>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label small" for="terms">
                                Tôi đồng ý với <a href="#" class="text-success">Điều khoản dịch vụ</a> và <a href="#" class="text-success">Chính sách bảo mật</a>.
                            </label>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-success btn-lg fw-bold" type="button" onclick="alert('Đăng ký thành công! Hãy đăng nhập.')">Đăng Ký</button>
                        </div>
                        <hr class="my-4">
                        <div class="text-center">
                            <p class="small mb-0">Đã có tài khoản? <a href="/auth/login.php" class="text-success fw-bold text-decoration-none">Đăng nhập ngay</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>