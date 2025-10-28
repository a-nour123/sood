<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CertificateTemplate extends Model
{
    use HasFactory;
    protected $table = 'certificate_templates';

    protected $fillable = [
        'name',
        'description',
        'file_path',
        'orientation',
        'field_positions',
        'is_default',
        'is_active',
        'auto_send',
        'background_color',
        'settings'
    ];

    protected $casts = [
        'field_positions' => 'array',
        'settings' => 'array',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'auto_send' => 'boolean'
    ];



    /**
     * Courses using this template
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'certificate_template_id');
    }

    /**
     * Certificates generated using this template
     */
    public function certificates()
    {
        return $this->hasMany(CourseCertificate::class, 'template_id');
    }

    // /**
    //  * Get template file URL
    //  */
    // public function getFileUrlAttribute()
    // {
    //     return $this->file_path ? Storage::url($this->file_path) : null;
    // }

    /**
     * Check if template file exists
     */
    public function templateFileExists()
    {
        return $this->file_path && Storage::exists('public/' . $this->file_path);
    }

    /**
     * Get the file URL for the template
     */
    public function getFileUrlAttribute()
    {
        if (!$this->file_path) {
            return null;
        }

        if (!Storage::disk('public')->exists($this->file_path)) {
            return null;
        }

        return asset('storage/' . $this->file_path);
    }

    /**
     * Check if file exists
     */
    public function getFileExistsAttribute()
    {
        return $this->file_path && Storage::disk('public')->exists($this->file_path);
    }

    /**
     * Get available field types for templates
     */
    public static function getAvailableFields()
    {
        return [
            'user_name' => __('locale.user_name'), // اسم المتدرب
            'user_email' => __('locale.user_email'), // بريد المتدرب الإلكتروني
            'course_name' => __('locale.course_name'), // اسم الكورس
            'course_description' => __('locale.course_description'), // وصف الكورس
            'grade' => __('locale.grade'), // الدرجة (مثال: 95/100)
            'percentage' => __('locale.percentage'), // النسبة المئوية
            'attendance' => __('locale.attendance'), // نسبة الحضور
            'attendance_sessions' => __('locale.attendance_sessions'), // عدد جلسات الحضور (مثال: 9/10)
            'issue_date' => __('locale.issue_date'), // تاريخ الإصدار (إنجليزي)
            'issue_date_ar' => __('locale.issue_date_ar'), // تاريخ الإصدار (عربي)
            'certificate_id' => __('locale.certificate_id'), // رقم الشهادة

            // training cases
            'training_name' => __('locale.training_name'), // اسم التدريب
            'training_level' => __('locale.training_level'), // المستوي

            // Uncomment if needed
            // 'instructor_name' => __('locale.instructor_name'), // اسم المدرب
            // 'course_duration' => __('locale.course_duration'), // مدة الكورس
            // 'custom_text' => __('locale.custom_text'), // نص مخصص
        ];
    }


    /**
     * Get font families
     */
    public static function getFontFamilies()
    {
        return [
            'Arial' => 'Arial',
            'Helvetica' => 'Helvetica',
            'Times' => 'Times',
            'Courier' => 'Courier'
        ];
    }

    /**
     * Get font styles
     */
    public static function getFontStyles()
    {
        return [
            '' => 'عادي',
            'B' => 'عريض',
            'I' => 'مائل',
            'U' => 'تحته خط',
            'BI' => 'عريض ومائل',
            'BU' => 'عريض وتحته خط',
            'IU' => 'مائل وتحته خط',
            'BIU' => 'عريض ومائل وتحته خط'
        ];
    }

    /**
     * Scope for active templates
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for default template
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Set as default template
     */
    public function setAsDefault()
    {
        // Remove default from other templates
        static::where('is_default', true)->update(['is_default' => false]);

        // Set this as default
        $this->update(['is_default' => true]);
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($template) {
            // Don't allow deleting if it's the only active template
            $activeCount = static::where('is_active', true)->count();
            if ($activeCount <= 1 && $template->is_active) {
                throw new \Exception('Cannot delete the last active template');
            }

            // Don't allow deleting if courses are using it
            if ($template->courses()->count() > 0) {
                throw new \Exception('Cannot delete template that is being used by courses');
            }

            // Delete template file
            if ($template->file_path && Storage::exists('public/' . $template->file_path)) {
                Storage::delete('public/' . $template->file_path);
            }
        });
    }
}