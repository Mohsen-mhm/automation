const provinceData = {
    "آذربايجان شرقي": ["اسكو", "اهر", "ایلخچی", "باسمنج", "بستان آباد", "بناب", "تبريز", "تسوج", "جلفا", "خسروشهر", "سراب", "سهند", "شبستر", "صوفیان", "مراغه", "مرند", "ملكان", "ممقان", "ميانه", "هاديشهر", "هريس", "هشترود", "ورزقان"],
    "آذربايجان غربي": ["اروميه", "اشنويه", "بوكان", "تكاب", "خوي", "سر دشت", "سلماس", "شاهين دژ", "ماكو", "مهاباد", "مياندوآب", "نقده", "پلدشت", "پيرانشهر", "چالدران"],
    اردبيل: ["اردبيل", "خلخال", "مشگين شهر", "نمين", "نير", "پارس آباد", "گرمي"],
    اصفهان: ["آران و بيدگل", "اردستان", "اصفهان", "باغ بهادران", "تودشک", "تيران", "حاجي آباد", "خميني شهر", "خوانسار", "درچه", "دهاقان", "زرين شهر", "سميرم", "شهرضا", "عسگران", "علويجه", "فلاورجان", "كاشان", "مباركه", "نجف آباد", "نطنز", "ورزنه", "کوهپایه", "گلپايگان"],
    ايلام: ["آبدانان", "ايلام", "ايوان", "دره شهر", "دهلران", "سرابله", "مهران"],
    بوشهر: ["اهرم", "برازجان", "بوشهر", "جم", "خورموج", "دير", "عسلویه", "كنگان", "کاکی", "گناوه"],
    تهران: ["اسلامشهر", "باقرشهر", "بومهن", "تجريش", "تهران", "دماوند", "رباط كريم", "رودهن", "ري", "شريف آباد", "شهريار", "فشم", "فيروزكوه", "قدس", "قرچك", "كهريزك", "لواسان", "ملارد", "ورامين", "پاكدشت", "چهاردانگه"],
    "چهارمحال بختياري": ["اردل", "بروجن", "شهركرد", "فارسان", "لردگان", "چلگرد"],
    "خراسان جنوبي": ["بيرجند", "سربيشه", "فردوس", "قائن", "نهبندان"],
    "خراسان رضوي": ["تايباد", "تربت جام", "تربت حيدريه", "خواف", "درگز", "سبزوار", "سرخس", "طبس", "طرقبه", "فريمان", "قوچان", "كاشمر", "مشهد", "نيشابور", "چناران", "گناباد"],
    "خراسان شمالي": ["آشخانه", "اسفراين", "بجنورد", "جاجرم", "شيروان"],
    خوزستان: ["آبادان", "انديمشك", "اهواز", "ايذه", "ايرانشهر", "باغ ملك", "بندر امام خميني", "بندر ماهشهر", "بهبهان", "حمیدیه", "خرمشهر", "دزفول", "رامشیر", "رامهرمز", "سوسنگرد", "شادگان", "شادگان", "شوش", "شوشتر", "لالي", "مسجد سليمان", "ملاثانی", "هنديجان", "هويزه"],
    زنجان: ["آب بر", "ابهر", "خدابنده", "خرمدره", "زنجان", "قيدار", "ماهنشان"],
    سمنان: ["ايوانكي", "بسطام", "دامغان", "سمنان", "شاهرود", "گرمسار"],
    "سيستان و بلوچستان": ["ايرانشهر", "خاش", "زابل", "زاهدان", "سراوان", "سرباز", "ميرجاوه", "چابهار"],
    فارس: ["آباده", "ارسنجان", "استهبان", "اقلید", "اوز", "بختگان", "بوانات", "بیضا", "پاسارگاد", "جویم", "جهرم", "خرامه", "خرم‌بید", "خفر", "خنج", "داراب", "رستم", "زرقان", "زرین‌دشت", "سپیدان", "سرچهان", "سروستان", "شیراز", "فراشبند", "فسا", "فیروزآباد", "قیر و کارزین", "کازرون", "کوار", "کوه‌چنار", "گراش", "لارستان", "لامرد", "مرودشت", "ممسنی", "مهر", "نی‌ریز"],
    قزوين: ["آبيك", "بوئين زهرا", "تاكستان", "قزوين"],
    قم: ["قم"],
    کرج: ["اشتهارد", "طالقان", "كرج", "ماهدشت", "نظرآباد", "هشتگرد"],
    كردستان: ["بانه", "بيجار", "حسن آباد", "سقز", "سنندج", "صلوات آباد", "قروه", "مريوان"],
    كرمان: ["انار", "بافت", "بردسير", "بم", "جيرفت", "راور", "رفسنجان", "زرند", "سيرجان", "كرمان", "كهنوج", "کوهبنان"],
    كرمانشاه: ["اسلام آباد غرب", "جوانرود", "سنقر", "صحنه", "قصر شيرين", "كرمانشاه", "كنگاور", "هرسين", "پاوه"],
    "كهكيلويه و بويراحمد": ["دهدشت", "دوگنبدان", "سي سخت", "ياسوج", "گچساران"],
    گلستان: ["آزاد شهر", "آق قلا", "راميان", "علي آباد كتول", "كردكوی", "كلاله", "گرگان", "گنبد كاووس"],
    گيلان: ["آستارا", "املش", "تالش", "رشت", "رودبار", "شفت", "صومعه سرا", "فومن", "لاهیجان", "لنگرود", "ماسال", "ماسوله", "منجيل", "هشتپر"],
    لرستان: ["ازنا", "الشتر", "اليگودرز", "بروجرد", "خرم آباد", "دزفول", "دورود", "كوهدشت", "ماهشهر", "نور آباد"],
    مازندران: ["آمل", "بابل", "بابلسر", "بلده", "بهشهر", "تنكابن", "جويبار", "رامسر", "ساري", "قائم شهر", "محمود آباد", "نكا", "نور", "نوشهر", "چالوس"],
    مركزي: ["آشتيان", "اراك", "تفرش", "خمين", "دليجان", "ساوه", "شازند", "محلات"],
    هرمزگان: ["بستك", "بندر جاسك", "بندر خمیر", "بندر لنگه", "بندرعباس", "حاجي آباد", "دهبارز", "قشم", "قشم", "كيش", "ميناب"],
    همدان: ["اسدآباد", "بهار", "رزن", "ملاير", "نهاوند", "همدان"],
    يزد: ["ابركوه", "اردكان", "اشكذر", "بافق", "تفت", "خضرآباد", "زارچ", "طبس", "مهريز", "ميبد", "هرات", "يزد"]
};
// $(document).ready(function () {
//     $(".ir-province").each(loadProvinces), $(".ir-province").change(loadCities), $(".ir-city").append($("<option>ابتدا استان را انتخاب کنید</option>"))
// });
// var loadProvinces = function () {
//     var t = $(this);
//     t.empty(), t.append($("<option>استان را انتخاب کنید</option>")), $.each(data, function (i, a) {
//         var o = $("<option></option>").attr("value", i).text(i);
//         t.append(o)
//     })
// }, loadCities = function () {
//     var t = $(this).closest("div.ir-select").find(".ir-city"), i = data[$(this).val()];
//     t.empty(), $.each(i, function (i, a) {
//         var o = $("<option></option>").attr("value", a).text(a);
//         t.append(o)
//     })
// };
// Get DOM elements for a specific modal or container
const getElements = (container = document) => {
    return {
        provinceSelect: container.querySelector('.ir-province'),
        citySelect: container.querySelector('.ir-city'),
        irSelect: container.querySelector('.ir-select')
    };
};

// Load provinces into select element
const loadProvinces = (provinceSelect, selectedProvince = '') => {
    if (!provinceSelect) return;

    provinceSelect.innerHTML = '';

    const defaultOption = document.createElement('option');
    defaultOption.text = 'استان را انتخاب کنید';
    defaultOption.value = '';
    provinceSelect.add(defaultOption);

    Object.keys(provinceData).forEach(province => {
        const option = document.createElement('option');
        option.value = province;
        option.text = province;
        provinceSelect.add(option);
    });

    if (selectedProvince) {
        provinceSelect.value = selectedProvince;
    }
};

// Load cities based on selected province
const loadCities = (provinceSelect, citySelect, selectedCity = '') => {
    if (!provinceSelect || !citySelect) return;

    citySelect.innerHTML = '';

    const selectedProvince = provinceSelect.value;

    if (!selectedProvince) {
        const defaultOption = document.createElement('option');
        defaultOption.text = 'ابتدا استان را انتخاب کنید';
        defaultOption.value = '';
        citySelect.add(defaultOption);
        return;
    }

    const cities = provinceData[selectedProvince] || [];
    cities.forEach(city => {
        const option = document.createElement('option');
        option.value = city;
        option.text = city;
        citySelect.add(option);
    });

    if (selectedCity) {
        citySelect.value = selectedCity;
    }
};

// Find the active modal
const findActiveModal = () => {
    const modal = document.querySelector('#edit-modal');
    if (modal) {
        return modal;
    }
    return null;
};

// Handle modal edit
const handleModalEdit = () => {
    Livewire.on('editFormOpened', (data) => {

        // Give the modal time to render
        setTimeout(() => {
            const modal = findActiveModal();

            if (!modal) {
                return;
            }

            const elements = getElements(modal);
            if (!elements.provinceSelect || !elements.citySelect) {
                return;
            }

            // Handle the nested data structure we see in the console
            const provinceValue = data[0]?.province || '';
            const cityValue = data[0]?.city || '';

            // Set province first
            loadProvinces(elements.provinceSelect, provinceValue);
            elements.provinceSelect.dispatchEvent(new Event('change'));

            // After a small delay, set city
            setTimeout(() => {
                loadCities(elements.provinceSelect, elements.citySelect, cityValue);

                // Force change events
                elements.citySelect.dispatchEvent(new Event('change'));
            }, 100);

        }, 100);
    });
};

// Initialize event listeners for a specific container
const initializeEventListeners = (container) => {
    const elements = getElements(container);
    const {provinceSelect, citySelect} = elements;

    if (!provinceSelect || !citySelect) return;

    provinceSelect.addEventListener('change', () => {
        loadCities(provinceSelect, citySelect);
    });
};

// Initialize the province/city selector
const initializeSelector = () => {
    // Initialize for all ir-select containers
    document.querySelectorAll('.ir-select').forEach(container => {
        const elements = getElements(container);
        if (!elements.provinceSelect || !elements.citySelect) return;

        loadProvinces(elements.provinceSelect);
        initializeEventListeners(container);
    });

    handleModalEdit();
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', initializeSelector);
