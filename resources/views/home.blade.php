@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Dashboard
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!

                        @can('developer_access')
                            <div class="row mt-4">
                                <div class="col-lg-4">
                                    <a href="{{ route('admin.run.migrate') }}" class="btn btn-primary btn-block">
                                        <i class="fas fa-database"></i> Run Migrate
                                    </a>
                                </div>
                                <div class="col-lg-4">
                                    <a href="{{ route('admin.cache.clear') }}" class="btn btn-warning btn-block">
                                        <i class="fas fa-broom"></i> Clear Cache
                                    </a>
                                </div>
                                <div class="col-lg-4">
                                    <a href="{{ route('admin.composer.install') }}" class="btn btn-info btn-block">
                                        <i class="fas fa-box-open"></i> Composer Install
                                    </a>
                                </div>
                            </div>
                        @endcan





                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection
