@extends('layouts.app')
@section('content')
<div class="mx-5">
    <div class="card" style="padding-bottom: 10px;">
        <div class="card-header p-0">
            <div class="col-md-6 heading" style="float: left"><h2> Employees</h2></div>
            <div class="col-md-6 heading-link heading-link-all" style="float: right;text-align: right;">
                <a class="btn btn-success" href="{{ url('employees/create') }}" > Create</a>
                <a class="btn btn-success" href="{{ url('employees-export') }}" > Export CSV</a>
            </div>
        </div>
        <div class="card-body">
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <table class="table table-bordered" id="employees">
                <thead>
                    <tr>
                        <!--<th>#</th>-->
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Designation</th>
                        <th>Salary</th>
                        <th>Created at</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employees as $emp)
                    <tr>
                        <td>{{ $emp->name }}</td>
                        <td>{{ $emp->email }}</td>
                        <td>{{ $emp->mobile }}</td>
                        <td>{{ $emp->designation }}</td>
                        <td>{{ $emp->salary }}</td>
                        <td>{{ date('d-m-Y', strtotime($emp->created_at)) }}</td>
                        <td>
                            <a href="{{ route('employees.edit', $emp->id) }}" class="btn btn-primary user-edit">Edit</a>
                            <button type="submit" data-id="{{$emp->id}}" class="btn btn-danger deleteEmploye" >Delete </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" style="text-align: center;font-weight: bold">
                            Data Not Found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {!! $employees->links() !!}
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('body').on('click', '.deleteEmploye', function () {
            var emplyee_id = $(this).data("id");
            if (confirm("Are You sure want to delete !")) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('employees.store') }}" + '/' + emplyee_id,
                    success: function (data) {
                        window.alert(data.message);
                        setTimeout(function () {
                            window.location = window.location.origin + '/employees';
                        }, 500);
                    },
                    error: function (data) {
                        window.alert(data.responseJSON.message);
                    }
                });
            }
        });
    });
</script>
@endsection
