<?php require_once __DIR__ . '/init.php';
$page = $page ?? ''; $title = $title ?? 'Christian Pertez';
$nav = ['index'=>'Home','about'=>'About','skills'=>'Skills','projects'=>'Projects','contact'=>'Contact'];
$u = current_user();
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= h($title) ?> — Christian Pertez</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="page-<?= h($page) ?>">
<header>
  <nav class="navbar">
    <a class="logo-container" href="index.php">
      <img src="image/pogi.jpg" alt="Logo" class="logo-img">
      <span class="logo">Christian Pertez</span>
    </a>
    <button class="hamburger" aria-label="Toggle menu" aria-expanded="false"><span></span><span></span><span></span></button>
    <ul class="nav-links">
      <?php foreach ($nav as $key => $label): ?>
        <li><a href="<?= $key ?>.php" class="<?= $page === $key ? 'active' : '' ?>"><?= $label ?></a></li>
      <?php endforeach; ?>
      <li><?php if ($u): ?>
        <a href="dashboard.php" class="nav-cta <?= $page === 'dashboard' ? 'active' : '' ?>"><i class="fas fa-user"></i> <?= h(explode(' ', $u['name'])[0]) ?></a>
      <?php else: ?>
        <a href="login.php" class="nav-cta <?= $page === 'login' ? 'active' : '' ?>">Log in</a>
      <?php endif; ?></li>
    </ul>
  </nav>
</header>
