
@extends('layouts.master')

@section('title', 'Contact Us')

@section('main')
    <main class="flex-shrink-0">
        <div class="contact-us">
            <div class="header-container">
                <div class="header-caption">
                    <div class="header-title">Contact Us</div>
                    <p>We'd love to hear from you! Get in touch with us for any inquiries or assistance.</p>
                </div>
            </div>
            <!-- Contact Form Section -->
            <section class="section-container">
                <div class="contact-form">
                    <div class="row">
                        
        
                        <!-- Contact Information -->
                        <div class="col-md-6 p-l-18 m-b-18">
                            <h2 class="font-weight-bold m-b-18">Contact Information</h2>
                            <p>Feel free to reach out to us via email or phone. We are always here to help!</p>
        
                            <div class="business-icon">
                                <p><a href="mailto:{{ $business->email }}"><i class="fa fa-envelope" aria-hidden="true"></i> {{ $business->email }}</p>
                                </div>
                                <div class="business-icon">
                                <p><i class="fa fa-phone" aria-hidden="true"></i> {{ $business->phone_number }}</p>
                                </div>
                                <div class="business-icon">
                                <p><a href="{{ $business->map }}"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $business->address }}</a></p>
                            </div>
        
                            <h4 class="font-weight-bold mt-4">Contact us</h4>
                            <div class="footer-icon-container">
                                @foreach ($contacts as $contact)
                                    <div class="footer-icon" data-toggle="tooltip" title="{{ $contact->platform_name }}">
                                        <a href="{{ $contact->url }}" target="_blank" rel="noopener noreferrer"><img src="{{ asset('icons/'.$contact->icon_class) }}" alt="Social Icon"></a>
                                    </div>
                                @endforeach
                            </div>
                            <h4 class="font-weight-bold mt-4">Find us</h4>
                            <div class="footer-icon-container">
                                @foreach ($marketplaces as $marketplace)
                                    <div class="footer-icon" data-toggle="tooltip" title="{{ $marketplace->platform_name }}">
                                        <a href="{{ $marketplace->url }}" target="_blank" rel="noopener noreferrer"><img src="{{ asset('icons/'.$marketplace->icon_class) }}" alt="Social Icon"></a>
                                    </div>
                                @endforeach
                            </div>
                            <h4 class="font-weight-bold mt-4">Follow Us</h4>
                            <div class="footer-icon-container">
                                @foreach ($socials as $social)
                                    <div class="footer-icon" data-toggle="tooltip" title="{{ $social->platform_name }}">
                                        <a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer"><img src="{{ asset('icons/'.$social->icon_class) }}" alt="Social Icon"></a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact-form-container">
                                <h2 class="font-weight-bold m-b-18">Send Us a Message</h2>
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <form action="{{ route('contact.send') }}" method="POST">
                                    @csrf
                                    @auth
                                        <div class="form-group">
                                            <label for="dis_name">Your Name</label>
                                            <input disabled type="text" name="dis_name" class="form-control @error('dis_name') is-invalid @enderror" placeholder="Enter your name" value="{{ auth()->user()->name }}" required>
                                            <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="dis_email">Your Email</label>
                                            <input disabled type="email" name="dis_email" class="form-control @error('dis_email') is-invalid @enderror" placeholder="Enter your email" value="{{ auth()->user()->email }}" required>
                                            <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endauth
                                    @guest
                                        <div class="form-group">
                                            <label for="name">Your Name</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter your name" value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Your Email</label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email" value="{{ old('email') }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endguest
                                    <div class="form-group">
                                        <label for="message">Your Message</label>
                                        <textarea name="message" rows="5" class="form-control @error('message') is-invalid @enderror" placeholder="Enter your message" required>{{ old('message') }}</textarea>
                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn button-secondary btn-lg">Send Message</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    @include('layouts.partials.footer-secondary')
@endsection

