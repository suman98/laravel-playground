<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Unknown Words</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

<div class="max-w-5xl mx-auto py-10 px-4">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Unknown Words</h1>
            <p class="text-gray-500 mt-1">Manage your vocabulary list</p>
        </div>
        <button onclick="openModal()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-lg transition">
            + Add Word
        </button>
    </div>

    {{-- Notification --}}
    <div id="notification" class="hidden mb-4 px-4 py-3 rounded-lg text-sm font-medium"></div>

    {{-- Search & filter bar --}}
    <div class="flex items-center gap-3 mb-4">
        <input id="search-input" type="search" placeholder="Search words, meaning, sentence…"
               class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
               oninput="filterTable()">
        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer select-none">
            <input type="checkbox" id="show-disabled" onchange="filterTable()"
                   class="w-4 h-4 accent-indigo-600">
            Show disabled
        </label>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-5 py-3 text-left">#</th>
                    <th class="px-5 py-3 text-left">Word</th>
                    <th class="px-5 py-3 text-left">Meaning</th>
                    <th class="px-5 py-3 text-left">Sentence</th>
                    <th class="px-5 py-3 text-left">Nepali</th>
                    <th class="px-5 py-3 text-center">Enabled</th>
                    <th class="px-5 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="words-table" class="divide-y divide-gray-100 text-gray-700">
                <tr id="loading-row">
                    <td colspan="7" class="px-5 py-8 text-center text-gray-400">Loading...</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Empty state (hidden by default) --}}
    <div id="empty-state" class="hidden text-center py-16 text-gray-400">
        <svg class="mx-auto mb-3 h-12 w-12 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        <p class="font-medium">No words yet. Add your first one!</p>
    </div>
</div>

{{-- Modal --}}
<div id="modal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg">
        <div class="flex items-center justify-between px-6 py-4 border-b">
            <h2 id="modal-title" class="text-lg font-semibold text-gray-900">Add Word</h2>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>

        <form id="word-form" class="px-6 py-5 space-y-4" onsubmit="submitForm(event)">
            <input type="hidden" id="edit-id">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Word <span class="text-red-500">*</span></label>
                <input type="text" id="field-word" placeholder="e.g. Ephemeral"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p id="err-word" class="hidden text-xs text-red-500 mt-1"></p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Meaning <span class="text-red-500">*</span></label>
                <textarea id="field-meaning" rows="2" placeholder="Definition of the word..."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"></textarea>
                <p id="err-meaning" class="hidden text-xs text-red-500 mt-1"></p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sentence <span class="text-red-500">*</span></label>
                <textarea id="field-sentence" rows="2" placeholder="Use the word in a sentence..."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"></textarea>
                <p id="err-sentence" class="hidden text-xs text-red-500 mt-1"></p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nepali Equivalent <span class="text-gray-400 font-normal">(optional)</span></label>
                <input type="text" id="field-np_word" placeholder="e.g. क्षणभंगुर"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                    Cancel
                </button>
                <button type="submit" id="submit-btn"
                        class="px-5 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="delete-modal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm text-center p-6">
        <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-1">Delete Word</h3>
        <p class="text-sm text-gray-500 mb-6">Are you sure you want to delete <strong id="delete-word-name"></strong>? This action cannot be undone.</p>
        <div class="flex gap-3 justify-center">
            <button onclick="closeDeleteModal()"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                Cancel
            </button>
            <button onclick="confirmDelete()"
                    class="px-5 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition">
                Delete
            </button>
        </div>
    </div>
</div>

<script>
    const API_BASE = '/api';
    const CSRF    = document.querySelector('meta[name="csrf-token"]').content;
    let deleteTargetId = null;
    let allWords = [];

    // ── Helpers ──────────────────────────────────────────────────────────────

    function notify(message, type = 'success') {
        const el = document.getElementById('notification');
        el.textContent = message;
        el.className = `mb-4 px-4 py-3 rounded-lg text-sm font-medium ${
            type === 'success'
                ? 'bg-green-100 text-green-800'
                : 'bg-red-100 text-red-800'
        }`;
        el.classList.remove('hidden');
        setTimeout(() => el.classList.add('hidden'), 3000);
    }

    function clearErrors() {
        ['word', 'meaning', 'sentence'].forEach(f => {
            const el = document.getElementById(`err-${f}`);
            el.classList.add('hidden');
            el.textContent = '';
        });
    }

    function showErrors(errors) {
        Object.entries(errors).forEach(([field, messages]) => {
            const el = document.getElementById(`err-${field}`);
            if (el) {
                el.textContent = messages[0];
                el.classList.remove('hidden');
            }
        });
    }

    // ── Load & Render ─────────────────────────────────────────────────────────

    async function loadWords() {
        const tbody = document.getElementById('words-table');
        tbody.innerHTML = '<tr><td colspan="7" class="px-5 py-8 text-center text-gray-400">Loading...</td></tr>';

        const res  = await fetch(`${API_BASE}/unknown_words`);
        const json = await res.json();
        allWords   = json.data;

        renderTable();
    }

    function renderTable() {
        const tbody       = document.getElementById('words-table');
        const query       = document.getElementById('search-input').value.trim().toLowerCase();
        const showDisabled = document.getElementById('show-disabled').checked;

        const filtered = allWords.filter(w => {
            if (!showDisabled && !w.enabled) return false;
            if (!query) return true;
            return [w.word, w.meaning, w.sentence, w.np_word].some(
                v => v && String(v).toLowerCase().includes(query)
            );
        });

        document.getElementById('empty-state').classList.toggle('hidden', allWords.length > 0);

        if (filtered.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7" class="px-5 py-8 text-center text-gray-400">${
                allWords.length === 0 ? '' : 'No words match.'
            }</td></tr>`;
            return;
        }

        let counter = 0;
        tbody.innerHTML = filtered.map(w => {
            counter++;
            const dim = !w.enabled ? 'opacity-40' : '';
            return `
            <tr class="hover:bg-gray-50 transition ${dim}" data-id="${w.id}">
                <td class="px-5 py-3 text-gray-400">${counter}</td>
                <td class="px-5 py-3 font-semibold text-indigo-700">${escape(w.word)}</td>
                <td class="px-5 py-3 max-w-xs truncate" title="${escape(w.meaning)}">${escape(w.meaning)}</td>
                <td class="px-5 py-3 max-w-xs truncate italic text-gray-500" title="${escape(w.sentence)}">${escape(w.sentence)}</td>
                <td class="px-5 py-3 text-gray-600">${w.np_word ? escape(w.np_word) : '<span class="text-gray-300">—</span>'}</td>
                <td class="px-5 py-3 text-center">
                    <input type="checkbox" ${w.enabled ? 'checked' : ''}
                           onchange="toggleEnabled(${w.id}, this)"
                           class="w-4 h-4 accent-indigo-600 cursor-pointer">
                </td>
                <td class="px-5 py-3 text-center space-x-2">
                    <button onclick="openEdit(${JSON.stringify(w).replace(/"/g, '&quot;')})"
                            class="text-xs font-medium text-indigo-600 hover:underline">Edit</button>
                    <button onclick="openDeleteModal(${w.id}, '${escape(w.word)}')"
                            class="text-xs font-medium text-red-500 hover:underline">Delete</button>
                </td>
            </tr>`;
        }).join('');
    }

    function filterTable() {
        renderTable();
    }

    async function toggleEnabled(id, checkbox) {
        const word = allWords.find(w => w.id === id);
        if (!word) return;

        try {
            const res = await fetch(`${API_BASE}/unknown_words/${id}/toggle`, {
                method: 'PATCH',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            });

            if (!res.ok) {
                checkbox.checked = word.enabled; // revert
                notify('Failed to update.', 'error');
                return;
            }

            const json = await res.json();
            word.enabled = json.data.enabled;
            renderTable();
        } catch {
            checkbox.checked = word.enabled;
            notify('Network error.', 'error');
        }
    }

    function escape(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    // ── Modal ─────────────────────────────────────────────────────────────────

    function openModal() {
        document.getElementById('modal-title').textContent = 'Add Word';
        document.getElementById('edit-id').value = '';
        document.getElementById('submit-btn').textContent = 'Save';
        ['word', 'meaning', 'sentence', 'np_word'].forEach(f => {
            document.getElementById(`field-${f}`).value = '';
        });
        clearErrors();
        document.getElementById('modal').classList.remove('hidden');
    }

    function openEdit(word) {
        document.getElementById('modal-title').textContent = 'Edit Word';
        document.getElementById('edit-id').value = word.id;
        document.getElementById('submit-btn').textContent = 'Update';
        document.getElementById('field-word').value     = word.word     ?? '';
        document.getElementById('field-meaning').value  = word.meaning  ?? '';
        document.getElementById('field-sentence').value = word.sentence ?? '';
        document.getElementById('field-np_word').value  = word.np_word  ?? '';
        clearErrors();
        document.getElementById('modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
    }

    // ── Submit ────────────────────────────────────────────────────────────────

    async function submitForm(e) {
        e.preventDefault();
        clearErrors();

        const id      = document.getElementById('edit-id').value;
        const payload = {
            word:     document.getElementById('field-word').value.trim(),
            meaning:  document.getElementById('field-meaning').value.trim(),
            sentence: document.getElementById('field-sentence').value.trim(),
            np_word:  document.getElementById('field-np_word').value.trim() || null,
        };

        const isEdit = !!id;
        const url    = isEdit ? `${API_BASE}/unknown_words/${id}` : `${API_BASE}/save_unknown_words`;
        const method = isEdit ? 'PUT' : 'POST';

        const btn = document.getElementById('submit-btn');
        btn.disabled    = true;
        btn.textContent = isEdit ? 'Updating...' : 'Saving...';

        try {
            const res = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
                body: JSON.stringify(payload),
            });

            const json = await res.json();

            if (!res.ok) {
                if (json.errors) showErrors(json.errors);
                else notify(json.message ?? 'Something went wrong.', 'error');
                return;
            }

            const saved = json.data.word ?? json.data;
            if (isEdit) {
                const idx = allWords.findIndex(w => w.id === saved.id);
                if (idx !== -1) allWords[idx] = saved;
            } else {
                allWords.unshift(saved);
            }
            closeModal();
            renderTable();
            notify(isEdit ? 'Word updated successfully.' : 'Word added successfully.');
        } catch (err) {
            notify('Network error. Please try again.', 'error');
        } finally {
            btn.disabled    = false;
            btn.textContent = isEdit ? 'Update' : 'Save';
        }
    }

    // ── Delete ────────────────────────────────────────────────────────────────

    function openDeleteModal(id, word) {
        deleteTargetId = id;
        document.getElementById('delete-word-name').textContent = word;
        document.getElementById('delete-modal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        deleteTargetId = null;
        document.getElementById('delete-modal').classList.add('hidden');
    }

    async function confirmDelete() {
        if (!deleteTargetId) return;

        try {
            const res = await fetch(`${API_BASE}/unknown_words/${deleteTargetId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
            });

            if (!res.ok) {
                notify('Failed to delete.', 'error');
                return;
            }

            allWords = allWords.filter(w => w.id !== deleteTargetId);
            closeDeleteModal();
            renderTable();
            notify('Word deleted successfully.');
        } catch {
            notify('Network error. Please try again.', 'error');
        }
    }

    // ── Close modals on backdrop click ────────────────────────────────────────

    document.getElementById('modal').addEventListener('click', function (e) {
        if (e.target === this) closeModal();
    });

    document.getElementById('delete-modal').addEventListener('click', function (e) {
        if (e.target === this) closeDeleteModal();
    });

    // ── Init ──────────────────────────────────────────────────────────────────

    loadWords();
</script>

</body>
</html>
