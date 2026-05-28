<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vocab Slides</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }

        /* ── Theme tokens ──────────────────────────────────────────────────── */
        :root {
            --bg-from:        #f8fafc;
            --bg-via:         #ffffff;
            --bg-to:          #f1f5f9;
            --bar-border:     #e2e8f0;
            --back-color:     #64748b;
            --back-hover:     #1e293b;
            --counter-color:  #94a3b8;
            --track-bg:       #e2e8f0;
            --summary-color:  #94a3b8;
            --card-bg:        #ffffff;
            --card-border:    #e2e8f0;
            --card-shadow:    0 4px 32px rgba(0,0,0,.08);
            --word-color:     #0f172a;
            --pronounce-fg:   #94a3b8;
            --pronounce-hov:  #6366f1;
            --divider:        #e2e8f0;
            --label-color:    #94a3b8;
            --meaning-color:  #334155;
            --sentence-color: #475569;
            --np-color:       #334155;
            --nav-bg:         #f1f5f9;
            --nav-hover:      #e2e8f0;
            --nav-border:     #e2e8f0;
            --nav-text:       #475569;
            --dot-inactive:   #cbd5e1;
            --empty-head:     #1e293b;
            --empty-sub:      #94a3b8;
            --toggle-bg:      #e2e8f0;
            --toggle-icon:    #64748b;
        }

        [data-theme="dark"] {
            --bg-from:        #0f172a;
            --bg-via:         #1e293b;
            --bg-to:          #0f172a;
            --bar-border:     rgba(255,255,255,.1);
            --back-color:     #94a3b8;
            --back-hover:     #ffffff;
            --counter-color:  #94a3b8;
            --track-bg:       rgba(255,255,255,.1);
            --summary-color:  #64748b;
            --card-bg:        rgba(255,255,255,.05);
            --card-border:    rgba(255,255,255,.1);
            --card-shadow:    none;
            --word-color:     #ffffff;
            --pronounce-fg:   #94a3b8;
            --pronounce-hov:  #818cf8;
            --divider:        rgba(255,255,255,.1);
            --label-color:    #64748b;
            --meaning-color:  #e2e8f0;
            --sentence-color: #cbd5e1;
            --np-color:       #e2e8f0;
            --nav-bg:         rgba(255,255,255,.05);
            --nav-hover:      rgba(255,255,255,.1);
            --nav-border:     rgba(255,255,255,.1);
            --nav-text:       #cbd5e1;
            --dot-inactive:   #475569;
            --empty-head:     #ffffff;
            --empty-sub:      #64748b;
            --toggle-bg:      rgba(255,255,255,.1);
            --toggle-icon:    #94a3b8;
        }

        /* ── Themed elements ───────────────────────────────────────────────── */
        body                { background: linear-gradient(135deg, var(--bg-from), var(--bg-via), var(--bg-to)); transition: background .3s; }
        .t-bar-border       { border-color: var(--bar-border); }
        .t-back             { color: var(--back-color); }
        .t-back:hover       { color: var(--back-hover); }
        .t-counter          { color: var(--counter-color); }
        .t-track            { background: var(--track-bg); }
        .t-summary          { color: var(--summary-color); }
        .t-card             { background: var(--card-bg); border-color: var(--card-border); box-shadow: var(--card-shadow); }
        .t-word             { color: var(--word-color); }
        .t-pronounce        { color: var(--pronounce-fg); }
        .t-pronounce:hover  { color: var(--pronounce-hov); }
        .t-divider          { background: var(--divider); }
        .t-label            { color: var(--label-color); }
        .t-meaning          { color: var(--meaning-color); }
        .t-sentence         { color: var(--sentence-color); }
        .t-np               { color: var(--np-color); }
        .t-nav              { color: var(--nav-text); background: var(--nav-bg); border-color: var(--nav-border); }
        .t-nav:hover:not(:disabled) { background: var(--nav-hover); }
        .t-empty-head       { color: var(--empty-head); }
        .t-empty-sub        { color: var(--empty-sub); }
        .t-toggle           { background: var(--toggle-bg); color: var(--toggle-icon); }

        /* ── Animations ────────────────────────────────────────────────────── */
        .slide-enter { animation: slideIn 0.35s ease forwards; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .detail-panel { animation: fadeIn 0.4s ease forwards; }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(.97); }
            to   { opacity: 1; transform: scale(1); }
        }

        .familiar-btn         { background: linear-gradient(135deg, #10b981, #059669); }
        .familiar-btn:hover   { background: linear-gradient(135deg, #059669, #047857); }
        .unfamiliar-btn       { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .unfamiliar-btn:hover { background: linear-gradient(135deg, #d97706, #b45309); }
        .progress-fill        { transition: width .4s ease; }

        /* smooth theme transition on key props */
        body, .t-card, .t-bar-border, .t-nav, .t-toggle {
            transition: background .25s, border-color .25s, color .25s, box-shadow .25s;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

{{-- Top bar --}}
<div class="flex items-center justify-between px-6 py-4 border-b t-bar-border">
    <a href="/unknown-words?tkn=gbwhbajwynxaoybndghamcxbghnbsawildjijnsiuhaidoiawdjiawdnawidnaklwdawd"
       class="t-back transition text-sm flex items-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back
    </a>

    <div class="flex items-center gap-3">
        <span id="counter" class="t-counter text-sm font-medium"></span>

        {{-- Theme toggle --}}
        <button id="theme-toggle" onclick="toggleTheme()" title="Toggle theme"
                class="t-toggle w-9 h-9 rounded-xl flex items-center justify-center transition">
            {{-- Sun (shown in dark mode) --}}
            <svg id="icon-sun" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
            </svg>
            {{-- Moon (shown in light mode) --}}
            <svg id="icon-moon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
            </svg>
        </button>

        <button onclick="resetAll()"
                class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-red-500/20 text-red-400 hover:bg-red-500/30 hover:text-red-300 transition border border-red-500/30">
            Reset All
        </button>
    </div>
</div>

{{-- Progress bar --}}
<div class="h-1 t-track">
    <div id="progress-fill" class="progress-fill h-full bg-indigo-500 rounded-r-full" style="width:0%"></div>
</div>

{{-- Familiarity summary --}}
<div class="flex justify-center gap-6 px-6 py-2 text-xs t-summary">
    <span>Familiar: <span id="familiar-count" class="text-emerald-400 font-semibold">0</span></span>
    <span>Unfamiliar: <span id="unfamiliar-count" class="text-amber-400 font-semibold">0</span></span>
    <span>Unseen: <span id="unseen-count" class="font-semibold">0</span></span>
</div>

{{-- Main slide area --}}
<main class="flex-1 flex flex-col items-center justify-center px-4 py-6">

    <div id="loading" class="t-summary text-lg">Loading words…</div>

    <div id="slide" class="hidden w-full max-w-2xl">

        {{-- Word card --}}
        <div id="word-card" class="t-card backdrop-blur border rounded-3xl p-10 text-center mb-6 slide-enter">

            {{-- Familiar badge --}}
            <div id="familiar-badge" class="hidden mb-4 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                Familiar
            </div>

            <h1 id="word-text" class="t-word text-5xl font-bold mb-3 tracking-tight"></h1>

            <button onclick="pronounce()" title="Pronounce"
                    class="t-pronounce transition inline-flex items-center gap-1.5 text-sm mt-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15.536 8.464a5 5 0 010 7.072M12 6v12m0 0l-3-3m3 3l3-3M9.172 16.828A4 4 0 016 13.172V10.83A4 4 0 019.172 7.172"/>
                </svg>
                Hear it again
            </button>

            {{-- Detail panel --}}
            <div id="detail-panel" class="hidden detail-panel mt-8 text-left space-y-4">
                <div class="h-px t-divider"></div>

                <div>
                    <p class="t-label text-xs uppercase tracking-widest mb-1">Meaning</p>
                    <p id="detail-meaning" class="t-meaning text-sm leading-relaxed"></p>
                </div>

                <div>
                    <p class="t-label text-xs uppercase tracking-widest mb-1">Example Sentence</p>
                    <p id="detail-sentence" class="t-sentence text-sm italic leading-relaxed"></p>
                </div>

                <div id="detail-np-wrap">
                    <p class="t-label text-xs uppercase tracking-widest mb-1">Nepali Equivalent</p>
                    <p id="detail-np" class="t-np text-sm"></p>
                </div>
            </div>
        </div>

        {{-- Action buttons --}}
        <div id="action-buttons" class="flex gap-4 justify-center mb-6">
            <button onclick="markFamiliar()"
                    class="familiar-btn text-white font-semibold px-8 py-3.5 rounded-2xl shadow-lg transition transform hover:scale-105 active:scale-95 flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                Familiar
            </button>
            <button onclick="markUnfamiliar()"
                    class="unfamiliar-btn text-white font-semibold px-8 py-3.5 rounded-2xl shadow-lg transition transform hover:scale-105 active:scale-95 flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
                Unfamiliar
            </button>
        </div>

        {{-- Navigation --}}
        <div class="flex items-center justify-between gap-4">
            <button onclick="navigate(-1)" id="prev-btn"
                    class="t-nav flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium border transition disabled:opacity-30 disabled:cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Previous
            </button>

            <div class="flex gap-1" id="dot-indicators"></div>

            <button onclick="navigate(1)" id="next-btn"
                    class="t-nav flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium border transition disabled:opacity-30 disabled:cursor-not-allowed">
                Next
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Empty state --}}
    <div id="empty-state" class="hidden text-center">
        <p class="text-4xl mb-4">🎉</p>
        <p id="empty-msg" class="t-empty-head font-semibold text-lg mb-1">No unfamiliar words left!</p>
        <p class="t-empty-sub text-sm">Hit "Reset All" to start over, or add more words.</p>
    </div>
</main>

{{-- Toast --}}
<div id="toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 hidden px-5 py-3 rounded-xl text-sm font-medium shadow-xl z-50"></div>

<script>
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;
    let words   = [];
    let current = 0;

    // ── Theme ──────────────────────────────────────────────────────────────────

    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        document.getElementById('icon-sun').classList.toggle('hidden', theme === 'light');
        document.getElementById('icon-moon').classList.toggle('hidden', theme === 'dark');
        localStorage.setItem('vocab-theme', theme);
    }

    function toggleTheme() {
        const current = document.documentElement.getAttribute('data-theme');
        applyTheme(current === 'dark' ? 'light' : 'dark');
    }

    // Apply saved theme before first paint
    applyTheme(localStorage.getItem('vocab-theme') || 'dark');

    // ── Helpers ────────────────────────────────────────────────────────────────

    function shuffle(arr) {
        for (let i = arr.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [arr[i], arr[j]] = [arr[j], arr[i]];
        }
        return arr;
    }

    // ── Fetch ──────────────────────────────────────────────────────────────────

    async function loadWords() {
        const res  = await fetch('/api/unknown_words');
        const json = await res.json();
        const all  = json.data;
        words = shuffle(all.filter(w => w.is_familiar === false));

        document.getElementById('loading').classList.add('hidden');

        if (!words.length) {
            const msg = document.getElementById('empty-msg');
            msg.textContent = all.length === 0
                ? 'No words found. Add some first!'
                : 'No unfamiliar words left!';
            document.getElementById('empty-state').classList.remove('hidden');
            return;
        }

        document.getElementById('slide').classList.remove('hidden');
        buildDots();
        showSlide(0, false);
    }

    // ── Slide rendering ────────────────────────────────────────────────────────

    function showSlide(index, animate = true) {
        current = Math.max(0, Math.min(index, words.length - 1));
        const w = words[current];

        if (animate) {
            const card = document.getElementById('word-card');
            card.classList.remove('slide-enter');
            void card.offsetWidth;
            card.classList.add('slide-enter');
        }

        document.getElementById('word-text').textContent = w.word;
        document.getElementById('familiar-badge').classList.toggle('hidden', !w.is_familiar);

        hideDetails();
        updateNav();
        updateDots();
        updateSummary();
        pronounce();
    }

    function hideDetails() {
        document.getElementById('detail-panel').classList.add('hidden');
        document.getElementById('action-buttons').style.opacity = '1';
        document.getElementById('action-buttons').style.pointerEvents = 'auto';
    }

    function showDetails() {
        const w = words[current];
        document.getElementById('detail-meaning').textContent  = w.meaning  || '—';
        document.getElementById('detail-sentence').textContent = w.sentence || '—';
        document.getElementById('detail-np').textContent       = w.np_word  || '—';
        document.getElementById('detail-np-wrap').classList.toggle('hidden', !w.np_word);

        const panel = document.getElementById('detail-panel');
        panel.classList.remove('hidden', 'detail-panel');
        void panel.offsetWidth;
        panel.classList.add('detail-panel');
    }

    // ── Navigation ─────────────────────────────────────────────────────────────

    function navigate(dir) {
        const next = current + dir;
        if (next < 0 || next >= words.length) return;
        showSlide(next);
    }

    function updateNav() {
        document.getElementById('prev-btn').disabled = current === 0;
        document.getElementById('next-btn').disabled = current === words.length - 1;
        document.getElementById('counter').textContent = `${current + 1} / ${words.length}`;
        const pct = words.length > 1 ? (current / (words.length - 1)) * 100 : 100;
        document.getElementById('progress-fill').style.width = pct + '%';
    }

    // ── Dot indicators ─────────────────────────────────────────────────────────

    function buildDots() {
        const container = document.getElementById('dot-indicators');
        const max = Math.min(words.length, 10);
        container.innerHTML = '';
        for (let i = 0; i < max; i++) {
            const dot = document.createElement('div');
            dot.style.cssText = 'width:6px;height:6px;border-radius:9999px;cursor:pointer;transition:all .2s;background:var(--dot-inactive)';
            dot.addEventListener('click', () => showSlide(i));
            container.appendChild(dot);
        }
    }

    function updateDots() {
        const dots = document.querySelectorAll('#dot-indicators div');
        const max  = dots.length;
        dots.forEach((d, i) => {
            const active = words.length <= 10
                ? i === current
                : i === Math.round((current / (words.length - 1)) * (max - 1));
            d.style.background = active ? '#6366f1' : 'var(--dot-inactive)';
            d.style.width      = active ? '12px' : '6px';
        });
    }

    // ── Summary ────────────────────────────────────────────────────────────────

    function updateSummary() {
        const fam   = words.filter(w => w.is_familiar === true).length;
        const unfam = words.filter(w => w.is_familiar === false).length;
        document.getElementById('familiar-count').textContent   = fam;
        document.getElementById('unfamiliar-count').textContent = unfam;
        document.getElementById('unseen-count').textContent     = words.length - fam - unfam;
    }

    // ── Speech ─────────────────────────────────────────────────────────────────

    function pronounce() {
        if (!('speechSynthesis' in window)) return;
        window.speechSynthesis.cancel();
        const u = new SpeechSynthesisUtterance(words[current].word);
        u.lang  = 'en-US';
        u.rate  = 0.85;
        window.speechSynthesis.speak(u);
    }

    // ── Familiar / Unfamiliar ──────────────────────────────────────────────────

    async function markFamiliar()   { await patchFamiliarity('/api/unknown-words/familiar',   true);  }
    async function markUnfamiliar() { await patchFamiliarity('/api/unknown-words/unfamiliar', false); }

    async function patchFamiliarity(url, isFamiliar) {
        const w = words[current];
        try {
            const res = await fetch(url, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: JSON.stringify({ id: w.id }),
            });
            if (!res.ok) { toast('Something went wrong.', 'error'); return; }

            const json = await res.json();
            words[current] = json.data;

            document.getElementById('familiar-badge').classList.toggle('hidden', !isFamiliar);
            document.getElementById('action-buttons').style.opacity      = '0.5';
            document.getElementById('action-buttons').style.pointerEvents = 'none';

            showDetails();
            updateSummary();
            toast(isFamiliar ? '✓ Marked as familiar' : '✗ Marked as unfamiliar', isFamiliar ? 'success' : 'warn');
        } catch {
            toast('Network error.', 'error');
        }
    }

    // ── Reset All ──────────────────────────────────────────────────────────────

    async function resetAll() {
        if (!confirm('Reset is_familiar for all words?')) return;
        try {
            const res = await fetch('/api/unknown-words/reset-familiar', {
                method: 'PATCH',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            });
            if (!res.ok) { toast('Reset failed.', 'error'); return; }

            words.forEach(w => w.is_familiar = false);
            document.getElementById('familiar-badge').classList.add('hidden');
            hideDetails();
            updateSummary();
            toast('All words reset.');
        } catch {
            toast('Network error.', 'error');
        }
    }

    // ── Toast ──────────────────────────────────────────────────────────────────

    function toast(msg, type = 'success') {
        const el = document.getElementById('toast');
        el.textContent = msg;
        el.className = `fixed bottom-6 left-1/2 -translate-x-1/2 px-5 py-3 rounded-xl text-sm font-medium shadow-xl z-50 ${
            type === 'success' ? 'bg-emerald-600 text-white' :
            type === 'warn'    ? 'bg-amber-500 text-white'   :
                                 'bg-red-600 text-white'
        }`;
        el.classList.remove('hidden');
        clearTimeout(el._t);
        el._t = setTimeout(() => el.classList.add('hidden'), 2500);
    }

    // ── Keyboard ───────────────────────────────────────────────────────────────

    document.addEventListener('keydown', e => {
        if (e.key === 'ArrowRight' || e.key === 'ArrowDown') navigate(1);
        if (e.key === 'ArrowLeft'  || e.key === 'ArrowUp')   navigate(-1);
        if (e.key === 'f' || e.key === 'F') markFamiliar();
        if (e.key === 'u' || e.key === 'U') markUnfamiliar();
        if (e.key === 'r' || e.key === 'R') pronounce();
        if (e.key === 't' || e.key === 'T') toggleTheme();
    });

    // ── Init ───────────────────────────────────────────────────────────────────

    loadWords();
</script>

</body>
</html>
