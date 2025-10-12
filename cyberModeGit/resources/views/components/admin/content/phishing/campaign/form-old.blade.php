<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModal" aria-hidden="true" id="{{ $id }}">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myExtraLargeModal">{{ $title }}</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>


        <div class="page-body">
            <div class="row my-5">
                <div class="col-xl-12">
                    <div class="card height-equal">
                        <div class="card-header pb-0">
                            <h3 class="my-3">New Campaign Wizard</h3>
                        </div>

                        <div class="card-body basic-wizard important-validation">
                            <div class="stepper-horizontal" id="stepper1">
                                <div class="stepper-one stepper step editing active">
                                    <div class="step-circle"><span>1</span></div>
                                    <div class="step-title">Employee Selection</div>
                                    <div class="step-bar-left"></div>
                                    <div class="step-bar-right"></div>
                                </div>
                                <div class="stepper-two step">
                                    <div class="step-circle"><span>2</span></div>
                                    <div class="step-title">Select Material</div>
                                    <div class="step-bar-left"></div>
                                    <div class="step-bar-right"></div>
                                </div>
                                <div class="stepper-three step">
                                    <div class="step-circle"><span>3</span></div>
                                    <div class="step-title">Delivery Schedule</div>
                                    <div class="step-bar-left"></div>
                                    <div class="step-bar-right"></div>
                                </div>
                                <div class="stepper-four step">
                                    <div class="step-circle"><span>4</span></div>
                                    <div class="step-title">Review & Submit</div>
                                    <div class="step-bar-left"></div>
                                    <div class="step-bar-right"></div>
                                </div>
                            </div>

                            <div id="msform">
                                {{-- Step 1 --}}
                                <form class="stepper-one row g-3 needs-validation custom-input" novalidate="" id="form-step-one">
                                    <div class="col-sm-5">
                                        <label class="form-label" for="campaign-name-basic-wizard" title="This can be anything you want. We recommend something that will help to uniquely identify this campaign from others (e.g. &quot;All-Staff-Mar-23&quot;).">Campaign Name: <span class="txt-danger">*</span></label>
                                        <input class="form-control" id="campaign-name-basic-wizard" name="campaign_name" type="text" required="required" placeholder="Enter a unique campaign name">
                                        <span class="error error-campaign_name text-danger my-2"></span>
                                    </div>

                                    <div class="col-sm-4">
                                        <label class="form-label" for="campaign-type-basic-wizard" title="What type of campaign are you looking to schedule? Simulated Phishing? Security Awareness Training? Or combine both together, and only assign training to those who fall victim to phishing">Campaign type: <span class="txt-danger">*</span></label>
                                        <select class="form-select select2" aria-label="Default select example" name="campaign_type" required="required" id="">
                                            <option value="simulated_phishing">Simulated Phishing</option>
                                            <option value="security_awareness">Security Awareness</option>
                                            <option value="simulated_phishing_and_security_awareness">Simulated Phishing And Security Awareness</option>
                                        </select>
                                        <span class="error error-campaign_type text-danger my-2"></span>
                                    </div>


                                    <div class="col-sm-3" id="training_frequency">
                                        <label class="form-label" for="campaign-type-basic-wizard" title="What type of campaign are you looking to schedule? Simulated Phishing? Security Awareness Training? Or combine both together, and only assign training to those who fall victim to phishing">Training Frequency: <span class="txt-danger">*</span></label>
                                        <select class="form-select select2" aria-label="Default select example" name="training_frequency" required="required">
                                            <option>One-off</option>
                                            <option value="daily">Daily</option>
                                            <option value="weekly">Deekly</option>
                                            <option value="monthly">Monthly</option>
                                            <option value="quarterly">Quarterly</option>
                                            <option value="annually">Annually</option>
                                        </select>
                                        <span class="error error-training_frequency text-danger my-2"></span>
                                    </div>

                                    <div class="col-sm-12 row">
                                        <div class="col-sm-12 my-3">
                                            <b>Select Employees</b>
                                        </div>

                                    <div class="col-sm-5">
                                        <h6 class="my-3">Available Employee Lists</h6>
                                        <select class="form-select select2" aria-label="Default select example" name="available_employee_list">
                                            @foreach ($employees as $employee)
                                                <option value="{{$employee->id}}">{{ $employee->name }}</option>
                                            @endforeach
                                        </select>

                                        <select multiple class="form-control" id="available_employees" name="available_employees[]">
                                            @foreach ($employees as $employee)
                                                <option value="{{$employee->id}}">{{ $employee->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-2">
                                            <div class="col d-flex flex-column justify-content-center" style="margin-top: 100px; margin-left: 50px;">
                                                <button type="button" class="btn btn-sm btn-primary mb-2" onclick="moveSelected('available_employees', 'selected_employees')">></button>
                                                <button type="button" class="btn btn-sm btn-primary mb-2" onclick="moveAll('available_employees', 'selected_employees')"> >></button>
                                                <button type="button" class="btn btn-sm btn-secondary mb-2" onclick="moveSelected('selected_employees', 'available_employees')"><</button>
                                                <button type="button" class="btn btn-sm btn-secondary" onclick="moveAll('selected_employees', 'available_employees')"><<</button>
                                            </div>
                                    </div>

                                    <div class="col-sm-5">
                                            <h6 class="my-3">Selected Employee List</h6>
                                            <select class="form-select select2" aria-label="Default select example" name="selected_employee_list">
                                                @foreach ($employees as $employee)
                                                    <option value="{{$employee->id}}">{{ $employee->name }}</option>
                                                @endforeach
                                            </select>

                                            <select multiple class="form-control" id="selected_employees" name="selected_employees[]">
                                            </select>

                                            <span class="error error-selected_employees text-danger my-2"></span>
                                            <button type="button" class="btn btn-sm btn-warning my-2" id="filter-employees">Filter employees</button>
                                    </div>
                                    </div>

                                </form>


                                {{-- Step 2 --}}
                                <form class="stepper-two row g-3 needs-validation custom-input" novalidate="" id="form-step-two">
                                    <div class="col-md-12" style="max-height: 400px; overflow: scroll">
                                        <div class="row">
                                            <div class="col-12">
                                                <label class="form-label text-bold" for="campaign-name-basic-wizard" >Phishing Material Selection : <span class="txt-danger">*</span></label>
                                                <span class="error error-email_templates text-danger my-2"></span>
                                            </div>

                                            <div class="col-md-8 mb-4">
                                                <select class="form-select select2" aria-label="Default select example" name="selected_employee_list">
                                                    <option>--</option>
                                                    @foreach ($emailtemplate as $template)
                                                        <option value="{{$template->id}}">{{$template->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-4 mb-4">
                                                <input class="form-control" id="search" name="search" type="text" required="required" placeholder="Type the name of phish">
                                            </div>
                                            {{-- @foreach ($emailtemplate as $template)
                                                <div class="col-md-4 mb-4" style="max-height: 250px;overflow: scroll">
                                                    <div class="card email-template-card" onclick="openEmailTemplate({{ $template['id'] }})">
                                                        <div class="card-header pb-0 my-4">
                                                            <span class="topleftcorner">{{ $template['email_difficulty'] }}</span>
                                                            <span class="topcorner">Payload: {{$template['payload_type']}}</span>
                                                        </div>

                                                        <div class="card-body">
                                                            <h4 class="my-4 text-center text-secondary">{{ $template['subject'] }}</h4>
                                                            <div class="overlay">
                                                                <img src="{{ asset('attachments/'.$template['attachment']) }}" alt="Overlay" class="overlay-image">
                                                            </div>
                                                            <p>
                                                                {{ $template['subject'] }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="btn-container">
                                                        <input type="checkbox" id="checkbox-{{ $template['id'] }}" class="btn-check" name="email_templates[]" value="{{ $template['id'] }}">
                                                        <label class="btn btn-outline-primary w-100" for="checkbox-{{ $template['id'] }}">
                                                            Select this attack
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach --}}

                                            @foreach ($emailtemplate as $template)
                                                <div class="col-md-4 mb-4">
                                                    <div class="card email-template-card" onclick="openEmailTemplate({{ $template['id'] }})">
                                                        <div class="card-header pb-0 my-4">
                                                            <span class="topleftcorner">{{ $template['email_difficulty'] }}</span>
                                                            <span class="topcorner">Payload: {{$template['payload_type']}}</span>
                                                        </div>

                                                        <div class="card-body">
                                                            <h4 class="my-4 text-center text-primary">{{ $template['subject'] }}</h4>
                                                            <div class="overlay">
                                                                <img src="{{ asset('attachments/'.$template['attachment']) }}" alt="Overlay" class="overlay-image">
                                                            </div>
                                                            <p class="card-text">{{ $template['subject'] }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="btn-container">
                                                        <input type="checkbox" id="checkbox-{{ $template['id'] }}" class="btn-check" name="email_templates[]" value="{{ $template['id'] }}">
                                                        <label class="btn btn-outline-primary w-100" for="checkbox-{{ $template['id'] }}">
                                                            Select this attack
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach


                                        </div>
                                    </div>
                                </form>


                                {{-- Step 3 --}}
                                <form class="stepper-three row g-3 needs-validation custom-input" novalidate="" id="form-step-three">

                                    <!-- First Tabs: Phishing Delivery Schedule -->
                                    <div class="col-sm-12">
                                        <div class="my-3">
                                            <b class="form-label" for="email-basic">Phishing Delivery Schedule <span class="txt-danger">*</span></b>
                                        </div>
                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <div class="nav-link">
                                                    <input type="radio" id="deliver-immediately" name="delivery_type" value="immediatly" checked>
                                                    <label for="deliver-immediately">Deliver Immediately</label>
                                                </div>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <div class="nav-link">
                                                    <input type="radio" id="setup-schedule" name="delivery_type" value="setup">
                                                    <label for="setup-schedule">Setup Schedule</label>
                                                </div>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <div class="nav-link">
                                                    <input type="radio" id="schedule-later" name="delivery_type" value="later">
                                                    <label for="schedule-later">Schedule Later</label>
                                                </div>
                                            </li>
                                        </ul>
                                        <div style="display: none" id="block-of-setup">
                                            <div class="col-12">
                                                <p><b>Note:</b> This schedule is used only for email delivery. We will capture employee interactions and assign trainings as long as a campaign remains active (isn't updated or deleted).</p>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="form-label" for="schedule-date-from" title="This can be anything you want. We recommend something that will help to uniquely identify this campaign from others (e.g. 'All-Staff-Mar-23').">Schedule date from: <span class="txt-danger">*</span></label>
                                                    <input class="form-control" id="schedule-date-from" name="schedule_date_from" type="date" required="required" placeholder="Enter a unique campaign name">
                                                    <span class="error error-schedule_date_from text-danger my-2"></span>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label" for="schedule-date-to" title="This can be anything you want. We recommend something that will help to uniquely identify this campaign from others (e.g. 'All-Staff-Mar-23').">Schedule date to: <span class="txt-danger">*</span></label>
                                                    <input class="form-control" id="schedule-date-to" name="schedule_date_to" type="date" required="required" placeholder="Enter a unique campaign name">
                                                    <span class="error error-schedule_date_to text-danger my-2"></span>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label" for="schedule-time-from" title="This can be anything you want. We recommend something that will help to uniquely identify this campaign from others (e.g. 'All-Staff-Mar-23').">Schedule time from: <span class="txt-danger">*</span></label>
                                                    <input class="form-control" id="schedule-time-from" name="schedule_time_from" type="time" required="required" placeholder="Enter a unique campaign name">
                                                    <span class="error error-schedule_time_from text-danger my-2"></span>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label" for="schedule-time-to" title="This can be anything you want. We recommend something that will help to uniquely identify this campaign from others (e.g. 'All-Staff-Mar-23').">Schedule time to: <span class="txt-danger">*</span></label>
                                                    <input class="form-control" id="schedule-time-to" name="schedule_time_to" type="time" required="required" placeholder="Enter a unique campaign name">
                                                    <span class="error error-schedule_time_to text-danger my-2"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Second Tabs: Campaign Frequency -->
                                    <div class="col-sm-12" id="campaign-frequency-section">
                                        <div class="my-3">
                                            <label class="form-label" for="email-basic">Campaign Frequency  <span class="txt-danger">*</span></label>
                                        </div>
                                        <ul class="nav nav-pills mb-3" id="campaign-frequency-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <div class="nav-link">
                                                    <input type="radio" id="one-of" name="campaign_frequency" value="oneOf" checked>
                                                    <label for="one-of">One-of</label>
                                                </div>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <div class="nav-link">
                                                    <input type="radio" id="weekly" name="campaign_frequency" value="weekly">
                                                    <label for="weekly">Weekly</label>
                                                </div>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <div class="nav-link">
                                                    <input type="radio" id="monthly" name="campaign_frequency" value="monthly">
                                                    <label for="monthly">Monthly</label>
                                                </div>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <div class="nav-link">
                                                    <input type="radio" id="quarterly" name="campaign_frequency" value="quarterly">
                                                    <label for="quarterly">Quarterly</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Expire After Input -->
                                    <div class="col-sm-12" id="expire-after-section" style="display: none;">
                                        <label class="form-label" for="expire-after">Expire After (days):</label>
                                        <input type="date" class="form-control" id="expire-after" name="expire_after" placeholder="Enter number of days">
                                        <span class="error error-expire_after text-danger my-2"></span>
                                    </div>
                                </form>


                                {{-- Step 4 --}}
                                <form class="stepper-four row g-3 needs-validation custom-input" id="form-step-four">
                                    <!-- Campaign Name -->
                                    <div class="form-group row">
                                        <label for="campaignName" class="col-sm-2 col-form-label">Campaign Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="campaignName" value="" disabled>
                                        </div>
                                    </div>

                                    <!-- Campaign Type -->
                                    <div class="form-group row">
                                        <label for="campaignType" class="col-sm-2 col-form-label">Campaign Type</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="campaignType" disabled name="campaignType">
                                                <option value="simulated_phishing">Simulated Phishing</option>
                                                <option value="security_awareness">Security Awareness</option>
                                                <option value="simulated_phishing_and_security_awareness">Simulated Phishing And Security Awareness</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Phishing Bundle -->
                                    <div id="phishingBundlesContainer"></div>

                                    
                                    <!-- Delivery Schedule -->
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Delivery Schedule</label>
                                        <div class="col-sm-10">
                                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <div class="nav-link">
                                                        <input type="radio" id="deliver-immediately" name="delivery_type"  value="immediatly">
                                                        <label for="deliver-immediately">Deliver Immediately</label>
                                                    </div>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <div class="nav-link">
                                                        <input type="radio" id="setup-schedule" name="delivery_type"  value="setup">
                                                        <label for="setup-schedule">Setup Schedule</label>
                                                    </div>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <div class="nav-link">
                                                        <input type="radio" id="schedule-later" name="delivery_type" value="later">
                                                        <label for="schedule-later">Schedule Later</label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Schedule Between Days -->
                                    <div class="form-group row">
                                        <label for="scheduleDays" class="col-sm-2 col-form-label">Schedule (Between Days)</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="scheduleDays" value="" disabled>
                                        </div>
                                    </div>

                                    <!-- Schedule Between Times -->
                                    <div class="form-group row">
                                        <label for="scheduleTimes" class="col-sm-2 col-form-label">Schedule (Between Times)</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="scheduleFromTime" value="" disabled>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="scheduleToTime" value="" disabled>
                                        </div>
                                    </div>

                                    <!-- Campaign Frequency -->
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Campaign Frequency</label>
                                        <div class="col-sm-10">
                                            <ul class="nav nav-pills mb-3" id="campaign-frequency-tab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <div class="nav-link">
                                                        <input type="radio" id="one-of" name="campaign_frequency" value="oneOf" >
                                                        <label for="one-of">One-of</label>
                                                    </div>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <div class="nav-link">
                                                        <input type="radio" id="weekly" name="campaign_frequency" value="weekly" >
                                                        <label for="weekly">Weekly</label>
                                                    </div>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <div class="nav-link">
                                                        <input type="radio" id="monthly" name="campaign_frequency" value="monthly">
                                                        <label for="monthly">Monthly</label>
                                                    </div>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <div class="nav-link">
                                                        <input type="radio" id="quarterly" name="campaign_frequency" value="quarterly" >
                                                        <label for="quarterly">Quarterly</label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Expire After -->
                                    <div class="form-group row">
                                        <label for="expireAfter" class="col-sm-2 col-form-label">Expire After</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="expireAfter" value="" disabled>
                                        </div>
                                    </div>






                                </form>


                            </div>

                            <div class="wizard-footer d-flex gap-2 justify-content-end mt-3">
                                <button class="btn alert-light-primary" id="backbtn" onclick="backStep()"> Back</button>
                                <button class="btn btn-primary" id="nextbtn" onclick="validateStep()">Next</button>
                            </div>
                        </div>
                    </div>
                </div>





                <div class="col-xl-6" style="display: none">
                    <div class="card height-equal">
                    <div class="card-header pb-0">
                        <h3>Student validation form</h3>
                        <p class="f-m-light mt-1">
                            Please make sure fill all the filed before click on next button.</p>
                    </div>
                    <div class="card-body custom-input">
                        <form class="form-wizard" id="regForm" action="#" method="POST">
                        <div class="tab">
                            <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="name">Name</label>
                                <input class="form-control" id="name" type="text" placeholder="Enter your name" required="required">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="student-email-wizard">Email<span class="txt-danger">*</span></label>
                                <input class="form-control" id="student-email-wizard" type="email" required="" placeholder="Cion@gmail.com">
                            </div>
                            <div class="col-12">
                                <label class="col-sm-12 form-label" for="password-wizard">Password<span class="txt-danger">*</span></label>
                                <input class="form-control" id="password-wizard" type="password" placeholder="Enter password" required="">
                            </div>
                            <div class="col-12">
                                <label class="col-sm-12 form-label" for="confirmpassowrd">Confirm Password<span class="txt-danger">*</span></label>
                                <input class="form-control" id="confirmpassowrd" type="password" placeholder="Enter confirm password" required="">
                            </div>
                            </div>
                        </div>
                        <div class="tab">
                            <div class="row g-3 avatar-upload">
                            <div class="col-12">
                                <div>
                                <div class="avatar-edit">
                                    <input id="imageUpload" type="file" accept=".png, .jpg, .jpeg">
                                    <label for="imageUpload"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="image"></div>
                                </div>
                                </div>
                                <h3>Add Profile</h3>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="exampleFormControlInput1">Portfolio URL</label>
                                <input class="form-control" id="exampleFormControlInput1" type="url" placeholder="https://Cion">
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="projectDescription">Project Description</label>
                                <textarea class="form-control" id="projectDescription" rows="2"></textarea>
                            </div>
                            </div>
                        </div>
                        <div class="tab">
                            <h5 class="mb-2">Social Links </h5>
                            <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="twitterControlInput">Twitter</label>
                                <input class="form-control" id="twitterControlInput" type="url" placeholder="https://twitter.com">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="githubControlInput">Github</label>
                                <input class="form-control" id="githubControlInput" type="url" placeholder="https:/github.com">
                            </div>
                            <div class="col-12">
                                <div class="input-group">
                                <input class="form-control" id="inputGroupFile04" type="file" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                <button class="btn btn-outline-secondary" id="inputGroupFileAddon04" type="button">Submit</button>
                                </div>
                            </div>
                            <div class="col-12">
                                <select class="form-select" aria-label="Default select example">
                                <option selected="">Positions</option>
                                <option value="1">Web Designer</option>
                                <option value="2">Software Engineer</option>
                                <option value="3">UI/UX Designer </option>
                                <option value="3">Web Developer</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="quationsTextarea">Why do you want to take this position?</label>
                                <textarea class="form-control" id="quationsTextarea" rows="2"></textarea>
                            </div>
                            </div>
                        </div>
                        <div>
                            <div class="text-end pt-3">
                            <button class="btn btn-secondary" id="prevBtn" type="button" onclick="nextPrev(-1)">Previous</button>
                            <button class="btn btn-primary" id="nextBtn" type="button" onclick="nextPrev(1)">Next</button>
                            </div>
                        </div>
                        <!-- Circles which indicates the steps of the form:-->
                        <div class="text-center"><span class="step"></span><span class="step"></span><span class="step"></span><span class="step"></span></div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>


      </div>
    </div>
</div>


<style>
    @media (max-width: 1800px) {
        .page-wrapper .page-body-wrapper .page-body, .page-wrapper .page-body-wrapper footer {
            margin-left: 0px !important;
        }
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .card-body {
        padding: 20px;
    }

    .card-title {
        font-size: 1.25rem;
        margin-bottom: 0.75rem;
    }

    .badge {
        font-size: 0.75rem;
    }

    .card-footer {
        background-color: #f8f9fa;
        padding: 10px 20px;
        font-size: 0.875rem;
    }

    .btn-link {
        font-size: 0.875rem;
        color: #007bff;
    }

    .topcorner {
        position: absolute;
        top: 0;
        right: 0;
        opacity: 1 !important;
        font-family: Inter, sans-serif !important;
        font-weight: 600;
        font-size: medium;
        background-color: #71869d !important;
        color: #f8f9fa !important;
    }

    .topleftcorner {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 1 !important;

        font-family: Inter, sans-serif !important;
        font-weight: 600;
        font-size: medium;
        background-color: #8260ee !important;
        color: #f8f9fa !important;

    }



    .btn-check {
        display: none;
    }

    /* Style the label to look like a button */
    .btn-container {
        margin-top: 1rem;
    }

    .btn-check:checked + .btn {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .btn {
        cursor: pointer;
        padding: .5rem 1rem;
        font-size: 0.875rem;
        border: 1px solid transparent;
        border-radius: .375rem;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .btn-outline-primary {
        color: #007bff;
        border-color: #007bff;
    }

    .btn-outline-primary:hover {
        background-color: #007bff;
        color: white !important;
        border-color: #007bff;
    }

    .nav-pills .nav-link {
        display: inline-block;
        width: auto;
        padding: 0.5rem 1rem;
        cursor: pointer;
    }

    .nav-pills .nav-link input[type="radio"] {
        display: none;
    }

    .nav-pills .nav-link input[type="radio"]:checked + label {
        background-color: #44225c;
        color: white;
    }

    .nav-pills .nav-link label {
        display: block;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        border: 1px solid #44225c;
        cursor: pointer;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-control:disabled {
        background-color: #e9ecef;
    }

    .activeBtn{
        background-color: #8260ee !important;
    }





    .email-template-card {
        position: relative;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        cursor: pointer;
    }

    .email-template-card:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .topleftcorner, .topcorner {
        position: absolute;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        padding: 5px;
        font-size: 12px;
    }

    .topleftcorner {
        top: 8px;
        left: 8px;
    }

    .topcorner {
        top: 8px;
        right: 8px;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
    }

    .email-template-card:hover .overlay {
        display: flex;
    }

    .overlay-image {
        max-width: 50px;
        opacity: 0.7;
    }


</style>
