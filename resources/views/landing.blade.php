<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Your Connection</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500;700&display=swap');

  *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

  :root {
    --bg: #07090c;
    --panel: #0e1218;
    --panel-2: #121822;
    --line: #1e2733;
    --text: #e8edf4;
    --muted: #7d8b9e;
    --accent: #43e5a0;
    --accent-dim: #1f7a58;
    --warn: #ffb454;
    --font: 'Inter', system-ui, -apple-system, sans-serif;
    --mono: 'JetBrains Mono', ui-monospace, SFMono-Regular, Menlo, monospace;
  }

  body {
    background:
      radial-gradient(900px 500px at 12% -10%, #10281f 0%, transparent 60%),
      radial-gradient(700px 500px at 95% 0%, #131c2b 0%, transparent 55%),
      var(--bg);
    color: var(--text);
    font-family: var(--font);
    min-height: 100vh;
    padding: 40px 20px 80px;
    -webkit-font-smoothing: antialiased;
  }

  .wrap { max-width: 1100px; margin: 0 auto; }

  header { margin-bottom: 32px; }
  .eyebrow {
    font-family: var(--mono);
    font-size: 11px;
    letter-spacing: .18em;
    text-transform: uppercase;
    color: var(--accent);
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 14px;
  }
  .dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: var(--accent);
    box-shadow: 0 0 0 0 rgba(67,229,160,.6);
    animation: pulse 2s infinite;
  }
  @keyframes pulse {
    0%   { box-shadow: 0 0 0 0 rgba(67,229,160,.5); }
    70%  { box-shadow: 0 0 0 9px rgba(67,229,160,0); }
    100% { box-shadow: 0 0 0 0 rgba(67,229,160,0); }
  }
  h1 { font-size: clamp(28px, 5vw, 44px); font-weight: 600; letter-spacing: -.02em; }
  .sub { color: var(--muted); margin-top: 8px; font-size: 15px; max-width: 60ch; }

  /* ---- hero strip ---- */
  .hero {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
    gap: 14px;
    margin-bottom: 34px;
  }
  .stat {
    background: linear-gradient(160deg, var(--panel-2), var(--panel));
    border: 1px solid var(--line);
    border-radius: 14px;
    padding: 18px 20px;
    position: relative;
    overflow: hidden;
  }
  .stat::after {
    content: '';
    position: absolute; inset: 0 auto auto 0;
    width: 100%; height: 1px;
    background: linear-gradient(90deg, transparent, var(--accent-dim), transparent);
    opacity: .7;
  }
  .stat .label {
    font-family: var(--mono);
    font-size: 10.5px;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--muted);
  }
  .stat .value {
    font-family: var(--mono);
    font-size: 25px;
    font-weight: 700;
    margin-top: 10px;
    word-break: break-all;
    line-height: 1.15;
  }
  .stat .value small { font-size: 13px; font-weight: 500; color: var(--muted); }
  .stat .note { margin-top: 6px; font-size: 12px; color: var(--muted); }

  /* ---- panels ---- */
  .grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 16px;
  }
  section.card {
    background: var(--panel);
    border: 1px solid var(--line);
    border-radius: 14px;
    padding: 20px 22px 8px;
  }
  section.card h2 {
    font-family: var(--mono);
    font-size: 11px;
    letter-spacing: .16em;
    text-transform: uppercase;
    color: var(--accent);
    margin-bottom: 14px;
    display: flex; align-items: center; gap: 8px;
  }
  section.card h2::after {
    content: ''; flex: 1; height: 1px; background: var(--line);
  }
  dl { display: block; }
  .row {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    gap: 16px;
    padding: 9px 0;
    border-bottom: 1px dashed rgba(30,39,51,.8);
    font-size: 13.5px;
  }
  .row:last-child { border-bottom: 0; }
  .row dt { color: var(--muted); white-space: nowrap; }
  .row dd {
    font-family: var(--mono);
    text-align: right;
    word-break: break-word;
    font-size: 12.5px;
  }
  .full { grid-column: 1 / -1; }
  .ua { font-family: var(--mono); font-size: 12px; color: var(--muted); line-height: 1.6; word-break: break-all; }

  /* ---- speed test ---- */
  .speed-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
  button {
    font-family: var(--mono);
    font-size: 12px;
    letter-spacing: .08em;
    text-transform: uppercase;
    background: var(--accent);
    color: #05130d;
    border: 0;
    border-radius: 8px;
    padding: 10px 18px;
    cursor: pointer;
    font-weight: 700;
    transition: transform .12s ease, opacity .12s ease;
  }
  button:hover { transform: translateY(-1px); }
  button:disabled { opacity: .45; cursor: progress; transform: none; }
  .bar {
    height: 6px;
    background: var(--panel-2);
    border-radius: 99px;
    overflow: hidden;
    margin: 16px 0 4px;
  }
  .bar > i {
    display: block; height: 100%; width: 0%;
    background: linear-gradient(90deg, var(--accent-dim), var(--accent));
    transition: width .25s ease;
  }
  .phase { font-family: var(--mono); font-size: 11px; color: var(--muted); }
  .pending { color: var(--muted); }
  .warn { color: var(--warn); }

  footer {
    margin-top: 34px;
    font-family: var(--mono);
    font-size: 11px;
    color: var(--muted);
    text-align: center;
    line-height: 1.8;
  }
</style>
</head>
<body>
<div class="wrap">

  <header>
    <div class="eyebrow"><span class="dot"></span> live session snapshot</div>
    <h1>Everything this page can see about you</h1>
    <p class="sub">All of it is public information your browser and network hand to every website you visit. Nothing here is stored.</p>
  </header>

  <div class="hero">
    <div class="stat">
      <div class="label">Your IP address</div>
      <div class="value">{{ $ip }}</div>
      <div class="note">{{ $ipVersion }}@if($isPrivateIp) · private/local range @endif</div>
    </div>
    <div class="stat">
      <div class="label">Your local time</div>
      <div class="value" id="clientClock">--:--:--</div>
      <div class="note" id="clientTz">detecting timezone…</div>
    </div>
    <div class="stat">
      <div class="label">Server time ({{ $serverTimezone }})</div>
      <div class="value" id="serverClock" data-epoch="{{ $unixTime }}">{{ $serverTime->format('H:i:s') }}</div>
      <div class="note">{{ $serverTime->format('D, d M Y') }}</div>
    </div>
    <div class="stat">
      <div class="label">Download speed</div>
      <div class="value" id="heroSpeed">— <small>Mbps</small></div>
      <div class="note" id="heroSpeedNote">run the test below</div>
    </div>
  </div>

  <div class="grid">

    <section class="card full">
      <h2>Internet speed</h2>
      <div class="speed-head">
        <div class="phase" id="speedPhase">Idle. The test downloads and uploads random data from this server.</div>
        <button id="runSpeed" type="button">Run speed test</button>
      </div>
      <div class="bar"><i id="speedBar"></i></div>
      <dl>
        <div class="row"><dt>Download</dt><dd id="dlSpeed" class="pending">not measured</dd></div>
        <div class="row"><dt>Upload</dt><dd id="ulSpeed" class="pending">not measured</dd></div>
        <div class="row"><dt>Latency (median of 8 pings)</dt><dd id="latency" class="pending">not measured</dd></div>
        <div class="row"><dt>Jitter</dt><dd id="jitter" class="pending">not measured</dd></div>
        <div class="row"><dt>Browser-reported link</dt><dd id="netInfo" class="pending">unavailable</dd></div>
      </dl>
    </section>

    <section class="card">
      <h2>Network &amp; request</h2>
      <dl>
        <div class="row"><dt>IP address</dt><dd>{{ $ip }}</dd></div>
        @if(count($ips) > 1)
        <div class="row"><dt>Proxy chain</dt><dd>{{ implode(' → ', $ips) }}</dd></div>
        @endif
        @if($forwardedFor)
        <div class="row"><dt>X-Forwarded-For</dt><dd>{{ $forwardedFor }}</dd></div>
        @endif
        <div class="row"><dt>Protocol</dt><dd>{{ $protocol }}</dd></div>
        <div class="row"><dt>Connection</dt><dd>{{ $isSecure ? 'HTTPS (encrypted)' : 'HTTP (plain)' }}</dd></div>
        <div class="row"><dt>Host</dt><dd>{{ $host }}:{{ $port }}</dd></div>
        <div class="row"><dt>Referrer</dt><dd>{{ $referrer ?: 'none' }}</dd></div>
        <div class="row"><dt>Do Not Track</dt><dd>{{ $doNotTrack ?: 'not set' }}</dd></div>
        <div class="row"><dt>Online right now</dt><dd id="onlineState">checking…</dd></div>
      </dl>
    </section>

    <section class="card">
      <h2>Device &amp; browser</h2>
      <dl>
        <div class="row"><dt>Browser</dt><dd>{{ $browser }}</dd></div>
        <div class="row"><dt>Operating system</dt><dd>{{ $os }}</dd></div>
        <div class="row"><dt>Device type</dt><dd>{{ $deviceType }}</dd></div>
        <div class="row"><dt>Looks like a bot</dt><dd>{{ $isBot ? 'yes' : 'no' }}</dd></div>
        <div class="row"><dt>Platform</dt><dd id="platform">—</dd></div>
        <div class="row"><dt>CPU cores</dt><dd id="cores">—</dd></div>
        <div class="row"><dt>Device memory</dt><dd id="memory">—</dd></div>
        <div class="row"><dt>Touch points</dt><dd id="touch">—</dd></div>
        <div class="row"><dt>GPU</dt><dd id="gpu">—</dd></div>
      </dl>
    </section>

    <section class="card">
      <h2>Screen &amp; display</h2>
      <dl>
        <div class="row"><dt>Screen resolution</dt><dd id="screenRes">—</dd></div>
        <div class="row"><dt>Available screen</dt><dd id="availRes">—</dd></div>
        <div class="row"><dt>Browser viewport</dt><dd id="viewport">—</dd></div>
        <div class="row"><dt>Pixel ratio</dt><dd id="dpr">—</dd></div>
        <div class="row"><dt>Colour depth</dt><dd id="colorDepth">—</dd></div>
        <div class="row"><dt>Orientation</dt><dd id="orientation">—</dd></div>
        <div class="row"><dt>Colour scheme</dt><dd id="scheme">—</dd></div>
        <div class="row"><dt>Reduced motion</dt><dd id="reducedMotion">—</dd></div>
      </dl>
    </section>

    <section class="card">
      <h2>Time &amp; locale</h2>
      <dl>
        <div class="row"><dt>Your timezone</dt><dd id="tzName">—</dd></div>
        <div class="row"><dt>UTC offset</dt><dd id="tzOffset">—</dd></div>
        <div class="row"><dt>Your local date</dt><dd id="clientDate">—</dd></div>
        <div class="row"><dt>Server UTC</dt><dd>{{ $utcTime->format('Y-m-d H:i:s') }} UTC</dd></div>
        <div class="row"><dt>Unix timestamp</dt><dd id="unix">{{ $unixTime }}</dd></div>
        <div class="row"><dt>Clock drift vs server</dt><dd id="drift">—</dd></div>
        <div class="row"><dt>Browser languages</dt><dd id="langs">—</dd></div>
        <div class="row"><dt>Accept-Language</dt><dd>{{ $acceptLanguage ?: 'not sent' }}</dd></div>
      </dl>
    </section>

    <section class="card">
      <h2>Capabilities &amp; storage</h2>
      <dl>
        <div class="row"><dt>Cookies enabled</dt><dd id="cookies">—</dd></div>
        <div class="row"><dt>Local storage</dt><dd id="localStorage">—</dd></div>
        <div class="row"><dt>Storage quota</dt><dd id="quota">—</dd></div>
        <div class="row"><dt>Storage used</dt><dd id="usage">—</dd></div>
        <div class="row"><dt>Battery</dt><dd id="battery">—</dd></div>
        <div class="row"><dt>WebGL</dt><dd id="webgl">—</dd></div>
        <div class="row"><dt>Page load time</dt><dd id="loadTime">—</dd></div>
      </dl>
    </section>

    <section class="card">
      <h2>Server</h2>
      <dl>
        <div class="row"><dt>Laravel</dt><dd>{{ $laravelVersion }}</dd></div>
        <div class="row"><dt>PHP</dt><dd>{{ $phpVersion }}</dd></div>
        <div class="row"><dt>Server software</dt><dd>{{ $serverSoftware }}</dd></div>
        <div class="row"><dt>Server OS family</dt><dd>{{ $osFamily }}</dd></div>
        <div class="row"><dt>Server timezone</dt><dd>{{ $serverTimezone }}</dd></div>
      </dl>
    </section>

    <section class="card full">
      <h2>Raw user agent</h2>
      <p class="ua">{{ $userAgent ?: 'not sent' }}</p>
      <div style="height:14px"></div>
    </section>

  </div>

  <footer>
    Every value on this page comes from your own browser or the HTTP request it sent.<br>
    Nothing is logged, stored, or sent anywhere else.
  </footer>
</div>

<script>
(function () {
  const $ = (id) => document.getElementById(id);
  const set = (id, value, pending) => {
    const el = $(id);
    if (!el) return;
    el.textContent = value;
    el.classList.toggle('pending', !!pending);
  };

  /* ------------------------------------------------------------------ clocks */
  const serverEpochMs = {{ $unixTime }} * 1000;
  const pageLoadedAt = Date.now();
  const drift = pageLoadedAt - serverEpochMs;

  const pad = (n) => String(n).padStart(2, '0');

  // Server clock rendered in its own timezone by PHP; tick it forward locally.
  const serverStart = "{{ $serverTime->format('H:i:s') }}".split(':').map(Number);
  let serverSeconds = serverStart[0] * 3600 + serverStart[1] * 60 + serverStart[2];
  const serverBase = Date.now();

  function tickAll() {
    const now = new Date();
    set('clientClock', pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds()));
    set('clientDate', now.toDateString());
    set('unix', Math.floor(now.getTime() / 1000));

    const s = (serverSeconds + Math.floor((Date.now() - serverBase) / 1000)) % 86400;
    set('serverClock', pad(Math.floor(s / 3600)) + ':' + pad(Math.floor(s / 60) % 60) + ':' + pad(s % 60));
  }
  tickAll();
  setInterval(tickAll, 1000);

  /* ------------------------------------------------------------- time & locale */
  try {
    const tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
    set('tzName', tz);
    set('clientTz', tz);
  } catch (e) {
    set('tzName', 'unknown');
  }
  const offsetMin = -new Date().getTimezoneOffset();
  const sign = offsetMin >= 0 ? '+' : '-';
  set('tzOffset', 'UTC' + sign + pad(Math.floor(Math.abs(offsetMin) / 60)) + ':' + pad(Math.abs(offsetMin) % 60));
  set('drift', (Math.abs(drift) < 2000 ? 'in sync' : (drift > 0 ? '+' : '') + (drift / 1000).toFixed(1) + 's'));
  set('langs', (navigator.languages || [navigator.language]).join(', ') || 'unknown');

  /* --------------------------------------------------------- device & browser */
  set('platform', navigator.userAgentData?.platform || navigator.platform || 'unknown');
  set('cores', navigator.hardwareConcurrency ? navigator.hardwareConcurrency + ' logical' : 'not exposed');
  set('memory', navigator.deviceMemory ? '~' + navigator.deviceMemory + ' GB' : 'not exposed');
  set('touch', navigator.maxTouchPoints ?? 0);

  /* ------------------------------------------------------------------ display */
  function paintDisplay() {
    set('screenRes', screen.width + ' × ' + screen.height);
    set('availRes', screen.availWidth + ' × ' + screen.availHeight);
    set('viewport', window.innerWidth + ' × ' + window.innerHeight);
    set('dpr', window.devicePixelRatio + '×');
    set('colorDepth', screen.colorDepth + '-bit');
    set('orientation', (screen.orientation && screen.orientation.type) || (window.innerWidth > window.innerHeight ? 'landscape' : 'portrait'));
  }
  paintDisplay();
  window.addEventListener('resize', paintDisplay);

  set('scheme', matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
  set('reducedMotion', matchMedia('(prefers-reduced-motion: reduce)').matches ? 'reduced' : 'no preference');

  /* ------------------------------------------------------------------- webgl */
  try {
    const gl = document.createElement('canvas').getContext('webgl');
    if (gl) {
      const dbg = gl.getExtension('WEBGL_debug_renderer_info');
      set('webgl', gl.getParameter(gl.VERSION));
      set('gpu', dbg ? gl.getParameter(dbg.UNMASKED_RENDERER_WEBGL) : 'masked by browser');
    } else {
      set('webgl', 'unsupported');
      set('gpu', 'unavailable');
    }
  } catch (e) {
    set('webgl', 'blocked');
    set('gpu', 'unavailable');
  }

  /* -------------------------------------------------------- storage & battery */
  set('cookies', navigator.cookieEnabled ? 'yes' : 'no');
  try {
    localStorage.setItem('__probe', '1');
    localStorage.removeItem('__probe');
    set('localStorage', 'available');
  } catch (e) {
    set('localStorage', 'blocked');
  }

  const mb = (b) => b >= 1073741824 ? (b / 1073741824).toFixed(2) + ' GB' : (b / 1048576).toFixed(1) + ' MB';

  if (navigator.storage && navigator.storage.estimate) {
    navigator.storage.estimate().then((est) => {
      set('quota', est.quota ? mb(est.quota) : 'unknown');
      set('usage', est.usage != null ? mb(est.usage) : 'unknown');
    }).catch(() => {});
  } else {
    set('quota', 'not exposed');
    set('usage', 'not exposed');
  }

  if (navigator.getBattery) {
    navigator.getBattery().then((b) => {
      const paint = () => set('battery', Math.round(b.level * 100) + '% · ' + (b.charging ? 'charging' : 'on battery'));
      paint();
      b.addEventListener('levelchange', paint);
      b.addEventListener('chargingchange', paint);
    }).catch(() => set('battery', 'not exposed'));
  } else {
    set('battery', 'not exposed');
  }

  const nav = performance.getEntriesByType('navigation')[0];
  if (nav) set('loadTime', Math.round(nav.duration || nav.responseEnd) + ' ms');

  /* ------------------------------------------------------------------- online */
  function paintOnline() {
    set('onlineState', navigator.onLine ? 'yes' : 'no — offline');
  }
  paintOnline();
  window.addEventListener('online', paintOnline);
  window.addEventListener('offline', paintOnline);

  const conn = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
  if (conn) {
    const parts = [];
    if (conn.effectiveType) parts.push(conn.effectiveType);
    if (conn.downlink) parts.push(conn.downlink + ' Mbps est.');
    if (conn.rtt) parts.push(conn.rtt + ' ms rtt');
    if (conn.saveData) parts.push('data saver on');
    set('netInfo', parts.join(' · ') || 'unavailable', false);
  }

  /* --------------------------------------------------------------- speed test */
  const btn = $('runSpeed');
  const bar = $('speedBar');
  const phase = $('speedPhase');
  const token = document.querySelector('meta[name="csrf-token"]').content;

  const bust = (url) => url + (url.includes('?') ? '&' : '?') + '_=' + Math.random().toString(36).slice(2);
  const mbps = (bytes, ms) => (bytes * 8) / (ms / 1000) / 1e6;

  async function measureLatency() {
    const samples = [];
    for (let i = 0; i < 8; i++) {
      const t0 = performance.now();
      await fetch(bust('{{ route('speedtest.ping') }}'), { cache: 'no-store' });
      samples.push(performance.now() - t0);
      bar.style.width = (5 + i * 2) + '%';
    }
    samples.sort((a, b) => a - b);
    const median = samples[Math.floor(samples.length / 2)];
    const deltas = samples.slice(1).map((v, i) => Math.abs(v - samples[i]));
    const jit = deltas.reduce((a, b) => a + b, 0) / deltas.length;
    return { median, jitter: jit };
  }

  async function measureDownload() {
    // Ramp payload size so slow links don't wait on a huge file.
    let size = 500000;
    let best = 0;
    for (let i = 0; i < 3; i++) {
      const t0 = performance.now();
      const res = await fetch(bust('{{ route('speedtest.download') }}?bytes=' + size), { cache: 'no-store' });
      const blob = await res.blob();
      const ms = performance.now() - t0;
      const rate = mbps(blob.size, ms);
      best = Math.max(best, rate);
      bar.style.width = (25 + i * 15) + '%';
      if (ms < 1200) size = Math.min(size * 4, 25000000); else break;
    }
    return best;
  }

  async function measureUpload() {
    const payload = new Uint8Array(2000000);
    crypto.getRandomValues(payload.subarray(0, 65536));
    const t0 = performance.now();
    await fetch('{{ route('speedtest.upload') }}', {
      method: 'POST',
      cache: 'no-store',
      headers: { 'Content-Type': 'application/octet-stream', 'X-CSRF-TOKEN': token },
      body: payload,
    });
    return mbps(payload.byteLength, performance.now() - t0);
  }

  btn.addEventListener('click', async () => {
    btn.disabled = true;
    bar.style.width = '2%';
    ['dlSpeed', 'ulSpeed', 'latency', 'jitter'].forEach((id) => set(id, 'measuring…', true));

    try {
      phase.textContent = 'Measuring latency…';
      const { median, jitter } = await measureLatency();
      set('latency', median.toFixed(1) + ' ms');
      set('jitter', jitter.toFixed(1) + ' ms');

      phase.textContent = 'Measuring download…';
      const dl = await measureDownload();
      set('dlSpeed', dl.toFixed(2) + ' Mbps');
      $('heroSpeed').innerHTML = dl.toFixed(1) + ' <small>Mbps</small>';
      $('heroSpeedNote').textContent = 'measured against this server';
      bar.style.width = '70%';

      phase.textContent = 'Measuring upload…';
      const ul = await measureUpload();
      set('ulSpeed', ul.toFixed(2) + ' Mbps');

      bar.style.width = '100%';
      phase.textContent = 'Done. Results reflect the path between you and this server only.';
    } catch (e) {
      phase.innerHTML = '<span class="warn">Test failed: ' + e.message + '</span>';
      bar.style.width = '0%';
    } finally {
      btn.disabled = false;
    }
  });
})();
</script>
</body>
</html>
