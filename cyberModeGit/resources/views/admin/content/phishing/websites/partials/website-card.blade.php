  {{-- <div class="col-xl-3 col-sm-6 xl-4 website-card" data-id="{{ $website->id }}">
      <div class="card">
          <div class="product-box">
              <div class="product-img">
                  <img class="img-fluid" src="{{ asset('storage/' . $website->cover) }} " alt="">
                  <div class="product-hover">
                      <ul>
                          @if (auth()->user()->hasPermission('website.trash'))
                              <li><a class="show-frame trash-website" data-bs-toggle="modal"
                                      data-id="{{ $website->id }}"
                                      onclick="ShowModalDeleteWebsite({{ $website->id }})"
                                      data-name="{{ $website->name }}"><i class="fa-solid fa-trash"></i></a></li>
                          @endif
                          @if (auth()->user()->hasPermission('website.update'))
                              <li><a class="edit-website" data-bs-toggle="modal" data-id="{{ $website->id }}"
                                      data-name="{{ $website->name }}" data-html_code="{{ $website->html_code }}"
                                      data-phishing_category_id="{{ $website->phishing_category_id }}"
                                      data-type="{{ $website->type }}" data-website_url="{{ $website->website_url }}"
                                      data-from_address_name="{{ $website->from_address_name }}"
                                      data-domain_id="{{ $website->domain_id }}"><i class="fa-solid fa-pen"></i></a>

                              </li>
                          @endif
                          <li><a href="{{ route('website.show', ['name' => urlencode($website->name), 'id' => $website->id]) }}"
                                  target="_blank"><i class="fa-solid fa-eye"></i></a></li>
                      </ul>
                  </div>
              </div>
              <div class="product-details">
                  <h4>{{ $website->name }}</h4>
                  <p>{{ $website->category->name ?? '' }}</p>
              </div>
          </div>
      </div>
  </div> --}}




  <!-- في ملف website-card.blade.php -->
<div class="col-xl-3 col-sm-6 xl-4 website-card" data-id="{{ $website->id }}">
    <div class="card">
        <div class="product-box">
            <div class="product-img">
                <img class="img-fluid" src="{{ asset('storage/' .$website->cover ?? 'default-image.jpg') }}" alt="">
                <div class="product-hover">
                    <ul>
                        @if(auth()->user()->hasPermission('website.trash'))
                            <li>
                                <a class="show-frame trash-website"
                                   data-bs-toggle="tooltip"
                                   data-bs-placement="top"
                                   title="{{ __('locale.Delete') }}"
                                   onclick="ShowModalDeleteWebsite({{ $website->id }})">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->hasPermission('website.update'))
                            <li>
                                <a class="show-frame edit-website"
                                   data-bs-toggle="tooltip"
                                   data-bs-placement="top"
                                   title="{{ __('locale.Edit') }}"
                                   data-id="{{ $website->id }}"
                                   data-name="{{ $website->name }}"
                                   data-phishing_category_id="{{ $website->phishing_category_id }}"
                                   data-from_address_name="{{ $website->from_address_name }}"
                                   data-website_url="{{ $website->website_url }}"
                                   data-type="{{ $website->type }}"

                                    data-download_fonts="{{ $website->download_fonts ? 1 : 0 }}"
                                    data-download_other_assets="{{ $website->download_other_assets ? 1 : 0 }}"
                                    data-download_css="{{ $website->download_css ? 1 : 0 }}"
                                    data-download_js="{{ $website->download_js ? 1 : 0 }}"
                                    data-download_images="{{ $website->download_images ? 1 : 0 }}"
                                    data-download_json="{{ $website->download_json ? 1 : 0 }}"

                                   data-domain_id="{{ $website->domain_id }}"
                                   data-is_spa="{{ $website->is_spa ? 1 : 0 }}"
                                   data-spa_html_code="{{ $website->spa_html_code }}"
                                   data-cover="{{ $website->cover ? asset('storage/'.$website->cover) : '' }}"
                                   data-html_code="{{ htmlspecialchars($website->html_code, ENT_QUOTES, 'UTF-8') }}">
                                   <i class="fa-solid fa-pen"></i>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a class="show-frame view-website"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="{{ __('locale.View') }}"
                                href="{{ route('website.show', ['name' => urlencode($website->name), 'id' => $website->id]) }}"
                                target="_blank">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="product-details">
                <div class="product-name">
                    <h6>
                        @if($website->is_spa)
                            <small class="text-info spa-indicator">SPA Mode</small><br>
                        @endif
                        {{ $website->name }}
                    </h6>
                </div>
                <div class="product-price">
                    <small class="text-muted">{{ __('locale.Category') }}: {{ $website->category->name ?? 'N/A' }}</small><br>
                    <small class="text-muted">{{ __('locale.Type') }}: {{ ucfirst($website->type) }}</small><br>
                    <small class="text-muted">{{ __('locale.Updated') }}: {{ $website->updated_at->diffForHumans() }}</small>

                    @if($website->is_spa)
                        <br><small class="text-info"><i class="fa fa-code"></i> SPA Website</small>
                    @endif

                    @if(!empty($website->scraped_assets))
                        @php
                            $assetCount = is_string($website->scraped_assets) ?
                                count(json_decode($website->scraped_assets, true) ?? []) :
                                count($website->scraped_assets ?? []);
                        @endphp
                        <br><small class="text-success"><i class="fa fa-download"></i> {{ $assetCount }} {{ __('locale.Assets Downloaded') }}</small>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

