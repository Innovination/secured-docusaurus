@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.project.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="project_name">{{ trans('cruds.project.fields.project_name') }}</label>
                    <input class="form-control {{ $errors->has('project_name') ? 'is-invalid' : '' }}" type="text"
                        name="project_name" id="project_name" value="{{ old('project_name', '') }}" required>
                    @if ($errors->has('project_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('project_name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.project_name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="slug">{{ trans('cruds.project.fields.slug') }}</label>
                    <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug"
                        id="slug" value="{{ old('slug', '') }}" readonly required>
                    @if ($errors->has('slug'))
                        <div class="invalid-feedback">
                            {{ $errors->first('slug') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.slug_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="status">{{ trans('cruds.project.fields.status') }}</label>
                    <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                        <option value="" disabled {{ old('status') === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        <option value="Pending" {{ old('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="In Progress" {{ old('status') === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Completed" {{ old('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @if ($errors->has('status'))
                        <div class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.status_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="remarks">{{ trans('cruds.project.fields.remarks') }}</label>
                    <textarea class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" name="remarks" id="remarks">{{ old('remarks') }}</textarea>
                    @if ($errors->has('remarks'))
                        <div class="invalid-feedback">
                            {{ $errors->first('remarks') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.remarks_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="allowed_users">{{ trans('cruds.project.fields.allowed_users') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all"
                            style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all"
                            style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('allowed_users') ? 'is-invalid' : '' }}"
                        name="allowed_users[]" id="allowed_users" multiple>
                        @foreach ($allowed_users as $id => $allowed_user)
                            <option value="{{ $id }}"
                                {{ in_array($id, old('allowed_users', [])) ? 'selected' : '' }}>{{ $allowed_user }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('allowed_users'))
                        <div class="invalid-feedback">
                            {{ $errors->first('allowed_users') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.allowed_users_helper') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
@parent
<script>
    document.getElementById('project_name').addEventListener('input', function() {
        const name = this.value;
        const slug = name.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9\-]/g, '');
        document.getElementById('slug').value = slug;
    });
</script>
@endsection
