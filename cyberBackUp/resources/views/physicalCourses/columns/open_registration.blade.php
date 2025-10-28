
@if (auth()->user()->hasPermission('physicalCourses.toggleRegistration'))
    <div data-toggle-registration data-course-id="{{ $course->id }}">
        @if ($course->open_registration)
            <button class="btn btn-sm btn-success" type="button">
                <i class="fas fa-check-circle me-1"></i>
                Open
            </button>
        @else
            <button class="btn btn-sm btn-danger" type="button">
                <i class="fas fa-times-circle me-1"></i>
                Closed
            </button>
        @endif
    </div>
@else
    <div>
        @if ($course->open_registration)
            <button class="btn btn-sm btn-success" type="button" disabled>
                <i class="fas fa-check-circle me-1"></i>
                Open
            </button>
        @else
            <button class="btn btn-sm btn-danger" type="button" disabled>
                <i class="fas fa-times-circle me-1"></i>
                Closed
            </button>
        @endif
    </div>
@endif
