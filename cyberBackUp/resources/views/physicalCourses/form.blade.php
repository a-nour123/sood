@php
    $isEdit = isset($course) && $course;
@endphp

<div class="card">
    <div class="card-body">
        <form
            action="{{ $isEdit ? route('admin.physical-courses.courses.update', $course->id) : route('admin.physical-courses.courses.store') }}"
            method="POST" enctype="multipart/form-data" id="course-form">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="name" class="form-label required">{{ __('physicalCourses.course_name') }}</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $course->name ?? '') }}" required
                            placeholder="{{ __('physicalCourses.enter_course_name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback"></div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="max_seats" class="form-label required">{{ __('physicalCourses.max_seats') }}</label>
                        <input type="number" name="max_seats" id="max_seats"
                            class="form-control @error('max_seats') is-invalid @enderror"
                            value="{{ old('max_seats', $course->max_seats ?? 10) }}" min="1" max="1000"
                            required placeholder="{{ __('physicalCourses.ten') }}">
                        @error('max_seats')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback"></div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="passing_grade"
                            class="form-label required">{{ __('physicalCourses.passing_grade') }}</label>
                        <input type="number" name="passing_grade" id="passing_grade"
                            class="form-control @error('passing_grade') is-invalid @enderror"
                            value="{{ old('passing_grade', $course->passing_grade ?? 10) }}" min="1"
                            max="1000" required placeholder="{{ __('physicalCourses.ten') }}">
                        @error('passing_grade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback"></div>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="mb-3">
                <label for="description" class="form-label">{{ __('physicalCourses.course_description') }}</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                    rows="4" placeholder="{{ __('physicalCourses.enter_detailed_description') }}">{{ old('description', $course->description ?? '') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <div class="invalid-feedback"></div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="grade" class="form-label required">{{ __('physicalCourses.max_grade') }}</label>
                        <input type="number" name="grade" id="grade"
                            class="form-control @error('grade') is-invalid @enderror"
                            value="{{ old('grade', $course->grade ?? 100) }}" min="0" max="1000" required
                            placeholder="{{ __('physicalCourses.hundred') }}">
                        @error('grade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback"></div>
                        @enderror
                        <div class="form-text">{{ __('physicalCourses.maximum_possible_grade') }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="certificate_template_id" class="form-label required">
                            {{ __('physicalCourses.certificate_template_id') }}
                        </label>
                        <select name="certificate_template_id" id="certificate_template_id"
                            class="form-select @error('certificate_template_id') is-invalid @enderror" required>
                            <option value="" >Select Certificate</option>
                            @foreach ($certificate_templates as $certificate_template)
                                <option value="{{ $certificate_template->id }}"
                                    {{ old('certificate_template_id', optional($course)->certificate_template_id) == $certificate_template->id ? 'selected' : '' }}>
                                    {{ $certificate_template->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('certificate_template_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback"></div>
                        @enderror

                        <div class="form-text">{{ __('physicalCourses.select_one_certificate') }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="survey_id" class="form-label">{{ __('physicalCourses.survey') }}</label>
                        <select name="survey_id" id="survey_id"
                            class="form-select @error('survey_id') is-invalid @enderror">
                            <option value="" >{{ __('physicalCourses.select_survey') }}</option>
                            @foreach ($surveys as $survey)
                                <option value="{{ $survey->id }}"
                                    {{ old('survey_id', optional($course)->survey_id) == $survey->id ? 'selected' : '' }}>
                                    {{ $survey->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('survey_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback"></div>
                        @enderror
                        <div class="form-text">{{ __('physicalCourses.select_course_survey') }}</div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="instructors"
                            class="form-label required">{{ __('physicalCourses.instructors') }}</label>
                        <select name="instructors[]" id="instructors"
                            class="form-select @error('instructors') is-invalid @enderror" multiple required>
                            @foreach ($instructors as $instructor)
                                <option value="{{ $instructor->id }}"
                                    {{ (old('instructors')
                                            ? in_array($instructor->id, old('instructors', []))
                                            : isset($course) && $course->instructors->pluck('id')->contains($instructor->id))
                                        ? 'selected'
                                        : '' }}>
                                    {{ $instructor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('instructors')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback"></div>
                        @enderror
                        <div class="form-text">{{ __('physicalCourses.select_one_or_more_instructors') }}</div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="materials" class="form-label">{{ __('physicalCourses.course_materials') }}</label>
                        <input type="file" name="materials[]" id="materials"
                            class="form-control @error('materials') is-invalid @enderror @error('materials.*') is-invalid @enderror"
                            multiple accept=".pdf,.doc,.docx,.pptx,.zip,.jpg,.jpeg,.png">
                        @error('materials')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('materials.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if (!$errors->has('materials') && !$errors->has('materials.*'))
                            <div class="invalid-feedback"></div>
                        @endif
                        <div class="form-text">{{ __('physicalCourses.upload_course_materials_help') }}</div>

                        @if ($isEdit && $course->materials && $course->materials->count() > 0)
                            <div class="mt-2">
                                <label class="small text-muted">{{ __('physicalCourses.current_materials') }}</label>
                                <ul class="list-unstyled mt-1">
                                    @foreach ($course->materials as $material)
                                        <li class="mb-1">
                                            <i class="fas fa-file-alt text-primary"></i>
                                            <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                                                class="text-decoration-none">
                                                {{ $material->file_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="cover_picture" class="form-label">{{ __('physicalCourses.cover_image') }}</label>
                        <input type="file" name="cover_picture" id="cover_picture"
                            class="form-control @error('cover_picture') is-invalid @enderror" accept="image/*">
                        @error('cover_picture')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback"></div>
                        @enderror
                        <div class="form-text">{{ __('physicalCourses.upload_cover_image_help') }}</div>

                        @if ($isEdit && $course->cover_picture)
                            <div class="mt-2">
                                <div class="current-image">
                                    <label
                                        class="small text-muted">{{ __('physicalCourses.current_image') }}</label><br>
                                    <img src="{{ asset('storage/' . $course->cover_picture) }}" class="img-thumbnail"
                                        style="max-width: 150px; max-height: 150px;" alt="Current cover">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <label class="form-label required mb-0">{{ __('physicalCourses.course_schedule') }}</label>
                    <button type="button" id="add-schedule" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-plus"></i> {{ __('physicalCourses.add_session') }}
                    </button>
                </div>

                <div class="card ">
                    <div class="card-body">
                        <div id="schedule-wrapper">
                            @if (old('schedule'))
                                @foreach (old('schedule') as $i => $sched)
                                    <div class="row mb-3 schedule-row" data-index="{{ $i }}">
                                        <div class="col-md-5">
                                            <label class="form-label small">{{ __('physicalCourses.date') }}</label>
                                            <input type="date" name="schedule[{{ $i }}][date]"
                                                class="form-control @error("schedule.{$i}.date") is-invalid @enderror"
                                                value="{{ $sched['date'] }}" required>
                                            @error("schedule.{$i}.date")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @else
                                                <div class="invalid-feedback"></div>
                                            @enderror
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label small">{{ __('physicalCourses.time') }}</label>
                                            <input type="time" name="schedule[{{ $i }}][time]"
                                                class="form-control @error("schedule.{$i}.time") is-invalid @enderror"
                                                value="{{ $sched['time'] }}" required>
                                            @error("schedule.{$i}.time")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @else
                                                <div class="invalid-feedback"></div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-schedule">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @elseif($isEdit && $course->schedules && $course->schedules->count() > 0)
                                @foreach ($course->schedules as $i => $sched)
                                    <div class="row mb-3 schedule-row" data-index="{{ $i }}">
                                        <div class="col-md-5">
                                            <label class="form-label small">{{ __('physicalCourses.date') }}</label>
                                            <input type="date" name="schedule[{{ $i }}][date]"
                                                class="form-control" value="{{ $sched->session_date }}" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label small">{{ __('physicalCourses.time') }}</label>
                                            <input type="time" name="schedule[{{ $i }}][time]"
                                                class="form-control" value="{{ $sched->session_time }}" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-schedule">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row mb-3 schedule-row" data-index="0">
                                    <div class="col-md-5">
                                        <label class="form-label small">{{ __('physicalCourses.date') }}</label>
                                        <input type="date" name="schedule[0][date]" class="form-control" required
                                            min="{{ date('Y-m-d') }}">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label small">{{ __('physicalCourses.time') }}</label>
                                        <input type="time" name="schedule[0][time]" class="form-control" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-schedule">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="form-text mt-2">
                            <i class="fas fa-info-circle text-info"></i>
                            {{ __('physicalCourses.add_multiple_sessions') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('admin.physical-courses.courses.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> {{ __('physicalCourses.cancel') }}
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i>
                    {{ $isEdit ? __('physicalCourses.update_course') : __('physicalCourses.create_course') }}
                </button>
            </div>
        </form>
    </div>
</div>
