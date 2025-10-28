<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\ComplianceFile;
use phpDocumentor\Reflection\Types\This;

trait FileTrait
{

    /**
     * @var string
     */
    protected $uploadPath = 'uploads';

    /**
     * @var
     */
    public $ref_id = null;
    /**
     * @var
     */
    public $ref_type = '';
    /**
     * @var
     */
    public $folderName = 'compliance';

    /**
     * @var string
     */
    public $rule = 'image|max:2000';

    /**
     * @return bool
     */
    private function createUploadFolder(): bool
    {
        if (!file_exists(config('filesystems.disks.public.root') . '/' . $this->uploadPath . '/' . $this->folderName)) {
            $attachmentPath = config('filesystems.disks.public.root') . '/' . $this->uploadPath . '/' . $this->folderName;
            mkdir($attachmentPath, 0777, true);

            Storage::put('public/' . $this->uploadPath . '/' . $this->folderName . '/index.html', 'Silent Is Golden');

            return true;
        }

        return false;
    }

    /**
     * For handle validation file action
     *
     * @param $file
     * @return fileUploadTrait|\Illuminate\Http\RedirectResponse
     */
    private function validateFileAction($file)
    {

        $rules = array('fileupload' => $this->rule);
        $file  = array('fileupload' => $file);

        $fileValidator = Validator::make($file, $rules);

        if ($fileValidator->fails()) {

            $messages = $fileValidator->messages();

            return redirect()->back()->withInput(request()->all())
                ->withErrors($messages);
        }
    }

    /**
     * For Handle validation file
     *
     * @param $files
     * @return fileUploadTrait|\Illuminate\Http\RedirectResponse
     */
    private function validateFile($files)
    {

        if (is_array($files)) {
            foreach ($files as $file) {
                return $this->validateFileAction($file);
            }
        }

        return $this->validateFileAction($files);
    }

    /**
     * For Handle Put File
     *
     * @param $file
     * @return bool|string
     */
    private function putFile($file, $ref_id)
    {

        $fileName = 'compliance-' . $ref_id . '-' . time() . '.' . $file->getClientOriginalExtension();
        $path     = $this->uploadPath . '/' . $this->folderName . '/';
        $file->move(public_path($path), $fileName);
        return $fileName;
    }

    /**
     * For Handle Save File Process
     *
     * @param $files
     * @return array
     */
    public function saveFiles($files, $ref_id, $ref_type)
    {

        $data = '';

        if ($files != null) {

            $this->validateFile($files);

            $this->createUploadFolder();
            $extension = $files->getClientOriginalExtension();
            $type = $files->getMimeType();
            $size = $files->getSize();
            $originalName = $files->getClientOriginalName();
            $filename = $this->putFile($files, $ref_id);
            $content = base64_encode(file_get_contents(public_path($this->uploadPath . '/' . $this->folderName . '/' . $filename)));
            $data = ComplianceFile::create([
                'ref_id' => $ref_id,
                'ref_type' => $ref_type,
                'name' => $originalName,
                'unique_name' => $filename,
                'type' => $type,
                'size' => $size,
                'timestamp' => now(),
                'user' => 1, //auth()->user()->id
                'content' => $content,
                'version' => 1
            ]);
        }

        return $data;
    }
}
