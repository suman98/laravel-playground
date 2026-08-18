<?php

define('APP_NAME', config('app.name', 'Laravel'));
define('APP_URL', config('app.url', ''));

?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= defined('APP_NAME') ? APP_NAME : 'Routes List' ?></title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        .xdebug-error { display: none; }

        /* ── Theme tokens ── */
        :root[data-theme="dark"] {
            --bg-base:        #0f172a;
            --bg-surface:     #1e293b;
            --bg-surface-alt: #1a2336;
            --bg-surface-hov: #263348;
            --bg-thead:       #0f172a;
            --bg-code:        #0f172a;
            --border:         #334155;
            --border-focus:   #6366f1;
            --text-primary:   #e2e8f0;
            --text-secondary: #94a3b8;
            --text-muted:     #64748b;
            --text-faint:     #475569;
            --text-uri:       #c4b5fd;
            --text-param:     #f59e0b;
            --text-action:    #7dd3fc;
            --text-closure:   #f9a8d4;
            --text-name:      #94a3b8;
            --text-name-emp:  #334155;
            --accent:         #6366f1;
            --accent-light:   #a78bfa;
            --mark-bg:        #854d0e;
            --mark-text:      #fef3c7;
            --toggle-icon:    "☀️";
            --uri-link-hover: #a78bfa;
        }

        :root[data-theme="light"] {
            --bg-base:        #f1f5f9;
            --bg-surface:     #ffffff;
            --bg-surface-alt: #f8fafc;
            --bg-surface-hov: #eef2ff;
            --bg-thead:       #f1f5f9;
            --bg-code:        #f1f5f9;
            --border:         #cbd5e1;
            --border-focus:   #6366f1;
            --text-primary:   #0f172a;
            --text-secondary: #475569;
            --text-muted:     #64748b;
            --text-faint:     #94a3b8;
            --text-uri:       #6d28d9;
            --text-param:     #b45309;
            --text-action:    #0369a1;
            --text-closure:   #be185d;
            --text-name:      #475569;
            --text-name-emp:  #cbd5e1;
            --accent:         #6366f1;
            --accent-light:   #7c3aed;
            --mark-bg:        #fef08a;
            --mark-text:      #713f12;
            --toggle-icon:    "🌙";
            --uri-link-hover: #4f46e5;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--bg-base);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 2rem;
            transition: background .25s, color .25s;
        }

        /* ── Header ── */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .header-left h1 {
            font-size: 1.75rem;
            font-weight: 700;
            background: linear-gradient(135deg, #6366f1, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header-left p {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .route-count {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 0.35rem 1rem;
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        .route-count span {
            font-weight: 700;
            color: var(--accent-light);
        }

        /* ── Theme toggle ── */
        .theme-toggle {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 0.35rem 0.9rem;
            font-size: 0.82rem;
            color: var(--text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            transition: border-color .2s, color .2s, background .25s;
            white-space: nowrap;
            font-family: inherit;
        }

        .theme-toggle:hover {
            border-color: var(--accent);
            color: var(--accent-light);
        }

        .theme-toggle-icon {
            font-size: 1rem;
            line-height: 1;
        }

        /* ── Stats bar ── */
        .stats-bar {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .stat {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.5rem 0.85rem;
            font-size: 0.75rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 0.4rem;
            transition: background .25s, border-color .25s;
        }

        .stat strong {
            color: var(--text-primary);
            font-size: 1rem;
        }

        /* ── Toolbar ── */
        .toolbar {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-bottom: 1.25rem;
            align-items: center;
        }

        .search-wrap {
            position: relative;
            flex: 1;
            min-width: 220px;
        }

        .search-wrap svg {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
        }

        #searchInput {
            width: 100%;
            padding: 0.55rem 0.75rem 0.55rem 2.25rem;
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text-primary);
            font-size: 0.875rem;
            outline: none;
            transition: border-color .2s, background .25s, color .25s;
        }

        #searchInput:focus { border-color: var(--border-focus); }
        #searchInput::placeholder { color: var(--text-faint); }

        .filter-group {
            display: flex;
            gap: 0.4rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 0.45rem 0.85rem;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: var(--bg-surface);
            color: var(--text-secondary);
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
            letter-spacing: .03em;
            font-family: inherit;
        }

        .filter-btn:hover { border-color: var(--accent); color: var(--accent-light); }

        .filter-btn.active {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }

        /* ── Method badges ── */
        .badge {
            display: inline-block;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: .05em;
            margin: 1px;
        }

        [data-theme="dark"] .badge-GET     { background: #14532d; color: #4ade80; border: 1px solid #166534; }
        [data-theme="dark"] .badge-POST    { background: #1e3a5f; color: #60a5fa; border: 1px solid #1d4ed8; }
        [data-theme="dark"] .badge-PUT     { background: #451a03; color: #fb923c; border: 1px solid #9a3412; }
        [data-theme="dark"] .badge-PATCH   { background: #422006; color: #fbbf24; border: 1px solid #92400e; }
        [data-theme="dark"] .badge-DELETE  { background: #450a0a; color: #f87171; border: 1px solid #991b1b; }
        [data-theme="dark"] .badge-HEAD    { background: #1e1b4b; color: #818cf8; border: 1px solid #3730a3; }
        [data-theme="dark"] .badge-OPTIONS { background: #1c1917; color: #a8a29e; border: 1px solid #44403c; }

        [data-theme="light"] .badge-GET     { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
        [data-theme="light"] .badge-POST    { background: #dbeafe; color: #1d4ed8; border: 1px solid #93c5fd; }
        [data-theme="light"] .badge-PUT     { background: #ffedd5; color: #c2410c; border: 1px solid #fdba74; }
        [data-theme="light"] .badge-PATCH   { background: #fef3c7; color: #b45309; border: 1px solid #fcd34d; }
        [data-theme="light"] .badge-DELETE  { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
        [data-theme="light"] .badge-HEAD    { background: #ede9fe; color: #6d28d9; border: 1px solid #c4b5fd; }
        [data-theme="light"] .badge-OPTIONS { background: #f5f5f4; color: #57534e; border: 1px solid #d6d3d1; }

        /* ── Table wrapper ── */
        .table-wrap {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: scroll;
            transition: background .25s, border-color .25s;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        thead th {
            background: var(--bg-thead);
            padding: 0.75rem 1rem;
            text-align: left;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);

            transition: background .25s;
        }

        tbody tr {
            border-bottom: 1px solid var(--bg-surface);
            transition: background .1s;
        }

        tbody tr:last-child { border-bottom: none; }
        tbody tr:nth-child(odd)  { background: var(--bg-surface-alt); }
        tbody tr:nth-child(even) { background: var(--bg-surface); }
        tbody tr:hover { background: var(--bg-surface-hov); }

        td {
            padding: 0.65rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--bg-surface-hov);
        }

        /* ── URI cell ── */
        .uri {
            font-family: 'JetBrains Mono', 'Fira Code', monospace;
            font-size: 0.82rem;
            color: var(--text-uri);
        }

        .uri-param { color: var(--text-param); }

        /* ── URI link ── */
        a.uri-link {
            text-decoration: none;
            color: inherit;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            border-radius: 4px;
            padding: 0.15rem 0.3rem;
            margin: -0.15rem -0.3rem;
            transition: color .15s, background .15s;
        }

        a.uri-link:hover {
            color: var(--uri-link-hover);
            background: color-mix(in srgb, var(--accent) 10%, transparent);
        }

        a.uri-link:hover .link-icon { opacity: 1; }

        .link-icon {
            opacity: 0;
            transition: opacity .15s;
            flex-shrink: 0;
        }

        /* Routes with params are not directly navigable — dim the icon */
        .uri-link.has-params .link-icon {
            opacity: 0;
        }
        .uri-link.has-params:hover {
            cursor: default;
            color: inherit;
            background: transparent;
        }

        /* ── Name cell ── */
        .route-name {
            font-size: 0.8rem;
            color: var(--text-name);
            font-family: monospace;
        }

        .route-name.empty { color: var(--text-name-emp); font-style: italic; }

        /* ── Action cell ── */
        .action {
            font-size: 0.8rem;
            color: var(--text-action);
            font-family: monospace;
            max-width: 280px;
            overflow: hidden;
            text-overflow: ellipsis;

        }

        .action-closure { color: var(--text-closure); font-style: italic; }

        /* ── Middleware cell ── */
        .mw-tag {
            display: inline-block;
            background: var(--bg-code);
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 0.15rem 0.45rem;
            font-size: 0.7rem;
            color: var(--text-secondary);
            margin: 1px;
            font-family: monospace;
            transition: background .25s, border-color .25s;
        }

        /* ── No results ── */
        .no-results {
            text-align: center;
            padding: 3rem;
            color: var(--text-faint);
            font-size: 0.95rem;
            display: none;
        }

        /* ── Highlight match ── */
        mark {
            background: var(--mark-bg);
            color: var(--mark-text);
            border-radius: 2px;
            padding: 0 1px;
        }
    </style>
</head>
<body>
<div class="container">

    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <h1>⚡ <?= APP_NAME ?? 'ROUTES' ?> Explorer</h1>
            <p>Application route map &mdash; <?= date('Y-m-d H:i:s') ?></p>
        </div>
        <div class="header-right">
            <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
                <span class="theme-toggle-icon" id="themeIcon">☀️</span>
                <span id="themeLabel">Light Mode</span>
            </button>
            <div class="route-count">
                Showing <span id="visibleCount"><?= count($routes) ?></span>
                of <span><?= count($routes) ?></span> routes
            </div>
        </div>
    </div>

    <!-- Stats -->
    <?php
    $methodCounts = [];
    foreach ($routes as $route) {
        foreach ($route->methods() as $m) {
            if ($m === 'HEAD') continue;
            $methodCounts[$m] = ($methodCounts[$m] ?? 0) + 1;
        }
    }
    arsort($methodCounts);
    ?>
    <div class="stats-bar">
        <?php foreach ($methodCounts as $method => $count): ?>
            <div class="stat">
                <strong><?= $count ?></strong> <?= htmlspecialchars($method) ?>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Toolbar -->
    <div class="toolbar">
        <div class="search-wrap">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input id="searchInput" type="text" placeholder="Search URI, name, action, middleware…">
        </div>
        <div class="filter-group" id="methodFilters">
            <button class="filter-btn active" data-method="ALL">All</button>
            <?php foreach (array_keys($methodCounts) as $method): ?>
                <button class="filter-btn" data-method="<?= htmlspecialchars($method) ?>">
                    <?= htmlspecialchars($method) ?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Table -->
    <div class="table-wrap">
        <table id="routeTable">
            <thead>
                <tr>
                    <th>Method</th>
                    <th>URI</th>
                    <th>Action</th>
                    <th>Name</th>

                    <th>Middleware</th>
                </tr>
            </thead>
            <tbody id="routeBody">
                <?php foreach ($routes as $route):
                    $methods   = array_filter($route->methods(), fn($m) => $m !== 'HEAD');
                    $uri       = $route->uri();
                    $name      = $route->getName() ?? '';
                    $action    = $route->getActionName() ?? '';
                    $isClosure = str_contains($action, '@') === false
                                 && str_contains($action, 'Closure') !== false
                                 || $action === 'Closure';
                    $hasParams = str_contains($uri, '{');
                    $isGetOnly = count(array_filter($methods, fn($m) => $m === 'GET')) > 0;

                    $mwList = [];
                    $routeMiddleware = $route->gatherMiddleware();
                    if (is_array($routeMiddleware)) {
                        foreach ($routeMiddleware as $m) {
                            $mwList[] = $middlewareClosure($m);
                        }
                    }
                ?>
                <tr data-methods="<?= htmlspecialchars(implode('|', $methods)) ?>">
                    <td>
                        <?php foreach ($methods as $m): ?>
                            <span class="badge badge-<?= htmlspecialchars($m) ?>">
                                <?= htmlspecialchars($m) ?>
                            </span>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <span class="uri"><?php
                            $encodedUri = htmlspecialchars($uri);
                            $linkClass  = 'uri-link' . ($hasParams ? ' has-params' : '');
                            // Only wrap in <a> for GET routes; others get a span styled identically
                            if ($isGetOnly && !$hasParams) {
                                $fullUrl = rtrim(APP_URL, '/') . '/' . ltrim($uri, '/');
                                echo '<a href="' . htmlspecialchars($fullUrl) . '" target="_blank" rel="noopener" class="' . $linkClass . '">'
                                   . $encodedUri
                                   . '<svg class="link-icon" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>'
                                   . '</a>';
                            } elseif ($hasParams) {
                                echo '<span class="' . $linkClass . '" title="Contains route parameters">'
                                   . $encodedUri
                                   . '</span>';
                            } else {
                                echo $encodedUri;
                            }
                        ?></span>
                    </td>
                    <td>
                        <span class="action <?= $isClosure ? 'action-closure' : '' ?>"
                              title="<?= htmlspecialchars($action) ?>">
                            <?= htmlspecialchars($action !== '' ? $action : '—') ?>
                        </span>
                    </td>
                    <td>
                        <span class="route-name <?= $name === '' ? 'empty' : '' ?>">
                            <?= $name !== '' ? htmlspecialchars($name) : '—' ?>
                        </span>
                    </td>

                    <td>
                        <?php if ($mwList): ?>
                            <?php foreach ($mwList as $mw): ?>
                                <span class="mw-tag"><?= htmlspecialchars($mw) ?></span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span style="color:var(--text-name-emp)">—</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="no-results" id="noResults">
            🔍 No routes match your search.
        </div>
    </div>

</div>

<script>
(function () {
    /* ── Theme toggle ── */
    const html        = document.documentElement;
    const toggleBtn   = document.getElementById('themeToggle');
    const themeIcon   = document.getElementById('themeIcon');
    const themeLabel  = document.getElementById('themeLabel');
    const STORAGE_KEY = 'routesExplorerTheme';

    function applyTheme(theme) {
        html.setAttribute('data-theme', theme);
        if (theme === 'dark') {
            themeIcon.textContent  = '☀️';
            themeLabel.textContent = 'Light Mode';
        } else {
            themeIcon.textContent  = '🌙';
            themeLabel.textContent = 'Dark Mode';
        }
        localStorage.setItem(STORAGE_KEY, theme);
    }

    // Respect saved preference or OS preference
    const saved = localStorage.getItem(STORAGE_KEY);
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    applyTheme(saved || (prefersDark ? 'dark' : 'light'));

    toggleBtn.addEventListener('click', () => {
        applyTheme(html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
    });

    /* ── Search & filter ── */
    const searchInput  = document.getElementById('searchInput');
    const filterBtns   = document.querySelectorAll('.filter-btn');
    const rows         = document.querySelectorAll('#routeBody tr');
    const visibleCount = document.getElementById('visibleCount');
    const noResults    = document.getElementById('noResults');

    let activeMethod = 'ALL';
    let searchTerm   = '';

    function applyFilters() {
        let visible = 0;
        rows.forEach(row => {
            const methods  = row.dataset.methods || '';
            const text     = row.textContent.toLowerCase();
            const methodOk = activeMethod === 'ALL' || methods.split('|').includes(activeMethod);
            const searchOk = searchTerm === '' || text.includes(searchTerm);

            row.style.display = (methodOk && searchOk) ? '' : 'none';
            if (methodOk && searchOk) visible++;
        });

        visibleCount.textContent = visible;
        noResults.style.display  = visible === 0 ? 'block' : 'none';
    }

    searchInput.addEventListener('input', e => {
        searchTerm = e.target.value.toLowerCase().trim();
        applyFilters();
    });

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            activeMethod = btn.dataset.method;
            applyFilters();
        });
    });

    /* ── Highlight URI {params} ── */
    document.querySelectorAll('.uri').forEach(el => {
        // Only process text nodes / plain spans (not anchors that already have innerHTML set)
        const anchor = el.querySelector('a.uri-link');
        const span   = el.querySelector('span.uri-link');

        if (anchor) {
            // Replace text nodes inside anchor (before the svg icon)
            anchor.childNodes.forEach(node => {
                if (node.nodeType === Node.TEXT_NODE) {
                    const wrapper = document.createElement('span');
                    wrapper.innerHTML = node.textContent.replace(
                        /(\{[^}]+\})/g,
                        '<span class="uri-param">$1</span>'
                    );
                    node.replaceWith(...wrapper.childNodes);
                }
            });
        } else if (span) {
            span.innerHTML = span.textContent.replace(
                /(\{[^}]+\})/g,
                '<span class="uri-param">$1</span>'
            );
        } else {
            el.innerHTML = el.textContent.replace(
                /(\{[^}]+\})/g,
                '<span class="uri-param">$1</span>'
            );
        }
    });
})();
</script>
</body>
</html>
