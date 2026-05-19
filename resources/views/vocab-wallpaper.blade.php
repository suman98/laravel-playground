<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=390, initial-scale=1.0">
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
  }
  .card:last-child { border-bottom: none; }

  .card-top {
    display: flex;
    align-items: baseline;
    gap: 10px;
    margin-bottom: 6px;
  }

  .word {
    font-family: 'Playfair Display', serif;
    font-size: 22px;
    color: #000;
    font-weight: 700;
  }

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
</style>
</head>
<body>

<div id="main-content">
  <div class="header">
    <div class="header-date">{{ strtoupper(now()->format('F j, Y')) }}</div>
    <div class="divider"></div>
  </div>

  <div class="cards-container">
    @forelse ($words as $word)
      <div class="card">
        <div class="card-top">
          <span class="word">
            {{ $word->word }}{{ $word->np_word ? ' / ' . $word->np_word : '' }}
          </span>
        </div>
        <div class="meaning">{{ $word->meaning }}</div>
        @if ($word->sentence)
          <div class="example">"{{ $word->sentence }}"</div>
        @endif
      </div>
    @empty
      <div class="state-msg">No words found.</div>
    @endforelse
  </div>
</div>

</body>
</html>
