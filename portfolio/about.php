<?php $page='about'; $title='About'; require 'includes/header.php';
$loves=[['Playing guitar','🎸'],['Basketball','🏀'],['Online games','🎮'],['Photography','📸'],['Cooking','🍳'],['Watching movies','🎬'],['Swimming','🏊'],['Lifting weights','🏋️'],['Adventure','🌍']]; ?>
<section class="about-page">
  <h1 class="about-title">About Me</h1>
  <div class="about-container">
    <div class="about-images">
      <?php foreach (['adventure','swimming','food'] as $i): ?><img src="image/<?= $i ?>.jpg" alt="<?= ucfirst($i) ?>" class="gallery-img"><?php endforeach; ?>
    </div>
    <div class="about-text">
      <h2>Things I Love</h2>
      <ul><?php foreach ($loves as [$t,$e]): ?><li><?= $t ?> <?= $e ?></li><?php endforeach; ?></ul>
    </div>
    <div class="about-images">
      <?php foreach (['basketball','photograher','guitar'] as $i): ?><img src="image/<?= $i ?>.jpg" alt="<?= ucfirst($i) ?>" class="gallery-img"><?php endforeach; ?>
    </div>
  </div>
</section>

<section class="vision-mission">
  <div class="vm-container">
    <div class="vm-box">
      <h2><i class="fas fa-eye"></i> Vision</h2>
      <p>To become a successful IT professional who creates innovative and useful systems that improve everyday life.</p>
      <p>To achieve financial stability while continuously growing in knowledge and skills.</p>
    </div>
    <div class="vm-box">
      <h2><i class="fas fa-bullseye"></i> Mission</h2>
      <p>To finish my IT degree with dedication and strong commitment.</p>
      <p>To continuously improve my technical and problem-solving skills.</p>
      <p>To build a stable and successful career in the technology industry.</p>
      <p>To achieve personal and financial growth through hard work and perseverance.</p>
    </div>
  </div>
</section>

<div id="imageModal" class="modal"><span class="close">&times;</span><img class="modal-content" id="modalImg" alt=""></div>
<?php require 'includes/footer.php'; ?>
