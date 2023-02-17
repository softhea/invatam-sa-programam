<?php
include 'views/header.html.php';
include 'views/menu.html.php';
?>

<?php if ($error !== ''): ?>
	<p><?=$error?></p>
<?php endif; ?>

<?php if ($message !== ''): ?>
	<p><?=$message?></p>
<?php endif; ?>

<h1>Invatam Sa Programam</h1>

<h3>PHP & MySQL</h3>

<p>HTML</p>

<p>JavaScript</p>

<p>CSS</p>

<?php
include 'views/footer.html.php';
?>