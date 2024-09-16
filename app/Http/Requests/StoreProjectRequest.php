<?php

namespace App\Http\Requests;

use App\Models\Project;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreProjectRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('project_create');
    }

    public function rules()
    {
        return [
            'project_name' => [
                'string',
                'required',
                'unique:projects',
            ],
            'slug' => [
                'string',
                'required',
                'unique:projects',
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
