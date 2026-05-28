<div class="contact-form-wrap">
    <h2 class="contact-form-heading"><i class="fa-regular fa-envelope"></i> Send Us a Message</h2>

    @if (session('contact_success'))
        <div class="alert contact-alert contact-alert--success" role="alert">
            {{ session('contact_success') }}
        </div>
    @endif

    <form action="{{ route('contact.store') }}" method="POST" class="contact-form" novalidate>
        @csrf

        <div class="row g-3 g-md-4">
            <div class="col-12">
                <label class="contact-form-label" for="contact_name">Your Name</label>
                <div class="contact-form-field">
                    <input
                        id="contact_name"
                        type="text"
                        name="name"
                        class="contact-form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        placeholder="Enter your name"
                        required
                        autocomplete="name"
                    >
                    <span class="contact-form-icon" aria-hidden="true"><i class="fa-regular fa-user"></i></span>
                </div>
                @error('name')
                    <div class="contact-form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label class="contact-form-label" for="contact_email">Email Address</label>
                <div class="contact-form-field">
                    <input
                        id="contact_email"
                        type="email"
                        name="email"
                        class="contact-form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="Enter your email"
                        required
                        autocomplete="email"
                    >
                    <span class="contact-form-icon" aria-hidden="true"><i class="fa-regular fa-envelope"></i></span>
                </div>
                @error('email')
                    <div class="contact-form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label class="contact-form-label" for="contact_phone">Phone Number</label>
                <div class="contact-form-field">
                    <input
                        id="contact_phone"
                        type="tel"
                        name="phone"
                        class="contact-form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone') }}"
                        placeholder="Enter your phone number"
                        required
                        autocomplete="tel"
                    >
                    <span class="contact-form-icon" aria-hidden="true"><i class="fa-solid fa-phone"></i></span>
                </div>
                @error('phone')
                    <div class="contact-form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label class="contact-form-label" for="contact_subject">Subject</label>
                <div class="contact-form-field">
                    <input
                        id="contact_subject"
                        type="text"
                        name="subject"
                        class="contact-form-control @error('subject') is-invalid @enderror"
                        value="{{ old('subject') }}"
                        placeholder="How can we help you?"
                        required
                    >
                    <span class="contact-form-icon" aria-hidden="true"><i class="fa-solid fa-list-check"></i></span>
                </div>
                @error('subject')
                    <div class="contact-form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label class="contact-form-label" for="contact_message">Message</label>
                <div class="contact-form-field">
                    <textarea
                        id="contact_message"
                        name="message"
                        class="contact-form-control contact-form-control--textarea @error('message') is-invalid @enderror"
                        rows="3"
                        placeholder="Type your message here..."
                        required
                    >{{ old('message') }}</textarea>
                    <span class="contact-form-icon contact-form-icon--textarea" aria-hidden="true"><i class="fa-regular fa-pen-to-square"></i></span>
                </div>
                @error('message')
                    <div class="contact-form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <button type="submit" class="contact-form-submit">
                    Send Message
                    <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </form>
</div>
