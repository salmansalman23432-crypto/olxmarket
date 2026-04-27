<?php 
include('config/db.php'); 
include('includes/functions.php'); 
include('includes/header.php'); 
?>

<div class="container">
    <div class="help-hero">
        <div class="update-alert">
            <strong>💡 ملاحظة هامة:</strong> 
            مركز المساعدة في تحديث مستمر؛ نوصي بزيارة هذه الصفحة بشكل دوري للاطلاع على أحدث النصائح وإرشادات الأمان في سوق جنزور.
        </div>
    </div>

    <div class="faq-section">
        <h2 style="color: var(--primary); margin-bottom: 20px;">الأسئلة الشائعة وإرشادات الأمان</h2>

        <div class="faq-item">
            <div class="faq-question">كيف يمكنني نشر إعلان جديد؟ <span>+</span></div>
            <div class="faq-answer">
                بعد تسجيل الدخول، اضغط على زر "أضف إعلان" في أعلى الصفحة. قم بتعبئة بيانات السلعة أو الخدمة، اختر القسم المناسب، وارفع صورة واضحة لزيادة فرص البيع.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">كيف أضمن حقي عند الشراء؟ (دليل الأمان) <span>+</span></div>
            <div class="faq-answer">
                نوصي دائماً بالتقابل وجهاً لوجه في أماكن عامة معروفة داخل جنزور (مثل المشروعات، الطريق الساحلي، أو وسط البلاد). قم بفحص السلعة جيداً قبل الدفع، ولا تقم بتحويل مبالغ مالية مسبقاً لأي جهة.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">هل النشر في "سوق جنزور" مجاني؟ <span>+</span></div>
            <div class="faq-answer">
                نعم، النشر في الموقع مجاني تماماً لخدمة أهالي البلدية والمناطق المجاورة، ويهدف لتسهيل حركة البيع والشراء المحلية.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">واجهت مشكلة تقنية، ماذا أفعل؟ <span>+</span></div>
            <div class="faq-answer">
                يمكنك مراسلة الدعم الفني عبر الواتساب مباشرة من خلال قسم "اتصل بنا" أو التأكد من تحديث متصفحك واستخدام صور بأحجام مناسبة.
            </div>
        </div>
    </div>
</div>

<script>
// كود بسيط لإضافة التفاعل مع الأسئلة
document.querySelectorAll('.faq-question').forEach(item => {
    item.addEventListener('click', () => {
        const parent = item.parentElement;
        parent.classList.toggle('active');
        item.querySelector('span').innerText = parent.classList.contains('active') ? '-' : '+';
    });
});
</script>

<?php include('includes/footer.php'); ?>