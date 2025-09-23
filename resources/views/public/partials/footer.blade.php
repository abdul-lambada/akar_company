<!-- ======= Public Site Footer ======= -->
<footer class="section-full">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-sm-6">
        <div class="single-footer-widget">
          <h6 class="text-white text-uppercase mb-20">Tentang {{ config('app.name') }}</h6>
          <p>{{ config('app.footer_about', 'Pusat solusi digital, desain kreatif, dan pengembangan perangkat lunak terpercaya.') }}</p>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="single-footer-widget">
          <h6 class="text-white text-uppercase mb-20">Navigasi</h6>
          <div class="d-flex">
            <ul class="footer-nav">
              <li><a href="#top">Beranda</a></li>
              <li><a href="#services">Layanan</a></li>
              <li><a href="#portfolio">Portfolio</a></li>
              <li><a href="#team">Tim</a></li>
            </ul>
            <ul class="ml-30 footer-nav">
              <li><a href="#blog">Blog</a></li>
              <li><a href="#contact">Kontak</a></li>
              @auth
              <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
              @endauth
            </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="single-footer-widget">
          <h6 class="text-white text-uppercase mb-20">Newsletter</h6>
          <p>Dapatkan info terbaru seputar layanan dan artikel menarik kami.</p>
          <div id="mc_embed_signup">
            <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="subscription relative d-flex justify-content-center">
              <input type="email" name="EMAIL" placeholder="Alamat email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Alamat email'" required>
              <div style="position: absolute; left: -5000px;" aria-hidden="true">
                <input type="text" name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="">
              </div>
              <button type="submit" class="newsletter-btn" name="subscribe" aria-label="Berlangganan"><span class="lnr lnr-location"></span></button>
              <div class="info"></div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="single-footer-widget">
          <h6 class="text-white text-uppercase mb-20">Ikuti Kami</h6>
          <ul class="instafeed d-flex flex-wrap gap-2">
            @foreach(range(1,4) as $i)
              <li><img src="{{ asset('public_template/img/i'.$i.'.jpg') }}" alt="Insta {{$i}}" loading="lazy"></li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-bottom d-flex justify-content-between align-items-center flex-wrap">
      <p class="footer-text m-0">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
      <div class="footer-social d-flex align-items-center gap-3">
        <a href="#" aria-label="Facebook"><i class="fa fa-facebook"></i></a>
        <a href="#" aria-label="Twitter"><i class="fa fa-twitter"></i></a>
        <a href="#" aria-label="Instagram"><i class="fa fa-instagram"></i></a>
        <a href="#" aria-label="LinkedIn"><i class="fa fa-linkedin"></i></a>
      </div>
    </div>
  </div>
</footer>
<!-- ======= End Public Site Footer ======= -->