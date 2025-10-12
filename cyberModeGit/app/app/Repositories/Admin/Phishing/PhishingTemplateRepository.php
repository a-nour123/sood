<?php


namespace App\Repositories\Admin\Phishing;

use App\Http\Requests\admin\phishing\PhishingTemplateRequest;
use App\Interfaces\Admin\Phishing\PhishingTemplateInterface;
use App\Models\PhishingDomains;
use App\Models\PhishingLandingPage;
use App\Models\PhishingSenderProfile;
use App\Models\PhishingTemplate;
use App\Models\PhishingWebsitePage;
use App\Traits\UpoladFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PhishingTemplateRepository implements PhishingTemplateInterface
{
    use UpoladFileTrait;


    public function index()
    {
        if (!auth()->user()->hasPermission('template.list')) {
            abort(403, 'Unauthorized action.');
        }
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('phishing.phishing')],
            ['name' => __('phishing.Templates')]
        ];
        $templates = PhishingTemplate::withoutTrashed()->orderBy('created_at','desc')->get();
        $senderProfiles = PhishingSenderProfile::withoutTrashed()->orderBy('created_at','desc')->get();
        $domains = PhishingDomains::withoutTrashed()->orderBy('created_at','desc')->get();
        $websitePages = PhishingWebsitePage::withoutTrashed()->orderBy('created_at','desc')->get();
        $landingPages = PhishingLandingPage::withoutTrashed()->orderBy('created_at','desc')->get();
        // return view('admin.content.phishing.templates.index', get_defined_vars());
        return view('admin.content.phishing.templates.index2', get_defined_vars());
    }
    public function store(PhishingTemplateRequest $request)
    {
        try {
            // Check if the template exists and is soft-deleted
            $existingTemplate = PhishingTemplate::withTrashed()
                ->where('name', $request->name)
                ->first();

            if ($existingTemplate && $existingTemplate->trashed()) {
                // If the template exists and is trashed, restore it
                $existingTemplate->restore();

                // Update other fields
                $existingTemplate->update([
                    'description' => $request->description,
                    'attachment' => $request->hasFile('attachment') ? $this->storeFileInStorage($request->file('attachment'), 'public/attachments') : $existingTemplate->attachment,
                    'mail_attachment' => session()->get('ckEditorImagePath') ?? $existingTemplate->mail_attachment,
                    'phishing_website_id' => $request->phishing_website_id,
                    'sender_profile_id' => $request->sender_profile_id,
                    'subject' => $request->subject,
                    'body' => preg_replace('/<a href="https?:\/\/([^"]+)"/', '<a href="$1"', $request->body),
                ]);

                return response()->json(['status' => true, 'message' => 'Email Template has been restored and updated successfully.'], 200);
            }

            // If no existing template, create a new one
            $updatedBody = preg_replace('/<a href="https?:\/\/([^"]+)"/', '<a href="$1"', $request->body);

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $path = $this->storeFileInStorage($file, 'public/attachments');
            }

            // Create new template
            PhishingTemplate::create([
                'name' => $request->name,
                'description' => $request->description,
                'attachment' => $path ?? null,
                'mail_attachment' => session()->get('ckEditorImagePath') ?? null,
                'phishing_website_id' => $request->phishing_website_id,
                'sender_profile_id' => $request->sender_profile_id,
                'subject' => $request->subject,
                'body' => $updatedBody,
            ]);

            return response()->json(['status' => true, 'message' => 'Email Template is Added Successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }



    public function edit($id)
    {
        try {
            $EmailTemplate = PhishingTemplate::with('senderProfile','website')->find($id);
            return response()->json(['EmailTemplate' => $EmailTemplate]);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $EmailTemplate = PhishingTemplate::with('senderProfile','website')->find($id);
            $website = $EmailTemplate->website;
            // if($website->domain()->exists()){
            //     $subdomain = $website->from_address_name;
            //     $domain = ltrim($website->domain->name, '@');
            //     // $dynamicUrl = "{$subdomain}.{$domain}";
            //     $dynamicUrl = "{$subdomain}.{$domain}/PWPI/{$website->id}";

            // }else{
            //     $domain = $website->from_address_name;
            //     // $dynamicUrl = "{$domain}";
            //     $dynamicUrl = "{$domain}/PWPI/{$website->id}";
            // }
            $updatedBody = str_replace('{PhishWebsitePage}', route('website.show', [$website->name,$website->id]), $EmailTemplate->body);
            // $updatedBody = preg_replace('/http:\/\/http:\/\//', 'http://', $updatedBody);
            // $updatedBody = str_replace('http//', '', $updatedBody);
            $updatedBody = str_replace('$$NAME$$', '5haled', $updatedBody);

            return view('admin.content.phishing.templates.mailTemplate',get_defined_vars());
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function update($id,PhishingTemplateRequest $request)
    {
        try {
            $emailTemplate = PhishingTemplate::findOrFail($id);
            // return $this->saveTemplate($request, $emailTemplate);
            if($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                // $path = $this->storeFile($file, 'attachments');
                $path = $this->storeFileInStorage($file, 'public/attachments');

            }

            $emailTemplate->update([
                'name' => $request->name,
                'description' => $request->description,
                // 'payload_type' => $request->payload_type,
                // 'email_difficulty' => $request->email_difficulty,
                'attachment' => $path ?? $emailTemplate->attachment,
                'phishing_website_id' => $request->phishing_website_id,
                'sender_profile_id' => $request->sender_profile_id,
                'mail_attachment' => session()->get('ckEditorImagePath') ?? null,
                'subject' => $request->subject,
                'body' => $request->body,
            ]);
            return response()->json(['status' => true,'message' => 'Email Template is Updated Successfully'], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    private function saveTemplate(Request $request, PhishingTemplate $emailTemplate = null)
    {
        $step = $request->input('step');
        if(!$emailTemplate) {
            $emailTemplate = $request->session()->get('emailTemplate', new PhishingTemplate());
        }

        if($step == 1) {
            $validatedData = $request->validate([
                'name' => 'required',
                'description' => 'required',
                // 'payload_type' => 'required',
                // 'email_difficulty' => 'required',
                'attachment' => 'sometimes|required|file',
            ]);

            if($request->hasFile('attachment')) {

                $file = $request->file('attachment');
                $path = $this->storeFile($file, 'attachments');
                $validatedData['attachment'] = $path;
            }

            $emailTemplate->fill($validatedData);
            $request->session()->put('emailTemplate', $emailTemplate);
            return response()->json(['success' => true, 'step' => 2]);

        }elseif($step == 2) {
            $validatedData = $request->validate([
                'subject' => 'required',
                'body' => 'required',
            ]);

            $emailTemplate->fill($validatedData);
            $body = html_entity_decode($request->input('body'));

            // $body = preg_replace('/<button[^>]*>.*?<\/button>/is', '', $body);
            // $body = preg_replace('/<input[^>]*type="submit"[^>]*>/is', '', $body);
            // $body = preg_replace('/<\/body>\s*<\/html>/i', '', $body);


            // $submitDataUrl = route('admin.phishing.mailForm.submited') . '?emailId=$$emailId&employeeId=$$employeeId';
            // $downloadAttachmentUrl = route('admin.phishing.mailAttachments.download') . '?emailId=$$emailId&employeeId=$$employeeId';

            // if ($emailTemplate->payload_type === 'data_entry') {
            //    $body .= '<br><a href="' . $submitDataUrl . '" class="btn btn-primary" style="background-color: #24b5d4; color: white; padding: 10px 20px; text-decoration: none;">Submit Data</a>';
            // } elseif ($emailTemplate->payload_type === 'attachment') {
            //     $body .= '<br><a href="' . $downloadAttachmentUrl . '">Download Attachment</a>';
            // } elseif ($emailTemplate->payload_type === 'website') {
            //    $body .= '<br><div style="margin-bottom:15px;"><a href="' . $downloadAttachmentUrl . '">Download Attachment</a></div>';
            //    $body .= '<br><a href="' . $submitDataUrl . '" class="btn btn-primary" style="background-color: #24b5d4; color: white; padding: 10px 20px; text-decoration: none;">Submit Data</a>';
            // }

            $body .= '</body></html>';
            $emailTemplate->body = $body;
            $request->session()->put('emailTemplate', $emailTemplate);
            return response()->json(['success' => true, 'step' => 3]);

        }elseif($step == 3) {
            if($request->_method == "PUT"){
                if ($request->hasFile('attachment')) {
                    $file = $request->file('attachment');
                    $path = $this->storeFile($file, 'attachments');
                    $emailTemplate->attachment = $path;
                }
                $emailTemplate->fill($request->except('attachment'));
                $emailTemplate->save();
                $message = 'Email Template updated successfully';

            }else{
                $emailTemplate->phishing_website_id = $request->phishing_website_id;
                $emailTemplate->sender_profile_id = $request->sender_profile_id;
                $emailTemplate->save();
                $message = 'Email Template saved successfully';
            }
            $request->session()->forget('emailTemplate');
            return response()->json(['success' => true, 'message'=> $message, 'redirect' => route('admin.phishing.emailTemplate.index')]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid step']);
    }
    public function trash($templateId)
    {
        try {
            // البحث عن القالب
            $template = PhishingTemplate::findOrFail($templateId);

            // التحقق إذا كان القالب مرتبطًا بحملة
            if ($template->campaignes()->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => __('phishing.TemplateCannotBeDeletedAsItIsLinkedToCampaign')
                ], 422);
            }

            // إذا لم يكن مرتبطًا بحملة، قم بحذفه
            $template->update(['deleted_at' => now()]);

            return response()->json([
                'status' => true,
                'message' => __('phishing.TemplateWasDeletedSuccessfully')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('locale.Error')
            ], 502);
        }
    }


    public function getArchivedemailTemplate()
    {
        $archived_email_templates = PhishingTemplate::onlyTrashed()->get();
        return view('admin.content.phishing.templates.archived', get_defined_vars());
    }


    public function restore($id,Request $request)
    {
        try {
            $Template = PhishingTemplate::onlyTrashed()->findOrFail($id);
            $Template->restore();
            return response()->json(['status' => true,'message' => __('phishing.TemplateRestoreSuccessfully')], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }
    public function delete($id)
    {
        try {
            $Template = PhishingTemplate::onlyTrashed()->findOrFail($id);
            $Template->forceDelete();
            return response()->json(['status' => true,'message' => __('phishing.TemplateWasDeletedSuccessfully')], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false,'message' => __('locale.Error')], 502);
        }
    }

    public function uploadFile(Request $request)
    {
        if ($request->hasFile('upload')) {

            $file = $request->file('upload');
            // $path = $this->storeFile($file, 'attachments');
            $filePath = $this->storeFileInStorage($file, 'public/mailAttachments/files');


            // $file = $request->file('upload');
            // $fileName = time() . '_' . $file->getClientOriginalName(); // Create a unique file name
            // $filePath = $file->storeAs('mailAttachments/files', $fileName, 'public'); // Store the file in a 'public' directory
            // Get the public URL of the uploaded file
            $url = Storage::url($filePath);
            // CKEditorFuncNum is sent as part of the request. It's used to insert the file link in the editor.
            // $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $CKEditorFuncNum = htmlspecialchars($request->input('CKEditorFuncNum'), ENT_QUOTES, 'UTF-8');
            // Return a JavaScript callback with the file URL
            echo "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', 'File uploaded successfully');</script>";
        } else {
            // Handle file upload failure

            // $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            // $message = 'File upload failed';
            $CKEditorFuncNum = htmlspecialchars($request->input('CKEditorFuncNum'), ENT_QUOTES, 'UTF-8');
            $message = htmlspecialchars('File upload failed', ENT_QUOTES, 'UTF-8');
            echo "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '', '$message');</script>";
        }
    }
    public function uploadImage(Request $request)
    {
        session()->forget('ckEditorImagePath');
        if ($request->hasFile('upload')) {
            // $image = $request->file('upload');
            // // $imageName = time() . '_' . $image->getClientOriginalName();
            // // $imagePath = $image->storeAs('mailAttachments/images', $imageName, 'public');
            // $imagePath = $this->storeFile($image, 'mailAttachments');

            $image = $request->file('upload');
            // $path = $this->storeFile($file, 'attachments');
            $imagePath = $this->storeFileInStorage($image, 'public/mailAttachments');


            session()->put('ckEditorImagePath',$imagePath);
            // Get the public URL of the uploaded image
            $url = Storage::url($imagePath);
            // CKEditorFuncNum is sent as part of the request. It's used to insert the image in the editor.
            $CKEditorFuncNum = htmlspecialchars($request->input('CKEditorFuncNum'), ENT_QUOTES, 'UTF-8');
            // Send the correct response back to CKEditor
            $message = htmlspecialchars('Image uploaded successfully', ENT_QUOTES, 'UTF-8');
            echo "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$message');</script>";
        } else {
            // Handle the error case
            $CKEditorFuncNum = htmlspecialchars($request->input('CKEditorFuncNum'), ENT_QUOTES, 'UTF-8');
            $message = htmlspecialchars('Failed Image upload', ENT_QUOTES, 'UTF-8');
            echo "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '', '$message');</script>";

        }
    }
}
