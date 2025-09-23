<footer class="section-full">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="single-footer-widget">
                    <h6 class="text-white text-uppercase mb-20">Tentang {{ config('app.name') }}</h6>
                    <p>{{ config('app.contact_cta_description', 'Kami adalah tim profesional yang berdedikasi untuk membantu bisnis Anda berkembang melalui solusi digital inovatif.') }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="single-footer-widget">
                    <h6 class="text-white text-uppercase mb-20">Kontak Kami</h6>
                    @if(config('app.company_address'))
                        <p class="mb-2"><i class="fa fa-map-marker mr-2"></i>{{ config('app.company_address') }}</p>
                    @endif
                    @if(config('app.company_phone'))
                        <p class="mb-2"><i class="fa fa-phone mr-2"></i><a href="tel:{{ preg_replace('/\D/','', config('app.company_phone')) }}">{{ config('app.company_phone') }}</a></p>
                    @endif
                    @if(config('app.company_email'))
                        <p class="mb-0"><i class="fa fa-envelope mr-2"></i><a href="mailto:{{ config('app.company_email') }}">{{ config('app.company_email') }}</a></p>
                    @endif
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="single-footer-widget">
                    <h6 class="text-white text-uppercase mb-20">Navigation Links</h6>
                    <div class="d-flex">
                        <ul class="footer-nav">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('public.about') }}">About</a></li>
                            <li><a href="{{ route('public.services') }}">Services</a></li>
                            <li><a href="{{ route('public.portfolio') }}">Portfolio</a></li>
                        </ul>
                        <ul class="ml-30 footer-nav">
                            <li><a href="{{ route('public.team') }}">Team</a></li>
                            <li><a href="{{ route('public.pricing') }}">Pricing</a></li>
                            <li><a href="{{ route('public.blog') }}">Blog</a></li>
                            <li><a href="{{ route('public.contact') }}">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom d-flex justify-content-between align-items-center">
            <p class="footer-text m-0">Copyright &copy; {{ date('Y') }} | All rights reserved to <a href="{{ config('app.url') }}">{{ config('app.name') }}</a>.</p>
            <div class="footer-social d-flex align-items-center">
                @if(config('app.company_whatsapp'))
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', config('app.company_whatsapp')) }}" target="_blank" rel="noopener"><i class="fa fa-whatsapp"></i></a>
                @endif
                @if(config('app.company_facebook'))
                    <a href="{{ config('app.company_facebook') }}" target="_blank" rel="noopener"><i class="fa fa-facebook"></i></a>
                @endif
                @if(config('app.company_twitter'))
                    <a href="{{ config('app.company_twitter') }}" target="_blank" rel="noopener"><i class="fa fa-twitter"></i></a>
                @endif
                @if(config('app.company_dribbble'))
                    <a href="{{ config('app.company_dribbble') }}" target="_blank" rel="noopener"><i class="fa fa-dribbble"></i></a>
                @endif
                @if(config('app.company_behance'))
                    <a href="{{ config('app.company_behance') }}" target="_blank" rel="noopener"><i class="fa fa-behance"></i></a>
                @endif
            </div>
        </div>
    </div>
</footer>