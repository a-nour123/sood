<section id="{{ $id }}">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header border-bottom p-1">
                    <div class="head-label">
                        <h4 class="card-title">{{ __('locale.FilterBy') }}</h4>
                    </div>
                
                </div>
                <!--Search Form -->
                <div class="card-body mt-2">
                    <form class="dt_adv_search" method="POST">
                        <div class="row g-1 mb-md-1">
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Name') }}:</label>
                                <input class="form-control dt-input" name="filter_name" data-column="1" data-column-index="0"
                                    type="text">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Domain') }}:</label>
                                <select class="form-control dt-input dt-select select2" name="filter_parentFamily" id="Domain" data-column="3"
                                    data-column-index="2">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @foreach ($domains as $domain)
                                        <option value="{{ $domain->name }}">{{ $domain->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.sub_domain') }}:</label>
                                <select class="form-control dt-input dt-select select2" name="filter_familiesOlny" id="SubDlocale.sub_domain"
                                    data-column="4" data-column-index="3">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @foreach ($subDomains as $subDomain)
                                        <option value="{{ $subDomain->name }}">{{ $subDomain->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-0" />
            <div class="card-datatable">
                <table class="dt-advanced-server-search table">
                    <thead>
                        <tr>
                            <th>{{ __('locale.#') }}</th>
                            <th>{{ __('locale.Name') }}</th>
                            <th>{{ __('locale.Order') }}</th>
                            <th>{{ __('locale.Domain') }}</th>
                            <th>{{ __('locale.sub_domains') }}</th>
                            <th>{{ __('locale.Actions') }}</th>
                        </tr>
                    </thead>
                    <!-- <tfoot>
                        <tr>
                            <th>{{ __('locale.#') }}</th>
                            <th>{{ __('locale.Name') }}</th>
                            <th>{{ __('locale.Order') }}</th>
                            <th>{{ __('locale.Domain') }}</th>
                            <th>{{ __('locale.sub_domains') }}</th>
                            <th>{{ __('locale.Actions') }}</th>
                        </tr>
                    </tfoot> -->
                </table>
            </div>
        </div>
    </div>
</section>
