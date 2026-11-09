<?php $page='projects'; $title='Projects'; require 'includes/header.php';
$projects = require 'includes/projects.php'; ?>
<section class="projects" id="projects">
  <p class="section-tag">Portfolio</p>
  <h2>My Projects</h2>
  <p class="projects-subtitle">A collection of things I've built — from web experiences to digital art.</p>
  <div class="project-grid">
    <?php foreach ($projects as $id => $p): ?>
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
</section>
<?php require 'includes/footer.php'; ?>
