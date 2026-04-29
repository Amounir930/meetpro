 <section class="section section-light">
     <div class="container">
         <div class="section-header mb-6">
             <h2 class="section-title">{{ __('home_cta_title') }}</h2>
             <p>{{ __('home_cta_subtitle') }}</p>
             <a @if (getSetting('AUTH_MODE') == 'enabled') href="{{ route('login') }}"
             @else
             href="#" @endif
                 class="btn btn-primary mt-3">{{ __('home_cta_button') }}</a>
         </div>
     </div>
 </section>
