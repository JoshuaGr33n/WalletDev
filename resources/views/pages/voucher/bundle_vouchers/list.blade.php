@extends('layouts.layout_admin')
@section('style')
<!--dynamic table-->
<link href="{{ asset('/js/advanced-datatable/css/demo_page.css') }}" rel="stylesheet" />
<link href="{{ asset('/js/advanced-datatable/css/demo_table.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('/js/data-tables/DT_bootstrap.css') }}" />
<link rel="stylesheet" href="{{ asset('/css/jquery-confirm.min.css') }}">
@endsection
@section('content')
<!-- page start-->
<div class="row">
    <div class="col-sm-12">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif
        <section class="panel">
            <header class="panel-heading">
                Manage Bundle Vouchers
                <span class="tools pull-right">
                    <a href="{{ route('vouchers.index') }}" title="Back" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i></a>
                </span>
                <span class="tools pull-right">
                    <a href="{{ route('bundle-vouchers.create') }}" data-toggle="tooltip" title="Add" class="btn btn-success btn-sm" data-toggle="tooltip" data-original-title="Add New">
                        <i class="fa fa-plus"></i> Create New Bundle Voucher
                    </a>
                </span>

            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="dynamic-table">
                        <thead>
                            <tr>
                                <th>Bundle Voucher Name</th>
                                <th>Bundle Voucher Code</th>
                                <th>Wallet Credit Value</th>
                                <th>Sale Start Date</th>
                                <th>Sale End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- page end-->
@endsection
@section('scripts')
<script src="{{ asset('/js/jquery-confirm.min.js') }}"></script>
<!--dynamic table-->
<script type="text/javascript" language="javascript" src="{{ asset('/js/dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/data-tables/DT_bootstrap.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('#dynamic-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('bundle-vouchers.index') }}",
                type: 'GET',
                data: function(d) {
                    d.full_name = '';
                }
            },
            columns: [{
                    data: 'voucher_name',
                    name: 'voucher_name'
                },
                {
                    data: 'bundle_voucher_code',
                    name: 'bundle_voucher_code'
                },
                {
                    data: 'buy_bundle_with',
                    name: 'buy_bundle_with'
                },
                {
                    data: 'sale_start_date',
                    name: 'sale_start_date'
                },
                {
                    data: 'sale_end_date',
                    name: 'sale_end_date'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                },
                {
                    data: 'actions',
                    name: 'actions'
                },
            ],
            order: [
                [0, 'asc']
            ],
            responsive: true,
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip(); // for tooltips in controls
                $('.deleteVoucher').on('click', function() {

                    var voucherID = $(this).data('voucher');
                    $.confirm({
                        title: 'WARNING!',
                        content: 'Are you sure you want to delete this Bundle?',
                        buttons: {
                            Yes: {
                                text: 'Yes',
                                btnClass: 'btn-danger',
                                action: function() {
                                    $.ajax({
                                        url: "{{ route('bundle-vouchers.destroy',['bundle_voucher' =>" + voucherID + " ]) }}",
                                        data: {
                                            "id": voucherID,
                                            _method: 'DELETE'
                                        },
                                        type: "post",
                                        dataType: "json",
                                        success: function(data) {
                                            window.location.reload();
                                        }
                                    });
                                    setInterval('location.reload()', 1000);
                                }
                            },
                            cancel: function() {

                            }
                        }
                    });

                });
            }
        });
        $('.search-custom').keyup(function() {
            table.draw(true);
        });
    });
</script>
@endsection