<div class="row">
    @forelse ($websites as $website)
        @if($param == 1)
            <div class="col-xl-3 col-sm-6 xl-4 website-card" data-id="{{ $website->id }}">
                <div class="card">
                    <div class="product-box">
                        <div class="product-img">
                            <img class="img-fluid" src="{{ asset($website->cover) }}" alt="">
                            <div class="product-hover">
                                <ul>
                                    <li><a class="show-frame trash-website" data-bs-toggle="modal"
                                        data-id="{{ $website->id }}" onclick="ShowModalDeleteWebsite({{ $website->id }})" data-name="{{ $website->name }}">
                                    <i class="fa-solid fa-trash"></i></a></li>
                                    <li><a class="edit-website" data-bs-toggle="modal"
                                        data-id="{{ $website->id }}" data-name="{{ $website->name }}" data-html_code="{{ $website->html_code }}" data-phishing_category_id="{{ $website->phishing_category_id }}">
                                    <i class="fa-solid fa-pen"></i></a></li>

                                    <li><a  href="{{ route('website.show',$website->id) }}" target="_blank">
                                        <i class="fa-solid fa-eye"></i></a></li> <!-- Button to view HTML code -->
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
            <p>No results found</p>
        </div>
    @endforelse
</div>
