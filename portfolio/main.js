(() => {
  const $ = (s, r = document) => r.querySelector(s), $$ = (s, r = document) => [...r.querySelectorAll(s)];

  // ── Mobile nav ──
  const ham = $('.hamburger'), links = $('.nav-links');
  if (ham && links) {
    const set = o => { ham.classList.toggle('open', o); links.classList.toggle('open', o); ham.setAttribute('aria-expanded', o); };
    ham.addEventListener('click', () => set(!ham.classList.contains('open')));
    $$('a', links).forEach(a => a.addEventListener('click', () => set(false)));
  }

  // ── Custom cursor (mouse devices only) ──
  const dot = $('.cursor-dot'), ring = $('.cursor-ring'), root = document.documentElement;
  if (dot && ring && matchMedia('(hover:hover) and (pointer:fine)').matches) {
    root.classList.add('has-cursor');
    let mx = innerWidth / 2, my = innerHeight / 2, rx = mx, ry = my;
    const still = matchMedia('(prefers-reduced-motion: reduce)').matches;
    addEventListener('mousemove', e => {
      mx = e.clientX; my = e.clientY; root.classList.add('cursor-on');
      dot.style.transform = `translate3d(${mx}px,${my}px,0)`;
    });
    (function loop() {
      rx += (mx - rx) * (still ? 1 : 0.18); ry += (my - ry) * (still ? 1 : 0.18);
      ring.style.transform = `translate3d(${rx}px,${ry}px,0)`;
      requestAnimationFrame(loop);
    })();
    const clickable = 'a,button,.btn,.skill-card,.project-card,.gallery-img,.project-images img,.single-project img,.close,.close-video,.pw-toggle,label,.hamburger';
    document.addEventListener('mouseover', e => {
      ring.classList.toggle('hover', !!e.target.closest(clickable));
      root.classList.toggle('cursor-hide', !!e.target.closest('input,textarea,video'));
    });
    addEventListener('mousedown', () => ring.classList.add('down'));
    addEventListener('mouseup', () => ring.classList.remove('down'));
    document.addEventListener('mouseleave', () => root.classList.remove('cursor-on'));
    document.addEventListener('mouseenter', () => root.classList.add('cursor-on'));
  }

  // ── Typewriter (home) ──
  const tw = $('#typewriter');
  if (tw) {
    const phrases = ['IT Student', 'Aspiring Game Developer', 'Creative Coder', 'Web Enthusiast'];
    const text = document.createTextNode(''), caret = document.createElement('span'); caret.className = 'cursor';
    tw.append(text, caret);
    let p = 0, c = 0, del = false;
    (function tick() {
      const w = phrases[p]; text.nodeValue = w.slice(0, c);
      if (!del && c === w.length) { del = true; return setTimeout(tick, 1400); }
      if (del && c === 0) { del = false; p = (p + 1) % phrases.length; }
      c += del ? -1 : 1; setTimeout(tick, del ? 40 : 80);
    })();
  }

  // ── Demo reel modal (home) ──
  const vm = $('#videoModal'), vid = $('#demoVideo'), openBtn = $('#openVideo');
  if (vm && openBtn) {
    const close = () => { vm.classList.remove('show'); vid.pause(); };
    openBtn.addEventListener('click', () => { vm.classList.add('show'); vid.currentTime = 0; vid.play().catch(() => {}); });
    $('.close-video').addEventListener('click', close);
    vm.addEventListener('click', e => { if (e.target === vm) close(); });
    addEventListener('keydown', e => { if (e.key === 'Escape') close(); });
  }

  // ── Image lightbox (About + Digital Art) ──
  const im = $('#imageModal'), big = $('#modalImg');
  if (im && big) {
    const close = () => { im.classList.remove('show'); big.removeAttribute('src'); };
    $$('.gallery-img').forEach(i => i.addEventListener('click', () => { big.src = i.src; im.classList.add('show'); }));
    $('.close', im).addEventListener('click', close);
    im.addEventListener('click', e => { if (e.target === im) close(); });
    addEventListener('keydown', e => { if (e.key === 'Escape') close(); });
  }

  // ── Skill rings ──
  const rings = $$('.ring-fill');
  if (rings.length) {
    const C = 2 * Math.PI * 36;
    const io = new IntersectionObserver(es => es.forEach(e => {
      if (!e.isIntersecting) return;
      e.target.style.strokeDashoffset = C * (1 - e.target.dataset.percent / 100); io.unobserve(e.target);
    }), { threshold: 0.4 });
    rings.forEach(r => io.observe(r));
  }

  // ── Project card reveal ──
  const cards = $$('.reveal-on');
  if (cards.length) {
    const io = new IntersectionObserver(es => es.forEach((e, i) => {
      if (!e.isIntersecting) return;
      setTimeout(() => e.target.classList.add('in'), i * 90); io.unobserve(e.target);
    }), { threshold: 0.1 });
    cards.forEach(c => io.observe(c));
  }

  // ── Show / hide password ──
  $$('.pw-toggle').forEach(b => b.addEventListener('click', () => {
    const i = b.previousElementSibling, show = i.type === 'password';
    i.type = show ? 'text' : 'password'; b.firstElementChild.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
  }));
})();
