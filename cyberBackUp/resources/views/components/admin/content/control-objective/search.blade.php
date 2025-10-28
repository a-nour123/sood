<section id="{{ $id }}">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form class="dt_adv_search" method="POST"></form>
            
            <div class="card-datatable">
                <div class="table-responsive">
                <table class="dt-advanced-server-search table" style="  overflow-x: auto !important;" aria-label="">
                    <thead>
                        <tr>
                            <th>{{ __('locale.#') }}</th>
                            <th>{{ __('locale.Name') }}</th>
                            <th>{{ __('locale.Description') }}</th>
                            <th>{{ __('locale.Framework') }}</th>
                            <th>{{ __('locale.Controls') }}</th>
                            <th>{{ __('locale.CreatedDate') }}</th>
                            <th>{{ __('locale.Actions') }}</th>
                        </tr>
                    </thead>
                    <!-- <tfoot>
                        <tr>
                            <th>{{ __('locale.#') }}</th>
                            <th>{{ __('locale.Name') }}</th>
                            <th>{{ __('locale.Description') }}</th>
                            <th>{{ __('locale.Framework') }}</th>
                            <th>{{ __('locale.Controls') }}</th>
                            <th>{{ __('locale.CreatedDate') }}</th>
                            <th>{{ __('locale.Actions') }}</th>
                        </tr>
                    </tfoot> -->
                </table>
                </div>
               
            </div>
        </div>
    </div>
</section>
