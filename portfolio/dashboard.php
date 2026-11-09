<?php require_once 'includes/init.php'; require_login();
$u=current_user(); $msgs=[];
if ($u['role']==='admin') {
  if ($_SERVER['REQUEST_METHOD']==='POST' && csrf_ok() && isset($_POST['delete'])) {
    db()->prepare('DELETE FROM messages WHERE id=?')->execute([(int)$_POST['delete']]);
    header('Location: dashboard.php'); exit;
  }
  $msgs=db()->query('SELECT * FROM messages ORDER BY id DESC')->fetchAll();
}
$page='dashboard'; $title='Dashboard'; require 'includes/header.php'; ?>
<section class="dash">
  <div class="dash-head">
    <div>
      <p class="section-tag"><?= $u['role']==='admin' ? 'Admin' : 'Member' ?></p>
      <h1>Hi, <?= h(explode(' ',$u['name'])[0]) ?>!</h1>
      <p><?= h($u['email']) ?></p>
    </div>
    <a href="logout.php" class="btn btn-outline"><i class="fas fa-sign-out-alt"></i> Log out</a>
  </div>
<?php if ($u['role']==='admin'): ?>
  <h2>Messages (<?= count($msgs) ?>)</h2>
  <?php if (!$msgs): ?><p class="empty">No messages yet. They will appear here when someone uses the contact form.</p><?php endif; ?>
  <div class="msg-list">
  <?php foreach ($msgs as $m): ?>
    <article class="msg">
      <div class="msg-head"><strong><?= h($m['name']) ?></strong><a href="mailto:<?= h($m['email']) ?>"><?= h($m['email']) ?></a><?php if ($m['phone']): ?><span class="empty"><?= h($m['phone']) ?></span><?php endif; ?><time><?= h($m['created_at']) ?></time></div>
      <p><?= nl2br(h($m['message'])) ?></p>
      <form method="post"><?= csrf_field() ?><button name="delete" value="<?= (int)$m['id'] ?>" class="link-btn" onclick="return confirm('Delete this message?')"><i class="fas fa-trash"></i> Delete</button></form>
    </article>
  <?php endforeach; ?>
  </div>
<?php else: ?>
  <p class="empty">You're logged in. Browse the <a href="projects.php" style="color:var(--accent)">projects</a> or <a href="contact.php" style="color:var(--accent)">send me a message</a>.</p>
<?php endif; ?>
</section>
<?php require 'includes/footer.php'; ?>
