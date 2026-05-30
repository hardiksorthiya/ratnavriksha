<footer class="footer-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="footer-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Ratnavriksha" class="img-fluid">
                </div>
                <p class="footer-description">Ratnavriksha Gems is a trusted name in the diamond industry, dedicated to
                    delivering exceptional natural and lab-grown diamonds with uncompromising quality, ethical sourcing,
                    and complete transparency. </p>
            </div>

            <div class="col-md-4 text-end">
                <img src="{{ asset('images/home/small.png') }}" alt="Ratnavriksha" class="img-fluid footer-small-image">
            </div>

            <div class="col-md-4 d-flex justify-content-md-end">
                <a href="#" class="footer-touch" aria-label="Get in touch">
                    <svg class="footer-touch-ring" viewBox="0 0 200 200" aria-hidden="true">
                        <defs>
                            <path id="footerTouchCircle" fill="none"
                                d="M100,100 m-78,0 a78,78 0 1,1 156,0 a78,78 0 1,1 -156,0" />
                        </defs>
                        <text fill="currentColor" font-size="15.5" font-weight="700" letter-spacing="8.5">
                            <textPath href="#footerTouchCircle" startOffset="0%">
                                GET IN TOUCH - GET IN TOUCH -
                            </textPath>
                        </text>
                    </svg>
                    <span class="footer-touch-center"></span>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <p class="footer-brand">Ratnavriksha</p>
            </div>
        </div>

        <div class="row footer-bottom align-items-center g-3">
            <div class="col-md-6 col-12">
                <p class="footer-copyright mb-0">Copyright &copy; {{ date('Y') }} Ratnavriksha. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 col-12">
                <ul class="footer-social-links">
                    <li>
                        <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer"
                            aria-label="Facebook">
                            <i class="fa-brands fa-facebook-f" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer"
                            aria-label="Instagram">
                            <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/" target="_blank" rel="noopener noreferrer"
                            aria-label="X (Twitter)">
                            <i class="fa-brands fa-x-twitter" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
