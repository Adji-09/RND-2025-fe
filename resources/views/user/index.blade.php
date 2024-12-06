@extends('layouts.master')

@section('title') {{ $title }} @endsection

@section('content')

    @include('components.breadcrumb')

    <div class="row">
        <div class="col-lg-12">
            <div class="card border card-border-default">
                <div class="card-header d-flex align-items-center">
                    <div class="flex-grow-1"></div>
                    <a type="button" href="{{ route('user.create') }}" class="btn btn-primary btn-label waves-effect waves-light">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="bx bx-user-plus label-icon align-middle fs-16 me-2"></i>
                            </div>
                            <div class="flex-grow-1">Add</div>
                        </div>
                    </a>
                    <div>
                        <button type="button" class="btn btn-sm btn-warning modalAlertSuccess" data-bs-toggle="modal" data-bs-title="Success" hidden></button>
                        <button type="button" class="btn btn-sm btn-warning modalAlertError" data-bs-toggle="modal" data-bs-title="Error" hidden></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-nowrap align-middle" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th>No.</th>
                                    <th style="text-align: center;">Photo</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th style="text-align: center;">Status</th>
                                    <th>Created</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <center><img src="{{ $row->foto }}" class="rounded" style="width: 100px; height: 100px;"></center>
                                        </td>
                                        <td>{{ $row->username }}</td>
                                        <td>{{ $row->email }}</td>
                                        <td>{{ $row->role }}</td>
                                        <td>
                                            @if ($row->status == 1)
                                                <center><span class="badge badge-soft-success badge-border">Active</span></center>
                                            @elseif ($row->status == 2)
                                                <center><span class="badge badge-soft-danger badge-border">Inactive</span></center>
                                            @endif
                                        </td>
                                        <td>{{ $row->created_at }}</td>
                                        <td>
                                            <center>
                                                <a href="{{ URL('/user/getById/'.$row->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="ri-edit-2-line align-middle"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger modalConfirmDelete" data-bs-toggle="modal"
                                                    data-bs-title="Delete" data-id_delete="{{ $row->id }}" title="Delete">
                                                    <i class="ri-delete-bin-line align-middle"></i>
                                                </button>
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

    @include('user.confirm_delete')
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

        $(document).on('click', '.modalConfirmDelete', function() {
            $('.id_delete').text($(this).data('id_delete'));
            $('#modalConfirmDelete').modal('show');
        });
    </script>

    // DATATABLE
    <script type="text/javascript">
        $(document).ready(function() {
            let t = $('#dataTable').DataTable({
                lengthMenu: [10, 25, 50, 100],
                responsive: true,
                searching: true,
                ordering: false,
                processing: true,
                pageLength: 10,
                pagingType: "full_numbers",
                pageResize: true,
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
                },
                columnDefs: [{
                    searchable: false,
                    orderable: false,
                    targets: 0,
                }, ],
                order: [
                    [1, 'asc']
                ],
            });

            t.on('order.dt search.dt', function() {
                let i = 1;

                t.cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                }).every(function(cell) {
                    this.data(i++);
                });

            }).draw();
        });
    </script>
@endsection
