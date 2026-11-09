<?php require_once 'includes/init.php';
$e=[]; $ok=false; $v=['first'=>'','last'=>'','email'=>'','phone'=>'','message'=>''];
if ($_SERVER['REQUEST_METHOD']==='POST') {
  foreach ($v as $k=>$_) $v[$k]=trim($_POST[$k] ?? '');
  if (!csrf_ok()) $e['form']='Session expired. Reload the page and try again.';
  if ($v['first']==='') $e['first']='Please enter your first name.';
  if ($v['last']==='') $e['last']='Please enter your last name.';
  if (!filter_var($v['email'],FILTER_VALIDATE_EMAIL)) $e['email']='Please enter a valid email.';
  if ($v['message']==='') $e['message']='Please write a message.';
  if (!$e) {
    db()->prepare('INSERT INTO messages(name,email,phone,message) VALUES(?,?,?,?)')
       ->execute([$v['first'].' '.$v['last'],$v['email'],$v['phone'],$v['message']]);
    $ok=true; $v=array_map(fn($x)=>'',$v);
  }
}
$cls=fn($k)=>isset($e[$k]) ? 'invalid' : '';
$page='contact'; $title='Contact'; require 'includes/header.php'; ?>
<section class="contact-section">
  <div class="contact-container">
    <div class="contact-left">
      <p class="section-tag">Let's connect</p>
      <h1>Contact Me</h1>
      <p>Feel free to use the form or send me an email. I'm open for projects, collaborations, and opportunities.</p>
      <div class="contact-info">
        <div class="contact-item"><div class="contact-item-icon"><i class="fas fa-phone"></i></div><span>0981-397-0800</span></div>
        <div class="contact-item"><div class="contact-item-icon"><i class="fas fa-envelope"></i></div><span>christianpertez23@gmail.com</span></div>
        <div class="contact-item"><div class="contact-item-icon"><i class="fas fa-map-marker-alt"></i></div><span>Valenzuela City, Philippines</span></div>
      </div>
      <div class="social-icons">
        <a href="https://www.facebook.com/share/1LwrBkQ3hE/" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="https://www.instagram.com/chrstn_prtz" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="https://www.tiktok.com/@tiaa4n" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
      </div>
    </div>
    <div class="contact-right">
      <form method="post" novalidate>
        <?= csrf_field() ?>
        <?php if ($ok): ?><p class="alert ok">✓ Message sent! I'll get back to you soon.</p><?php endif; ?>
        <?php if (isset($e['form'])): ?><p class="alert err"><?= h($e['form']) ?></p><?php endif; ?>
        <div class="row">
          <div class="form-group"><label for="first">First Name</label><input id="first" name="first" value="<?= h($v['first']) ?>" placeholder="Juan" class="<?= $cls('first') ?>"><span class="form-error"><?= h($e['first'] ?? '') ?></span></div>
          <div class="form-group"><label for="last">Last Name</label><input id="last" name="last" value="<?= h($v['last']) ?>" placeholder="Dela Cruz" class="<?= $cls('last') ?>"><span class="form-error"><?= h($e['last'] ?? '') ?></span></div>
        </div>
        <div class="form-group"><label for="email">Email</label><input type="email" id="email" name="email" value="<?= h($v['email']) ?>" placeholder="juan@example.com" class="<?= $cls('email') ?>"><span class="form-error"><?= h($e['email'] ?? '') ?></span></div>
        <div class="form-group"><label for="phone">Phone <span style="color:var(--text-dim);font-weight:400;text-transform:none">(optional)</span></label><input id="phone" name="phone" value="<?= h($v['phone']) ?>" placeholder="+63 912 345 6789"></div>
        <div class="form-group"><label for="message">Message</label><textarea id="message" name="message" placeholder="Tell me about your project or opportunity..." class="<?= $cls('message') ?>"><?= h($v['message']) ?></textarea><span class="form-error"><?= h($e['message'] ?? '') ?></span></div>
        <button type="submit" class="btn btn-primary submit-btn"><i class="fas fa-paper-plane"></i> Send Message</button>
      </form>
    </div>
  </div>
</section>
<?php require 'includes/footer.php'; ?>
