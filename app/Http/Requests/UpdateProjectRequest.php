<?php

namespace App\Http\Requests;

use App\Models\Project;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateProjectRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('project_edit');
    }

    public function rules()
    {
        return [
            'project_name' => [
                'string',
                'required',
                'unique:projects,project_name,' . request()->route('project')->id,
            ],
            'slug' => [
                'string',
                'required',
                'unique:projects,slug,' . request()->route('project')->id,
            ],
            'allowed_users.*' => [
                'integer',
            ],
            'allowed_users' => [
                'array',
            ],
        ];
    }
}
