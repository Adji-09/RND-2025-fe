@extends('layouts.master')

@section('title') {{ $title }} @endsection

@section('content')

    @include('components.breadcrumb')

    <button type="button" class="btn btn-sm btn-warning modalAlertSuccess" data-bs-toggle="modal" data-bs-title="Success" hidden></button>
    <button type="button" class="btn btn-sm btn-warning modalAlertError" data-bs-toggle="modal" data-bs-title="Error" hidden></button>

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-height-100">
                <div class="card-body">
                    <div class="offcanvas-body p-0">
                        <div data-simplebar class="h-100">
                            <div class="p-2">
                                <div class="col-lg-12">
                                    <form id="form" action="{{ route('theme.update') }}" method="POST" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate>
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <div class="col-md-6">
                                            <label for="title_apps" class="form-label">Title Application <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" id="title_apps" name="title_apps" value="{{ $datas->title_apps }}" autocomplete="off" placeholder="Title Application" required {{ Session::get('role_id') == 1 ? "" : "disabled" }}>
                                            <div class="invalid-feedback">
                                                Please enter Title Application.
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="title_header" class="form-label">Title Header <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" id="title_header" name="title_header" value="{{ $datas->title_header }}" autocomplete="off" placeholder="Title Header" required {{ Session::get('role_id') == 1 ? "" : "disabled" }}>
                                            <div class="invalid-feedback">
                                                Please enter Title Header.
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="subtitle_header" class="form-label">Subtitle Header <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" id="subtitle_header" name="subtitle_header" value="{{ $datas->subtitle_header }}" autocomplete="off" placeholder="Subtitle Header" required {{ Session::get('role_id') == 1 ? "" : "disabled" }}>
                                            <div class="invalid-feedback">
                                                Please enter Subtitle Header.
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="title_footer" class="form-label">Title Footer <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" id="title_footer" name="title_footer" value="{{ $datas->title_footer }}" autocomplete="off" placeholder="Title Footer" required {{ Session::get('role_id') == 1 ? "" : "disabled" }}>
                                            <div class="invalid-feedback">
                                                Please enter Title Footer.
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-5">
                                            <h6 class="mb-0 fw-semibold text-uppercase">Color Scheme</h6>
                                            <p class="text-muted">Choose Light or Dark Scheme.</p>

                                            <div class="colorscheme-cardradio">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-check card-radio">
                                                            <input class="form-check-input" type="radio" name="data_layout_mode" id="layout-mode-light" value="light" {{ $datas->data_layout_mode == "light" ? 'checked' : '' }}>
                                                            <label class="form-check-label p-0 avatar-md w-100" for="layout-mode-light">
                                                                <span class="d-flex gap-1 h-100">
                                                                    <span class="flex-shrink-0">
                                                                        <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                                            <span class="d-block p-1 px-2 bg-soft-primary rounded mb-2"></span>
                                                                            <span class="d-block p-1 px-2 pb-0 bg-soft-primary"></span>
                                                                            <span class="d-block p-1 px-2 pb-0 bg-soft-primary"></span>
                                                                            <span class="d-block p-1 px-2 pb-0 bg-soft-primary"></span>
                                                                        </span>
                                                                    </span>
                                                                    <span class="flex-grow-1">
                                                                        <span class="d-flex h-100 flex-column">
                                                                            <span class="bg-light d-block p-1"></span>
                                                                            <span class="bg-light d-block p-1 mt-auto"></span>
                                                                        </span>
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                        <h5 class="fs-13 text-center mt-2">Light</h5>
                                                    </div>

                                                    <div class="col-4">
                                                        <div class="form-check card-radio dark">
                                                            <input class="form-check-input" type="radio" name="data_layout_mode" id="layout-mode-dark" value="dark" {{ $datas->data_layout_mode == "dark" ? 'checked' : '' }}>
                                                            <label class="form-check-label p-0 avatar-md w-100 bg-dark" for="layout-mode-dark">
                                                                <span class="d-flex gap-1 h-100">
                                                                    <span class="flex-shrink-0">
                                                                        <span class="bg-soft-light d-flex h-100 flex-column gap-1 p-1">
                                                                            <span class="d-block p-1 px-2 bg-soft-light rounded mb-2"></span>
                                                                            <span class="d-block p-1 px-2 pb-0 bg-soft-light"></span>
                                                                            <span class="d-block p-1 px-2 pb-0 bg-soft-light"></span>
                                                                            <span class="d-block p-1 px-2 pb-0 bg-soft-light"></span>
                                                                        </span>
                                                                    </span>
                                                                    <span class="flex-grow-1">
                                                                        <span class="d-flex h-100 flex-column">
                                                                            <span class="bg-soft-light d-block p-1"></span>
                                                                            <span class="bg-soft-light d-block p-1 mt-auto"></span>
                                                                        </span>
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                        <h5 class="fs-13 text-center mt-2">Dark</h5>
                                                    </div>
                                                </div>
                                            </div>

                                            <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Topbar Color</h6>
                                            <p class="text-muted">Choose Light or Dark Topbar Color.</p>

                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-check card-radio">
                                                        <input class="form-check-input" type="radio" name="data_topbar" id="topbar-color-light" value="light" {{ $datas->data_topbar == "light" ? 'checked' : '' }}>
                                                        <label class="form-check-label p-0 avatar-md w-100" for="topbar-color-light">
                                                            <span class="d-flex gap-1 h-100">
                                                                <span class="flex-shrink-0">
                                                                    <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                                        <span class="d-block p-1 px-2 bg-soft-primary rounded mb-2"></span>
                                                                        <span class="d-block p-1 px-2 pb-0 bg-soft-primary"></span>
                                                                        <span class="d-block p-1 px-2 pb-0 bg-soft-primary"></span>
                                                                        <span class="d-block p-1 px-2 pb-0 bg-soft-primary"></span>
                                                                    </span>
                                                                </span>
                                                                <span class="flex-grow-1">
                                                                    <span class="d-flex h-100 flex-column">
                                                                        <span class="bg-light d-block p-1"></span>
                                                                        <span class="bg-light d-block p-1 mt-auto"></span>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <h5 class="fs-13 text-center mt-2">Light</h5>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-check card-radio">
                                                        <input class="form-check-input" type="radio" name="data_topbar" id="topbar-color-dark" value="dark" {{ $datas->data_topbar == "dark" ? 'checked' : '' }}>
                                                        <label class="form-check-label p-0 avatar-md w-100" for="topbar-color-dark">
                                                            <span class="d-flex gap-1 h-100">
                                                                <span class="flex-shrink-0">
                                                                    <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                                        <span class="d-block p-1 px-2 bg-soft-primary rounded mb-2"></span>
                                                                        <span class="d-block p-1 px-2 pb-0 bg-soft-primary"></span>
                                                                        <span class="d-block p-1 px-2 pb-0 bg-soft-primary"></span>
                                                                        <span class="d-block p-1 px-2 pb-0 bg-soft-primary"></span>
                                                                    </span>
                                                                </span>
                                                                <span class="flex-grow-1">
                                                                    <span class="d-flex h-100 flex-column">
                                                                        <span class="bg-primary d-block p-1"></span>
                                                                        <span class="bg-light d-block p-1 mt-auto"></span>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <h5 class="fs-13 text-center mt-2">Dark</h5>
                                                </div>
                                            </div>

                                            <div id="sidebar-color">
                                                <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Sidebar Color</h6>
                                                <p class="text-muted">Choose a color of Sidebar.</p>

                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-check sidebar-setting card-radio" data-bs-toggle="collapse" data-bs-target="#collapseBgGradient.show">
                                                            <input class="form-check-input" type="radio" name="data_sidebar" id="sidebar-color-light" value="light" {{ $datas->data_sidebar == "light" ? 'checked' : '' }}>
                                                            <label class="form-check-label p-0 avatar-md w-100" for="sidebar-color-light">
                                                                <span class="d-flex gap-1 h-100">
                                                                    <span class="flex-shrink-0">
                                                                        <span class="bg-white border-end d-flex h-100 flex-column gap-1 p-1">
                                                                            <span class="d-block p-1 px-2 bg-soft-primary rounded mb-2"></span>
                                                                            <span class="d-block p-1 px-2 pb-0 bg-soft-primary"></span>
                                                                            <span class="d-block p-1 px-2 pb-0 bg-soft-primary"></span>
                                                                            <span class="d-block p-1 px-2 pb-0 bg-soft-primary"></span>
                                                                        </span>
                                                                    </span>
                                                                    <span class="flex-grow-1">
                                                                        <span class="d-flex h-100 flex-column">
                                                                            <span class="bg-light d-block p-1"></span>
                                                                            <span class="bg-light d-block p-1 mt-auto"></span>
                                                                        </span>
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                        <h5 class="fs-13 text-center mt-2">Light</h5>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-check sidebar-setting card-radio" data-bs-toggle="collapse" data-bs-target="#collapseBgGradient.show">
                                                            <input class="form-check-input" type="radio" name="data_sidebar" id="sidebar-color-dark" value="dark" {{ $datas->data_sidebar == "dark" ? 'checked' : '' }}>
                                                            <label class="form-check-label p-0 avatar-md w-100" for="sidebar-color-dark">
                                                                <span class="d-flex gap-1 h-100">
                                                                    <span class="flex-shrink-0">
                                                                        <span class="bg-primary d-flex h-100 flex-column gap-1 p-1">
                                                                            <span class="d-block p-1 px-2 bg-soft-light rounded mb-2"></span>
                                                                            <span class="d-block p-1 px-2 pb-0 bg-soft-light"></span>
                                                                            <span class="d-block p-1 px-2 pb-0 bg-soft-light"></span>
                                                                            <span class="d-block p-1 px-2 pb-0 bg-soft-light"></span>
                                                                        </span>
                                                                    </span>
                                                                    <span class="flex-grow-1">
                                                                        <span class="d-flex h-100 flex-column">
                                                                            <span class="bg-light d-block p-1"></span>
                                                                            <span class="bg-light d-block p-1 mt-auto"></span>
                                                                        </span>
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                        <h5 class="fs-13 text-center mt-2">Dark</h5>
                                                    </div>
                                                    <div class="col-4">
                                                        <button class="btn btn-link avatar-md w-100 p-0 overflow-hidden border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBgGradient" aria-expanded="false" aria-controls="collapseBgGradient">
                                                            <span class="d-flex gap-1 h-100">
                                                                <span class="flex-shrink-0">
                                                                    <span class="bg-vertical-gradient d-flex h-100 flex-column gap-1 p-1">
                                                                        <span class="d-block p-1 px-2 bg-soft-light rounded mb-2"></span>
                                                                        <span class="d-block p-1 px-2 pb-0 bg-soft-light"></span>
                                                                        <span class="d-block p-1 px-2 pb-0 bg-soft-light"></span>
                                                                        <span class="d-block p-1 px-2 pb-0 bg-soft-light"></span>
                                                                    </span>
                                                                </span>
                                                                <span class="flex-grow-1">
                                                                    <span class="d-flex h-100 flex-column">
                                                                        <span class="bg-light d-block p-1"></span>
                                                                        <span class="bg-light d-block p-1 mt-auto"></span>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </button>
                                                        <h5 class="fs-13 text-center mt-2">Gradient</h5>
                                                    </div>
                                                </div>

                                                <div class="collapse" id="collapseBgGradient">
                                                    <div class="d-flex gap-2 flex-wrap img-switch p-2 px-3 bg-light rounded">

                                                        <div class="form-check sidebar-setting card-radio">
                                                            <input class="form-check-input" type="radio" name="data_sidebar" id="sidebar-color-gradient" value="gradient" {{ $datas->data_sidebar == "gradient" ? 'checked' : '' }}>
                                                            <label class="form-check-label p-0 avatar-xs rounded-circle" for="sidebar-color-gradient">
                                                                <span class="avatar-title rounded-circle bg-vertical-gradient"></span>
                                                            </label>
                                                        </div>
                                                        <div class="form-check sidebar-setting card-radio">
                                                            <input class="form-check-input" type="radio" name="data_sidebar" id="sidebar-color-gradient-2" value="gradient-2" {{ $datas->data_sidebar == "gradient-2" ? 'checked' : '' }}>
                                                            <label class="form-check-label p-0 avatar-xs rounded-circle" for="sidebar-color-gradient-2">
                                                                <span class="avatar-title rounded-circle bg-vertical-gradient-2"></span>
                                                            </label>
                                                        </div>
                                                        <div class="form-check sidebar-setting card-radio">
                                                            <input class="form-check-input" type="radio" name="data_sidebar" id="sidebar-color-gradient-3" value="gradient-3" {{ $datas->data_sidebar == "gradient-3" ? 'checked' : '' }}>
                                                            <label class="form-check-label p-0 avatar-xs rounded-circle" for="sidebar-color-gradient-3">
                                                                <span class="avatar-title rounded-circle bg-vertical-gradient-3"></span>
                                                            </label>
                                                        </div>
                                                        <div class="form-check sidebar-setting card-radio">
                                                            <input class="form-check-input" type="radio" name="data_sidebar" id="sidebar-color-gradient-4" value="gradient-4" {{ $datas->data_sidebar == "gradient-4" ? 'checked' : '' }}>
                                                            <label class="form-check-label p-0 avatar-xs rounded-circle" for="sidebar-color-gradient-4">
                                                                <span class="avatar-title rounded-circle bg-vertical-gradient-4"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="offcanvas-footer border-top text-center"></div>
                                        <div class="col-md-12">
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-success btn-label waves-effect waves-light">
                                                    <i class="ri-save-2-fill label-icon align-middle fs-16 me-2"></i> Save
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.alert_success')
    @include('components.alert_error')

@endsection

@section('script')
    <script type="text/javascript">
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
