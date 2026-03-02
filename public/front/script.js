document.addEventListener("DOMContentLoaded", function () {

    const subscribeBtn = document.querySelector('.subscribe-btn');

    if (subscribeBtn) {
        subscribeBtn.addEventListener('click', function () {
            alert('شكرًا لاشتراكك! سيتم إرسال تحديثاتنا إلى بريدك.');
        });
    }

});
// ================= Subjects =================
function selectSubject(subject) {
    const subjects = {
        math: 'الرياضيات',
        english: 'الإنجليزي',
        arabic: 'اللغة العربية',
        science: 'العلوم',
        social: 'الدراسات الاجتماعية'
    };

    alert(`تم اختيار مادة: ${subjects[subject]}`);
    // window.location.href = `/subject/${subject}`;
}

// ================= Teachers =================
function selectTeacher(teacherId) {
    alert(`تم اختيار المدرس رقم ${teacherId}`);
    // window.location.href = `/teacher/${teacherId}`;
}

// ================= Animations =================
document.addEventListener("DOMContentLoaded", function () {

    // Subject Cards Animation
    const subjectCards = document.querySelectorAll('.subject-card');
    subjectCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'scale(0.9)';

        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'scale(1)';
        }, index * 100);
    });

    // Teacher Cards Animation
    const teacherCards = document.querySelectorAll('.teacher-card');
    teacherCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';

        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

});

// ================= Actions =================
function askQuestion() {
    alert('سيتم فتح نموذج الأسئلة');
}

function joinLive() {
    alert('سيتم الانتقال للحصص المباشرة');
}

// ================= Navigation =================
function goToTest(url) {
    window.location.href = url;
}

function goToReview(url) {
    window.location.href = url;
}
// ================= Features =================
function handleFeature(feature) {
    const features = {
        explain: 'شرح الدرس',
        practice: 'تطبيق عملي',
        exams: 'امتحانات دورية',
        followup: 'متابعة مستمرة'
    };

    console.log(`تم اختيار: ${features[feature]}`);
    // window.location.href = `/feature/${feature}`;
}

// ================= Contact =================
function handleContact() {
    alert('سيتم توجيهك لصفحة التواصل');
    // window.location.href = '/contact';
}

// ================= Animations =================
document.addEventListener("DOMContentLoaded", function () {

    // Feature Cards Animation
    const featureCards = document.querySelectorAll('.feature-card');
    featureCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateX(50px)';

        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateX(0)';
        }, index * 100);
    });

    // Learning Cards Animation
    const learningCards = document.querySelectorAll('.learning-card');
    learningCards.forEach((card, index) => {
        card.style.opacity = '1';
        card.style.transform = 'scale(0.8)';

        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'scale(1)';
        }, index * 100);
    });

});
// Navigation functions
function goToTest(url) {
    window.location.href = url;
}

function goToReview(url) {
    window.location.href = url;
}
 function handleFeature(feature) {
            const features = {
                'explain': 'شرح الدرس',
                'practice': 'تطبيق عملي',
                'exams': 'امتحانات دورية',
                'followup': 'متابعة مستمرة'
            };
            
            console.log(`تم اختيار: ${features[feature]}`);
            // يمكنك هنا إضافة كود للانتقال لصفحة معينة أو عرض محتوى
        }

        // Animation on load
        window.addEventListener('load', function() {
            const cards = document.querySelectorAll('.feature-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateX(50px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateX(0)';
                }, index * 100);
            });
        });
        function handleContact() {
        alert('سيتم توجيهك لصفحة التواصل');
        // window.location.href = '/contact';
    }

    // Animation عند التحميل
window.addEventListener('load', function() {
    const cards = document.querySelectorAll('.learning-card');
    cards.forEach((card, index) => {
        card.style.opacity = '1';
        card.style.transform = 'scale(0.8)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'scale(1)';
        }, index * 100);
    });
});
function openSummary() {
    alert('ملخص الوحدة متاح بعد إتمام جميع الدروس.');
}

function openExam() {
    alert('الامتحان متاح بعد إتمام جميع الدروس.');
}

   function togglePassword() {
  const input = document.getElementById("password");
  input.type = input.type === "password" ? "text" : "password";
}
function openSummary() {
    alert('ملخص الوحدة متاح بعد إتمام جميع الدروس.');
}

function openExam() {
    alert('الامتحان متاح بعد إتمام جميع الدروس.');
}
 // Tabs (Email / Phone)
const tabs = document.querySelectorAll('.login-tabs button');
const emailInput = document.querySelector('input[type="email"]');

tabs.forEach(tab => {
    tab.addEventListener('click', () => {

        // remove active from all
        tabs.forEach(btn => btn.classList.remove('active'));

        // add active to clicked
        tab.classList.add('active');

        // change placeholder
        if (tab.textContent.includes('هاتف')) {
            emailInput.type = 'tel';
            emailInput.placeholder = 'أدخل رقم الهاتف';
        } else {
            emailInput.type = 'email';
            emailInput.placeholder = 'أدخل بريدك الإلكتروني';
        }
    });
});
// ================= Slider =================
let currentIndex = 0;

function scrollCards(direction) {
    const slider = document.getElementById("videosSlider");
    if (!slider) return;

    const cardWidth = 320; // عرض الكارد + المسافة
    const totalCards = slider.children.length;

    const wrapper = document.querySelector('.slider-wrapper');
    if (!wrapper) return;

    const visibleCards = Math.floor(wrapper.offsetWidth / cardWidth);

    currentIndex += direction;

    // الحدود
    if (currentIndex < 0) currentIndex = 0;
    if (currentIndex > totalCards - visibleCards) {
        currentIndex = totalCards - visibleCards;
    }

    slider.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
}

// ================= Animations =================
document.addEventListener("DOMContentLoaded", function () {

    const cards = document.querySelectorAll('.subject-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'scale(0.9)';

        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'scale(1)';
        }, index * 100);
    });

});

// ================= Actions =================
function askQuestion() {
    alert('سيتم فتح نموذج الأسئلة');
}

function joinLive() {
    alert('سيتم الانتقال للحصص المباشرة');
}
