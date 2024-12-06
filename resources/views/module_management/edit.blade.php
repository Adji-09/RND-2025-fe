@extends('layouts.master')

@section('title') {{ $li }} {{ $title }} @endsection

@section('content')

    @include('components.breadcrumb')

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-dark btn-label waves-effect waves-light" href="{{ route('module.index') }}"><i class="ri-arrow-left-s-line label-icon align-middle fs-16 me-2"></i> Back</a>
                    <button type="button" class="btn btn-sm btn-warning modalAlertSuccess" data-bs-toggle="modal" data-bs-title="Success" hidden></button>
                    <button type="button" class="btn btn-sm btn-warning modalAlertError" data-bs-toggle="modal" data-bs-title="Error" hidden></button>
                </div>
                <div class="card-body">
                    <form id="form" action="{{ route('module.update') }}" method="POST" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        @foreach($datas as $data)
                            <input type="hidden" id="module_id" name="module_id" value="{{ $data->module_id }}" />
                            <div class="col-md-12">
                                <label for="module_name" class="form-label">Module <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="module_name" name="module_name"
                                    value="{{ $data->module_name }}" placeholder="Module" autocomplete="false" disabled />
                            </div>
                            <div class="col-md-12">
                                <label class="d-block">Permission</label>
                                <div class="form-check form-check-inline mt-3">
                                    <input class="form-check-input" type="checkbox" id="is_superadmin_copy" name="is_superadmin_copy" value="{{ $data->is_superadmin }}" {{ $data->is_superadmin == 1 ? 'checked' : '' }} disabled />
                                    <input class="form-check-input" type="checkbox" id="is_superadmin" name="is_superadmin" value="{{ $data->is_superadmin }}" {{ $data->is_superadmin == 1 ? 'checked' : '' }} hidden />
                                    <label class="form-check-label" for="is_superadmin">Administrator</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="module_status" class="form-label">Status <span style="color: red;">*</span></label>
                                <select class="form-select" id="module_status" name="module_status" required>
                                    <option value="" disabled>---</option>
                                    <option value="1" {{ $data->module_status == 1 ? "selected" : "" }}>Active</option>
                                    <option value="2" {{ $data->module_status == 2 ? "selected" : "" }}>Inactive</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please choose Status.
                                </div>
                            </div>
                        @endforeach
                        <div class="col-md-12">
                            <div class="text-end">
                                <button type="submit" class="btn btn-success btn-label waves-effect waves-light" id="btn_simpan"><i class="ri-save-2-fill label-icon align-middle fs-16 me-2"></i> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('components.alert_success')
    @include('components.alert_error')

@endsection

@section('script')
    <script>
        var success = <?php echo json_encode(\Session::get('success')) ?>;

        var error = <?php echo json_encode(\Session::get('error')) ?>;

        if (success) {
            $(document).ready(function() {
                $("#modalAlertSuccess").modal("show");
            });
        }

        if (error) {
            $(document).ready(function() {
                $("#modalAlertError").modal("show");
            });
        }
    </script>
@endsection
