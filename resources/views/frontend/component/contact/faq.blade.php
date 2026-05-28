@php
    $faqs = [
        [
            'question' => 'Are all your diamonds natural and certified?',
            'answer' => 'Yes. Every diamond we offer is 100% natural and accompanied by authentic certification from trusted gemological laboratories, so you can buy with complete confidence.',
        ],
        [
            'question' => 'How can I enquire about a specific diamond?',
            'answer' => 'Browse our product pages and use the enquiry option on any diamond you like. Share your details and our team will get back to you with availability, pricing, and guidance.',
        ],
        [
            'question' => 'Do you offer custom diamond selection or bulk orders?',
            'answer' => 'Absolutely. Whether you need a single stone for a special piece or a curated selection for your business, we work closely with you to match your requirements.',
        ],
        [
            'question' => 'What is your return or exchange policy?',
            'answer' => 'We stand behind the quality of every diamond. Return and exchange terms depend on the product and certification — contact us and we will walk you through the options clearly.',
        ],
        [
            'question' => 'How long does delivery take?',
            'answer' => 'Delivery timelines vary by location and order type. Once your order is confirmed, we provide secure packaging and tracking so your diamond reaches you safely and on time.',
        ],
        [
            'question' => 'Can I visit your office in Surat?',
            'answer' => 'Yes, you are welcome to visit us during business hours. We recommend calling or messaging ahead so our team can prepare and give you the attention you deserve.',
        ],
    ];
@endphp

<section class="contact-faq py-5">
    <div class="container">
        <div class="contact-faq-header text-center">
            <span class="about-who-label">FAQ</span>
            <h2 class="about-who-title font-pilo">Frequently Asked Questions</h2>
            <div class="about-who-divider mx-auto" aria-hidden="true">
                <span class="about-who-divider-line"></span>
                <span class="about-who-divider-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L20 12L12 22L4 12L12 2Z" fill="none" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                </span>
                <span class="about-who-divider-line"></span>
            </div>
            <p class="contact-faq-intro">Quick answers to common questions about our diamonds, orders, and services.</p>
        </div>

        <div class="contact-faq-list" id="contactFaqAccordion">
            @foreach ($faqs as $index => $faq)
                <div class="contact-faq-item {{ $index === 0 ? 'is-open' : '' }}">
                    <button
                        type="button"
                        class="contact-faq-trigger"
                        aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                        aria-controls="contact-faq-panel-{{ $index }}"
                        id="contact-faq-trigger-{{ $index }}"
                    >
                        <span class="contact-faq-question font-pilo">{{ $faq['question'] }}</span>
                        <span class="contact-faq-icon" aria-hidden="true">
                            <i class="fa-solid fa-plus"></i>
                        </span>
                    </button>
                    <div
                        class="contact-faq-panel"
                        id="contact-faq-panel-{{ $index }}"
                        role="region"
                        aria-labelledby="contact-faq-trigger-{{ $index }}"
                    >
                        <div class="contact-faq-panel-inner">
                            <p class="contact-faq-answer">{{ $faq['answer'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
