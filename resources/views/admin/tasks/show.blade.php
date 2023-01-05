@extends('admin.layouts.master')
@section('title', 'Task Detail')

@section('content')
    <section class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Task Detail</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Task Detail
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
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6  mb-1"">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" value="{{ $task->name }}" readonly />
                                    </div>
                                    <div class="col-md-6  mb-1"">
                                        <label class="form-label">Occurrence</label>
                                        <input type="text" class="form-control" value="{{ $task->occurrence->name }}"
                                            readonly />
                                    </div>
                                    <div class="col-md-6  mb-1"">
                                        <label class="form-label">Start Date</label>
                                        <input type="text" class="form-control" value="{{ $task->start_date }}"
                                            readonly />
                                    </div>
                                    <div class="col-md-6  mb-1"">
                                        <label class="form-label">End Date</label>
                                        <input type="text" class="form-control" value="{{ $task->end_date }}" readonly />
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <table class="table" id="dataTable">
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
                                            <td>{{ $taskIteration->trigger_date }}</td>
                                            <td>
                                                @if($taskIteration->status == 0)
                                                    <span style="cursor: pointer" data-toggle="tooltip" title="Marked As Completed"  onclick="changeStatus({{$taskIteration->id}})"
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
            </section>
        </div>
    </section>
@endsection
@section('scripts')
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
