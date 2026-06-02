@php
    $contactItems = [
        [
            'icon' => 'fa-solid fa-phone',
            'title' => 'Phone',
            'primary' => '+91 7900521005 / +91 7900512005 / +91 7900503005',
            'secondary' => 'you can also call us on the above numbers',
            'href' => 'tel:+917900521005',
        ],
        [
            'icon' => 'fa-regular fa-envelope',
            'title' => 'Email',
            'primary' => 'ratnavrikshaprivatelimited@gmail.com',
            'secondary' => 'We reply within 24 hours',
            'href' => 'mailto:ratnavrikshaprivatelimited@gmail.com',
        ],
        [
            'icon' => 'fa-solid fa-location-dot',
            'title' => 'Address',
            'primary' => 'Flat No 102, First Floor, A Block, Building Name - Nalanda, Samrajya Residency, Near Paradise Hotel, Raipur',
            'secondary' => 'Chhattisgarh - 492001',
            'href' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d33035.76853795265!2d81.5978853743164!3d21.2724059!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a28e728a51b7065%3A0xbeebb3dd7e67c94d!2sSamrajya%20Residency!5e1!3m2!1sen!2sin!4v1780383471113!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        ],
        [
            'icon' => 'fa-brands fa-whatsapp',
            'title' => 'WhatsApp',
            'primary' => '+91 7900521005',
            'secondary' => 'Chat with us on WhatsApp',
            'href' => 'https://wa.me/917900521005',
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
