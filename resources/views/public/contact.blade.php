@extends('layouts.public')

@section('title', 'Contact')

@section('content')
<section class="section-gap" id="contact">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 mb-4">
        <h3>Contact Us</h3>
        <p class="text-muted">Isi formulir berikut, tim kami akan segera menghubungi Anda.</p>
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
              <button class="primary-btn submit-btn mt-20" style="float: right;">Send Message</button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-lg-6">
        <h3>Our Office</h3>
        <p>Alamat kantor Anda atau informasi kontak lain di sini.</p>
        <ul class="list-unstyled">
          <li><i class="fa fa-envelope-o me-2"></i> email@company.com</li>
          <li><i class="fa fa-phone me-2"></i> +62 812-3456-7890</li>
          <li><i class="fa fa-map-marker me-2"></i> Jl. Contoh Alamat No. 123, Jakarta</li>
        </ul>
      </div>
    </div>
  </div>
</section>
@endsection