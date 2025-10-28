<div class="email-attachment">
    <div class="attachment-icon">
        <i class="fa fa-paperclip"></i> <!-- Icon for attachment -->
    </div>
    <div class="attachment-details">
        {{--  <p class="file-name">{{ $fileName }}</p>  --}}
        <a href="{{ config('app.url') . '/mail-attachments?PMTI=' . $emailId . '&PEI=' . $employeeId . '&PCI=' . $campaign_id . '&PMTF=' . urlencode($fileName) }}" class="download-link">
            Download :{{ $fileName }}
        </a>

    </div>
</div>

<style>
    .email-attachment {
        display: flex;
        align-items: center;
        margin-top: 10px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .attachment-icon {
        font-size: 18px;
        margin-right: 10px;
    }

    .file-name {
        font-weight: bold;
        margin-right: 10px;
    }

    .download-link {
        color: #007bff;
        text-decoration: none;
    }

    .download-link:hover {
        text-decoration: underline;
    }

</style>

