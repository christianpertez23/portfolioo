<?php $page='index'; $title='Portfolio'; require 'includes/header.php';
$projects = require 'includes/projects.php'; ?>
<div id="videoModal" class="video-modal">
  <span class="close-video">&times;</span>
  <div class="modal-video-box"><video id="demoVideo" controls><source src="video/reel.mp4" type="video/mp4"></video></div>
</div>

<section class="hero" id="home">
  <div class="hero-text">
    <div class="hero-eyebrow">Available for work</div>
    <h1>Hello, I'm<br><span class="name-highlight">Christian</span></h1>
    <h3 id="typewriter"></h3>
    <p>A little code, a little music, a little basketball — that's my kind of balance.</p>
    <div class="hero-actions">
      <button class="btn btn-primary" id="openVideo"><i class="fas fa-play"></i> Demo Reel</button>
      <a href="contact.php" class="btn btn-outline"><i class="fas fa-envelope"></i> Get in Touch</a>
    </div>
  </div>
  <div class="hero-img"><img src="image/grad.jpg" alt="Christian Pertez"></div>
</section>

<section class="featured">
  <p class="section-tag">Portfolio</p>
  <h2>Featured Projects</h2>
  <div class="project-grid">
    <?php foreach (array_slice($projects, 0, 3, true) as $id => $p): ?>
    <div class="project-card reveal-on">
      <div class="project-card-thumb"><?= $p['emoji'] ?></div>
      <div class="project-card-body">
        <div class="project-tags"><?php foreach ($p['tags'] as $t): ?><span class="tag"><?= h($t) ?></span><?php endforeach; ?></div>
        <h3><?= h($p['title']) ?></h3>
        <p><?= h($p['short']) ?></p>
        <a href="project.php?id=<?= $id ?>" class="btn btn-outline">View Project <i class="fas fa-arrow-right"></i></a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <a href="projects.php" class="btn btn-primary">All Projects <i class="fas fa-arrow-right"></i></a>
</section>
<?php require 'includes/footer.php'; ?>
