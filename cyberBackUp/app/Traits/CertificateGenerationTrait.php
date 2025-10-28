<?php

namespace App\Traits;
use App\Models\Course;
use App\Models\CourseCertificate;
use App\Models\CertificateTemplate;
use App\Models\User;
use App\Mail\SendCertificate;
use App\Models\LMSTrainingModule;
use App\Models\LMSTrainingModuleCertificate;
use TCPDF;
use setasign\Fpdi\Tcpdf\Fpdi; // Use FPDI with TCPDF
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

trait CertificateGenerationTrait
{
    private $pxToMmRatio = 0.352778; // 25.4 / 72

    // Arabic fonts that work well with TCPDF
    private $supportedFonts = [
        'arial' => 'dejavusans',
        'times' => 'dejavuserif',
        'courier' => 'dejavusansmono',
        'helvetica' => 'dejavusans',
        'dejavusans' => 'dejavusans',
        'dejavuserif' => 'dejavuserif',
        'dejavusansmono' => 'dejavusansmono',
        'freeserif' => 'freeserif',
        'freesans' => 'freesans',
        'freemono' => 'freemono'
    ];

    /**
     * خريطة الخطوط البديلة للنص العربي
     */
    private $fontMapping = [
        'cambria' => 'dejavuserif',
        'calibri' => 'dejavusans',
        'tahoma' => 'dejavusans',
        'georgia' => 'dejavuserif',
        'verdana' => 'dejavusans',
        'comic sans ms' => 'dejavusans',
        'impact' => 'dejavusans',
        'trebuchet ms' => 'dejavusans',
        'arial' => 'dejavusans',
        'times' => 'dejavuserif',
        'courier' => 'dejavusansmono',
        'helvetica' => 'dejavusans'
    ];

    public function generateCertificateForUser(Course $course, User $user)
    {
        // Check if user meets grade requirements
        $grade = $course->grades()->where('user_id', $user->id)->first();

        if (!$grade || $grade->grade < $course->passing_grade) {
            throw new \Exception('User does not meet grade requirements');
        }

        // Check if user has approved course request
        $courseRequest = $user->courseRequests()
            ->where('course_id', $course->id)
            ->where('status', 'approved')
            ->first();

        if (!$courseRequest) {
            throw new \Exception('User does not have approved course request');
        }

        $template = $this->getCertificateTemplate($course);
        $attendanceData = $this->calculateAttendance($course, $user);
        $certificateId = $this->generateCertificateId($course, $user);

        $fileName = $this->generatePdfWithTcpdf($course, $user, $template, [
            'grade' => $grade->grade,
            'fullGrade' => $course->grade,
            'percentage' => round(($grade->grade / $course->grade) * 100, 2),
            'attendance' => $attendanceData,
            'certificateId' => $certificateId
        ]);

        // Save certificate record
        CourseCertificate::updateOrCreate([
            'course_id' => $course->id,
            'user_id' => $user->id,
        ], [
            'certificate_file' => $fileName,
            'certificate_id' => $certificateId,
            'grade' => $grade->grade,
            'template_id' => $template->id,
            'issued_at' => now(),
        ]);

        return $fileName;
    }

    /**
     * Generate PDF using TCPDF with Arabic support
     *
     * @param Course $course
     * @param User $user
     * @param CertificateTemplate $template
     * @param array $data
     * @return string
     * @throws \Exception
     */
    private function generatePdfWithTcpdf(Course $course, User $user, CertificateTemplate $template, array $data)
    {
        try {
            // Ensure output directory exists
            $outputDir = storage_path('app/public/certificates/' . $course->id);
            if (!file_exists($outputDir)) {
                mkdir($outputDir, 0777, true);
            }

            // Check if template file exists
            $templatePath = storage_path('app/public/' . $template->file_path);
            if (!file_exists($templatePath)) {
                throw new \Exception('Certificate template file not found');
            }

            // Initialize TCPDF with FPDI
            $pdf = new Fpdi('L', 'mm', 'A4', true, 'UTF-8', false);

            // Set document information
            $pdf->SetCreator('Certificate Generator');
            $pdf->SetAuthor('System');
            $pdf->SetTitle('Certificate - ' . $user->name);

            // Set default font subsetting mode
            $pdf->setFontSubsetting(true);

            // Set margins
            $pdf->SetMargins(0, 0, 0);
            $pdf->SetAutoPageBreak(false, 0);

            // Remove header/footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            // Set source file and add page
            $pdf->setSourceFile($templatePath);
            $pdf->AddPage($template->orientation ?: 'L'); // L for Landscape, P for Portrait

            // Import the template page
            $tpl = $pdf->importPage(1);
            $pdf->useTemplate($tpl);

            // Add custom text based on template configuration
            $this->addTextToTcpdf($pdf, $template, $course, $user, $data);

            // Generate unique filename
            $fileName = 'certificates/' . $course->id . '/' . $user->id . '_' . time() . '.pdf';
            $filePath = storage_path('app/public/' . $fileName);

            // Save the PDF
            $pdf->Output($filePath, 'F');

            return $fileName;

        } catch (\Exception $e) {
            Log::error('TCPDF Certificate generation failed: ' . $e->getMessage());
            throw new \Exception('Failed to generate certificate: ' . $e->getMessage());
        }
    }

    /**
     * Add text to TCPDF with Arabic support
     */
    private function addTextToTcpdf(Fpdi $pdf, CertificateTemplate $template, Course $course, User $user, array $data)
    {
        Log::info('PDF type Class', ['class' => get_class($pdf)]);
        Log::info('Page dimensions', [
            'width' => $pdf->getPageWidth(),
            'height' => $pdf->getPageHeight()
        ]);

        // التأكد من أن field_positions موجود وليس فارغ
        if (empty($template->field_positions)) {
            Log::warning('No field positions found for template', ['template_id' => $template->id]);
            return;
        }

        $fields = is_string($template->field_positions)
            ? json_decode($template->field_positions, true)
            : $template->field_positions;

        if (!is_array($fields) || empty($fields)) {
            Log::warning('Field positions is not valid array', [
                'template_id' => $template->id,
                'field_positions' => $template->field_positions
            ]);
            return;
        }

        Log::info('Adding text to PDF', [
            'template_id' => $template->id,
            'fields_count' => count($fields)
        ]);

        foreach ($fields as $index => $field) {
            try {
                // تحقق من وجود الحقول المطلوبة
                if (!isset($field['field']) || !isset($field['x']) || !isset($field['y'])) {
                    Log::warning('Invalid field structure', [
                        'index' => $index,
                        'field' => $field
                    ]);
                    continue;
                }

                // Get the text value
                $text = $this->getFieldValue($field['field'], $course, $user, $data);

                if (empty($text)) {
                    Log::warning('Empty text for field', [
                        'field' => $field['field'],
                        'user_id' => $user->id
                    ]);
                    continue;
                }

                // تنظيف اسم الخط وتحويله للحالة الصغيرة
                $fontFamily = isset($field['font_family']) ? explode(',', $field['font_family'])[0] : 'dejavusans';
                $fontFamily = trim(strtolower($fontFamily));

                // الحصول على الخط المدعوم
                $supportedFont = $this->getSupportedFont($fontFamily);
                $fontSize = $field['font_size'] ?? 12;
                $fontStyle = $this->getFontStyle($field['font_style'] ?? '');

                // Set font with Arabic support
                $pdf->SetFont($supportedFont, $fontStyle, $fontSize);

                // Set text color
                if (isset($field['color']) && !empty($field['color'])) {
                    $color = $this->hexToRgb($field['color']);
                    $pdf->SetTextColor($color['r'], $color['g'], $color['b']);
                } else {
                    $pdf->SetTextColor(0, 0, 0); // Default black
                }

                Log::info('Adding field to PDF', [
                    'field' => $field['field'],
                    'text' => $text,
                    'x' => $field['x'],
                    'y' => $field['y'],
                    'font' => $supportedFont
                ]);

                // Convert coordinates from pixels to mm
                $x = $this->pxToMm($field['x']);
                $y = $this->pxToMm($field['y']);

                // Check if text contains Arabic characters
                if ($this->containsArabic($text)) {
                    // For Arabic text, use writeHTMLCell for better rendering
                    $width = isset($field['width']) ? $this->pxToMm($field['width']) : 100;
                    $height = isset($field['height']) ? $this->pxToMm($field['height']) : 10;
                    $alignment = $this->getAlignment($field['alignment'] ?? 'L');

                    // Prepare HTML for Arabic text
                    $html = '<div style="text-align: ' . $alignment . '; direction: rtl;">' . htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . '</div>';

                    $pdf->writeHTMLCell($width, $height, $x, $y, $html, 0, 0, false, true, $alignment, true);
                } else {
                    // For English text, use regular Text method
                    $pdf->Text($x, $y, $text);
                }

            } catch (\Exception $e) {
                Log::error('Failed to add field to PDF', [
                    'field' => $field['field'] ?? 'unknown',
                    'error' => $e->getMessage(),
                    'index' => $index
                ]);

                // في حالة فشل تعين الخط، استخدم الخط الافتراضي
                try {
                    $pdf->SetFont('dejavusans', '', 12);
                    $text = $this->getFieldValue($field['field'], $course, $user, $data);
                    $x = $this->pxToMm($field['x']);
                    $y = $this->pxToMm($field['y']);
                    $pdf->Text($x, $y, $text);
                } catch (\Exception $fallbackError) {
                    Log::error('Fallback text addition also failed', [
                        'field' => $field['field'] ?? 'unknown',
                        'error' => $fallbackError->getMessage()
                    ]);
                }
            }
        }
    }

    /**
     * Check if text contains Arabic characters
     */
    private function containsArabic($text)
    {
        return preg_match('/[\x{0600}-\x{06FF}]/u', $text);
    }

    /**
     * Convert alignment to HTML style
     */
    private function getAlignment($alignment)
    {
        switch (strtoupper($alignment)) {
            case 'C':
            case 'CENTER':
                return 'center';
            case 'R':
            case 'RIGHT':
                return 'right';
            case 'L':
            case 'LEFT':
            default:
                return 'left';
        }
    }

    private function pxToMm($px)
    {
        return floatval($px) * $this->pxToMmRatio;
    }

    private function getFontStyle($style)
    {
        $style = strtolower(trim($style));
        switch ($style) {
            case 'bold':
            case 'b':
                return 'B';
            case 'italic':
            case 'i':
                return 'I';
            case 'underline':
            case 'u':
                return 'U';
            case 'bolditalic':
            case 'bi':
                return 'BI';
            default:
                return '';
        }
    }

    /**
     * الحصول على الخط المدعوم مع دعم النص العربي
     */
    private function getSupportedFont(string $requestedFont): string
    {
        // تحقق من وجود الخط في القائمة المدعومة مباشرة
        if (isset($this->supportedFonts[$requestedFont])) {
            return $this->supportedFonts[$requestedFont];
        }

        // تحقق من وجود خط بديل
        if (isset($this->fontMapping[$requestedFont])) {
            return $this->fontMapping[$requestedFont];
        }

        // البحث الجزئي في أسماء الخطوط
        foreach ($this->fontMapping as $pattern => $replacement) {
            if (strpos($requestedFont, $pattern) !== false) {
                return $replacement;
            }
        }

        // الخط الافتراضي للنص العربي
        return 'dejavusans';
    }

    /**
     * Get field value based on field type
     */
    private function getFieldValue(string $field, Course $course, User $user, array $data): string
    {
        try {
            switch ($field) {
                case 'user_name':
                case 'student_name':
                    return $user->name ?? '';
                case 'user_email':
                    return $user->email ?? '';
                case 'course_name':
                    return $course->name ?? '';
                case 'course_description':
                    return $course->description ?? '';
                case 'grade':
                    return ($data['grade'] ?? 0) . '/' . ($data['fullGrade'] ?? 100);
                case 'percentage':
                    return ($data['percentage'] ?? 0) . '%';
                case 'attendance':
                    return ($data['attendance']['percentage'] ?? 0) . '%';
                case 'attendance_sessions':
                    return ($data['attendance']['attended'] ?? 0) . '/' . ($data['attendance']['total'] ?? 0);
                case 'issue_date':
                case 'completion_date':
                    return now()->format('Y-m-d');
                case 'issue_date_ar':
                    return now()->locale('ar')->translatedFormat('j F Y');
                case 'certificate_id':
                    return $data['certificateId'] ?? '';
                case 'custom_text':
                    return $field['custom_value'] ?? $course->certificateTemplate->description ?? '';
                default:
                    Log::warning('Unknown field type', ['field' => $field]);
                    return $field;
            }
        } catch (\Exception $e) {
            Log::error('Error getting field value', [
                'field' => $field,
                'error' => $e->getMessage()
            ]);
            return '';
        }
    }

    /**
     * Convert hex color to RGB
     */
    private function hexToRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');
        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2))
        ];
    }

    /**
     * Get certificate template for course
     */
    private function getCertificateTemplate(Course $course): CertificateTemplate
    {
        // Check if course has specific template
        if ($course->certificate_template_id) {
            $template = CertificateTemplate::find($course->certificate_template_id);
            if ($template && $template->is_active) {
                return $template;
            }
        }

        // Get default template
        $defaultTemplate = CertificateTemplate::where('is_default', true)
            ->where('is_active', true)
            ->first();

        if (!$defaultTemplate) {
            throw new \Exception('No active certificate template found');
        }

        return $defaultTemplate;
    }

    /**
     * Generate certificates for all eligible users in a course
     */
    private function generateCourseCertificatesForEligibleUsers(Course $course)
    {
        $eligibleUsers = $this->getEligibleUsersWithoutCertificates($course);
        $certificatesGenerated = 0;
        $errors = [];

        foreach ($eligibleUsers as $user) {
            try {
                $this->generateCertificateForUser($course, $user);
                $certificatesGenerated++;
            } catch (\Exception $e) {
                $errors[] = "Failed to generate certificate for user {$user->name}: " . $e->getMessage();
                Log::error("Certificate generation failed for user {$user->id}: " . $e->getMessage());
            }
        }

        Log::info("Generated {$certificatesGenerated} certificates for course {$course->id}");

        if (!empty($errors)) {
            Log::warning("Certificate generation errors: " . implode(', ', $errors));
        }

        return $certificatesGenerated;
    }

    /**
     * Get users eligible for certificate generation
     */
    private function getEligibleUsers(Course $course)
    {
        $courseId = $course->id;
        $passingGrade = $course->passing_grade;

        return User::whereHas('courseRequests', function ($query) use ($courseId) {
            $query->where('course_id', $courseId)
                ->where('status', 'approved');
        })
            ->whereHas('courseGrades', function ($query) use ($courseId, $passingGrade) {
                $query->where('course_id', $courseId)
                    ->where('grade', '>=', $passingGrade);
            })
            ->with([
                'courseGrades' => function ($query) use ($courseId) {
                    $query->where('course_id', $courseId);
                }
            ])
            ->get();
    }

    /**
     * Get eligible users who don't have certificates yet
     */
    public function getEligibleUsersWithoutCertificates(Course $course)
    {
        $courseId = $course->id;
        $passingGrade = $course->passing_grade;

        return User::whereHas('courseRequests', function ($query) use ($courseId) {
            $query->where('course_id', $courseId)
                ->where('status', 'approved');
        })
            ->whereHas('courseGrades', function ($query) use ($courseId, $passingGrade) {
                $query->where('course_id', $courseId)
                    ->where('grade', '>=', $passingGrade);
            })
            ->whereDoesntHave('certificates', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })
            ->with([
                'courseGrades' => function ($query) use ($courseId) {
                    $query->where('course_id', $courseId);
                }
            ])
            ->get();
    }

    /**
     * Calculate attendance percentage for a user in a course
     */
    private function calculateAttendance(Course $course, User $user)
    {
        $totalSessions = $course->schedules()->count();

        $attended = $course->schedules()
            ->whereHas('attendances', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->where('attended', true);
            })
            ->count();

        $attendancePercentage = $totalSessions > 0 ? ($attended / $totalSessions) * 100 : 0;

        return [
            'total' => $totalSessions,
            'attended' => $attended,
            'percentage' => round($attendancePercentage, 2)
        ];
    }

    /**
     * Generate unique certificate ID
     */
    private function generateCertificateId(Course $course, User $user)
    {
        return 'CERT-' . $course->id . '-' . $user->id . '-' . date('Ymd') . '-' . substr(uniqid(), -4);
    }

    /**
     * Download certificate for a user
     */
    public function downloadCourseCertificate(Course $course, User $user)
    {
        $certificate = CourseCertificate::where('course_id', $course->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$certificate || !Storage::exists('public/' . $certificate->certificate_file)) {
            return redirect()->back()->with('error', 'Certificate not found');
        }

        $downloadName = $user->name . '_' . $course->name . '_Certificate.pdf';

        return Storage::download(
            'public/' . $certificate->certificate_file,
            $downloadName
        );
    }

    /**
     * Preview certificate template
     */
    public function previewCertificateTemplate(CertificateTemplate $template, Course $course = null)
    {
        try {
            // Use sample data for preview
            $sampleUser = new User([
                'name' => 'خالد عابد أمــين',
                'email' => 'khalidabeed24@gmail.com'
            ]);

            $sampleCourse = $course ?: new Course([
                'name' => 'كورس تصميم المواقع',
                'description' => 'كورس شامل في تصميم وتطوير المواقع'
            ]);

            $sampleData = [
                'grade' => 95,
                'fullGrade' => 100,
                'percentage' => 95,
                'attendance' => [
                    'total' => 10,
                    'attended' => 9,
                    'percentage' => 90
                ],
                'certificateId' => 'CERT-PREVIEW-001'
            ];

            $fileName = $this->generatePdfWithTcpdf($sampleCourse, $sampleUser, $template, $sampleData);
            $filePath = storage_path('app/public/' . $fileName);

            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="preview.pdf"'
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * View certificate in browser
     */
    public function viewCourseCertificate(Course $course, User $user)
    {
        $certificate = CourseCertificate::where('course_id', $course->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$certificate || !Storage::exists('public/' . $certificate->certificate_file)) {
            return redirect()->back()->with('error', 'Certificate not found');
        }

        $template = $this->getCertificateTemplate($course);
        $grade = $course->grades()->where('user_id', $user->id)->first();
        $attendanceData = $this->calculateAttendance($course, $user);
        $certificateId = $certificate->certificate_id;
        $fileName = $this->generatePdfWithTcpdf($course, $user, $template, [
            'grade' => $grade->grade,
            'fullGrade' => $course->grade,
            'percentage' => round(($grade->grade / $course->grade) * 100, 2),
            'attendance' => $attendanceData,
            'certificateId' => $certificateId
        ]);
        $filePath = storage_path('app/public/' . $fileName);
        return response()->file($filePath);
    }

    /**
     * Get all certificates for a course
     */
    public function getCertificatesForCourse(Course $course)
    {
        $certificates = CourseCertificate::where('course_id', $course->id)
            ->with('user')
            ->orderBy('issued_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'certificates' => $certificates
        ]);
    }

    /**
     * Get certificates data for DataTables
     */
    public function listCertificatesAjax(Course $course)
    {
        $certificates = $course->certificates()
            ->with('user')
            ->select('course_certificates.*');

        return DataTables::of($certificates)
            ->addIndexColumn()
            ->addColumn('user_name', function ($certificate) {
                return $certificate->user ? $certificate->user->name : 'N/A';
            })
            ->addColumn('user_email', function ($certificate) {
                return $certificate->user ? $certificate->user->email : 'N/A';
            })
            ->addColumn('certificate_id', function ($certificate) {
                return $certificate->certificate_id ?? 'N/A';
            })
            ->addColumn('grade_display', function ($certificate) use ($course) {
                return $certificate->grade . '/' . $course->grade;
            })
            ->addColumn('percentage', function ($certificate) use ($course) {
                if ($course->grade > 0) {
                    return round(($certificate->grade / $course->grade) * 100, 2) . '%';
                }
                return '0%';
            })
            ->addColumn('issued_date', function ($certificate) {
                return $certificate->issued_at ? $certificate->issued_at : 'N/A';
            })
            ->addColumn('actions', function ($certificate) use ($course) {
                if (!$certificate->user) {
                    return '<span class="text-muted">No actions available</span>';
                }

                $downloadUrl = route(
                    'admin.physical-courses.certificates.courses.download-certificate',
                    [$course->id, $certificate->user->id]
                );

                $viewUrl = route(
                    'admin.physical-courses.certificates.courses.view-certificate',
                    [$course->id, $certificate->user->id]
                );

                return '
                <div class="d-flex gap-1">
                    <a href="' . $viewUrl . '" class="btn btn-sm btn-info" title="View Certificate" target="_blank">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="' . $downloadUrl . '" class="btn btn-sm btn-primary" title="Download Certificate">
                        <i class="fas fa-download"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-danger delete-certificate"
                            data-id="' . $certificate->id . '"
                            data-course-id="' . $course->id . '"
                            title="Delete Certificate">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }


    public function listuserCertificatesAjax()
    {
        try {
            $certificates = CourseCertificate::where('user_id', auth()->id())
                ->whereHas('course.surveyResponses', function ($query) {
                    $query->where('user_id', auth()->id());
                })
                ->with(['course', 'user'])
                ->select('course_certificates.*');

            return DataTables::of($certificates)
                ->addIndexColumn()
                ->addColumn('user_name', function ($certificate) {
                    return $certificate->user->name ?? 'N/A';
                })
                ->addColumn('course_name', function ($certificate) {
                    return $certificate->course->name ?? 'N/A';
                })
                ->addColumn('certificate_id', function ($certificate) {
                    return '<span class="certificate-id">' . ($certificate->certificate_id ?? 'N/A') . '</span>';
                })
                ->addColumn('grade_display', function ($certificate) {
                    $userGrade = $certificate->grade ?? 0;
                    $totalGrade = $certificate->course->grade ?? 0;

                    if ($totalGrade > 0) {
                        $badgeClass = ($userGrade >= $certificate->course->passing_grade) ? 'success' : 'warning';
                        return '<span class="badge bg-' . $badgeClass . '">' . $userGrade . '/' . $totalGrade . '</span>';
                    }
                    return '<span class="badge bg-secondary">N/A</span>';
                })
                ->addColumn('percentage', function ($certificate) {
                    $courseGrade = $certificate->course->grade ?? 0;
                    if ($courseGrade > 0) {
                        $percentage = round(($certificate->grade / $courseGrade) * 100, 2);
                        $badgeClass = ($percentage >= 70) ? 'success' : (($percentage >= 50) ? 'warning' : 'danger');
                        return '<span class="badge bg-' . $badgeClass . '">' . $percentage . '%</span>';
                    }
                    return '<span class="badge bg-secondary">0%</span>';
                })
                ->addColumn('issued_date', function ($certificate) {
                    if ($certificate->issued_at) {
                        return \Carbon\Carbon::parse($certificate->issued_at)->format('d M Y');
                    }
                    return 'N/A';
                })
                ->addColumn('actions', function ($certificate) {
                    if (!$certificate->user || !$certificate->course) {
                        return '<span class="text-muted">No actions available</span>';
                    }

                    $downloadUrl = route(
                        'admin.physical-courses.certificates.courses.download-certificate',
                        [$certificate->course->id, $certificate->user->id]
                    );

                    $viewUrl = route(
                        'admin.physical-courses.certificates.courses.view-certificate',
                        [$certificate->course->id, $certificate->user->id]
                    );

                    return '
                <div class="d-flex gap-1">
                    <a href="' . $viewUrl . '" class="btn btn-sm btn-info" title="' . __('physicalCourses.view_certificate') . '" target="_blank">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="' . $downloadUrl . '" class="btn btn-sm btn-primary" title="' . __('physicalCourses.download_certificate') . '">
                        <i class="fas fa-download"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-danger delete-certificate"
                            data-id="' . $certificate->id . '"
                            data-course-id="' . $certificate->course->id . '"
                            title="' . __('physicalCourses.delete_certificate') . '">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>';
                })
                ->rawColumns(['certificate_id', 'grade_display', 'percentage', 'actions'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching certificates.',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Get eligible users without certificates for DataTables
     *
     * @param Course $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function listEligibleUsersWithoutCertificatesAjax(Course $course)
    {
        $courseId = $course->id;
        $passingGrade = $course->passing_grade;

        $eligibleUsers = User::whereHas('courseRequests', function ($query) use ($courseId) {
            $query->where('course_id', $courseId)
                ->where('status', 'approved');
        })
            ->whereHas('courseGrades', function ($query) use ($courseId, $passingGrade) {
                $query->where('course_id', $courseId)
                    ->where('grade', '>=', $passingGrade);
            })
            ->whereDoesntHave('certificates', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })
            ->with([
                'courseGrades' => function ($query) use ($courseId) {
                    $query->where('course_id', $courseId);
                }
            ])
            ->select('users.*');

        return DataTables::of($eligibleUsers)
            ->addIndexColumn()
            ->addColumn('user_name', function ($user) {
                return $user->name;
            })
            ->addColumn('user_email', function ($user) {
                return $user->email;
            })
            ->addColumn('grade_display', function ($user) use ($course) {
                $userGrade = $user->courseGrades->first();
                return $userGrade ? $userGrade->grade . '/' . $course->grade : 'N/A';
            })
            ->addColumn('percentage', function ($user) use ($course) {
                $userGrade = $user->courseGrades->first();
                if ($userGrade && $course->grade > 0) {
                    return round(($userGrade->grade / $course->grade) * 100, 2) . '%';
                }
                return '0%';
            })
            ->addColumn('status', function ($user) use ($course) {
                $userGrade = $user->courseGrades->first();
                if ($userGrade) {
                    $percentage = $course->grade > 0 ? round(($userGrade->grade / $course->grade) * 100, 2) : 0;
                    if ($percentage >= 90) {
                        return '<span class="badge bg-success">Excellent</span>';
                    } elseif ($percentage >= 80) {
                        return '<span class="badge bg-info">Very Good</span>';
                    } elseif ($percentage >= 70) {
                        return '<span class="badge bg-warning">Good</span>';
                    } else {
                        return '<span class="badge bg-secondary">Pass</span>';
                    }
                }
                return '<span class="badge bg-secondary">N/A</span>';
            })
            ->addColumn('actions', function ($user) use ($course) {
                $generateUrl = route(
                    'admin.physical-courses.certificates.courses.generate-single-certificate',
                    [$course->id, $user->id]
                );

                return '
                <div class="d-flex gap-1">
                    <button type="button" class="btn btn-sm btn-success generate-single-certificate"
                            data-url="' . $generateUrl . '"
                            data-user-id="' . $user->id . '"
                            data-user-name="' . $user->name . '"
                            title="Generate Certificate">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>';
            })
            ->rawColumns(['actions', 'status'])
            ->make(true);
    }

    /**
     * Generate certificate manually for a specific user
     *
     * @param Course $course
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function generateCertificate(Course $course, User $user)
    {
        try {
            // Check if user is eligible
            $userGrade = $user->courseGrades()
                ->where('course_id', $course->id)
                ->where('grade', '>=', $course->passing_grade)
                ->first();

            if (!$userGrade) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User is not eligible for certificate'
                    ], 400);
                }
                return back()->with('error', 'User is not eligible for certificate');
            }

            // Check if certificate already exists
            $existingCertificate = $user->certificates()
                ->where('course_id', $course->id)
                ->first();

            if ($existingCertificate) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Certificate already exists for this user'
                    ], 400);
                }
                return back()->with('error', 'Certificate already exists for this user');
            }

            // Generate certificate
            $fileName = $this->generateCertificateForUser($course, $user);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Certificate generated successfully',
                    'file_name' => $fileName
                ]);
            }

            return back()->with('success', 'Certificate generated successfully.');
        } catch (\Exception $e) {
            Log::error('Manual certificate generation failed: ' . $e->getMessage());

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error generating certificate: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Generate single certificate (AJAX endpoint)
     *
     * @param Course $course
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateSingleCertificateForCourse(Course $course, User $user)
    {
        try {
            // Check if user is eligible
            $userGrade = $user->courseGrades()
                ->where('course_id', $course->id)
                ->where('grade', '>=', $course->passing_grade)
                ->first();

            if (!$userGrade) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is not eligible for certificate'
                ], 400);
            }

            // Check if certificate already exists
            $existingCertificate = $user->certificates()
                ->where('course_id', $course->id)
                ->first();

            if ($existingCertificate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Certificate already exists for this user'
                ], 400);
            }

            // Generate certificate
            $fileName = $this->generateCertificateForUser($course, $user);

            return response()->json([
                'success' => true,
                'message' => 'Certificate generated successfully',
                'file_name' => $fileName
            ]);

        } catch (\Exception $e) {
            Log::error('Single certificate generation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error generating certificate: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Regenerate all certificates for a course
     *
     * @param Course $course
     * @return \Illuminate\Http\RedirectResponse
     */
    public function regenerateAllCertificatesForCourse(Course $course)
    {
        try {
            DB::beginTransaction();

            // Delete existing certificates
            $existingCertificates = CourseCertificate::where('course_id', $course->id)->get();
            foreach ($existingCertificates as $certificate) {
                if (Storage::exists('public/' . $certificate->certificate_file)) {
                    Storage::delete('public/' . $certificate->certificate_file);
                }
                $certificate->delete();
            }

            // Generate new certificates for all eligible users
            $eligibleUsers = $this->getEligibleUsers($course);
            $certificatesGenerated = 0;

            foreach ($eligibleUsers as $user) {
                try {
                    $this->generateCertificateForUser($course, $user);
                    $certificatesGenerated++;
                } catch (\Exception $e) {
                    Log::error("Failed to regenerate certificate for user {$user->id}: " . $e->getMessage());
                }
            }

            DB::commit();

            return back()->with('success', "{$certificatesGenerated} certificates regenerated successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Regeneration of certificates failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to regenerate certificates: ' . $e->getMessage());
        }
    }

    /**
     * Delete a specific certificate
     *
     * @param Request $request
     * @param Course $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCertificate(Request $request, Course $course)
    {
        try {
            $certificateId = $request->input('certificate_id');
            $certificate = CourseCertificate::where('id', $certificateId)
                ->where('course_id', $course->id)
                ->firstOrFail();

            // Delete file if exists
            if (Storage::exists('public/' . $certificate->certificate_file)) {
                Storage::delete('public/' . $certificate->certificate_file);
            }

            $certificate->delete();

            return response()->json([
                'success' => true,
                'message' => 'Certificate deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Certificate deletion failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting certificate: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display user's certificates
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listMyCertificates()
    {
        $user = auth()->user();
        $certificates = CourseCertificate::where('user_id', $user->id)
            ->with('course')
            ->orderBy('issued_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'certificates' => $certificates
        ]);
    }

    /**
     * Download user's own certificate
     *
     * @param CourseCertificate $certificate
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
     */
    public function downloadMyCourseCertificate(CourseCertificate $certificate)
    {
        // Check if the certificate belongs to the authenticated user
        if ($certificate->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized access to certificate');
        }

        if (!Storage::exists('public/' . $certificate->certificate_file)) {
            return redirect()->back()->with('error', 'Certificate file not found');
        }

        $downloadName = auth()->user()->name . '_' . $certificate->course->name . '_Certificate.pdf';

        return Storage::download(
            'public/' . $certificate->certificate_file,
            $downloadName
        );
    }

    /**
     * Get certificates page view
     *
     * @param Course $course
     * @return \Illuminate\View\View
     */
    public function getCertificates(Course $course)
    {
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.physical-courses.courses.index'), 'name' => __('physicalCourses.physical_courses')],
            ['name' => __('physicalCourses.certificates')],
        ];

        $certificates = CourseCertificate::where('course_id', $course->id)
            ->with('user')
            ->orderBy('issued_at', 'desc')
            ->get();

        $eligibleUsers = $this->getEligibleUsers($course);

        return view('physicalCourses.certificate.index', compact('course', 'certificates', 'breadcrumbs', 'eligibleUsers'));
    }

    /**
     * Get course certificate statistics
     *
     * @param Course $course
     * @return array
     */
    public function getCourseCertificateStatistics(Course $course)
    {
        $eligibleUsers = $this->getEligibleUsers($course);
        $certificates = CourseCertificate::where('course_id', $course->id)->get();

        return [
            'total_eligible' => $eligibleUsers->count(),
            'certificates_generated' => $certificates->count(),
            'pending_certificates' => $eligibleUsers->count() - $certificates->count(),
            'completion_percentage' => $eligibleUsers->count() > 0
                ? round(($certificates->count() / $eligibleUsers->count()) * 100, 2)
                : 0
        ];
    }

    // ================================== *************** ==================================
    // LMS Training module certificate Certificates
    // ===================================== ************** ===============================

    public function generateSingleCertificateForTraining(LMSTrainingModule $lMSTrainingModule, User $user)
    {
        try {
            // Check if user is eligible - Fixed the column name
            $userGrade = $user->trainingModules()
                ->where('training_module_id', $lMSTrainingModule->id)
                ->wherePivot('score', '>=', $lMSTrainingModule->passing_score)
                ->wherePivot('passed', 1)
                ->first();

            if (!$userGrade) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is not eligible for certificate'
                ], 400);
            }

            // Check if certificate already exists
            $existingCertificate = $user->trainingCertificates()
                ->where('training_id', $lMSTrainingModule->id)
                ->first();

            if ($existingCertificate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Certificate already exists for this user'
                ], 400);
            }

            // Generate certificate
            $fileName = $this->generateTrainingCertificateForUser($lMSTrainingModule, $user);

            return response()->json([
                'success' => true,
                'message' => 'Certificate generated successfully',
                'file_name' => $fileName
            ]);

        } catch (\Exception $e) {
            Log::error('Single certificate generation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error generating certificate: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate training certificate for user
     */
    public function generateTrainingCertificateForUser(LMSTrainingModule $lMSTrainingModule, User $user)
    {
        // Check if user meets grade requirements
        $userPivot = $lMSTrainingModule->users()
            ->where('user_id', $user->id)
            ->wherePivot('passed', 1)
            ->first();

        if (!$userPivot || $userPivot->pivot->score < $lMSTrainingModule->passing_score) {
            throw new \Exception('User does not meet grade requirements');
        }

        $template = $this->getCertificateTemplateForTraining($lMSTrainingModule);
        $certificateId = $this->generateCertificateIdForTraining($lMSTrainingModule, $user);

        $fileName = $this->generatePdfWithTcpdfForTraining($lMSTrainingModule, $user, $template, [
            'score' => $userPivot->pivot->score,
            'passing_score' => $lMSTrainingModule->passing_score,
            'percentage' => round($userPivot->pivot->score, 2),
            'certificateId' => $certificateId,
            'completed_at' => $userPivot->pivot->completed_at
        ]);

        // Save certificate record
        LMSTrainingModuleCertificate::updateOrCreate([
            'training_id' => $lMSTrainingModule->id,
            'user_id' => $user->id,
        ], [
            'certificate_file' => $fileName,
            'certificate_id' => $certificateId,
            'grade' => $userPivot->pivot->score,
            'template_id' => $template->id,
            'issued_at' => now(),
            'campaign_id' => $userPivot->pivot->campaign_id ?? null, // Add campaign_id if exists
        ]);

        return $fileName;
    }

    /**
     * Get certificate template for training module
     */
    private function getCertificateTemplateForTraining(LMSTrainingModule $lMSTrainingModule): CertificateTemplate
    {
        // Check if training module has specific template
        if ($lMSTrainingModule->certificate_template_id) {
            $template = CertificateTemplate::find($lMSTrainingModule->certificate_template_id);
            if ($template && $template->is_active) {
                return $template;
            }
        }

        // Check if level has template
        if ($lMSTrainingModule->level && $lMSTrainingModule->level->certificate_template_id) {
            $template = CertificateTemplate::find($lMSTrainingModule->level->certificate_template_id);
            if ($template && $template->is_active) {
                return $template;
            }
        }

        // Check if course has template
        if ($lMSTrainingModule->level && $lMSTrainingModule->level->course && $lMSTrainingModule->level->course->certificate_template_id) {
            $template = CertificateTemplate::find($lMSTrainingModule->level->course->certificate_template_id);
            if ($template && $template->is_active) {
                return $template;
            }
        }

        // Get default template
        $defaultTemplate = CertificateTemplate::where('is_default', true)
            ->where('is_active', true)
            ->first();

        if (!$defaultTemplate) {
            throw new \Exception('No active certificate template found');
        }

        return $defaultTemplate;
    }

    /**
     * Generate unique certificate ID
     */
    private function generateCertificateIdForTraining(LMSTrainingModule $lMSTrainingModule, User $user)
    {
        return 'LMS-CERT-' . $lMSTrainingModule->id . '-' . $user->id . '-' . date('Ymd') . '-' . substr(uniqid(), -4);
    }

    /**
     * Generate PDF certificate using TCPDF
     */
    private function generatePdfWithTcpdfForTraining(LMSTrainingModule $lMSTrainingModule, User $user, CertificateTemplate $template, array $data)
    {
        try {
            // Ensure output directory exists
            $outputDir = storage_path('app/public/certificates/training_modules/' . $lMSTrainingModule->id);
            if (!file_exists($outputDir)) {
                mkdir($outputDir, 0777, true);
            }

            // Check if template file exists
            $templatePath = storage_path('app/public/' . $template->file_path);
            if (!file_exists($templatePath)) {
                throw new \Exception('Certificate template file not found');
            }

            // Initialize TCPDF with FPDI
            $pdf = new Fpdi('L', 'mm', 'A4', true, 'UTF-8', false);

            // Set document information
            $pdf->SetCreator('LMS Certificate Generator');
            $pdf->SetAuthor('Training System');
            $pdf->SetTitle('Training Certificate - ' . $user->name);

            // Set default font subsetting mode
            $pdf->setFontSubsetting(true);

            // Set margins
            $pdf->SetMargins(0, 0, 0);
            $pdf->SetAutoPageBreak(false, 0);

            // Remove header/footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            // Set source file and add page
            $pdf->setSourceFile($templatePath);
            $pdf->AddPage($template->orientation ?: 'L');

            // Import the template page
            $tpl = $pdf->importPage(1);
            $pdf->useTemplate($tpl);

            // Add custom text based on template configuration
            $this->addTextToTcpdfForTraining($pdf, $template, $lMSTrainingModule, $user, $data);

            // Generate unique filename
            $fileName = 'certificates/training_modules/' . $lMSTrainingModule->id . '/' . $user->id . '_' . time() . '.pdf';
            $filePath = storage_path('app/public/' . $fileName);

            // Save the PDF
            $pdf->Output($filePath, 'F');

            return $fileName;

        } catch (\Exception $e) {
            Log::error('TCPDF Certificate generation failed: ' . $e->getMessage());
            throw new \Exception('Failed to generate certificate: ' . $e->getMessage());
        }
    }

    /**
     * Add text to TCPDF with Arabic support
     */
    private function addTextToTcpdfForTraining(Fpdi $pdf, CertificateTemplate $template, LMSTrainingModule $lMSTrainingModule, User $user, array $data)
    {
        if (empty($template->field_positions)) {
            Log::warning('No field positions found for template', ['template_id' => $template->id]);
            return;
        }

        $fields = is_string($template->field_positions)
            ? json_decode($template->field_positions, true)
            : $template->field_positions;

        if (!is_array($fields) || empty($fields)) {
            Log::warning('Field positions is not valid array', [
                'template_id' => $template->id,
                'field_positions' => $template->field_positions
            ]);
            return;
        }

        foreach ($fields as $index => $field) {
            try {
                if (!isset($field['field']) || !isset($field['x']) || !isset($field['y'])) {
                    Log::warning('Invalid field structure', [
                        'index' => $index,
                        'field' => $field
                    ]);
                    continue;
                }

                // Get the text value
                $text = $this->getFieldValueForTraining($field['field'], $lMSTrainingModule, $user, $data);

                if (empty($text)) {
                    Log::warning('Empty text for field', [
                        'field' => $field['field'],
                        'user_id' => $user->id
                    ]);
                    continue;
                }

                // Font configuration
                $fontFamily = isset($field['font_family']) ? explode(',', $field['font_family'])[0] : 'dejavusans';
                $fontFamily = trim(strtolower($fontFamily));
                $supportedFont = $this->getSupportedFont($fontFamily);
                $fontSize = $field['font_size'] ?? 12;
                $fontStyle = $this->getFontStyle($field['font_style'] ?? '');

                // Set font
                $pdf->SetFont($supportedFont, $fontStyle, $fontSize);

                // Set text color
                if (isset($field['color']) && !empty($field['color'])) {
                    $color = $this->hexToRgb($field['color']);
                    $pdf->SetTextColor($color['r'], $color['g'], $color['b']);
                } else {
                    $pdf->SetTextColor(0, 0, 0);
                }

                // Convert coordinates
                $x = $this->pxToMm($field['x']);
                $y = $this->pxToMm($field['y']);

                // Add text to PDF
                if ($this->containsArabic($text)) {
                    $width = isset($field['width']) ? $this->pxToMm($field['width']) : 100;
                    $height = isset($field['height']) ? $this->pxToMm($field['height']) : 10;
                    $alignment = $this->getAlignment($field['alignment'] ?? 'L');

                    $html = '<div style="text-align: ' . $alignment . '; direction: rtl;">' . htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . '</div>';
                    $pdf->writeHTMLCell($width, $height, $x, $y, $html, 0, 0, false, true, $alignment, true);
                } else {
                    $pdf->Text($x, $y, $text);
                }

            } catch (\Exception $e) {
                Log::error('Failed to add field to PDF', [
                    'field' => $field['field'] ?? 'unknown',
                    'error' => $e->getMessage(),
                    'index' => $index
                ]);
            }
        }
    }

    private function getFieldValueForTraining($field, LMSTrainingModule $lMSTrainingModule, User $user, array $data)
    {
        switch ($field) {
            case 'user_name':
                return $user->name;
            case 'user_email':
                return $user->email;
            case 'training_name':
                return $lMSTrainingModule->name;
            case 'training_level':
                return $lMSTrainingModule->level ? $lMSTrainingModule->level->title : '';
            case 'course_name':
                return $lMSTrainingModule->level && $lMSTrainingModule->level->course ? $lMSTrainingModule->level->course->title : '';
            case 'score':
            case 'grade':
                return $data['score'] . '%';
            case 'passing_score':
                return $data['passing_score'] . '%';
            case 'certificate_id':
                return $data['certificateId'];
            case 'issued_date':
                return now()->format('Y-m-d');
            case 'completed_date':
                return $data['completed_at'] ? $data['completed_at']->format('Y-m-d') : now()->format('Y-m-d');
            case 'completion_time':
                return $lMSTrainingModule->completion_time . ' minutes';
            default:
                return '';
        }
    }

    // public function viewTrainingCertificate(LMSTrainingModule $training, User $user)
    // {
    //     $certificate = LMSTrainingModuleCertificate::where('train_id', $training->id)
    //         ->where('user_id', $user->id)
    //         ->first();

    //     if (!$certificate || !Storage::exists('public/' . $certificate->certificate_file)) {
    //         return redirect()->back()->with('error', 'Certificate not found');
    //     }

    //     $template = $this->getCertificateTemplateForTraining($training);
    //     $grade = $training->grades()->where('user_id', $user->id)->first();
    //     $certificateId = $certificate->certificate_id;
    //     $fileName = $this->generatePdfWithTcpdfForTraining($training, $user, $template, [
    //         'grade' => $grade->grade,
    //         'fullGrade' => $training->grade,
    //         'percentage' => round(($grade->grade / $training->grade) * 100, 2),
    //         'certificateId' => $certificateId
    //     ]);
    //     $filePath = storage_path('app/public/' . $fileName);
    //     return response()->file($filePath);
    // }

    public function viewTrainingCertificateRegenerate(LMSTrainingModule $training, User $user)
    {
        try {
            $userPivot = $training->users()
                ->where('user_id', $user->id)
                ->wherePivot('passed', 1)
                ->wherePivot('score', '>=', $training->passing_score)
                ->first();

            if (!$userPivot) {
                return redirect()->back()->with('error', 'User is not eligible for this certificate');
            }

            $template = $this->getCertificateTemplateForTraining($training);
            $certificate = LMSTrainingModuleCertificate::where('training_id', $training->id)
                ->where('user_id', $user->id)
                ->first();

            $certificateId = $certificate ? $certificate->certificate_id : $this->generateCertificateIdForTraining($training, $user);
            $fileName = $this->generatePdfWithTcpdfForTraining($training, $user, $template, [
                'score' => $userPivot->pivot->score,
                'passing_score' => $training->passing_score,
                'percentage' => round($userPivot->pivot->score, 2),
                'certificateId' => $certificateId,
                'completed_at' => $userPivot->pivot->completed_at
            ]);

            $filePath = storage_path('app/public/' . $fileName);

            if (!file_exists($filePath)) {
                return redirect()->back()->with('error', 'Failed to generate certificate file');
            }

            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="certificate_' . $user->id . '_' . $training->id . '.pdf"'
            ]);

        } catch (\Exception $e) {
            Log::error('Error generating training certificate for view: ' . $e->getMessage(), [
                'training_id' => $training->id,
                'user_id' => $user->id
            ]);

            return redirect()->back()->with('error', 'Error generating certificate: ' . $e->getMessage());
        }
    }

}
