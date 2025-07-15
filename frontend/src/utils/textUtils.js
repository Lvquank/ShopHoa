export const formatUrlString = (str) => {
    if (!str) return '';

    // Handle specific cases
    const specificMappings = {
        'hoa-bo': 'Hoa bó',
        'hoa-gio': 'Hoa giỏ',
        'mau-truyen-thong': 'Mẫu truyền thống',
        'mau-hien-dai': 'Mẫu hiện đại',
        'hoa-khai-truong': 'Hoa khai trương',
        'hoa-dam-tang': 'Hoa đám tang',
        'lan-ho-diep': 'Lan hồ điệp',
        'hoa-dam-tang-cong-giao': 'Hoa đám tang công giáo',
    };

    // Check if we have a specific mapping
    if (specificMappings[str]) {
        return specificMappings[str];
    }

    // General case: convert hyphenated string to title case
    return str
        .split('-')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ');
};
