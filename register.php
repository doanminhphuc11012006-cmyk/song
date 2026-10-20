<?php require 'config.php'; $err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $n = trim($_POST['name'] ?? ''); $m = trim($_POST['email'] ?? ''); $p = $_POST['password'] ?? '';
    if ($n === '' || !filter_var($m, FILTER_VALIDATE_EMAIL) || strlen($p) < 6) $err = 'Nhập đủ tên, email hợp lệ và mật khẩu từ 6 ký tự.';
    else {
        $c = db()->prepare('SELECT 1 FROM users WHERE email=?'); $c->execute([$m]);
        if ($c->fetch()) $err = 'Email này đã được đăng ký.';
        else {
            $role = db()->query('SELECT COUNT(*) FROM users')->fetchColumn() == 0 ? 'admin' : 'user'; // người đầu tiên là admin
            db()->prepare('INSERT INTO users(name,email,password,role) VALUES(?,?,?,?)')->execute([$n, $m, password_hash($p, PASSWORD_DEFAULT), $role]);
            header('Location: login.php'); exit;
        }
    }
}
head('Đăng ký - Sóng'); ?>
<h1>Tạo tài khoản</h1><?php if ($err): ?><p class="err"><?= e($err) ?></p><?php endif; ?>
<form method="post" class="box"><input name="name" placeholder="Tên hiển thị" required>
<input name="email" type="email" placeholder="Email" required><input name="password" type="password" placeholder="Mật khẩu (từ 6 ký tự)" required>
<button>Đăng ký</button></form><?php foot();
