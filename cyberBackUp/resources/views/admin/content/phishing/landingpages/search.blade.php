<div class="row">
    @forelse ($landingpages as $landingpage)
        @if($param == 1)
            <div class="col-xl-3 col-sm-6 xl-4 website-card" data-id="{{ $landingpage->id }}">
                <div class="card">
                    <div class="product-box">
                        <div class="product-img">
                            <img class="img-fluid" src="{{ asset($landingpage->website->cover??'') }}" alt="">
                            <div class="product-hover">
                                <ul>
                                    <li><a class="show-frame trash-website" data-bs-toggle="modal" data-id="{{ $landingpage->id }}" onclick="ShowModalDeleteWebsite({{ $landingpage->id }})" data-name="{{ $landingpage->name }}"><i class="fa-solid fa-trash"></i></a></li>
                                    <li><a class="edit-landingpage" data-bs-toggle="modal" data-id="{{ $landingpage->id }}" data-name="{{ $landingpage->name }}" data-description="{{ $landingpage->description }}" data-phishing_website_id="{{ $landingpage->phishing_website_id }}"><i class="fa-solid fa-pen"></i></a></li>
                                    <li><a href="{{ route('admin.phishing.landingpage.show', $landingpage->id) }}"><i class="fa-solid fa-eye"></i></a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="product-details">
                            <h4>{{ $landingpage->name }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-xl-3 col-sm-6 xl-4 website-card" data-id="{{ $landingpage->id }}">
                <div class="card">
                    <div class="product-box">
                        <div class="product-img">
                            <img class="img-fluid" src="{{ asset($landingpage->website->cover??'') }}" alt="">
                            <div class="product-hover">
                                <ul>
                                    <li><a class=" show-frame trash-website" data-bs-toggle="modal" data-id="{{ $landingpage->id }}" onclick="ShowModalRestorePage({{ $landingpage->id }})" data-name="{{ $landingpage->name }}">
                                        <i class="fa-solid fa-undo"></i>

                                <li><a class="edit-regulator" data-bs-toggle="modal" data-id="{{ $landingpage->id }}" onclick="ShowModalDeletePage({{ $landingpage->id }})" data-name="{{ $landingpage->name }}"><i class="fa-solid fa-trash"></i></a>
                                </li>

                                <li><a   href="{{ route('admin.phishing.landingpage.show',$landingpage->id) }}" >
                                        <i class="fa-solid fa-eye"></i></a></li> <!-- Button to view HTML code -->


                                </ul>
                            </div>
                        </div>
                        <div class="product-details">
                            <h4>{{ $landingpage->name }}</h4>
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
