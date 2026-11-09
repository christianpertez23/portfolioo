<?php require_once 'includes/init.php';
if (current_user()) { header('Location: dashboard.php'); exit; }
$next = basename($_GET['next'] ?? $_POST['next'] ?? 'dashboard.php');
if (!preg_match('/^[a-z_]+\.php$/i', $next)) $next = 'dashboard.php';
$error=''; $email='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $email = trim($_POST['email'] ?? '');
  if (!csrf_ok()) $error='Session expired. Reload the page and try again.';
  else {
    $st = db()->prepare('SELECT * FROM users WHERE email = ?'); $st->execute([$email]);
    $row = $st->fetch();
    if ($row && password_verify($_POST['password'] ?? '', $row['password'])) {
      session_regenerate_id(true);
      $_SESSION['user'] = ['id'=>$row['id'],'name'=>$row['name'],'email'=>$row['email'],'role'=>$row['role']];
      header('Location: ' . $next); exit;
    }
    $error = 'Email or password is incorrect.';
  }
}
$page='login'; $title='Log in'; require 'includes/header.php'; ?>
<section class="auth-section">
  <div class="auth-card">
    <p class="section-tag">Members area</p>
    <h1>Welcome back</h1>
    <p class="sub">Log in to see your dashboard.</p>
    <form method="post" novalidate>
      <?= csrf_field() ?><input type="hidden" name="next" value="<?= h($next) ?>">
      <?php if ($error): ?><p class="alert err"><?= h($error) ?></p><?php endif; ?>
      <div class="form-group"><label for="email">Email</label><input type="email" id="email" name="email" value="<?= h($email) ?>" autocomplete="email" required autofocus></div>
      <div class="form-group"><label for="password">Password</label>
        <span class="pw"><input type="password" id="password" name="password" autocomplete="current-password" required><button type="button" class="pw-toggle" aria-label="Show password"><i class="fas fa-eye"></i></button></span></div>
      <button class="btn btn-primary" type="submit">Log in</button>
      <p class="auth-alt">No account yet? <a href="register.php">Create one</a></p>
    </form>
  </div>
</section>
<?php require 'includes/footer.php'; ?>
