<div class="d-flex gap-1 action-buttons">
    @if (auth()->user()->hasPermission('physicalCourses.update'))
        <a href="{{ route('admin.physical-courses.courses.edit', $course->id) }}" class="btn btn-sm btn-warning">
            <i class="fas fa-edit me-1"></i>
        </a>
    @else
        <a href="#" class="btn btn-sm btn-warning" disabled>
            <i class="fas fa-edit me-1"></i>
        </a>
    @endif

    @if (auth()->user()->hasPermission('physicalCourses.delete'))
        <button class="btn btn-sm btn-danger delete-course" data-course-id="{{ $course->id }}"
            data-course-name="{{ $course->name }}" type="button">
            <i class="fas fa-trash me-1"></i>
        </button>
    @else
        <button class="btn btn-sm btn-danger" disabled type="button">
            <i class="fas fa-trash me-1"></i>
        </button>
    @endif

    @if (auth()->user()->hasPermission('physicalCourses.reports'))
        <a title="Statistics" href="{{ route('admin.physical-courses.courses.course.summary', $course->id) }}"
            class="btn btn-sm btn-info">
            <i class="fas fa-chart-bar me-1"></i>
        </a>
    @else
        <a title="Statistics" href="#" class="btn btn-sm btn-info" disabled>
            <i class="fas fa-chart-bar me-1"></i>
        </a>
    @endif

    @if (auth()->user()->hasPermission('physicalCourses.update') && !$course->course_complete)
        <a href="#" class="btn btn-sm btn-success" data-course-id="{{ $course->id }}" data-toggle-completion
            title="Complete Course">
            <i class="fas fa-circle-check me-1"></i>
        </a>
    @else
        <a href="#" class="btn btn-sm btn-success" disabled title="Complete Course">
            <i class="fas fa-circle-check me-1"></i>
        </a>
    @endif


    {{-- @if ($course->course_complete && auth()->user()->hasPermission('physicalCourses.certificates')) --}}
    @if ($course->course_complete)
        <a class="btn btn-sm btn-purple" title="Manage Certificates"
            href="{{ route('admin.physical-courses.certificates.courses.certificates', $course->id) }}">
            <i class="fas fa-certificate me-1"></i>
        </a>
    @elseif (!$course->course_complete)
        <button class="btn btn-sm btn-purple" disabled title="Complete course first to manage certificates">
            <i class="fas fa-certificate me-1"></i>
        </button>
    @else
        <button class="btn btn-sm btn-purple" disabled title="No permission">
            <i class="fas fa-certificate me-1"></i>
        </button>
    @endif

    <a href="{{ route('admin.physical-courses.courses.survey.results', ['type' => 'course', 'id' => $course->id]) }}"
        class="btn btn-sm btn-primary" title="Manage Surveys">
        <i class="fas fa-list me-1"></i>
    </a>
</div>
