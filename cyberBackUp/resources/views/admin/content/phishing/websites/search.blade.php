<div class="row">
    @forelse ($websites as $website)
        @if($param == 1)
        <div class="col-xl-3 col-sm-6 xl-4 website-card" data-id="{{ $website->id }}">
            <div class="card">
                <div class="product-box">
                    <div class="product-img">
                        {{--  <img class="img-fluid" src="{{ $website->website_url }}" alt="">  --}}
                        <img class="img-fluid" src="{{ asset('storage/'.$website->cover) }} " alt="">
                        <div class="product-hover">
                            <ul>
                                {{--  @if (auth()->user()->hasPermission('website.trash'))  --}}

                                <li><a class="show-frame trash-website" data-bs-toggle="modal" data-id="{{ $website->id }}" onclick="ShowModalDeleteWebsite({{ $website->id }})" data-name="{{ $website->name }}"><i class="fa-solid fa-trash"></i></a></li>
                              {{--  @endif  --}}
                                {{--  @if (auth()->user()->hasPermission('website.update'))  --}}

                                <li><a class="edit-website" data-bs-toggle="modal"
                                    data-id="{{ $website->id }}"
                                    data-name="{{ $website->name }}"
                                    data-html_code="{{ $website->html_code }}"
                                    data-phishing_category_id="{{ $website->phishing_category_id }}"

                                    data-type="{{ $website->type }}"
                                    data-website_url="{{ $website->website_url }}"
                                    data-from_address_name="{{ $website->from_address_name }}"
                                    data-domain_id="{{ $website->domain_id }}"


                                    ><i class="fa-solid fa-pen"></i></a>

                                </li>
                                {{--  @endif  --}}
                                {{--  @if (auth()->user()->hasPermission('website.view'))  --}}
                                <li><a href="{{ route('website.show',['name' => urlencode($website->name), 'id' => $website->id]) }}" target="_blank"><i class="fa-solid fa-eye"></i></a></li>
                            {{--  @endif  --}}
                            </ul>
                        </div>
                    </div>
                    <div class="product-details">
                        <h4>{{ $website->name }}</h4>
                        <p>{{ $website->category->name ?? '' }}</p>
                    </div>
                </div>
            </div>
        </div>
        @else
            <div class="col-xl-3 col-sm-6 xl-4 website-card" data-id="{{ $website->id }}">
                <div class="card">
                    <div class="product-box">
                        <div class="product-img">
                            <img class="img-fluid" src="{{ asset($website->cover) }}" alt="">
                            <div class="product-hover">
                                <ul>
                                    <li><a class="show-frame trash-website" data-bs-toggle="modal"
                                        data-id="{{ $website->id }}" onclick="ShowModalRestoreWebsite({{ $website->id }})" data-name="{{ $website->name }}">
                                    <i class="fa-solid fa-undo"></i></a></li>
                                    <li><a class="edit-regulator" data-bs-toggle="modal"
                                        data-id="{{ $website->id }}" onclick="ShowModalDeleteWebsite({{ $website->id }})" data-name="{{ $website->name }}">
                                    <i class="fa-solid fa-trash"></i></a></li>
                                    <li><a href="{{ route('website.show', $website->id) }}"><i class="fa-solid fa-eye"></i></a></li>

                                </ul>
                            </div>
                        </div>
                        <div class="product-details">
                            <h4>{{ $website->name }}</h4>
                            <p>{{ $website->category->name ?? '' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @empty
        <div class="col-12">
            <p>{{ __('phishing.no_search_results_found') }}</p>
        </div>
    @endforelse
</div>
