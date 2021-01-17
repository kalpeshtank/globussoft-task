@extends('layouts.app')
@section('content')
<div class="mx-5">
    <div class="card" style="padding-bottom: 10px;">
        <div class="card-header">
            <div class="col-md-6" style="float: left"><h3>{{$title}}</h3></div>
            <div class="col-md-6 heading-link-all" style="float: right;text-align: right;">
                <a class="btn btn-success" href="{{ url('employees') }}" > View Employees</a>
            </div>
        </div>
        <form method="POST" id="employeeForm" name="employeeForm">
            <div class="card-body">
                @csrf
                <input id="id" type="hidden" class="form-control" name="id" value="{{ isset($employees->id)? $employees->id : old('id') }}">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Name<span style="color: red">*</span></label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($employees->name)? $employees->name : old('name') }}"  autocomplete="name" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email<span style="color: red">*</span></label>
                        <input id="product_name" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ isset($employees->email)? $employees->email : old('email') }}"  autocomplete="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="mobile">Mobile<span style="color: red">*</span></label>
                        <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ isset($employees->mobile)? $employees->mobile : old('mobile') }}"  autocomplete="mobile">
                        @error('mobile')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="designation">Designation<span style="color: red">*</span></label>
                        <input id="designation" type="text" class="form-control @error('designation') is-invalid @enderror" name="designation" value="{{ isset($employees->designation)? $employees->designation : old('designation') }}" >
                        @error('designation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="salary">Salary<span style="color: red">*</span></label>
                        <input id="salary" type="number" class="form-control @error('salary') is-invalid @enderror" name="salary" value="{{ isset($employees->salary)? $employees->salary : old('salary') }}"  autocomplete="salary">
                        @error('salary')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer user-edit-footer">
                <div class="col-md-12">
                    <button type="button" id="saveBtn" class="btn btn-primary float-right">{{$button}}</button>
                </div> 
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            btntext = $(this).html();
            $(this).html('Sending..');
            $.ajax({
                data: $('#employeeForm').serialize(),
                url: "{{ route('employees.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#employeeForm').trigger("reset");
                    window.alert(data.message);
                    setTimeout(function () {
                        window.location = window.location.origin + '/employees';
                    }, 500);
                },
                error: function (data) {
                    window.alert(data.responseJSON.message);
                    $('#saveBtn').html(btntext);
                }
            });
        });
    });
</script>
@endsection

