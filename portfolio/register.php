<?php require_once 'includes/init.php';
if (current_user()) { header('Location: dashboard.php'); exit; }
$e=[]; $v=['name'=>'','email'=>''];
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $v['name']=trim($_POST['name'] ?? ''); $v['email']=trim($_POST['email'] ?? '');
  $pw=$_POST['password'] ?? ''; $pw2=$_POST['password2'] ?? '';
  if (!csrf_ok()) $e['form']='Session expired. Reload the page and try again.';
  if ($v['name']==='') $e['name']='Please enter your name.';
  if (!filter_var($v['email'],FILTER_VALIDATE_EMAIL)) $e['email']='Please enter a valid email.';
  if (strlen($pw)<8) $e['password']='Use at least 8 characters.';
  if ($pw!==$pw2) $e['password2']='Passwords do not match.';
  if (!$e) {
    $pdo=db(); $st=$pdo->prepare('SELECT 1 FROM users WHERE email=?'); $st->execute([$v['email']]);
    if ($st->fetch()) $e['email']='That email is already registered.';
    else {
      $role = ((int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn()===0) ? 'admin' : 'user'; // first account = admin
      $pdo->prepare('INSERT INTO users(name,email,password,role) VALUES(?,?,?,?)')->execute([$v['name'],$v['email'],password_hash($pw,PASSWORD_DEFAULT),$role]);
      session_regenerate_id(true);
      $_SESSION['user']=['id'=>(int)$pdo->lastInsertId(),'name'=>$v['name'],'email'=>$v['email'],'role'=>$role];
      header('Location: dashboard.php'); exit;
    }
  }
}
$cls=fn($k)=>isset($e[$k]) ? 'invalid' : '';
$page='login'; $title='Create account'; require 'includes/header.php'; ?>
<section class="auth-section">
  <div class="auth-card">
    <p class="section-tag">Members area</p>
    <h1>Create account</h1>
    <p class="sub">It only takes a few seconds.</p>
    <form method="post" novalidate>
      <?= csrf_field() ?>
      <?php if (isset($e['form'])): ?><p class="alert err"><?= h($e['form']) ?></p><?php endif; ?>
      <div class="form-group"><label for="name">Name</label><input id="name" name="name" value="<?= h($v['name']) ?>" class="<?= $cls('name') ?>" required autofocus><span class="form-error"><?= h($e['name'] ?? '') ?></span></div>
      <div class="form-group"><label for="email">Email</label><input type="email" id="email" name="email" value="<?= h($v['email']) ?>" class="<?= $cls('email') ?>" required><span class="form-error"><?= h($e['email'] ?? '') ?></span></div>
      <div class="form-group"><label for="password">Password</label>
        <span class="pw"><input type="password" id="password" name="password" autocomplete="new-password" class="<?= $cls('password') ?>" required><button type="button" class="pw-toggle" aria-label="Show password"><i class="fas fa-eye"></i></button></span><span class="form-error"><?= h($e['password'] ?? '') ?></span></div>
      <div class="form-group"><label for="password2">Confirm password</label><input type="password" id="password2" name="password2" autocomplete="new-password" class="<?= $cls('password2') ?>" required><span class="form-error"><?= h($e['password2'] ?? '') ?></span></div>
      <button class="btn btn-primary" type="submit">Create account</button>
      <p class="auth-alt">Already registered? <a href="login.php">Log in</a></p>
    </form>
  </div>
</section>
<?php require 'includes/footer.php'; ?>
