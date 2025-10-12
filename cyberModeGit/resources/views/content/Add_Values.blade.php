@extends('layouts/contentLayoutMaster')

@section('title', 'Form Layouts')
@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')


<!-- Basic multiple Column Form section start -->
<section id="multiple-column-form">
    <div class="col-md-6 mb-1">
        <label class="form-label" for="select2-basic">Basic</label>
        <form action="{{ route('values.store') }}" method="POST" >
            @csrf
        <select class="select2 form-select" id="select2-basic" name="table_name">
          <option value="reviews">reviews</option>
          <option value="asset_categories">Asset Category</option>
          <option value="asset_environment_categories">Asset Category</option>
          <option value="next_steps">next_steps</option>
          <option value="categories">categories</option>
          <option value="teams">teams</option>
          <option value="technologies">technologies</option>
          {{--  <option value="OR">Oregon</option>
          <option value="AZ">Arizona</option>
          <option value="CO">Colorado</option>
          <option value="ID">Idaho</option>
          <option value="MT">Montana</option>
          <option value="NE">Nebraska</option>
          <option value="NM">New Mexico</option>
          <option value="ND">North Dakota</option>
          <option value="UT">Utah</option>
          <option value="WY">Wyoming</option>
          <option value="AL">Alabama</option>
          <option value="AR">Arkansas</option>
          <option value="IL">Illinois</option>
          <option value="IA">Iowa</option>
          <option value="KS">Kansas</option>
          <option value="KY">Kentucky</option>
          <option value="LA">Louisiana</option>
          <option value="MN">Minnesota</option>
          <option value="MS">Mississippi</option>
          <option value="MO">Missouri</option>
          <option value="OK">Oklahoma</option>
          <option value="SD">South Dakota</option>
          <option value="TX">Texas</option>
          <option value="TN">Tennessee</option>
          <option value="WI">Wisconsin</option>
          <option value="CT">Connecticut</option>
          <option value="DE">Delaware</option>
          <option value="FL">Florida</option>
          <option value="GA">Georgia</option>
          <option value="IN">Indiana</option>
          <option value="ME">Maine</option>
          <option value="MD">Maryland</option>
          <option value="MA">Massachusetts</option>
          <option value="MI">Michigan</option>
          <option value="NH">New Hampshire</option>
          <option value="NJ">New Jersey</option>
          <option value="NY">New York</option>
          <option value="NC">North Carolina</option>
          <option value="OH">Ohio</option>
          <option value="PA">Pennsylvania</option>
          <option value="RI">Rhode Island</option>
          <option value="SC">South Carolina</option>
          <option value="VT">Vermont</option>
          <option value="VA">Virginia</option>
          <option value="WV">West Virginia</option>  --}}
        </select>
      </div>
  <div class="row">
    <div class="col-12">

      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Multiple Column</h4>
        </div>
        <div class="card-body">

                    <div class="col-md-6 col-12 mb-1">
                        <div class="input-group">
                          <input
                            type="text"
                            class="form-control  @error('name') is-invalid @enderror"
                            placeholder="Button on right"
                            aria-describedby="button-addon2"
                            name="name"
                          />
                          @error('name')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                          <button class="btn btn-outline-primary" id="button-addon2" type="submit">Add</button>
                        </div>
                      </div>
                </form>


              <form action="post">
                <div class="col-md-6 mb-1">
                    <label class="form-label" for="select2-basic">Basic</label>
                    <select class="select2 form-select" id="select2-basic">
                      <option value="AK">Alaska</option>
                      <option value="HI">Hawaii</option>
                      <option value="CA">California</option>
                      <option value="NV">Nevada</option>
                      <option value="OR">Oregon</option>
                      <option value="WA">Washington</option>
                      <option value="AZ">Arizona</option>
                      <option value="CO">Colorado</option>
                      <option value="ID">Idaho</option>
                      <option value="MT">Montana</option>
                    </select>
                  </div>


              </form>

            </div>
        </div>
    </div>
  </div>
</section>
<!-- Basic Floating Label Form section end -->
@endsection
@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
@endsection
