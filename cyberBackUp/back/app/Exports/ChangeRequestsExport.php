<?php

namespace App\Exports;

use App\Models\ChangeRequest;
use App\Models\Department;
use App\Traits\LaravelExportPropertiesTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class ChangeRequestsExport implements FromCollection, WithMapping, WithHeadings, WithProperties
{

    use LaravelExportPropertiesTrait; // This trait implement properties function required by (WithProperties)
    private $counter = 1;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $currentUserId = auth()->id();
        $managerIds = Department::pluck('manager_id')->toArray();
        $currentUserIsDepartmentManager = array_search($currentUserId, $managerIds) === false ? false : true;
        // $currentUserIsInResponsibleDepartment = auth()->user()->department_id == change_requests_responsible_department_id();
        $currentUserIsInResponsibleDepartment = auth()->id() == change_requests_responsible_department_manager_id();
        // current user is change requests responsible department manager
        if ($currentUserIsInResponsibleDepartment) {
            $_changeRequests = ChangeRequest::with('created_by_user:id,username')->where('review_cycle', 'Responsible-Department-Review')->get();
        }
        // current user is department manager
        else if ($currentUserIsDepartmentManager) {
            $departments = Department::where('manager_id', $currentUserId)->get();
            $departmentEmployees = [];
            foreach ($departments as $department) {
                $departmentEmployees = array_merge($departmentEmployees, $department->employees()->where('id', '<>', $currentUserId)->pluck('id')->toArray());
            }
            $_changeRequests = ChangeRequest::with('created_by_user:id,username,department_id')->whereIn('created_by', $departmentEmployees)->where('review_cycle', 'Department-Manager-Review')->orWhere('created_by', $currentUserId)->get();
        }
        // current user is belongs to department and normal employee
        else {
            $_changeRequests = ChangeRequest::with('created_by_user:id,username,department_id')->where('created_by', $currentUserId)->get();
        }

        return $_changeRequests->map(function ($changeRequest) use ($currentUserId, $currentUserIsInResponsibleDepartment) {
            $editableStatus = null;
            $decision = false;

            // Get if current review cycle in reviewing
            if ($changeRequest->start_review_cycle == 'Department-Manager-Review') {
                $editableStatus = 'Department-Manager-In-Review';
            } else if ($changeRequest->start_review_cycle == 'Responsible-Department-Review') {
                $editableStatus = 'Responsible-Department-In-Review';
            }


            // Get if current user have ability to make decision or not
            if ($currentUserIsInResponsibleDepartment && $changeRequest->review_cycle == 'Responsible-Department-Review' && !in_array($changeRequest->status, ['Responsible-Department-Accepted', 'Responsible-Department-Rejected'])) { // current user is change requests responsible department manager
                $decision = true;
            } else {
                $changeRequestCreatorDepartmantManagerId = $changeRequest->created_by_user->department->manager_id ?? null;

                if ($currentUserId == $changeRequestCreatorDepartmantManagerId && $changeRequest->review_cycle == 'Department-Manager-Review' && $changeRequest->status != 'Department-Manager-Rejected') { // current user is change request department manager
                    $decision = true;
                }
            }

            $creatorUserName = $changeRequest->created_by_user->username ?? null;
            return (object)[
                'title' => $changeRequest->title,
                'description' => $changeRequest->description,
                'file' => $changeRequest->display_file_name,
                'status_text' => __('locale.' . $changeRequest->status),
                'review_cycle_text' => __('locale.' . $changeRequest->review_cycle),
                'created_at' => $changeRequest->created_at->format('Y-m-d H:i'),
                'reason' => $changeRequest->rejection_reason,
                'creator' => ($creatorUserName) == auth()->user()->username ? __('locale.Me') : $creatorUserName,
            ];
        });
    }

    /**
     * @var ChangeRequest $changeRequest
     */
    public function map($changeRequest): array
    {
        return [
            $this->counter++,
            $changeRequest->title,
            $changeRequest->description,
            $changeRequest->creator,
            $changeRequest->file,
            $changeRequest->status_text,
            $changeRequest->reason,
            $changeRequest->review_cycle_text,
            $changeRequest->created_at,
        ];
    }


    public function headings(): array
    {
        return [
            __('locale.#'),
            __('locale.Title'),
            __('locale.Description'),
            __('locale.CreatedBy'),
            __('locale.File'),
            __('locale.Status'),
            __('locale.Reason'),
            __('locale.ReviewCycle'),
            __('locale.CreatedDate')
        ];
    }
}
