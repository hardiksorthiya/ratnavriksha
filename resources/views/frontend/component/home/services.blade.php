<section class="service-section py-5">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="service-content text-center d-flex flex-column align-items-center">
                    <h2 class="service-title font-pilo">Our Best Service For You</h2>
                    <p class="services-subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.</p>
                </div>
            </div>
        </div>

        <div class="row row-cols-2 row-cols-sm-3 row-cols-lg-5 g-4 g-lg-5 mt-5 justify-content-center service-item">
            @for ($i = 0; $i < 5; $i++)
                <div class="col d-flex justify-content-center">
                    <div class="service-card position-relative">
                        <div class="pentagonal-shape"></div>
                        <div class="service-card-content position-relative d-flex flex-column align-items-center justify-content-center">
                            <h6 class="service-card-title text-center">Eco <br>Friendly</h6>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2.75 4.02">
                                <path
                                    d="M69.3,125.73c.08.07.15.15.22.22l1.79,1.73a.07.07,0,0,1,0,.12l-2,1.9,0,.05h0c-.21-.23-.43-.45-.64-.67a.19.19,0,0,1,0-.07v-2.52a.11.11,0,0,1,0-.08l.17-.18.47-.49Zm1.79,2h0l-1.76-.7v1.42Zm-1.76,1.8L71,127.93h0l-1.61.65s0,0,0,0v.91Zm1.66-2h0l-1.66-1.6v.92s0,0,0,0l1.37.55Zm-1.77-.43-.49.62.49.62Zm0,1.42-.48-.61v1Zm-.48-1,.49-.62-.49-.36Zm.52,2v-.87l-.49.36Zm0-2.72v-.87l-.48.52Z"
                                    transform="translate(-68.59 -125.73)" />
                            </svg>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>
