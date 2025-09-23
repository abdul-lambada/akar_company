@extends('layouts.public')

@section('title', 'Contact Us')

@section('content')
    <!-- Page Header -->
    <section class="page-header d-flex align-items-center" style="background:url('{{ asset('public_template/img/header-bg.jpg') }}') center/cover no-repeat; min-height:300px">
        <div class="container text-center">
            <h1 class="display-4 fw-bold text-white">Get in Touch</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Contact</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Contact Details & Form -->
    <section class="py-5">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-5">
                    <h3 class="fw-bold mb-4">Let's talk about your project</h3>
                    <p class="text-muted">We'd love to hear from you. Reach out through any of the channels below and we'll respond promptly.</p>
                    <ul class="list-unstyled mb-4">
                        <li class="d-flex mb-3"><i class="bi bi-geo-alt text-primary fs-5 me-3"></i> <span>{{ $contactAddress ?? 'Jl. Contoh No.123, Jakarta' }}</span></li>
                        <li class="d-flex mb-3"><i class="bi bi-telephone text-primary fs-5 me-3"></i> <span>{{ $contactPhone ?? '+62 812 3456 7890' }}</span></li>
                        <li class="d-flex"><i class="bi bi-envelope text-primary fs-5 me-3"></i> <span>{{ $contactEmail ?? 'hello@akarcompany.com' }}</span></li>
                    </ul>

                    <h5 class="fw-semibold mb-3">Follow Us</h5>
                    <div class="d-flex">
                        <a href="#" class="text-primary me-3 fs-5"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-primary me-3 fs-5"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-primary me-3 fs-5"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-primary fs-5"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h4 class="fw-semibold mb-3">Send us a message</h4>
                            <form method="POST" action="{{ route('contact.submit') }}" class="needs-validation" novalidate>
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                        <div class="invalid-feedback">Please enter your name.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" required>
                                        <div class="invalid-feedback">Valid email is required.</div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Subject</label>
                                        <input type="text" name="subject" class="form-control" required>
                                        <div class="invalid-feedback">Please enter a subject.</div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Message</label>
                                        <textarea name="message" rows="5" class="form-control" required></textarea>
                                        <div class="invalid-feedback">Please enter your message.</div>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-primary px-4">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Google Map Embed -->
    <section class="map-section">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126914.36148445771!2d106.68942915399215!3d-6.229379304023246!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f1576e18f1f3%3A0x4027a76e35316c0!2sJakarta!5e0!3m2!1sen!2sid!4v1611113133371!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </section>
@endsection

@push('scripts')
<script>
    // Bootstrap client-side validation for example
    (function () {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        })
    })();
</script>
@endpush