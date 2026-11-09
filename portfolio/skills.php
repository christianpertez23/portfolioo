<?php $page='skills'; $title='Skills'; require 'includes/header.php';
$skills=['Communication'=>90,'Teamwork'=>85,'Problem Solving'=>80,'Adaptability'=>75,'Creativity'=>70,'Critical Thinking'=>85]; ?>
<section class="skills-section">
  <h1 class="skills-title">My Skills</h1>
  <div class="skills-container">
    <div class="skills-image"><img src="image/chano.jpg" alt="Christian Pertez"></div>
    <div class="skills-grid">
      <?php foreach ($skills as $name => $pct): ?>
      <div class="skill-card">
        <div class="skill-ring-wrap">
          <svg viewBox="0 0 90 90"><circle class="ring-bg" cx="45" cy="45" r="36"/><circle class="ring-fill" cx="45" cy="45" r="36" data-percent="<?= $pct ?>"/></svg>
          <div class="ring-label"><?= $pct ?>%</div>
        </div>
        <p><?= $name ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php require 'includes/footer.php'; ?>
