<?php
declare(strict_types=1);

/** Escape ข้อความก่อนแสดงผลใน HTML */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/** เติม 0 ข้างหน้า เช่น 3 → "03" */
function pad2(int $n): string
{
    return str_pad((string) $n, 2, '0', STR_PAD_LEFT);
}

/**
 * แปลงค่า image ในไฟล์ข้อมูลเป็น URL
 *  - "unsplash:PHOTO_ID"        → ดึงรูปจาก Unsplash
 *  - "assets/images/xxx.jpg"    → ใช้ไฟล์ในโปรเจกต์ตามเดิม
 */
function img_src(string $image, int $width = 1600): string
{
    if (str_starts_with($image, 'unsplash:')) {
        $id = substr($image, strlen('unsplash:'));
        return 'https://unsplash.com/photos/' . rawurlencode($id) . '/download?w=' . $width;
    }
    return $image;
}

/* ---------------- ภาษา ---------------- */

const LANGS = ['en', 'th'];

/** เลือกภาษา: ?lang=th ในลิงก์ > คุกกี้ที่จำไว้ > ภาษาอังกฤษ */
function detect_lang(): string
{
    $q = $_GET['lang'] ?? null;
    if (is_string($q) && in_array($q, LANGS, true)) {
        if (PHP_SAPI !== 'cli' && !headers_sent()) {
            setcookie('lang', $q, ['expires' => time() + 60 * 60 * 24 * 365, 'path' => '/', 'samesite' => 'Lax']);
        }
        return $q;
    }
    $c = $_COOKIE['lang'] ?? null;
    return (is_string($c) && in_array($c, LANGS, true)) ? $c : 'en';
}

function lang(): string
{
    return $GLOBALS['LANG'] ?? 'en';
}

function other_lang(): string
{
    return lang() === 'en' ? 'th' : 'en';
}

/** ดึงข้อความตามภาษา: รับได้ทั้ง ['en' => ..., 'th' => ...] และข้อความธรรมดา */
function t(mixed $value, ?string $lang = null): mixed
{
    $lang ??= lang();
    if (is_array($value) && (array_key_exists('en', $value) || array_key_exists('th', $value))) {
        return $value[$lang] ?? $value['en'] ?? reset($value);
    }
    return $value;
}

/** ข้อความหน้าเว็บจาก data/ui.php */
function ui(string $key): string
{
    return $GLOBALS['UI'][lang()][$key] ?? $GLOBALS['UI']['en'][$key] ?? $key;
}

/* ---------------- เวลา ---------------- */

/** "08:30" → 510 (นาทีนับจากเที่ยงคืน) */
function to_minutes(string $hhmm): int
{
    [$h, $m] = array_map('intval', explode(':', $hhmm));
    return $h * 60 + $m;
}

/** ระยะเวลาโดยประมาณ เช่น "≈ 2 hr 30 min" / "≈ 2 ชม. 30 นาที" */
function duration_label(string $start, string $end): string
{
    $diff = to_minutes($end) - to_minutes($start);
    if ($diff < 0) {
        $diff += 24 * 60;
    }
    $h = intdiv($diff, 60);
    $m = $diff % 60;

    $parts = [];
    if ($h > 0) {
        $parts[] = $h . ' ' . ui('hr');
    }
    if ($m > 0) {
        $parts[] = $m . ' ' . ui('min');
    }
    return '≈ ' . ($parts ? implode(' ', $parts) : '0 ' . ui('min'));
}

/** ช่วงเวลา เช่น "09:30 to 11:30" / "09:30 – 11:30 น." */
function time_range(string $start, string $end = ''): string
{
    if ($end === '') {
        return $start . ui('time_suffix');
    }
    return $start . ' ' . ui('to') . ' ' . $end . ui('time_suffix');
}

/** ไอคอน SVG ขนาดเล็กที่ใช้ในหน้าเว็บ */
function icon(string $name): string
{
    $paths = [
        'arrow-right' => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'chev-left'   => '<path d="M15 6l-6 6 6 6"/>',
        'chev-right'  => '<path d="M9 6l6 6-6 6"/>',
        'play'        => '<path d="M8 5.5v13l11-6.5z" fill="currentColor" stroke="none"/>',
        'pause'       => '<path d="M8 5v14M16 5v14"/>',
        'menu'        => '<path d="M9 6h12M9 12h12M9 18h12"/><circle cx="4" cy="6" r="1" fill="currentColor"/><circle cx="4" cy="12" r="1" fill="currentColor"/><circle cx="4" cy="18" r="1" fill="currentColor"/>',
        'clock'       => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'pin'         => '<path d="M12 21s-7-6.2-7-11.5a7 7 0 1 1 14 0C19 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/>',
        'calendar'    => '<rect x="3" y="5" width="18" height="16" rx="3"/><path d="M3 10h18M8 3v4M16 3v4"/>',
        'sun'         => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/>',
        'car'         => '<path d="M5 16V11l2-5h10l2 5v5"/><path d="M3 16h18v3H3z"/><circle cx="7.5" cy="13" r="1"/><circle cx="16.5" cy="13" r="1"/>',
        'mountain'    => '<path d="M3 20l6-10 4 6 3-4 5 8z"/>',
        'spark'       => '<path d="M12 3v4M12 17v4M3 12h4M17 12h4M6 6l2.5 2.5M15.5 15.5L18 18M6 18l2.5-2.5M15.5 8.5L18 6"/>',
        'close'       => '<path d="M6 6l12 12M18 6L6 18"/>',
        'globe'       => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.5 2.6 3.8 5.6 3.8 9s-1.3 6.4-3.8 9c-2.5-2.6-3.8-5.6-3.8-9S9.5 5.6 12 3z"/>',
    ];
    $d = $paths[$name] ?? '';
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $d . '</svg>';
}
