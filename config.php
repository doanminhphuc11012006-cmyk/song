<?php
// Điền thông tin MySQL của host (InfinityFree). Chạy ở máy: host 127.0.0.1, user root, mật khẩu rỗng.
define('DB_HOST', 'sql106.infinityfree.com');
define('DB_PORT', '3306');
define('DB_NAME', 'if0_43222318_shop');
define('DB_USER', 'if0_43222318');
define('DB_PASS', 'kC64MExzQKG');
session_start();
function db(): PDO {
    static $p = null;
    if (!$p) $p = new PDO('mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME.';charset=utf8mb4', DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
    return $p;
}
function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function me() { return $_SESSION['u'] ?? null; }
function admin_only() { if (!me() || me()['role'] !== 'admin') { header('Location: login.php'); exit; } }
function csrf() { return $_SESSION['t'] ??= bin2hex(random_bytes(16)); }
function head($title) { $u = me(); ?>
<!doctype html><html lang="vi"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($title) ?></title>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css"></head><body>
<header><a class="logo" href="index.php">Sóng</a><nav>
<?php if ($u): ?><span><?= e($u['name']) ?></span>
<?php if ($u['role'] === 'admin'): ?><a href="admin.php">Quản lý bài hát</a><?php endif; ?>
<a href="logout.php">Đăng xuất</a>
<?php else: ?><a href="login.php">Đăng nhập</a><a href="register.php">Đăng ký</a><?php endif; ?>
</nav></header><main>
<?php }
function foot($player = false) { ?></main>
<?php if ($player): ?>
<div class="player"><div id="np">Chọn một bài để nghe</div>
<button id="pv" aria-label="Bài trước">&#9664;&#9664;</button>
<audio id="audio" controls></audio>
<button id="nx" aria-label="Bài sau">&#9654;&#9654;</button></div>
<script>
const a=document.getElementById('audio'),np=document.getElementById('np'),tr=[...document.querySelectorAll('.track')];let i=-1;
function play(k){if(!tr[k])return;i=k;tr.forEach(x=>x.classList.remove('on'));tr[k].classList.add('on');
a.src=tr[k].dataset.src;a.play();np.textContent=tr[k].dataset.title+' - '+tr[k].dataset.artist;}
tr.forEach((b,k)=>b.onclick=()=>play(k));a.onended=()=>play(i+1);
document.getElementById('nx').onclick=()=>play(i+1);document.getElementById('pv').onclick=()=>play(i-1);
</script><?php endif; ?></body></html>
<?php }
