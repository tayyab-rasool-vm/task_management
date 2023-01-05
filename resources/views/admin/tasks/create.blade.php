@extends('admin.layouts.master')
@section('title', 'Create Task')
@section('content')
    <section class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Create Task</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Create Task
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header row"></div>
        <div class="content-body">
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <form class="form" id="add_form" method="POST" action="{{ route('tasks.store') }}">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 col-12 mb-1">
                                            <label class="form-label" for="name">Name</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                placeholder="Task Name"/>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <label class="form-label" for="occurrence_id">Occurence</label>
                                            <select name="occurrence_id" id="occurrence_id" class="select2 form-select"
                                                data-placeholder="Select Occurence">
                                                <option value=""></option>
                                                @foreach ($occurrences as $occurrence)
                                                    <option value="{{ $occurrence->id }}">{{ $occurrence->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <label class="form-label" for="start_date">Start Date</label>
                                            <input type="text" name="start_date" id="start_date" class="form-control flatpickr-basic"
                                                placeholder="YYYY-MM-DD" />
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <label class="form-label" for="end_date">End Date</label>
                                            <input type="text" name="end_date" id="end_date" class="form-control flatpickr-basic"
                                                placeholder="YYYY-MM-DD" />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-outline-success">Reset</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection
@section('scripts')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                toastr.error("{{ $error }}")
            </script>
        @endforeach
    @endif
@endsection
