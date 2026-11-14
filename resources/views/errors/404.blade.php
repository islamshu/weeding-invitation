<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>الدعوة غير متاحة — دعوة</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cairo:400,600,700|playfair-display:500,600" rel="stylesheet">
    <style>
        :root {
            --ivory: #fbf7f0;
            --paper: #fffdfa;
            --champagne: #c9a86a;
            --champagne-soft: #e6d2ae;
            --burgundy: #6d1f33;
            --ink: #241f19;
            --muted: #5f574c;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100svh;
            display: grid;
            place-items: center;
            padding: 24px;
            color: var(--ink);
            font-family: 'Cairo', system-ui, sans-serif;
            background:
                radial-gradient(900px 420px at 85% -10%, #f1e4cc 0, transparent 62%),
                radial-gradient(700px 380px at 0% 100%, #f7efe3 0, transparent 58%),
                var(--ivory);
        }

        .card {
            position: relative;
            width: min(100%, 560px);
            overflow: hidden;
            padding: clamp(28px, 6vw, 52px);
            text-align: center;
            background: rgba(255, 253, 250, .88);
            border: 1px solid var(--champagne-soft);
            border-radius: 28px;
            box-shadow: 0 35px 90px -55px rgba(61, 44, 21, .55);
            backdrop-filter: blur(10px);
        }

        .card::before {
            content: '';
            position: absolute;
            inset: 12px;
            border: 1px solid rgba(201, 168, 106, .38);
            border-radius: 20px;
            pointer-events: none;
        }

        .halo {
            position: absolute;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            top: -140px;
            inset-inline-end: -100px;
            background: rgba(230, 210, 174, .35);
            filter: blur(36px);
            pointer-events: none;
        }

        .mark {
            position: relative;
            display: inline-flex;
            width: 74px;
            height: 74px;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(201, 168, 106, .75);
            border-radius: 50%;
            background: var(--paper);
            color: var(--burgundy);
            box-shadow: 0 16px 34px -24px rgba(109, 31, 51, .7);
        }

        .mark svg { width: 30px; height: 30px; }

        .code {
            margin: 22px 0 0;
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(40px, 10vw, 64px);
            line-height: 1;
            color: var(--champagne);
            letter-spacing: .06em;
        }

        h1 {
            position: relative;
            margin: 12px 0 0;
            font-family: 'Playfair Display', 'Cairo', serif;
            font-size: clamp(23px, 4vw, 30px);
            font-weight: 600;
        }

        p {
            position: relative;
            margin: 12px auto 0;
            max-width: 380px;
            color: var(--muted);
            font-size: 14px;
            line-height: 2;
        }

        .en {
            margin-top: 4px;
            font-size: 11px;
            color: #8a8175;
            direction: ltr;
            line-height: 1.8;
        }

        .rule {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 22px 0;
            color: var(--champagne);
            font-size: 11px;
        }

        .rule::before,
        .rule::after {
            content: '';
            width: 58px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--champagne));
        }

        .rule::after {
            background: linear-gradient(90deg, var(--champagne), transparent);
        }

        .actions {
            position: relative;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        a {
            display: inline-flex;
            min-height: 44px;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: transform .2s ease, background .2s ease, border-color .2s ease;
        }

        a:hover { transform: translateY(-1px); }

        .primary {
            color: #fdfbf7;
            background: var(--burgundy);
            box-shadow: 0 14px 30px -16px rgba(109, 31, 51, .7);
        }

        .primary:hover { background: #571827; }

        .secondary {
            color: #3b352d;
            border: 1px solid var(--champagne-soft);
            background: rgba(255, 255, 255, .6);
        }

        .secondary:hover { border-color: var(--champagne); }

        @media (max-width: 420px) {
            .actions a { width: 100%; }
        }
    </style>
</head>
<body>
    <main class="card">
        <div class="halo" aria-hidden="true"></div>

        <div class="mark" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21.3l7.8-7.8 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z" />
            </svg>
        </div>

        <p class="code">404</p>
        <h1>الدعوة غير متاحة</h1>
        <p>
            قد يكون الرابط غير صحيح، أو أن الدعوة لم تُنشر بعد،
            أو تم إخفاؤها مؤقتًا. تواصل مع أصحاب الدعوة للحصول على الرابط الصحيح.
        </p>
        <p class="en">
            This invitation is unavailable. The link may be incorrect, or the invitation
            has not been published or has been hidden by its owners.
        </p>

        <div class="rule" aria-hidden="true">✦</div>

        <div class="actions">
            <a class="primary" href="/">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
                العودة للرئيسية
            </a>
            <a class="secondary" href="/dashboard">لوحة التحكم</a>
        </div>
    </main>
</body>
</html>
