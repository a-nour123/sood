@if ($website->scraped_assets && !empty(json_decode($website->scraped_assets, true)))
    {!! $website->html_code !!}
    <input type="hidden" name="PMTI" data-PMII="{{ $emailId }}" data-PEI="{{ $employeeId }}"
        data-PCI="{{ $campaignId }}" id="P_data">

    <script src="{{ asset('cdn/jquery-3.5.1.js') }}"></script>

    <script>
        $(document).ready(function() {
            const mailOpenedUrl = "{!! route('mailForm.submited', ['PMTI' => '__PMTI__', 'PEI' => '__PEI__', 'PCI' => '__PCI__']) !!}";

            function handleSubmit(e) {
                e.preventDefault();

                const emailId = $('#P_data').attr('data-PMII');
                const employeeId = $('#P_data').attr('data-PEI');
                const campaignId = $('#P_data').attr('data-PCI');

                console.log('=== FORM SUBMIT DETECTED (SCRAPED CONTENT) ===');
                console.log('Triggered by:', e.target);
                console.log('Event type:', e.type);
                console.log('Email ID:', emailId);
                console.log('Employee ID:', employeeId);
                console.log('Campaign ID:', campaignId);

                const url = mailOpenedUrl
                    .replace('__PMTI__', emailId)
                    .replace('__PEI__', employeeId)
                    .replace('__PCI__', campaignId);

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        console.log('Success:', response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Error:', textStatus, errorThrown);
                    }
                });
            }

            $(document).on('submit', 'form', function(e) {
                console.log('Form submitted via submit event');
                handleSubmit(e);
            });

            $(document).on('click', 'button[type="submit"], input[type="submit"]', function(e) {
                console.log('Submit button clicked');
                handleSubmit(e);
            });

            $(document).on('click', 'form button:not([type="button"]):not([type="reset"])', function(e) {
                console.log('Form button clicked (default submit behavior)');
                handleSubmit(e);
            });

            $(document).on('keypress', 'form input, form textarea', function(e) {
                if (e.which === 13 && !$(this).is('textarea')) { // Enter key (not in textarea)
                    console.log('Enter key pressed in form input');
                    handleSubmit(e);
                }
            });

            $(document).on('click', '[onclick*="submit"], [onclick*=".submit()"], [onclick]', function(e) {
                const onclickValue = $(this).attr('onclick');
                console.log('Element with onclick clicked:', onclickValue);

                const submitKeywords = [
                    'submit', 'send', 'post', 'login', 'signin', 'signup',
                    'register', 'save', 'confirm', 'ok', 'دخول', 'تسجيل',
                    'إرسال', 'حفظ', 'تأكيد', 'موافق'
                ];

                const hasSubmitKeyword = submitKeywords.some(keyword =>
                    onclickValue.toLowerCase().includes(keyword.toLowerCase())
                );

                if (hasSubmitKeyword || onclickValue.includes('submit') || onclickValue.includes(
                        '.submit()')) {
                    console.log('Submit-related onclick detected');
                    handleSubmit(e);
                }
            });

            const originalSubmit = HTMLFormElement.prototype.submit;
            HTMLFormElement.prototype.submit = function() {
                console.log('Form submitted via JavaScript .submit() method');

                const fakeEvent = {
                    type: 'submit',
                    target: this,
                    preventDefault: function() {}
                };

                handleSubmit(fakeEvent);
            };

            $(document).on('click', '[data-submit], [data-form-submit]', function(e) {
                console.log('Element with data-submit clicked');
                handleSubmit(e);
            });

            $(document).on('click', 'a[href*="submit"], a[href="#submit"]', function(e) {
                console.log('Submit link clicked');
                handleSubmit(e);
            });

            $(document).on('change', 'form select[onchange*="submit"], form input[onchange*="submit"]', function(
            e) {
                console.log('Form element with auto-submit changed');
                handleSubmit(e);
            });

            $(document).on('click', '*', function(e) {
                const element = $(this);
                const text = element.text().toLowerCase().trim();
                const id = element.attr('id') ? element.attr('id').toLowerCase() : '';
                const className = element.attr('class') ? element.attr('class').toLowerCase() : '';
                const title = element.attr('title') ? element.attr('title').toLowerCase() : '';

                const submitKeywords = [
                    'submit', 'send', 'post', 'login', 'signin', 'signup', 'signon',
                    'register', 'save', 'confirm', 'ok', 'enter', 'go', 'next',
                    'تسجيل الدخول', 'دخول', 'تسجيل', 'إرسال', 'حفظ', 'تأكيد',
                    'موافق', 'التالي', 'إدخال', 'تسليم'
                ];

                const ignoredElements = ['html', 'body', 'head', 'script', 'style', 'meta', 'title'];
                if (ignoredElements.includes(e.target.tagName.toLowerCase())) {
                    return;
                }

                if (element.is('input[type=text], input[type=email], input[type=password], textarea') &&
                    e.target === e.currentTarget) {
                    return;
                }

                const hasSubmitKeyword = submitKeywords.some(keyword =>
                    text.includes(keyword) ||
                    id.includes(keyword) ||
                    className.includes(keyword) ||
                    title.includes(keyword)
                );

                const hasOnclick = element.attr('onclick');

                if (hasSubmitKeyword || hasOnclick) {
                    console.log('Potential submit element clicked:', {
                        text: text,
                        id: id,
                        class: className,
                        title: title,
                        onclick: hasOnclick
                    });
                    handleSubmit(e);
                    e.stopPropagation();
                    return false;
                }
            });

            console.log(
                'Form submit tracker initialized for SCRAPED CONTENT - monitoring all form submission methods!');
        });
    </script>
@else
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $website->name }}</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
            }

            img {
                max-width: 100%;
                height: auto;
            }

            [data-submit],
            button[type=submit],
            input[type=submit],
            input[type=button],
            .btn,
            .submit-btn,
            .clickable {
                cursor: pointer;
            }
        </style>
    </head>

    <body>
        {!! $website->html_code ?? '' !!}
        <input type="hidden" name="PMTI" data-PMII="{{ $emailId }}" data-PEI="{{ $employeeId }}"
            data-PCI="{{ $campaignId }}" id="P_data">

        <script src="{{ asset('cdn/jquery-3.5.1.js') }}"></script>

        <script src="{{ asset('lms-quizes/quiz/js/bootstrap.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                const mailOpenedUrl = "{!! route('mailForm.submited', ['PMTI' => '__PMTI__', 'PEI' => '__PEI__', 'PCI' => '__PCI__']) !!}";

                function handleSubmit(e) {
                    e.preventDefault();

                    const emailId = $('#P_data').attr('data-PMII');
                    const employeeId = $('#P_data').attr('data-PEI');
                    const campaignId = $('#P_data').attr('data-PCI');

                    console.log('=== FORM SUBMIT DETECTED ===');
                    console.log('Triggered by:', e.target);
                    console.log('Event type:', e.type);
                    console.log('Email ID:', emailId);
                    console.log('Employee ID:', employeeId);
                    console.log('Campaign ID:', campaignId);

                    const url = mailOpenedUrl
                        .replace('__PMTI__', emailId)
                        .replace('__PEI__', employeeId)
                        .replace('__PCI__', campaignId);

                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            console.log('Success:', response);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log('Error:', textStatus, errorThrown);
                        }

                        console.log(
                        'Form submit tracker initialized - monitoring all form submission methods!');
                    });
                }

                $(document).on('submit', 'form', function(e) {
                    console.log('Form submitted via submit event');
                    handleSubmit(e);
                });

                $(document).on('click', 'button[type="submit"], input[type="submit"]', function(e) {
                    console.log('Submit button clicked');
                    handleSubmit(e);
                });

                $(document).on('click', 'form button:not([type="button"]):not([type="reset"])', function(e) {
                    console.log('Form button clicked (default submit behavior)');
                    handleSubmit(e);
                });

                $(document).on('keypress', 'form input, form textarea', function(e) {
                    if (e.which === 13 && !$(this).is('textarea')) { // Enter key (not in textarea)
                        console.log('Enter key pressed in form input');
                        handleSubmit(e);
                    }
                });

                $(document).on('click', '[onclick*="submit"], [onclick*=".submit()"]', function(e) {
                    console.log('Element with submit onclick clicked');
                    handleSubmit(e);
                });

                const originalSubmit = HTMLFormElement.prototype.submit;
                HTMLFormElement.prototype.submit = function() {
                    console.log('Form submitted via JavaScript .submit() method');

                    const fakeEvent = {
                        type: 'submit',
                        target: this,
                        preventDefault: function() {}
                    };

                    handleSubmit(fakeEvent);
                };

                $(document).on('click', '[data-submit], [data-form-submit]', function(e) {
                    console.log('Element with data-submit clicked');
                    handleSubmit(e);
                });

                $(document).on('click', 'a[href*="submit"], a[href="#submit"]', function(e) {
                    console.log('Submit link clicked');
                    handleSubmit(e);
                });

                $(document).on('change', 'form select[onchange*="submit"], form input[onchange*="submit"]', function(
                e) {
                    console.log('Form element with auto-submit changed');
                    handleSubmit(e);
                });

                console.log('Form submit tracker initialized - monitoring all form submission methods!');
            });
        </script>
    </body>

    </html>
@endif
