<?php

namespace App\Http\Controllers;

use App\Models\CertificateTemplate;
use App\Models\Course;
use App\Traits\CertificateGenerationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CertificateTemplateController extends Controller
{
    use CertificateGenerationTrait;

    /**
     * Display a listing of certificate templates
     */
    public function index()
    {
        $templates = CertificateTemplate::orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.physical-courses.courses.index'), 'name' => __('physicalCourses.physical_courses')],
            ['name' => __('Certificate Templates')],
        ];

        return view('physicalCourses.certificate-templates.index', compact('templates', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new template
     */
    public function create()
    {
        $data = $this->getTemplateFormData();

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.physical-courses.certificate-templates.index'), 'name' => __('Certificate Templates')],
            ['name' => __('Create Template')],
        ];

        return view('physicalCourses.certificate-templates.create', array_merge($data, compact('breadcrumbs')));
    }

    /**
     * Store a newly created template
     */
    public function store(Request $request)
    {
        $validator = $this->validateTemplateRequest($request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Upload template file
            $filePath = $this->handleFileUpload($request->file('template_file'));

            // Create template with initial field positions
            $template = CertificateTemplate::create([
                'name' => $request->name,
                'description' => $request->description,
                'file_path' => $filePath,
                'orientation' => $request->orientation,
                'field_positions' => [],
                // 'field_positions' => $this->getDefaultFieldPositions($request->orientation),
                'is_default' => $request->boolean('is_default'),
                'is_active' => $request->boolean('is_active', true),
                'auto_send' => $request->boolean('auto_send'),
                'background_color' => $request->background_color ?? '#FFFFFF',
                'settings' => $this->getDefaultSettings()
            ]);

            // If set as default, update other templates
            if ($template->is_default) {
                $template->setAsDefault();
            }

            DB::commit();

            // Return with success and option to design
            return redirect()->route('admin.physical-courses.certificate-templates.design', $template)
                ->with('success', 'تم إنشاء القالب بنجاح. يمكنك الآن تصميم مواضع الحقول.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Certificate template creation failed: ' . $e->getMessage());

            // Delete uploaded file if exists
            if (isset($filePath) && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            return back()->with('error', 'خطأ في إنشاء القالب: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the specified template
     */
    public function show(CertificateTemplate $template)
    {
        $template->load(['courses']); // Load related courses

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.physical-courses.certificate-templates.index'), 'name' => __('Certificate Templates')],
            ['name' => $template->name],
        ];

        return view('physicalCourses.certificate-templates.show', compact('template', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified template
     */
    public function edit(CertificateTemplate $template)
    {
        $data = $this->getTemplateFormData();

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.physical-courses.certificate-templates.index'), 'name' => __('Certificate Templates')],
            ['name' => 'تعديل ' . $template->name],
        ];
        // dd($template->field_positions);

        return view('physicalCourses.certificate-templates.edit', array_merge($data, compact('template', 'breadcrumbs')));
    }

    /**
     * Update the specified template
     */
    public function update(Request $request, CertificateTemplate $template)
    {
        $validator = $this->validateTemplateRequest($request, $template->id);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Handle file upload if new file provided
            $filePath = $template->file_path;
            if ($request->hasFile('template_file')) {
                // Delete old file
                if ($template->file_path && Storage::disk('public')->exists($template->file_path)) {
                    Storage::disk('public')->delete($template->file_path);
                }

                // Upload new file
                $filePath = $this->handleFileUpload($request->file('template_file'));

                // Reset field positions if new file uploaded
                $fieldPositions = [];
                // $fieldPositions = $this->getDefaultFieldPositions($request->orientation);
            } else {
                $fieldPositions = $template->field_positions;
            }

            // Update template
            $template->update([
                'name' => $request->name,
                'description' => $request->description,
                'file_path' => $filePath,
                'orientation' => $request->orientation,
                'field_positions' => $fieldPositions,
                'is_default' => $request->boolean('is_default'),
                'is_active' => $request->boolean('is_active'),
                'auto_send' => $request->boolean('auto_send'),
                'background_color' => $request->background_color ?? $template->background_color,
            ]);

            // If set as default, update other templates
            if ($template->is_default) {
                $template->setAsDefault();
            }

            DB::commit();

            return redirect()->route('admin.physical-courses.certificate-templates.index')
                ->with('success', 'تم تحديث القالب بنجاح.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Certificate template update failed: ' . $e->getMessage());
            return back()->with('error', 'خطأ في تحديث القالب: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified template
     */
    public function destroy(CertificateTemplate $template)
    {
        DB::beginTransaction();
        try {
            // Check if template is being used
            if ($template->courses()->count() > 0) {
                return back()->with('error', 'لا يمكن حذف القالب لأنه مستخدم في كورسات موجودة.');
            }

            // Delete file
            if ($template->file_path && Storage::disk('public')->exists($template->file_path)) {
                Storage::disk('public')->delete($template->file_path);
            }

            $template->delete();

            DB::commit();
            return redirect()->route('admin.physical-courses.certificate-templates.index')
                ->with('success', 'تم حذف القالب بنجاح.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Certificate template deletion failed: ' . $e->getMessage());
            return back()->with('error', 'خطأ في حذف القالب: ' . $e->getMessage());
        }
    }

    /**
     * Show template designer interface
     */

    public function design(CertificateTemplate $template)
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.physical-courses.certificate-templates.index'), 'name' => __('Certificate Templates')],
            ['link' => route('admin.physical-courses.certificate-templates.show', $template), 'name' => $template->name],
            ['name' => 'تصميم القالب'],
        ];
        $data = $this->getTemplateFormData();
        $availableFields = collect(CertificateTemplate::getAvailableFields())
            ->map(function ($label, $key) {
                return [
                    'label' => $label,
                    'icon' => $this->getFieldIcon($key), // You'll need to create this method
                    'sample' => $this->getFieldSample($key) // You'll need to create this method
                ];
            })->toArray();

        // $fileExists = false;
        // $fileUrl = null;
        // $debugInfo = [];

        // if ($template->file_path) {
        //     $fileExists = Storage::disk('public')->exists($template->file_path);
        //     $fileUrl = Storage::disk('public')->url($template->file_path);

        //     $debugInfo = [
        //         'file_path' => $template->file_path,
        //         'full_path' => Storage::disk('public')->path($template->file_path),
        //         'exists' => $fileExists,
        //         'url' => $fileUrl,
        //         'storage_path' => storage_path('app/public/' . $template->file_path),
        //         'file_exists_check' => file_exists(storage_path('app/public/' . $template->file_path))
        //     ];
        // }

        $fileExists = $template->file_exists;
        $fileUrl = $template->file_url;
        $debugInfo = [];
        if ($template->file_path) {
            $debugInfo = [
                'file_path' => $template->file_path,
                'full_path' => Storage::disk('public')->path($template->file_path),
                'exists' => $fileExists,
                'url' => $fileUrl,
                'storage_path' => storage_path('app/public/' . $template->file_path),
                'file_exists_check' => file_exists(storage_path('app/public/' . $template->file_path))
            ];
        }


        return view('physicalCourses.certificate-templates.design', array_merge($data, compact('template', 'fileExists', 'fileUrl', 'debugInfo', 'availableFields', 'breadcrumbs')));
    }

    private function getFieldIcon($fieldKey)
    {
        $icons = [
            'user_name' => 'fas fa-user',
            'user_email' => 'fas fa-envelope',
            'course_name' => 'fas fa-book',
            'course_description' => 'fas fa-align-left',
            'grade' => 'fas fa-star',
            'percentage' => 'fas fa-percent',
            'attendance' => 'fas fa-calendar-check',
            'attendance_sessions' => 'fas fa-list-ol',
            'issue_date' => 'fas fa-calendar',
            'issue_date_ar' => 'fas fa-calendar-alt',
            'certificate_id' => 'fas fa-id-card',
            'instructor_name' => 'fas fa-chalkboard-teacher',
            'course_duration' => 'fas fa-clock',
            'custom_text' => 'fas fa-text-width'
        ];

        return $icons[$fieldKey] ?? 'fas fa-text-width';
    }

    private function getFieldSample($fieldKey)
    {
        $samples = [
            'user_name' => __('locale.user_name'),
            'user_email' => __('locale.user_email'),
            'course_name' => __('locale.course_name'),
            'course_description' => __('locale.course_description'),
            'grade' => '95/100',
            'percentage' => '95%',
            'attendance' => '90%',
            'attendance_sessions' => '9/10',
            'issue_date' => date('Y-m-d'),
            'issue_date_ar' => 'التاريخ الهجري',
            'certificate_id' => __('locale.certificate_id'),
            'instructor_name' => __('locale.instructor_name'),
            'course_duration' => __('locale.course_duration'),
            'custom_text' => __('locale.custom_text'),
        ];

        return $samples[$fieldKey] ?? 'نموذج النص';
    }

    /**
     * Set template as default
     */
    public function setDefault(CertificateTemplate $template)
    {
        try {
            $template->setAsDefault();
            return back()->with('success', 'تم تعيين القالب كافتراضي بنجاح.');
        } catch (\Exception $e) {
            Log::error('Set template as default failed: ' . $e->getMessage());
            return back()->with('error', 'خطأ في تعيين القالب كافتراضي: ' . $e->getMessage());
        }
    }

    /**
     * Toggle template active status
     */
    public function toggleActive(CertificateTemplate $template)
    {
        try {
            $template->update(['is_active' => !$template->is_active]);
            $status = $template->is_active ? 'تم تفعيله' : 'تم إلغاء تفعيله';
            return back()->with('success', "القالب {$status} بنجاح.");
        } catch (\Exception $e) {
            Log::error('Toggle template status failed: ' . $e->getMessage());
            return back()->with('error', 'خطأ في تحديث حالة القالب: ' . $e->getMessage());
        }
    }

    /**
     * Duplicate template
     */
    public function duplicate(CertificateTemplate $template)
    {
        DB::beginTransaction();
        try {
            $newTemplate = $template->replicate();
            $newTemplate->name = $template->name . ' - نسخة';
            $newTemplate->is_default = false;
            $newTemplate->created_at = now();
            $newTemplate->updated_at = now();

            // Copy file if exists
            if ($template->file_path && Storage::disk('public')->exists($template->file_path)) {
                $originalPath = $template->file_path;
                $extension = pathinfo($originalPath, PATHINFO_EXTENSION);
                $newFileName = 'certificate_template_' . time() . '_' . uniqid() . '.' . $extension;
                $newPath = 'certificate-templates/' . $newFileName;

                Storage::disk('public')->copy($originalPath, $newPath);
                $newTemplate->file_path = $newPath;
            }

            $newTemplate->save();

            DB::commit();
            return redirect()->route('admin.physical-courses.certificate-templates.edit', $newTemplate)
                ->with('success', 'تم نسخ القالب بنجاح. يمكنك تعديله الآن.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Template duplication failed: ' . $e->getMessage());
            return back()->with('error', 'خطأ في نسخ القالب: ' . $e->getMessage());
        }
    }

    /**
     * Preview template with sample data
     */
    public function preview(CertificateTemplate $template, Request $request)
    {
        try {
            $course = null;
            if ($request->has('course_id')) {
                $course = Course::find($request->course_id);
            }

            return $this->previewCertificateTemplate($template, $course);
        } catch (\Exception $e) {
            Log::error('Template preview failed: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get template configuration for designer
     */
    public function getConfiguration(CertificateTemplate $template)
    {
        return response()->json([
            'template' => $template,
            'available_fields' => CertificateTemplate::getAvailableFields(),
            'font_families' => CertificateTemplate::getFontFamilies(),
            'font_styles' => CertificateTemplate::getFontStyles(),
            'field_positions' => $template->field_positions ?? [],
            'pdf_url' => $template->file_path ? Storage::disk('public')->url($template->file_path) : null
        ]);
    }

    /**
     * Save field positions from designer
     */
    public function saveFieldPositions(Request $request, CertificateTemplate $template)
    {
        $validator = Validator::make($request->all(), [
            'field_positions' => 'required|array', // Can be empty array
            'field_positions.*.field' => 'required|string',
            'field_positions.*.x' => 'required|numeric',
            'field_positions.*.y' => 'required|numeric',
            'field_positions.*.width' => 'nullable|numeric|min:10',
            'field_positions.*.height' => 'nullable|numeric|min:10',
            'field_positions.*.font_family' => 'nullable|string',
            'field_positions.*.font_size' => 'nullable|numeric|min:8|max:72',
            'field_positions.*.font_style' => 'nullable|string',
            'field_positions.*.color' => 'nullable|string',
            'field_positions.*.alignment' => 'nullable|in:L,C,R',
            'field_positions.*.rotation' => 'nullable|numeric|min:-360|max:360',
            'field_positions.*.text_align' => 'nullable|string',
            'field_positions.*.font_weight' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            Log::error('Field positions validation failed', [
                'template_id' => $template->id,
                'errors' => $validator->errors()->toArray(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'خطأ في التحقق من البيانات',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Check if field_positions is empty
            $fieldPositions = $request->field_positions ?? [];

            if (empty($fieldPositions)) {
                Log::info('Saving empty field positions for template', [
                    'template_id' => $template->id,
                    'template_name' => $template->name
                ]);
            }

            $template->update([
                'field_positions' => $fieldPositions,
                'updated_at' => now()
            ]);

            // Log the update
            Log::info('Certificate template field positions updated', [
                'template_id' => $template->id,
                'template_name' => $template->name,
                'fields_count' => count($fieldPositions)
            ]);

            return response()->json([
                'success' => true,
                'message' => count($fieldPositions) > 0
                    ? 'تم حفظ مواضع الحقول بنجاح'
                    : 'تم حفظ التصميم الفارغ بنجاح',
                'template' => $template->fresh(),
                'fields_count' => count($fieldPositions)
            ]);

        } catch (\Exception $e) {
            Log::error('Save field positions failed: ' . $e->getMessage(), [
                'template_id' => $template->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'خطأ في حفظ مواضع الحقول: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get template form data (fields, fonts, etc.)
     */
    private function getTemplateFormData()
    {
        return [
            'availableFields' => CertificateTemplate::getAvailableFields(),
            'fontFamilies' => CertificateTemplate::getFontFamilies(),
            'fontStyles' => CertificateTemplate::getFontStyles(),
            'orientations' => [
                'L' => 'أفقي (Landscape)',
                'P' => 'عمودي (Portrait)'
            ],
            'alignments' => [
                'L' => 'يسار',
                'C' => 'وسط',
                'R' => 'يمين'
            ]
        ];
    }

    /**
     * Validate template request
     */
    private function validateTemplateRequest(Request $request, $templateId = null)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'orientation' => 'required|in:L,P',
            'is_default' => 'boolean',
            'is_active' => 'boolean',
            'auto_send' => 'boolean',
            'background_color' => 'nullable|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
        ];

        // File validation - required for create, optional for update
        if (!$templateId) {
            $rules['template_file'] = 'required|file|mimes:pdf|max:10240'; // 10MB max
        } else {
            $rules['template_file'] = 'nullable|file|mimes:pdf|max:10240';
        }

        return Validator::make($request->all(), $rules, [
            'name.required' => 'اسم القالب مطلوب',
            'name.max' => 'اسم القالب لا يجب أن يزيد عن 255 حرف',
            'template_file.required' => 'ملف القالب مطلوب',
            'template_file.mimes' => 'يجب أن يكون الملف من نوع PDF',
            'template_file.max' => 'حجم الملف لا يجب أن يزيد عن 10 ميجابايت',
            'orientation.required' => 'اتجاه القالب مطلوب',
            'orientation.in' => 'اتجاه القالب غير صحيح',
            'background_color.regex' => 'لون الخلفية غير صحيح',
        ]);
    }

    /**
     * Handle file upload
     */
    private function handleFileUpload($file)
    {
        if (!$file) {
            throw new \Exception('لم يتم تحديد ملف للرفع');
        }

        // Validate file
        if ($file->getSize() > 10485760) { // 10MB
            throw new \Exception('حجم الملف كبير جداً (الحد الأقصى 10 ميجابايت)');
        }

        if ($file->getMimeType() !== 'application/pdf') {
            throw new \Exception('نوع الملف غير مقبول (PDF فقط)');
        }

        // Generate unique filename
        $fileName = 'certificate_template_' . time() . '_' . uniqid() . '.pdf';

        // Store file
        $filePath = $file->storeAs('certificate-templates', $fileName, 'public');

        if (!$filePath) {
            throw new \Exception('فشل في رفع الملف');
        }

        return $filePath;
    }

    /**
     * Get default field positions based on orientation
     */
    private function getDefaultFieldPositions($orientation)
    {
        $positions = [];

        if ($orientation === 'L') {
            // Landscape default positions
            $positions = [
                [
                    'field' => 'student_name',
                    'x' => 400,
                    'y' => 200,
                    'width' => 300,
                    'height' => 30,
                    'font_family' => 'Arial',
                    'font_size' => 24,
                    'font_style' => 'bold',
                    'color' => '#000000',
                    'alignment' => 'C'
                ],
                [
                    'field' => 'course_name',
                    'x' => 400,
                    'y' => 250,
                    'width' => 300,
                    'height' => 25,
                    'font_family' => 'Arial',
                    'font_size' => 18,
                    'font_style' => 'normal',
                    'color' => '#000000',
                    'alignment' => 'C'
                ],
                [
                    'field' => 'completion_date',
                    'x' => 400,
                    'y' => 300,
                    'width' => 200,
                    'height' => 20,
                    'font_family' => 'Arial',
                    'font_size' => 14,
                    'font_style' => 'normal',
                    'color' => '#666666',
                    'alignment' => 'C'
                ]
            ];
        } else {
            // Portrait default positions
            $positions = [
                [
                    'field' => 'student_name',
                    'x' => 300,
                    'y' => 300,
                    'width' => 250,
                    'height' => 30,
                    'font_family' => 'Arial',
                    'font_size' => 22,
                    'font_style' => 'bold',
                    'color' => '#000000',
                    'alignment' => 'C'
                ],
                [
                    'field' => 'course_name',
                    'x' => 300,
                    'y' => 350,
                    'width' => 250,
                    'height' => 25,
                    'font_family' => 'Arial',
                    'font_size' => 16,
                    'font_style' => 'normal',
                    'color' => '#000000',
                    'alignment' => 'C'
                ],
                [
                    'field' => 'completion_date',
                    'x' => 300,
                    'y' => 400,
                    'width' => 200,
                    'height' => 20,
                    'font_family' => 'Arial',
                    'font_size' => 12,
                    'font_style' => 'normal',
                    'color' => '#666666',
                    'alignment' => 'C'
                ]
            ];
        }

        return $positions;
    }

    /**
     * Get default settings
     */
    private function getDefaultSettings()
    {
        return [
            'page_margins' => [
                'top' => 20,
                'right' => 20,
                'bottom' => 20,
                'left' => 20
            ],
            'quality' => 'high',
            'compression' => true,
            'watermark' => false,
            'security' => [
                'password_protected' => false,
                'allow_print' => true,
                'allow_copy' => false,
                'allow_modify' => false
            ]
        ];
    }
}