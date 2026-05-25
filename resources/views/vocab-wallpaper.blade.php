<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=390, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Vocab Wallpaper</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;600&display=swap');

  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    margin-top: 80px;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: #ffffff;
    font-family: 'Inter', sans-serif;
    color: #000;
  }

  #main-content {
    width: 390px;
    min-height: 844px;
    padding: 60px 28px 48px;
    box-sizing: border-box;
  }

  .header {
    text-align: center;
    margin-bottom: 36px;
  }
  .header-date {
    font-size: 11px;
    color: #aaa;
    margin-top: 4px;
    letter-spacing: 1px;
  }
  .divider {
    width: 40px;
    height: 2px;
    background: #000;
    margin: 16px auto 0;
  }

  .cards-container {
    display: flex;
    flex-direction: column;
    gap: 24px;
  }

  .card {
    border-bottom: 1px solid #e0e0e0;
    padding-bottom: 20px;
    position: relative;
  }
  .card:last-child { border-bottom: none; }

  .card-top {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 6px;
  }

  .word {
    font-family: 'Playfair Display', serif;
    font-size: 22px;
    color: #000;
    font-weight: 700;
  }

  .card-actions {
    display: flex;
    gap: 8px;
    flex-shrink: 0;
    align-items: center;
    opacity: 0;
    transition: opacity .15s;
  }
  .card:hover .card-actions { opacity: 1; }

  .card-actions button {
    background: none;
    border: none;
    cursor: pointer;
    padding: 2px;
    color: #bbb;
    line-height: 1;
    transition: color .15s;
  }
  .card-actions .btn-edit:hover  { color: #4f46e5; }
  .card-actions .btn-delete:hover { color: #ef4444; }

  .meaning {
    font-size: 13px;
    color: #222;
    line-height: 1.55;
    font-weight: 400;
    margin-bottom: 6px;
  }

  .example {
    font-size: 11.5px;
    color: #000;
    font-style: italic;
    line-height: 1.45;
  }

  .state-msg {
    text-align: center;
    padding: 60px 0;
    color: #aaa;
    font-size: 13px;
    letter-spacing: 0.5px;
  }

  /* ── Modals ── */
  .modal-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.35);
    z-index: 200;
    justify-content: center;
    align-items: center;
    padding: 16px;
  }
  .modal-backdrop.open { display: flex; }

  .modal-box {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0,0,0,.12);
    width: 100%;
    max-width: 420px;
  }

  .modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid #f0f0f0;
  }
  .modal-header h2 { font-size: 15px; font-weight: 600; }
  .modal-close {
    background: none; border: none; font-size: 20px;
    color: #aaa; cursor: pointer; line-height: 1;
  }
  .modal-close:hover { color: #333; }

  .modal-body { padding: 20px; display: flex; flex-direction: column; gap: 14px; }

  .field label {
    display: block;
    font-size: 11.5px;
    font-weight: 600;
    color: #555;
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: .5px;
  }
  .field input, .field textarea {
    width: 100%;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 13px;
    font-family: 'Inter', sans-serif;
    outline: none;
    resize: none;
    transition: border-color .15s;
  }
  .field input:focus, .field textarea:focus { border-color: #000; }

  .modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 14px 20px;
    border-top: 1px solid #f0f0f0;
  }
  .btn { border: none; border-radius: 8px; padding: 8px 18px; font-size: 13px; font-family: 'Inter', sans-serif; cursor: pointer; font-weight: 600; transition: opacity .15s; }
  .btn:disabled { opacity: .5; }
  .btn-cancel { background: #f4f4f4; color: #555; }
  .btn-cancel:hover { background: #eee; }
  .btn-save   { background: #000; color: #fff; }
  .btn-save:hover { opacity: .8; }
  .btn-danger { background: #ef4444; color: #fff; }
  .btn-danger:hover { opacity: .85; }

  /* delete modal */
  .delete-modal-body { padding: 24px 20px; text-align: center; }
  .delete-modal-body p { font-size: 13px; color: #555; margin-top: 8px; line-height: 1.5; }
  .delete-modal-body strong { color: #000; }

  .inspire {
    margin-top: 40px;
    padding-top: 24px;
    border-top: 1px solid #e0e0e0;
    text-align: center;
  }
  .inspire-quote {
    font-family: 'Playfair Display', serif;
    font-size: 14px;
    color: #333;
    line-height: 1.6;
    font-style: italic;
  }
  .inspire-author {
    margin-top: 8px;
    font-size: 10.5px;
    color: #aaa;
    letter-spacing: 1px;
    text-transform: uppercase;
  }
</style>
</head>
<body>

<div id="main-content">
  <!-- <div class="header">
    <div class="header-date">{{ strtoupper(now()->format('F j, Y')) }}</div>
    <div class="divider"></div>
  </div> -->

  <div class="cards-container">
    @forelse ($words as $word)
      <div class="card" id="card-{{ $word->id }}"
           data-id="{{ $word->id }}"
           data-word="{{ e($word->word) }}"
           data-meaning="{{ e($word->meaning) }}"
           data-sentence="{{ e($word->sentence) }}"
           data-np="{{ e($word->np_word) }}">
        <div class="card-top">
          <span class="word">
            {{ $word->word }}{{ $word->np_word ? ' / ' . $word->np_word : '' }}
          </span>
          <div class="card-actions">
            <button class="btn-edit" title="Edit" onclick="openEdit({{ $word->id }})">
              <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
              </svg>
            </button>
            <button class="btn-delete" title="Delete" onclick="openDelete({{ $word->id }})">
              <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                <path d="M10 11v6M14 11v6"/>
                <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
              </svg>
            </button>
          </div>
        </div>
        <div class="meaning" id="meaning-{{ $word->id }}">{{ $word->meaning }}</div>
        @if ($word->sentence)
          <div class="example" id="example-{{ $word->id }}">"{{ $word->sentence }}"</div>
        @endif
      </div>
    @empty
      <div class="state-msg">No words found.</div>
    @endforelse
  </div>

  <div class="inspire">
    <div class="inspire-quote">"{!! $quote !!}"</div>
  </div>
</div>

<!-- Edit Modal -->
<div id="edit-modal" class="modal-backdrop">
  <div class="modal-box">
    <div class="modal-header">
      <h2>Edit Word</h2>
      <button class="modal-close" onclick="closeEdit()">&times;</button>
    </div>
    <div class="modal-body">
      <input type="hidden" id="edit-id">
      <div class="field">
        <label>Word</label>
        <input type="text" id="edit-word">
      </div>
      <div class="field">
        <label>Nepali</label>
        <input type="text" id="edit-np">
      </div>
      <div class="field">
        <label>Meaning</label>
        <textarea id="edit-meaning" rows="3"></textarea>
      </div>
      <div class="field">
        <label>Sentence</label>
        <textarea id="edit-sentence" rows="2"></textarea>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-cancel" onclick="closeEdit()">Cancel</button>
      <button class="btn btn-save" id="save-btn" onclick="saveEdit()">Save</button>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div id="delete-modal" class="modal-backdrop">
  <div class="modal-box">
    <div class="delete-modal-body">
      <p>Delete <strong id="delete-word-name"></strong>?<br>This cannot be undone.</p>
    </div>
    <div class="modal-footer">
      <button class="btn btn-cancel" onclick="closeDelete()">Cancel</button>
      <button class="btn btn-danger" id="delete-btn" onclick="confirmDelete()">Delete</button>
    </div>
  </div>
</div>

<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;
let deleteTargetId = null;

function cardData(id) {
  const el = document.getElementById('card-' + id);
  return {
    word:     el.dataset.word,
    meaning:  el.dataset.meaning,
    sentence: el.dataset.sentence,
    np:       el.dataset.np,
  };
}

// ── Edit ──────────────────────────────────────────────────────────────────────

function openEdit(id) {
  const d = cardData(id);
  document.getElementById('edit-id').value       = id;
  document.getElementById('edit-word').value     = d.word;
  document.getElementById('edit-np').value       = d.np;
  document.getElementById('edit-meaning').value  = d.meaning;
  document.getElementById('edit-sentence').value = d.sentence;
  document.getElementById('edit-modal').classList.add('open');
}

function closeEdit() {
  document.getElementById('edit-modal').classList.remove('open');
}

async function saveEdit() {
  const id  = document.getElementById('edit-id').value;
  const btn = document.getElementById('save-btn');
  btn.disabled = true;
  btn.textContent = 'Saving…';

  const payload = {
    word:     document.getElementById('edit-word').value.trim(),
    np_word:  document.getElementById('edit-np').value.trim() || null,
    meaning:  document.getElementById('edit-meaning').value.trim(),
    sentence: document.getElementById('edit-sentence').value.trim(),
  };

  try {
    const res  = await fetch(`/api/unknown_words/${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
      body: JSON.stringify(payload),
    });

    if (!res.ok) return;

    const w   = (await res.json()).data.word;
    const card = document.getElementById('card-' + id);

    // update data attributes
    card.dataset.word     = w.word;
    card.dataset.meaning  = w.meaning;
    card.dataset.sentence = w.sentence ?? '';
    card.dataset.np       = w.np_word ?? '';

    // update visible text
    card.querySelector('.word').textContent = w.word + (w.np_word ? ' / ' + w.np_word : '');
    document.getElementById('meaning-'  + id).textContent = w.meaning;
    const exEl = document.getElementById('example-' + id);
    if (exEl) exEl.textContent = w.sentence ? '"' + w.sentence + '"' : '';

    closeEdit();
  } finally {
    btn.disabled = false;
    btn.textContent = 'Save';
  }
}

// ── Delete ────────────────────────────────────────────────────────────────────

function openDelete(id) {
  deleteTargetId = id;
  document.getElementById('delete-word-name').textContent = cardData(id).word;
  document.getElementById('delete-modal').classList.add('open');
}

function closeDelete() {
  deleteTargetId = null;
  document.getElementById('delete-modal').classList.remove('open');
}

async function confirmDelete() {
  if (!deleteTargetId) return;
  const btn = document.getElementById('delete-btn');
  btn.disabled = true;
  btn.textContent = 'Deleting…';

  try {
    const res = await fetch(`/api/unknown_words/${deleteTargetId}`, {
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
    });

    if (!res.ok) return;

    document.getElementById('card-' + deleteTargetId)?.remove();
    closeDelete();
  } finally {
    btn.disabled = false;
    btn.textContent = 'Delete';
  }
}

// close on backdrop click
document.getElementById('edit-modal').addEventListener('click', function(e) { if (e.target === this) closeEdit(); });
document.getElementById('delete-modal').addEventListener('click', function(e) { if (e.target === this) closeDelete(); });
</script>
</body>
</html>
