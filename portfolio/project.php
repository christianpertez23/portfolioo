<?php $projects = require 'includes/projects.php';
$id = (int)($_GET['id'] ?? 0);
if (!isset($projects[$id])) { header('Location: projects.php'); exit; }
$p = $projects[$id]; $page='projects'; $title=$p['title']; require 'includes/header.php';
$n = str_pad($id, 2, '0', STR_PAD_LEFT); ?>
<?php if ($p['type']==='gallery'): ?>
<div id="imageModal" class="modal"><span class="close" id="modalClose">&times;</span><img class="modal-content" id="modalImg" alt="Enlarged artwork"></div>
<?php endif; ?>

<section class="project-showcase">
  <div class="showcase-header">
    <p class="section-tag">Project <?= $n ?> — <?= implode(' &amp; ', array_map('h', $p['tags'])) ?></p>
    <h1><?= h($p['title']) ?></h1>
    <p><?= h($p['short']) ?><?= $p['type']==='gallery' ? ' Click any image to view it full size.' : '' ?></p>
  </div>

<?php if ($p['type']==='site'): ?>
  <div class="single-project"><a href="<?= h($p['link']) ?>" target="_blank" rel="noopener"><img src="<?= h($p['cover']) ?>" alt="<?= h($p['title']) ?>" title="Click to open project"></a></div>
<?php elseif ($p['type']==='videos' && count($p['videos']) > 1): ?>
  <div class="video-gallery"><?php foreach ($p['videos'] as [$v,$poster]): ?>
    <video controls preload="metadata" poster="<?= h($poster) ?>"><source src="<?= h($v) ?>" type="video/mp4"></video><?php endforeach; ?></div>
<?php elseif ($p['type']==='videos'): ?>
  <div class="single-video"><video controls preload="metadata" poster="<?= h($p['videos'][0][1]) ?>"><source src="<?= h($p['videos'][0][0]) ?>" type="video/mp4"></video></div>
<?php else: ?>
  <div class="project-images"><?php foreach ($p['images'] as $i): ?><img src="image/<?= $i ?>.jpg" alt="<?= ucfirst($i) ?> design" class="gallery-img" loading="lazy"><?php endforeach; ?></div>
<?php endif; ?>

  <div class="project-info">
    <p class="left-text"><?= h($p['left']) ?></p>
    <span class="project-title"><?= $n ?></span>
    <p class="right-text"><?= h($p['right']) ?></p>
  </div>

  <div class="project-nav">
    <?php if ($id > 1): ?><a href="project.php?id=<?= $id-1 ?>"><i class="fas fa-arrow-left"></i> Previous</a>
    <?php else: ?><a href="projects.php"><i class="fas fa-th-large"></i> All Projects</a><?php endif; ?>
    <?php if (isset($projects[$id+1])): ?><a href="project.php?id=<?= $id+1 ?>">Next Project <i class="fas fa-arrow-right"></i></a>
    <?php else: ?><a href="projects.php"><i class="fas fa-th-large"></i> All Projects</a><?php endif; ?>
  </div>
</section>
<?php require 'includes/footer.php'; ?>
