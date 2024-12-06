@extends('layouts.master')

@section('title') {{ $title }} @endsection

@section('content')

    @include('components.breadcrumb')

    <div class="row">
        <div class="col-lg-12">
            <div class="card border card-border-default">
                <div class="card-header d-flex align-items-center">
                    <h4 class="card-title mb-0 flex-grow-1">Drag and Drop Table</h4>
                    <div>
                        <button type="button" class="btn btn-sm btn-warning modalAlertSuccess" data-bs-toggle="modal" data-bs-title="Success" hidden></button>
                        <button type="button" class="btn btn-sm btn-warning modalAlertError" data-bs-toggle="modal" data-bs-title="Error" hidden></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered dt-responsive nowrap align-middle mdl-data-table" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <td style="text-align: center;"><i class="ri-drag-move-2-line fs-24"></i></td>
                                    <th>Module</th>
                                    <th hidden>ID</th>
                                    <th style="text-align: center;">Icon</th>
                                    <th style="text-align: center;">Administrator</th>
                                    <th style="text-align: center;">Status</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td align="center">{{ $loop->iteration }}</td>
                                        <td>{{ $data->module_name }}</td>
                                        <td hidden>{{ $data->module_id }}</td>
                                        <td align="center"><i class="{{ $data->module_icon }} fs-24"></i></td>
                                        <td align="center">
                                            @if ($data->is_superadmin == 1)
                                                <i class="ri-checkbox-circle-fill fs-24" style="color: blue;"></i>
                                            @else
                                                <i class="ri-close-circle-fill fs-24" style="color: red;"></i>
                                            @endif
                                        </td>
                                        <td align="center">
                                            @if ($data->module_status == 1)
                                                <span class="badge badge-soft-success badge-border">Active</span>
                                            @else
                                                <span class="badge badge-soft-danger badge-border">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <center>
                                                <a href="module/edit/{{ $data->module_id }}" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="ri-edit-2-line align-middle"></i>
                                                </a>
                                            </center>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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

    // DATATABLE
    <script type="text/javascript">
        $(function () {
            var table = $('#dataTable').DataTable({
                responsive: true,
                ordering: false,
                paging: false,
                // scrollY: 500,
                columnDefs: [
                    { orderable: true, className: 'reorder', targets: 0 },
                    { orderable: false, targets: '_all' }
                ],
                rowReorder: {
                    snapX: 10
                },
                language: {
                    emptyTable: "No data available in table",
                    zeroRecords: "No matching records found",
                    lengthMenu: "Show _MENU_ entries",
                    loadingRecords: "Loading...",
                    processing: "Process...",
                    info: "Showing <b>_START_ to _END_</b> of _TOTAL_ entries",
                    infoEmpty: "Showing <b>0 to 0</b> of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    paginate: {
                        previous: '<i class="bx bxs-chevron-left align-middle"></i>',
                        next: '<i class="bx bxs-chevron-right align-middle"></i>',
                        first: '<i class="bx bxs-chevrons-left align-middle"></i>',
                        last: '<i class="bx bxs-chevrons-right align-middle"></i>',
                    },
                }
            });

            table.on('row-reorder', function (e, diff, edit)
            {
                for (var i = 0, ien = diff.length; i < ien; i++)
                {
                    let rowData = table.row(diff[i].node).data();

                    var form = new FormData();
                    form.append("module_id", `${rowData[2]}`);
                    form.append("module_position", `${diff[i].newData}`);

                    var access_token = <?php echo json_encode(\Session::get('access_token')) ?>;

                    var settings = {
                        "url": "http://localhost:8010/api/module/update_pos",
                        "method": "POST",
                        "timeout": 0,
                        "headers": {
                            "Authorization": "Bearer " + access_token
                        },
                        "processData": false,
                        "mimeType": "multipart/form-data",
                        "contentType": false,
                        "data": form
                    };

                    $.ajax(settings).done(function (response) {
                        var base_url = window.location.origin;
                        window.location.href = base_url + "/module";
                    });
                }
            });
        });
    </script>
@endsection
