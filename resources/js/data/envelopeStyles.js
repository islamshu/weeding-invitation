/**
 * Envelope identities shared by the public cover, the owner preview and the
 * studio. `flap` is a normalised SVG path (viewBox 0 0 100 60) so every style
 * keeps the exact same opening animation while looking clearly different.
 */
export const envelopeStyles = [
    {
        key: 'classic',
        name_ar: 'كلاسيكي',
        name_en: 'Classic',
        flap: 'M2 2 L98 2 L50 56 Z',
        seal: 'monogram',
        description_ar: 'ظرف كلاسيكي بخطوط ذهبية وختم دائري.',
        description_en: 'A classic envelope with gold rules and a round seal.',
    },
    {
        key: 'wax',
        name_ar: 'ختم شمعي',
        name_en: 'Wax seal',
        flap: 'M2 2 L98 2 C 78 24, 66 42, 50 56 C 34 42, 22 24, 2 2 Z',
        seal: 'heart',
        description_ar: 'ختم شمعي دافئ وغطاء منحني فخم.',
        description_en: 'A warm wax seal with a beautifully curved flap.',
    },
    {
        key: 'monogram',
        name_ar: 'مونوغرام',
        name_en: 'Monogram',
        flap: 'M2 2 L98 2 L98 34 L50 52 L2 34 Z',
        seal: 'monogram',
        description_ar: 'غطاء هندسي مع أحرف العروسين في المنتصف.',
        description_en: 'A geometric flap with the couple monogram at its heart.',
    },
    {
        key: 'floral',
        name_ar: 'زهري',
        name_en: 'Floral',
        flap: 'M2 2 L98 2 C 86 18, 74 34, 62 38 C 56 52, 44 52, 38 38 C 26 34, 14 18, 2 2 Z',
        seal: 'flower',
        description_ar: 'حافة مقوّسة ولمسات زهور ناعمة.',
        description_en: 'A scalloped flap with soft floral details.',
    },
    {
        key: 'minimal',
        name_ar: 'بسيط',
        name_en: 'Minimal',
        flap: 'M2 2 L98 2 L50 40 Z',
        seal: 'ring',
        description_ar: 'خطوط رفيعة ومساحات هادئة بلا زخرفة.',
        description_en: 'Thin rules and calm whitespace, free of ornament.',
    },
    {
        key: 'arabesque',
        name_ar: 'أرابيسك',
        name_en: 'Arabesque',
        flap: 'M2 2 L98 2 L98 20 C 82 20, 70 30, 50 54 C 30 30, 18 20, 2 20 Z',
        seal: 'star',
        description_ar: 'زخارف عربية متكررة وقمة على شكل قوس.',
        description_en: 'Repeating arabesque patterns under an arched crown.',
    },
    {
        key: 'deco',
        name_ar: 'آرت ديكو',
        name_en: 'Art Deco',
        flap: 'M2 2 L98 2 L98 18 L58 18 L50 52 L42 18 L2 18 Z',
        seal: 'diamond',
        description_ar: 'خطوط هندسية حادة وإيقاع آرت ديكو.',
        description_en: 'Sharp geometry and an unmistakable Art Deco rhythm.',
    },
    {
        key: 'ribbon',
        name_ar: 'شريط حرير',
        name_en: 'Ribbon',
        flap: 'M2 2 L98 2 L98 30 L50 30 L2 30 Z',
        seal: 'bow',
        description_ar: 'شريط حريري عمودي وقوس أنيق.',
        description_en: 'A vertical silk ribbon finished with a graceful bow.',
    },
    {
        key: 'night',
        name_ar: 'ليلة النجوم',
        name_en: 'Starry night',
        flap: 'M2 2 L98 2 C 74 20, 64 40, 50 58 C 36 40, 26 20, 2 2 Z',
        seal: 'moon',
        description_ar: 'سماء داكنة، نجوم ذهبية وهلال رقيق.',
        description_en: 'A dark sky, golden stars and a slender crescent.',
    },
];

export const defaultEnvelopeStyle = envelopeStyles[0];

export function getEnvelopeStyle(key) {
    return envelopeStyles.find((style) => style.key === key) ?? defaultEnvelopeStyle;
}
