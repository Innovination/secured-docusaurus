<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProjectRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class ProjectController extends Controller
{

    public function loadProject($slug)
    {
        // Define the path to the index.html based on the project name
    
        $project = Project::where('slug', $slug)->first();
    
        if (!$project) {
            return redirect()->route('admin.projects.index');
        }
    
        // Check if the logged-in user is allowed in this project
        $user = auth()->user();
        if (!$project->allowed_users->contains($user)) {
            return redirect()->route('admin.projects.index');
        }
    
        $filePath = url('/') . '/token/' . $project->token . '/index.html';
        return view('admin.projects.detail', compact('filePath'));
    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('project_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Project::with(['allowed_users'])->whereHas('allowed_users', function ($q) {
                $q->where('id', auth()->user()->id);
            })->select(sprintf('%s.*', (new Project)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'project_show';
                $editGate      = 'project_edit';
                $deleteGate    = 'project_delete';
                $crudRoutePart = 'projects';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('project_name', function ($row) {
                return $row->project_name ? $row->project_name : '';
            });
            $table->editColumn('slug', function ($row) {
                return $row->slug ? $row->slug : '';
            });
            $table->editColumn('token', function ($row) {
                return $row->token ? $row->token : '';
            });
            $table->editColumn('allowed_users', function ($row) {
                $labels = [];
                foreach ($row->allowed_users as $allowed_user) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $allowed_user->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'allowed_users']);

            return $table->make(true);
        }

        $users = User::get();

        return view('admin.projects.index', compact('users'));
    }

    public function admin_view(Request $request)
    {
        abort_if(Gate::denies('project_admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Project::with(['allowed_users'])->select(sprintf('%s.*', (new Project)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'project_show';
                $editGate      = 'project_edit';
                $deleteGate    = 'project_delete';
                $crudRoutePart = 'projects';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('project_name', function ($row) {
                return $row->project_name ? $row->project_name : '';
            });
            $table->editColumn('slug', function ($row) {
                return $row->slug ? $row->slug : '';
            });
            $table->editColumn('token', function ($row) {
                return $row->token ? $row->token : '';
            });
            $table->editColumn('allowed_users', function ($row) {
                $labels = [];
                foreach ($row->allowed_users as $allowed_user) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $allowed_user->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'allowed_users']);

            return $table->make(true);
        }

        $users = User::get();

        return view('admin.projects.admin_index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('project_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allowed_users = User::pluck('name', 'id');

        return view('admin.projects.create', compact('allowed_users'));
    }

    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->all());
        $project->allowed_users()->sync($request->input('allowed_users', []));

        return redirect()->route('admin.projects.index');
    }

    public function edit(Project $project)
    {
        abort_if(Gate::denies('project_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allowed_users = User::pluck('name', 'id');

        $project->load('allowed_users');

        return view('admin.projects.edit', compact('allowed_users', 'project'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->all());
        $project->allowed_users()->sync($request->input('allowed_users', []));

        return redirect()->route('admin.projects.index');
    }

    public function show(Project $project)
    {
        abort_if(Gate::denies('project_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project->load('allowed_users');

        return view('admin.projects.show', compact('project'));
    }

    public function destroy(Project $project)
    {
        abort_if(Gate::denies('project_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project->delete();

        return back();
    }

    public function massDestroy(MassDestroyProjectRequest $request)
    {
        $projects = Project::find(request('ids'));

        foreach ($projects as $project) {
            $project->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
