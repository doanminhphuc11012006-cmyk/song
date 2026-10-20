<?php require 'config.php'; $err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $s = db()->prepare('SELECT * FROM users WHERE email=?'); $s->execute([trim($_POST['email'] ?? '')]); $u = $s->fetch();
    if ($u && password_verify($_POST['password'] ?? '', $u['password'])) {
        session_regenerate_id(true);
        $_SESSION['u'] = ['id' => $u['id'], 'name' => $u['name'], 'role' => $u['role']];
        header('Location: index.php'); exit;
    }
    $err = 'Sai email hoặc mật khẩu.';
}
head('Đăng nhập - Sóng'); ?>
<h1>Đăng nhập</h1><?php if ($err): ?><p class="err"><?= e($err) ?></p><?php endif; ?>
<form method="post" class="box"><input name="email" type="email" placeholder="Email" required>
<input name="password" type="password" placeholder="Mật khẩu" required><button>Đăng nhập</button></form><?php foot();
