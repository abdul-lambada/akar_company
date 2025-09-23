@extends('layouts.public')

@section('title', 'Contact')
@section('meta_description', 'Hubungi ' . config('app.name') . ' untuk konsultasi, penawaran, atau pertanyaan seputar layanan kami.')

@section('content')
<section class="section-gap" id="contact">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="product-area-title text-center">
          <p class="text-uppercase">{{ config('app.contact_cta_title', 'Butuh Bantuan?') }}</p>
          <h2 class="h1">{{ config('app.contact_heading', 'Contact Us') }}</h2>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <h3 class="h4">{{ config('app.contact_cta_title', 'Butuh Bantuan?') }}</h3>
        <p class="text-muted">{{ config('app.contact_cta_description', 'Hubungi kami untuk konsultasi gratis dan penawaran terbaik.') }}</p>
        <div class="alert" style="display:none;"></div>
        <form id="myForm" class="form-area">
          <div class="row">
            <div class="col-lg-6 form-group">
              <input name="name" placeholder="Your name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your name'"
                     class="common-input mb-20 form-control" required="" type="text">
            </div>
            <div class="col-lg-6 form-group">
              <input name="email" placeholder="Your email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your email'" class="common-input mb-20 form-control" required="" type="email">
            </div>
            <div class="col-lg-12 form-group">
              <input name="subject" placeholder="Subject" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Subject'" class="common-input mb-20 form-control" required="" type="text">
            </div>
            <div class="col-lg-12 form-group">
              <textarea class="common-textarea form-control" name="message" placeholder="Message" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Message'" required=""></textarea>
            </div>
            <div class="col-lg-12">
              <button class="primary-btn submit-btn mt-2" type="submit">Send Message</button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-lg-6">
        <h3 class="h4">Our Office</h3>
        <ul class="list-unstyled">
          @if(config('mail.from.address'))
            <li><i class="fa fa-envelope-o me-2"></i> {{ config('mail.from.address') }}</li>
          @endif
          @if(config('app.company_whatsapp'))
            <li><i class="fa fa-phone me-2"></i> <a href="https://wa.me/{{ preg_replace('/\D/', '', config('app.company_whatsapp')) }}" target="_blank" rel="noopener">{{ config('app.company_whatsapp') }}</a></li>
          @endif
          <li><i class="fa fa-globe me-2"></i> <a href="{{ config('app.url') }}" target="_blank" rel="noopener">{{ config('app.url') }}</a></li>
        </ul>
      </div>
    </div>
  </div>
</section>
@endsection