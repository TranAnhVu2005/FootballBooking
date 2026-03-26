<?php include __DIR__ . "/../partials/header.php" ?>
<style>
    .admin-wrapper { padding: 0 20px; }
    .table-container { border-radius: 16px; overflow: hidden; }
</style>
<div class="admin-wrapper py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success mb-0">Bảng Quản Trị</h3>
        <span class="badge bg-danger fs-6">ADMIN</span>
    </div>

    <?php if (!empty($messages['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($messages['success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 table-container">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold">Danh sách người dùng</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                    <thead class="table-light">
                        <tr>
                            <th>Họ tên</th>
                            <th>Vai trò</th>
                            <th>Trạng thái</th>
                            <th class="text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($u->fullname) ?></strong><br>
                                <span class="text-muted" style="font-size: 0.75rem;"><?= htmlspecialchars($u->email) ?></span>
                            </td>
                            <td>
                                <?php if ($u->role === 'ADMIN'): ?>
                                    <span class="badge bg-primary">ADMIN</span>
                                <?php elseif ($u->role === 'OWNER'): ?>
                                    <span class="badge bg-warning text-dark">Chủ sân</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Người dùng</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($u->status === 'ACTIVE'): ?>
                                    <span class="badge bg-success">Hoạt động</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Khóa</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end d-flex gap-1 justify-content-end flex-wrap">
                                <?php if ($u->role !== 'ADMIN'): ?>

                                    <?php if ($u->role === 'OWNER'): ?>
                                        <!-- Thu hồi quyền chủ sân -->
                                        <form action="/admin/users/revoke-owner" method="POST" class="d-inline"
                                            onsubmit="return confirm('Thu hồi quyền Chủ sân của <?= htmlspecialchars($u->fullname, ENT_QUOTES) ?>?');">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="user_id" value="<?= $u->userId ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-warning py-0 px-2" style="font-size: 0.75rem;">
                                                <i class="bi bi-building-dash"></i> Thu hồi chủ sân
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <!-- Cấp quyền chủ sân -->
                                        <form action="/admin/users/set-owner" method="POST" class="d-inline"
                                            onsubmit="return confirm('Cấp quyền Chủ sân cho <?= htmlspecialchars($u->fullname, ENT_QUOTES) ?>?');">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="user_id" value="<?= $u->userId ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-success py-0 px-2" style="font-size: 0.75rem;">
                                                <i class="bi bi-building-add"></i> Cấp chủ sân
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <?php if ($u->status === 'ACTIVE'): ?>
                                        <form action="/admin/users/deactivate" method="POST" class="d-inline"
                                            onsubmit="return confirm('Khóa tài khoản <?= htmlspecialchars($u->fullname, ENT_QUOTES) ?>?');">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="user_id" value="<?= $u->userId ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2" style="font-size: 0.75rem;">
                                                <i class="bi bi-lock-fill"></i> Khóa
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form action="/admin/users/activate" method="POST" class="d-inline"
                                            onsubmit="return confirm('Mở khóa tài khoản <?= htmlspecialchars($u->fullname, ENT_QUOTES) ?>?');">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="user_id" value="<?= $u->userId ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-secondary py-0 px-2" style="font-size: 0.75rem;">
                                                <i class="bi bi-unlock-fill"></i> Mở khóa
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . "/../partials/footer.php" ?>
