
<!-- BEGIN: Footer-->
 <footer class="footer custom-footer py-2 footer-light {{($configData['footerType'] === 'footer-hidden') ? 'd-none':''}} {{$configData['footerType']}}">
  <p class="clearfix mb-0">
    <span class="float-md-start d-block d-md-inline-block mt-25">{{ __('locale.COPYRIGHT') }} &copy;
      <script>document.write(new Date().getFullYear())</script><a class="ms-25" href="{{ getSystemSetting('APP_AUTHOR_WEBSITE', 'https://www.pksaudi.com/') }}" target="_blank">
        {{ session()->get('locale') == 'ar' ? getSystemSetting('APP_AUTHOR_ABBR_AR', 'Cyber Mode') : getSystemSetting('APP_AUTHOR_ABBR_EN', 'Cyber Mode') }}
        </a>,
      <span class="d-none d-sm-inline-block">{{ __('locale.All rights Reserved') }}</span>
    </span>
  </p>
</footer> 
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>  
<!-- END: Footer-->

{{--  <footer class="footer ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 footer-copyright">
                <p class="mb-0">Copyright 2024 © Cion theme by pixelstrap.</p>
            </div>
            <div class="col-md-6">
                <p class="float-end mb-0">Hand crafted &amp; made with
                    <svg class="footer-icon">
                        <use href="/cion/cionapp/static/assets/svg/icon-sprite.svg#heart"></use>
                    </svg>
                </p>
            </div>
        </div>
    </div>
</footer>  --}}
