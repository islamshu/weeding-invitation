/**
 * Curated font library for invitations.
 *
 * Every entry is self-hosted through the Bunny font loader configured in
 * `vite.config.js`. The Arabic `family` stack always ends with a safe Arabic
 * fallback so text never falls back to a Latin-only face.
 *
 * Keep the keys in sync with `config/invitations.php` (`font_families`).
 */

export const FONT_CATEGORIES = [
    { key: 'naskh', name_ar: 'نسخي ورقعة', name_en: 'Naskh & Ruqaa' },
    { key: 'kufi', name_ar: 'كوفي', name_en: 'Kufi' },
    { key: 'modern', name_ar: 'عصري', name_en: 'Modern' },
    { key: 'display', name_ar: 'عناوين', name_en: 'Display' },
    { key: 'latin', name_ar: 'لاتيني', name_en: 'Latin' },
];

export const FONT_LIBRARY = [
    // ── Naskh & Ruqaa ────────────────────────────────────────────────────
    {
        key: 'naskh',
        name_ar: 'نسخ كلاسيكي',
        name_en: 'Noto Naskh',
        family: "'Noto Naskh Arabic', 'Amiri', serif",
        category: 'naskh',
        sample_ar: 'بسم الله الرحمن الرحيم',
    },
    {
        key: 'amiri',
        name_ar: 'أميري',
        name_en: 'Amiri',
        family: "'Amiri', 'Noto Naskh Arabic', serif",
        category: 'naskh',
        sample_ar: 'يتشرفان بدعوة سيادتكم',
    },
    {
        key: 'scheherazade',
        name_ar: 'شهرزاد',
        name_en: 'Scheherazade New',
        family: "'Scheherazade New', 'Amiri', serif",
        category: 'naskh',
        sample_ar: 'أفراح آل شبلاق',
    },
    {
        key: 'aref_ruqaa',
        name_ar: 'رقعة فنية',
        name_en: 'Aref Ruqaa',
        family: "'Aref Ruqaa', 'Amiri', serif",
        category: 'naskh',
        sample_ar: 'محمد و سارة',
    },

    // ── Kufi ─────────────────────────────────────────────────────────────
    {
        key: 'reem_kufi',
        name_ar: 'ريم كوفي',
        name_en: 'Reem Kufi',
        family: "'Reem Kufi', 'Noto Kufi Arabic', sans-serif",
        category: 'kufi',
        sample_ar: 'دعوة زفاف',
    },
    {
        key: 'noto_kufi',
        name_ar: 'كوفي هندسي',
        name_en: 'Noto Kufi Arabic',
        family: "'Noto Kufi Arabic', 'Reem Kufi', sans-serif",
        category: 'kufi',
        sample_ar: 'حفل الزفاف',
    },

    // ── Modern ───────────────────────────────────────────────────────────
    {
        key: 'cairo',
        name_ar: 'القاهرة',
        name_en: 'Cairo',
        family: "'Cairo', 'Tajawal', sans-serif",
        category: 'modern',
        sample_ar: 'أحمد عبد الله & سارة محمود',
    },
    {
        key: 'tajawal',
        name_ar: 'تجوّل',
        name_en: 'Tajawal',
        family: "'Tajawal', 'Cairo', sans-serif",
        category: 'modern',
        sample_ar: 'بكل محبة وفرح',
    },
    {
        key: 'el_messiri',
        name_ar: 'المسيري',
        name_en: 'El Messiri',
        family: "'El Messiri', 'Cairo', sans-serif",
        category: 'modern',
        sample_ar: 'قاعة الياسمين — رام الله',
    },
    {
        key: 'almarai',
        name_ar: 'المراعي',
        name_en: 'Almarai',
        family: "'Almarai', 'Cairo', sans-serif",
        category: 'modern',
        sample_ar: 'بقي على الفرح ٧٨ يومًا',
    },
    {
        key: 'markazi',
        name_ar: 'مركزي',
        name_en: 'Markazi Text',
        family: "'Markazi Text', 'Amiri', serif",
        category: 'modern',
        sample_ar: 'حضوركم شرف لنا',
    },
    {
        key: 'changa',
        name_ar: 'تشانغا',
        name_en: 'Changa',
        family: "'Changa', 'Cairo', sans-serif",
        category: 'modern',
        sample_ar: 'الاثنين، ١ فبراير ٢٠٢٧',
    },
    {
        key: 'alexandria',
        name_ar: 'الإسكندرية',
        name_en: 'Alexandria',
        family: "'Alexandria', 'Cairo', sans-serif",
        category: 'modern',
        sample_ar: 'يسرنا ويشرفنا دعوتكم',
    },

    // ── Display ──────────────────────────────────────────────────────────
    {
        key: 'lalezar',
        name_ar: 'لالزار',
        name_en: 'Lalezar',
        family: "'Lalezar', 'Cairo', cursive",
        category: 'display',
        sample_ar: 'دعوة زفاف',
    },
    {
        key: 'rakkas',
        name_ar: 'ركّاس',
        name_en: 'Rakkas',
        family: "'Rakkas', 'Cairo', cursive",
        category: 'display',
        sample_ar: 'أفراح آل شبلاق',
    },
    {
        key: 'jomhuria',
        name_ar: 'جمهورية',
        name_en: 'Jomhuria',
        family: "'Jomhuria', 'Cairo', cursive",
        category: 'display',
        sample_ar: 'محمد و سارة',
    },

    // ── Latin ────────────────────────────────────────────────────────────
    {
        key: 'playfair',
        name_ar: 'بلايفير',
        name_en: 'Playfair Display',
        family: "'Noto Naskh Arabic', serif",
        en_family: "'Playfair Display', serif",
        category: 'latin',
        sample_ar: 'Wedding Invitation',
    },
    {
        key: 'cormorant',
        name_ar: 'كورمورانت',
        name_en: 'Cormorant Garamond',
        family: "'Noto Naskh Arabic', serif",
        en_family: "'Cormorant Garamond', serif",
        category: 'latin',
        sample_ar: 'Wedding Invitation',
    },
    {
        key: 'montserrat',
        name_ar: 'مونتسيرات',
        name_en: 'Montserrat',
        family: "'Tajawal', sans-serif",
        en_family: "'Montserrat', sans-serif",
        category: 'latin',
        sample_ar: 'Wedding Invitation',
    },
];

export const FONT_STACKS = Object.fromEntries(
    FONT_LIBRARY.map((font) => [font.key, { ar: font.family, en: font.en_family ?? font.family }])
);

export function getFont(key) {
    return FONT_LIBRARY.find((font) => font.key === key) ?? null;
}

export function fontName(font, lang = 'ar') {
    if (!font) return '';
    return lang === 'ar' ? font.name_ar : font.name_en;
}
