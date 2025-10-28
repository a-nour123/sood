<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PhishingEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData;
    public $employee;
    public $campaign_id;

    public function __construct($emailData,$employee,$campaign_id = null)
    {
        $this->emailData = $emailData;
        $this->employee = $employee;
        $this->campaign_id = $campaign_id;
    }

    public function build()
    {
        $body = view('emails.phishing.email')
            ->with([
                'campaign_id' => $this->campaign_id,
                'emailData' => $this->emailData,
                'employee' => $this->employee,
            ])
            ->render();


        $dynamicUrl = $this->getMailWebsiteUrl();
        $body = str_replace('$$emailId', $this->emailData['id'], $body);
        $body = str_replace('$$employeeId', $this->employee->id, $body);
        $body = str_replace('{PhishWebsitePage}',config('app.url') . '/PWPI/' . $this->emailData->website->id . '/click?PMTI=' . $this->emailData['id'] . '&PEI=' . $this->employee->id. '&PCI=' . $this->campaign_id, $body);
        // $body = str_replace('{PhishWebsitePage}', $dynamicUrl, $body);
        // $body = str_replace('{PhishWebsitePage}',route('phishing.clickOnLink',[
        //     'id' => $this->emailData->website->id,
        //     'PMTI' => $this->emailData['id'],
        //     'PEI' =>$this->employee->id,
        // ]), $body);
        // $body = str_replace('http//', '', $body);
        // $body = preg_replace('#(http://)+#', 'http://', $body);
        $body = str_replace('$$NAME$$', $this->employee->name, $body);

        if($this->emailData['mail_attachment']){
            $attachmentHtml = view('emails.phishing.partial')
                ->with([
                    'campaign_id' => $this->campaign_id,
                    'fileName' => $this->emailData['mail_attachment'],
                    'emailId' => $this->emailData['id'],
                    'employeeId' => $this->employee->id,
                ])
                ->render();

            $body .= $attachmentHtml;
        }

        return $this->html($body);
    }

    public function getMailWebsiteUrl()
    {
        $website = $this->emailData->website;
        if($website->domain()->exists()){
            $subdomain = $website->from_address_name;
            $domain = ltrim($website->domain->name, '@');
            $dynamicUrl = "{$subdomain}.{$domain}/PWPI/{$website->id}?PMTI={$this->emailData->id}&PEI={$this->employee->id}";

        }else{
            $domain = $website->from_address_name;
            $dynamicUrl = "{$domain}/PWPI/{$website->id}?PMTI={$this->emailData->id}&PEI={$this->employee->id}";
        }

        return $dynamicUrl;
    }
}
