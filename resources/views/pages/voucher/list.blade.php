@extends('layouts.layout_admin')
@section('style')
<!--dynamic table-->
    <link href="{{ asset('/js/advanced-datatable/css/demo_page.css') }}" rel="stylesheet" />
    <link href="{{ asset('/js/advanced-datatable/css/demo_table.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/js/data-tables/DT_bootstrap.css') }}" />
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
                Manage Voucher
                <span class="tools pull-right">
                    <a href="{{ route('vouchers.create') }}" data-toggle="tooltip" title="Add" class="btn btn-primary btn-sm" data-toggle="tooltip" data-original-title="Add New">
                        <i class="fa fa-plus"></i> Add New Voucher
                    </a>
                </span>
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="dynamic-table">
                        <thead>
                            <tr>
                                <th>Voucher Name</th>
                                <th>Discount Type</th>
                                <th>Discount Value</th>
                                <th>Sale Start Date</th>
                                <th>Sale End Date</th>
                                <th>Status</th>
                                <th>Action</th>
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
<!--<script src="{{ asset('/js/flot-chart/jquery.flot.tooltip.min.js') }}"></script>-->
<!--dynamic table-->
<script type="text/javascript" language="javascript" src="{{ asset('/js/dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/data-tables/DT_bootstrap.js') }}"></script>
<!--common script init for all pages-->
<!--<script src="{{ asset('/js/scripts.js') }}"></script>-->

<!--dynamic table initialization -->
<!--<script src="{{ asset('/js/dynamic_table_init.js') }}"></script>-->
<script type="text/javascript">
$(document).ready(function(){
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    var table = $('#dynamic-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('vouchers.index') }}",
          type: 'GET',
          data: function (d) {
            d.full_name = '';
          }
        },
        columns: [
            {data: 'voucher_name', name: 'voucher_name'},
            {data: 'discount_type', name: 'discount_type'},
            {data: 'voucher_value', name: 'voucher_value'},
            {data: 'sale_start_date', name: 'sale_start_date'},
            {data: 'sale_end_date', name: 'sale_end_date'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'desc']],
        responsive:true,
        drawCallback: function( settings ) {
        $('[data-toggle="tooltip"]').tooltip(); // for tooltips in controls
        $('.deleteVoucher').on('click',function(){
            var x = confirm("Do you want to delete the voucher?");
            if(x == true) { 
             var voucherID = $(this).data('voucher'); 
                $.ajax({
                    url: "{{ route('deleteVoucher') }}",
                    data: { "id": voucherID },
                    type: "post",
                    dataType: "json",
                    success: function (data) {
                       window.location.reload();
                    }
                });
            }
         });
        }
    });
     $('.search-custom').keyup(function(){
        table.draw(true);
    });
});    
</script>
@endsection