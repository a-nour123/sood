<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendered Form</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://appsforoffice.cdn.partner.office365.cn/appsforoffice/lib/1/hosted/office.js"></script>

</head>

<body>
    <img src="{{ config('app.url') . '/mail-opened?PMTI=' . $emailData['id'] . '&PEI=' . $employee->id . '&PCI=' . $campaign_id }}" alt="" width="1" height="1" style="display:none;" />
    <h2>{{ $emailData['subject'] }}</h2>
    {!! $emailData['body'] !!}
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function(){
            console.log('Welcome To Phishing Mail Template');
            // Download procees Here ~~~~~~~~~~~~~~
        })
    </script>
</body>
</html>
