<?php
declare(strict_types=1);

require __DIR__ . '/includes/helpers.php';

$LANG = detect_lang();
$UI   = require __DIR__ . '/data/ui.php';
$trip = require __DIR__ . '/data/trip.php';

$slides = $trip['slides'];
$days   = $trip['days'];
$total  = count($slides);
$first  = $slides[0];

$isPlace  = fn (array $s): bool => ($s['type'] ?? 'place') !== 'note';
$stopTime = fn (array $s, string $key): string => $isPlace($s) ? $s[$key] : $s['time'];
$stopCount = array_sum(array_map(fn ($d) => count(array_filter($d['stops'], $isPlace)), $days));

/** ชื่อรอง: ถ้ากำหนด subtitle/subname ไว้ใช้ตามภาษาปัจจุบัน ไม่งั้นแสดงชื่อในอีกภาษา */
$secondary = function (array $item, string $nameKey, string $subKey): array {
    if (isset($item[$subKey])) {
        return [t($item[$subKey]), lang()];
    }
    return [t($item[$nameKey], other_lang()), other_lang()];
};
?>
<!DOCTYPE html>
<html lang="<?= e($LANG) ?>" style="--accent: <?= e($first['accent']) ?>; --bg-top: <?= e($first['bg_top']) ?>; --bg-bottom: <?= e($first['bg_bottom']) ?>;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(t($trip['title'])) ?> | <?= e($trip['brand']) ?></title>
    <meta name="description" content="<?= e(t($trip['tagline'])) ?>">
    <link rel="icon" type="image/png" href="assets/images/travel.png">
    <link rel="apple-touch-icon" href="assets/images/travel.png">
    <link rel="alternate" hreflang="en" href="?lang=en">
    <link rel="alternate" hreflang="th" href="?lang=th">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai+Looped:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script>
        document.documentElement.classList.add('js');
        // ถ้ารูปโหลดไม่ได้ ซ่อนรูปไว้ ให้พื้นหลังสีแสดงแทน
        document.addEventListener('error', function (ev) {
            if (ev.target.tagName === 'IMG') ev.target.classList.add('is-broken');
        }, true);
    </script>
</head>
<body>

<!-- ============ HERO ============ -->
<div class="hero-wrap" id="top">
    <!-- พื้นหลังนอกกรอบ: ภาพของสไลด์ที่กำลังแสดง -->
    <div class="page-bgs" aria-hidden="true">
        <?php foreach ($slides as $i => $s): ?>
            <div class="page-bg<?= $i === 0 ? ' is-active' : '' ?>">
                <img src="<?= e(img_src($s['image'], 1600)) ?>" alt="" <?= $i === 0 ? '' : 'loading="lazy"' ?>>
            </div>
        <?php endforeach; ?>
    </div>

    <header class="hero" data-hero>

        <div class="hero__bgs" aria-hidden="true">
            <?php foreach ($slides as $i => $s): ?>
                <div class="hero__bg<?= $i === 0 ? ' is-active' : '' ?>">
                    <img src="<?= e(img_src($s['image'], 2000)) ?>" alt="" <?= $i === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?>>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="hero__shade"></div>

        <nav class="nav">
            <a class="nav__logo" href="#top"><?= e($trip['brand']) ?></a>
            <ul class="nav__links">
                <li><a href="#top"><?= e(ui('nav_highlights')) ?></a></li>
                <li><a href="#program"><?= e(ui('nav_program')) ?></a></li>
                <li><a href="#contact"><?= e(ui('nav_contact')) ?></a></li>
            </ul>
            <div class="nav__actions">
                <div class="lang" role="group" aria-label="<?= e(ui('language')) ?>">
                    <a class="lang__opt<?= $LANG === 'en' ? ' is-active' : '' ?>" href="?lang=en" hreflang="en" lang="en"<?= $LANG === 'en' ? ' aria-current="true"' : '' ?>>EN</a>
                    <a class="lang__opt<?= $LANG === 'th' ? ' is-active' : '' ?>" href="?lang=th" hreflang="th" lang="th"<?= $LANG === 'th' ? ' aria-current="true"' : '' ?>>ไทย</a>
                </div>
                <a class="nav__user" href="#contact">
                    <span class="nav__avatar"><?= e($trip['avatar'] ?? '') ?></span>
                    <?= e(ui('book')) ?>
                </a>
                <button class="icon-btn" type="button" data-menu-toggle aria-expanded="false" aria-label="<?= e(ui('menu')) ?>">
                    <?= icon('menu') ?>
                </button>
            </div>
            <div class="menu" data-menu>
                <a href="#top"><?= e(ui('nav_highlights')) ?></a>
                <a href="#program"><?= e(ui('nav_program')) ?></a>
                <?php if (count($days) > 1) foreach ($days as $d => $day): ?>
                    <a class="menu__sub" href="#day-<?= $d + 1 ?>"><?= e(ui('day')) ?> <?= $d + 1 ?>: <?= e(t($day['title'])) ?></a>
                <?php endforeach; ?>
                <a href="#contact"><?= e(ui('nav_contact')) ?></a>
            </div>
        </nav>

        <aside class="rail" style="--n: <?= $total ?>; --progress: 0%;">
            <div class="rail__track">
                <span class="rail__fill"></span>
                <?php for ($i = 0; $i < $total; $i++): ?>
                    <span class="rail__dot<?= $i === 0 ? ' is-passed' : '' ?>" style="--i: <?= $i ?>"></span>
                <?php endfor; ?>
                <button class="rail__play" type="button" data-play aria-label="<?= e(ui('play_pause')) ?>">
                    <span class="i-play"><?= icon('play') ?></span>
                    <span class="i-pause"><?= icon('pause') ?></span>
                </button>
            </div>
            <div class="rail__count"><b data-current>01</b> / <?= pad2($total) ?></div>
        </aside>

        <div class="hero__content">
            <?php foreach ($slides as $i => $s):
                [$sub, $subLang] = $secondary($s, 'title', 'subtitle');
                $tag = $i === 0 ? 'h1' : 'h2'; ?>
                <article class="hero__text<?= $i === 0 ? ' is-active' : '' ?>"
                         aria-hidden="<?= $i === 0 ? 'false' : 'true' ?>"
                         data-accent="<?= e($s['accent']) ?>"
                         data-bg-top="<?= e($s['bg_top']) ?>"
                         data-bg-bottom="<?= e($s['bg_bottom']) ?>">
                    <p class="hero__time"><?= icon('clock') ?><?= e(time_range($s['start'], $s['end'])) ?></p>
                    <<?= $tag ?> class="hero__title">
                        <span class="main"><?= e(t($s['title'])) ?></span>
                        <span class="sub" lang="<?= e($subLang) ?>"><?= e($sub) ?></span>
                    </<?= $tag ?>>
                    <p class="hero__desc"><?= e(t($s['desc'])) ?></p>
                    <a class="btn" href="<?= e($s['link']) ?>" tabindex="<?= $i === 0 ? '0' : '-1' ?>">
                        <?= e(ui('see_plan')) ?> <?= icon('chev-right') ?>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="hero__cards">
            <?php foreach ($slides as $i => $s):
                $pos = $i === 0 ? -1 : ($i - 1); ?>
                <button class="card" type="button" data-index="<?= $i ?>" data-pos="<?= $pos ?>" style="--p: <?= $pos ?>; --c: <?= e($s['accent']) ?>;" aria-label="<?= e(ui('go_to')) ?> <?= e(t($s['title'])) ?>">
                    <span class="card__label"><?= e(t($s['title'])) ?></span>
                    <span class="card__img"><img src="<?= e(img_src($s['image'], 600)) ?>" alt="" loading="lazy"></span>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="hero__arrows">
            <button class="arrow" type="button" data-prev aria-label="<?= e(ui('prev')) ?>"><?= icon('chev-left') ?></button>
            <button class="arrow" type="button" data-next aria-label="<?= e(ui('next')) ?>"><?= icon('chev-right') ?></button>
        </div>

        <div class="pager" style="--n: <?= $total ?>; --i: 0;">
            <div class="pager__nums">
                <?php for ($i = 0; $i < $total; $i++): ?>
                    <button class="pager__num<?= $i === 0 ? ' is-active' : '' ?>" type="button" data-goto="<?= $i ?>" aria-label="<?= e(ui('slide')) ?> <?= $i + 1 ?>"><?= $i + 1 ?></button>
                <?php endfor; ?>
            </div>
            <div class="pager__bar"><span></span></div>
        </div>
    </header>
</div>

<!-- ============ PROGRAM ============ -->
<main class="program" id="program">
    <section class="intro reveal">
        <h2><?= e(t($trip['title'])) ?></h2>
        <p><?= e(t($trip['tagline'])) ?></p>

        <ul class="facts">
            <?php foreach ($trip['facts'] as $f): ?>
                <li class="fact">
                    <?= icon($f['icon']) ?>
                    <span>
                        <small><?= e(t($f['label'])) ?></small>
                        <b><?= e($f['value'] === 'auto' ? $stopCount . ' ' . ui('places') : t($f['value'])) ?></b>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <?php if (count($days) > 1): ?>
        <nav class="days-nav" aria-label="<?= e(ui('choose_day')) ?>">
            <?php foreach ($days as $d => $day): ?>
                <a class="day-tab<?= $d === 0 ? ' is-active' : '' ?>" href="#day-<?= $d + 1 ?>">
                    <b><?= e(ui('day')) ?> <?= $d + 1 ?></b><?= e(t($day['title'])) ?>
                </a>
            <?php endforeach; ?>
        </nav>
    <?php endif; ?>

    <?php foreach ($days as $d => $day):
        $stops = $day['stops'];
        $firstStop = $stops[0];
        $lastStop  = $stops[count($stops) - 1];
        $flip = false; ?>
        <section class="day" id="day-<?= $d + 1 ?>">
            <header class="day__head reveal">
                <span class="day__num" aria-hidden="true"><?= pad2($d + 1) ?></span>
                <div class="day__label">
                    <small><?= e(ui('day')) ?> <?= $d + 1 ?></small>
                    <h3><?= e(t($day['title'])) ?></h3>
                    <p><?= e(t($day['summary'])) ?></p>
                </div>
                <div class="day__meta">
                    <span class="chip"><?= icon('clock') ?><?= e(time_range($stopTime($firstStop, 'start'), $stopTime($lastStop, 'end'))) ?></span>
                    <span class="chip"><?= icon('pin') ?><?= count(array_filter($stops, $isPlace)) ?> <?= e(ui('stops')) ?></span>
                    <span class="chip"><?= icon('car') ?><?= e(t($day['start'])) ?></span>
                </div>
            </header>

            <ol class="timeline">
                <?php foreach ($stops as $stop): ?>
                    <?php if (!$isPlace($stop)): ?>
                        <li class="stop stop--note reveal">
                            <div class="stop__time"><span class="stop__clock"><?= e($stop['time']) ?></span></div>
                            <p class="note"><?= icon($stop['icon'] ?? 'pin') ?><?= e(t($stop['text'])) ?></p>
                        </li>
                        <?php continue; ?>
                    <?php endif;
                    [$subName, $subLang] = $secondary($stop, 'name', 'subname');
                    $tags = t($stop['tags'] ?? []); ?>
                    <li class="stop reveal<?= $flip ? ' stop--flip' : '' ?>"<?= !empty($stop['id']) ? ' id="stop-' . e($stop['id']) . '"' : '' ?>>
                        <?php $flip = !$flip; ?>
                        <div class="stop__time">
                            <span class="stop__clock"><?= e($stop['start']) ?></span>
                            <small><?= e(ui('until')) ?> <?= e($stop['end']) ?></small>
                        </div>

                        <article class="stop__card">
                            <figure class="stop__media">
                                <img src="<?= e(img_src($stop['image'], 1200)) ?>" alt="<?= e(t($stop['name'])) ?>" loading="lazy">
                                <figcaption class="stop__dur"><?= icon('clock') ?><?= e(duration_label($stop['start'], $stop['end'])) ?></figcaption>
                            </figure>
                            <div class="stop__body">
                                <p class="stop__range"><?= e(time_range($stop['start'], $stop['end'])) ?></p>
                                <h4><?= e(t($stop['name'])) ?></h4>
                                <p class="stop__en" lang="<?= e($subLang) ?>"><?= e($subName) ?></p>
                                <p class="stop__desc"><?= e(t($stop['desc'])) ?></p>
                                <?php if ($tags): ?>
                                    <ul class="stop__tags">
                                        <?php foreach ($tags as $tag): ?>
                                            <li><?= e($tag) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                                <?php if (!empty($stop['tip'])): ?>
                                    <p class="stop__tip"><b><?= e(ui('tip')) ?></b><?= e(t($stop['tip'])) ?></p>
                                <?php endif; ?>
                            </div>
                        </article>

                        <?php if (!empty($stop['transit'])): ?>
                            <p class="transit"><?= icon('car') ?><?= e(t($stop['transit'])) ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        </section>
    <?php endforeach; ?>
</main>

<!-- ============ CONTACT ============ -->
<section class="cta reveal" id="contact">
    <img class="cta__bg" src="<?= e(img_src($trip['contact']['image'] ?? $first['image'], 1800)) ?>" alt="" loading="lazy">
    <h2><?= e(t($trip['contact']['title'])) ?></h2>
    <p><?= e(t($trip['contact']['text'])) ?></p>
    <a class="btn" href="<?= e($trip['contact']['button_link']) ?>"><?= e(t($trip['contact']['button_label'])) ?> <?= icon('arrow-right') ?></a>
</section>

<footer class="footer">
    <p>© <?= date('Y') ?> <?= e($trip['brand']) ?></p>
    <p><?= e(ui('footer_note')) ?></p>
    <p class="footer__credit"><?= e(ui('photos')) ?> <?= e(implode(', ', $trip['credits'])) ?></p>
</footer>

<script src="assets/js/main.js" defer></script>
</body>
</html>
