@extends('admin.layouts.master')
@section('title', 'Tasks')

@section('content')
    <section class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Tasks</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Tasks
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
                            <div class="card-header border-bottom p-1">
                                <div class="head-label">
                                    <h6 class="mb-0">Filter Form</h6>
                                </div>
                            </div>
                            <div class="card-body p-1">
                                <form class="form" method="GET" action="{{ url('tasks') }}">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="type">Type</label>
                                                <select name="type" id="type" class="select2 form-select"
                                                    data-placeholder="Select Type" required>
                                                    <option value="">Select Type</option>
                                                    <option value="today"
                                                        {{ request('type') == 'today' ? 'selected' : '' }}>Tasks Today
                                                    </option>
                                                    <option value="tomorrow"
                                                        {{ request('type') == 'tomorrow' ? 'selected' : '' }}>Tasks Tomorrow
                                                    </option>
                                                    <option value="next_week"
                                                        {{ request('type') == 'next_week' ? 'selected' : '' }}>Tasks Next
                                                        Week</option>
                                                    <option value="next_week2"
                                                        {{ request('type') == 'next_week2' ? 'selected' : '' }}>Tasks Next
                                                        Next Week</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <a href="{{ route('tasks.index') }}" class="btn btn-danger">Reset</a>
                                        <button class="btn btn-success">Filter</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="border-bottom p-1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="head-label">
                                            <h6 class="mb-0">List Of Tasks</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <div class="head-label">
                                          <a class="btn btn-sm btn-primary" href="{{route('tasks.create')}}">Add New</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-1">
                                <table class="table" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Name</th>
                                            <th>Occurrence</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tasks as $key => $task)
                                            <tr>
                                                <td>{{ $key = $key + 1 }}</td>
                                                <td>{{ $task->name }}</td>
                                                <td>{{ optional($task->occurrence)->name }}</td>
                                                <td>{{ $task->start_date }}</td>
                                                <td>{{ $task->end_date }}</td>
                                                <td>
                                                    @if ($task->taskIterations->count() > 0)
                                                        <a type="button"  data-toggle="tooltip"
                                                        title="Detail" data-bs-toggle="collapse"
                                                            data-bs-target="#accordionIcon-1_{{ $key }}"
                                                            aria-controls="accordionIcon-1_{{ $key }}">
                                                            <i class="fa fa-info-circle" aria-controls="true"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr style="border-style:none">
                                                <td colspan='6' style="padding: 0;">
                                                    <div id="accordionIcon" class="accordion accordion-without-arrow">
                                                        <div class="accordion-item">
                                                            <div id="accordionIcon-1_{{ $key }}"
                                                                class="accordion-collapse collapse"
                                                                data-bs-parent="#accordionIcon">
                                                                <div class="accordion-body">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Sr.No</th>
                                                                                <th>Trigger Date</th>
                                                                                <th>Status</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($task->taskIterations as $key => $taskIteration)
                                                                                <tr>
                                                                                    <td>{{ $key = $key + 1 }}</td>
                                                                                    <td>{{ $taskIteration->trigger_date }}
                                                                                    </td>
                                                                                    <td>
                                                                                        @if ($taskIteration->status == 0)
                                                                                            <span style="cursor: pointer"
                                                                                                data-toggle="tooltip"
                                                                                                title="Marked As Completed"
                                                                                                onclick="changeStatus({{ $taskIteration->id }})"
                                                                                                class="badge bg-danger">
                                                                                                Pending
                                                                                            </span>
                                                                                        @else
                                                                                            <span class="badge bg-success">
                                                                                                Completed
                                                                                            </span>
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="p-1">
                                    {{ $tasks->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection
@section('scripts')
    @if (Session::has('message'))
        <script>
            toastr.success("{!! Session::get('message') !!}");
        </script>
    @endif
    <script>
        function changeStatus(id) {
            Swal.fire({
                title: 'Are You Sure? This Iteration will be Marked As Completed.',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: 'No',
                customClass: {
                    actions: 'my-actions',
                    cancelButton: 'order-1 right-gap',
                    confirmButton: 'order-2',
                    denyButton: 'order-3',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'post',
                        url: "{{ url('task/iteration/change/status') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'iteration_id': id,
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Status Changed Successfully!'
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 300);
                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Something Went Wrong!'
                                });
                            }
                        }
                    });
                }
            })
        }
    </script>
@endsection
