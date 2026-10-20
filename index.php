<?php require 'config.php';
$q = trim($_GET['q'] ?? '');
$st = db()->prepare('SELECT * FROM songs WHERE title LIKE ? OR artist LIKE ? ORDER BY id DESC');
$st->execute(["%$q%", "%$q%"]); $songs = $st->fetchAll();
head('Sóng - Nghe nhạc trực tuyến'); ?>
<h1>Nghe gì hôm nay?</h1>
<form class="search"><input name="q" value="<?= e($q) ?>" placeholder="Tìm bài hát hoặc nghệ sĩ"><button>Tìm</button></form>
<?php if (!$songs): ?><p class="empty">Không tìm thấy bài nào. Thử từ khóa khác nhé.</p><?php endif; ?>
<ol class="tracks"><?php foreach ($songs as $s): ?>
<li><button class="track" data-src="<?= e($s['file_path']) ?>" data-title="<?= e($s['title']) ?>" data-artist="<?= e($s['artist']) ?>">
<span class="t"><b><?= e($s['title']) ?></b><small><?= e($s['artist']) ?></small></span><span class="go">Phát</span></button></li>
<?php endforeach; ?></ol>
<?php foot(true);
