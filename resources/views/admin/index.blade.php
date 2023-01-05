@extends('admin.layouts.master')

@section('title', 'Dashboard')
@section('content')
<section class="content-wrapper container-xxl p-0">
    {{-- <div class="content-header row"></div> --}}
    <div class="content-body">
        <h1>Dashboard</h1>
    </div>
</section>
@endsection
@section('scripts')
    <script>
        setTimeout(function () {
            toastr['success'](
            'You have successfully logged in.',
            '👋 Welcome {{Auth::user()->name}}!',
            {
                closeButton: true,
                tapToDismiss: false
            }
            );
        }, 2000);
    </script>
@endsection