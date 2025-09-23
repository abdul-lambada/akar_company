@extends('layouts.strategy')

@section('title', 'Contact - ' . config('app.name', 'Akar Company'))

@section('meta_description')
{{ config('app.contact_cta_description') }}
@endsection

@section('meta_keywords')
contact, hubungi kami, whatsapp, konsultasi
@endsection

@section('content')
  <section class="section" id="contact">
    <div class="container section-title" data-aos="fade-up">
      <h2>Contact</h2>
      <div><span>{{ config('app.contact_cta_title') }}</span> <span class="description-title">{{ config('app.name') }}</span></div>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="text-center">
            <p>{{ config('app.contact_cta_description') }}</p>
            <a class="btn btn-success" href="https://wa.me/{{ preg_replace('/\D/', '', config('app.company_whatsapp', '')) }}" target="_blank">
              <i class="bi bi-whatsapp"></i> Chat WhatsApp
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection