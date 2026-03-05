document.addEventListener("DOMContentLoaded", function () {
    // English → Bangla number map
    const engToBan = {
        0: "০",
        1: "১",
        2: "২",
        3: "৩",
        4: "৪",
        5: "৫",
        6: "৬",
        7: "৭",
        8: "৮",
        9: "৯",
    };

    // Month map (English → Bangla)
    const months = {
        January: "জানুয়ারি",
        February: "ফেব্রুয়ারি",
        March: "মার্চ",
        April: "এপ্রিল",
        May: "মে",
        June: "জুন",
        July: "জুলাই",
        August: "আগস্ট",
        September: "সেপ্টেম্বর",
        October: "অক্টোবর",
        November: "নভেম্বর",
        December: "ডিসেম্বর",
    };

    function convertToBanglaDate(text) {
        if (!text) return text;

        // Replace English numbers → Bangla
        let converted = text.replace(/[0-9]/g, (d) => engToBan[d]);

        // Replace English months → Bangla months
        for (const [en, bn] of Object.entries(months)) {
            converted = converted.replace(en, bn);
        }

        return converted;
    }

    // Apply conversion to all elements with .bangla-date
    document.querySelectorAll(".bangla-date").forEach(function (el) {
        el.innerText = convertToBanglaDate(el.innerText.trim());
    });
});
