@php
    $contactItems = [
        [
            'icon' => 'fa-solid fa-phone',
            'title' => 'Phone',
            'primary' => '+91 98765 43210',
            'secondary' => 'Mon - Sat : 10:00 AM - 7:00 PM',
            'href' => 'tel:+919876543210',
        ],
        [
            'icon' => 'fa-regular fa-envelope',
            'title' => 'Email',
            'primary' => 'info@ratnavriksha.com',
            'secondary' => 'We reply within 24 hours',
            'href' => 'mailto:info@ratnavriksha.com',
        ],
        [
            'icon' => 'fa-solid fa-location-dot',
            'title' => 'Address',
            'primary' => 'Surat, Gujarat, India - 395001',
            'secondary' => 'Visit our office',
            'href' => 'https://maps.google.com/?q=Surat,Gujarat,India',
        ],
        [
            'icon' => 'fa-brands fa-whatsapp',
            'title' => 'WhatsApp',
            'primary' => '+91 98765 43210',
            'secondary' => 'Chat with us on WhatsApp',
            'href' => 'https://wa.me/919876543210',
        ],
    ];
@endphp

<section class="contact-section py-5">
    <div class="container">
        <div class="contact-section-inner">
            <div class="row g-4 g-lg-5">
                <div class="col-lg-5">
                    <div class="contact-info">
                        <h2 class="contact-block-label">Get in Touch</h2>
                        <h3 class="contact-info-heading font-pilo">We'd Love to Hear<br>From You</h3>
                        <div class="about-who-divider" aria-hidden="true">
                            <span class="about-who-divider-line"></span>
                            <span class="about-who-divider-icon">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2L20 12L12 22L4 12L12 2Z" fill="none" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                            </span>
                            <span class="about-who-divider-line"></span>
                        </div>
                        <p class="contact-info-intro">Whether you have a question, need expert advice, or want to know more about our diamonds, our team is here to assist you.</p>

                        <ul class="contact-info-list list-unstyled mb-0">
                            @foreach ($contactItems as $item)
                                <li class="contact-info-item">
                                    <div class="contact-info-icon" aria-hidden="true">
                                        <i class="{{ $item['icon'] }}"></i>
                                    </div>
                                    <div class="contact-info-body">
                                        <h3 class="contact-info-title font-pilo">{{ $item['title'] }}</h3>
                                        <p class="contact-info-primary">{{ $item['primary'] }}</p>
                                        <p class="contact-info-text">{{ $item['secondary'] }}</p>
                                    </div>
                                    <a href="{{ $item['href'] }}" class="contact-info-arrow" target="{{ str_starts_with($item['href'], 'http') ? '_blank' : '_self' }}" rel="noopener" aria-label="{{ $item['title'] }}">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-lg-7">
                    @include('frontend.component.contact.form')
                </div>
            </div>
        </div>
    </div>
</section>
