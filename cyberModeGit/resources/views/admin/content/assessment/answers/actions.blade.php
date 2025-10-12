<td style="text-align: center;">
    <div class="dropdown">
        <a class="pe-1 dropdown-toggle hide-arrow text-primary" href="#" role="button" id="actionsDropdown{{ $id }}" data-bs-toggle="dropdown" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4">
                <circle cx="12" cy="12" r="1"></circle>
                <circle cx="12" cy="5" r="1"></circle>
                <circle cx="12" cy="19" r="1"></circle>
            </svg>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionsDropdown{{ $id }}">
            <!-- Edit Action -->
            <li>
                <a href="javascript:void(0)" 
                   class="dropdown-item edit_answer_btn" 
                   data-id="{{ $id }}" 
                   data-url="{{ route('admin.answers.edit', ['question' => $question_id, 'answer' => $id]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit font-small-4">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    {{ __('locale.Edit') }}
                </a>
            </li>

            <!-- Delete Action -->
            <li>
                <a href="javascript:void(0)" 
                   class="dropdown-item delete_answer_btn" 
                   data-url="{{ route('admin.answers.destroy', ['question' => $question_id, 'answer' => $id]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 me-50 font-small-4">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                    {{ __('locale.Delete') }}
                </a>
            </li>
        </ul>
    </div>
</td>
