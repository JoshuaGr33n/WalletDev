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
        <section class="panel">
            <header class="panel-heading">
                Manage Notification
                <span class="tools pull-right">
                    <a href="{{ route('notification.create') }}" data-toggle="tooltip" title="Add" class="btn btn-primary btn-sm" data-toggle="tooltip" data-original-title="Add New">
                        <i class="fa fa-plus"></i> Send New Notification
                    </a>
                </span>
            </header>
            <div class="panel-body">
            <div class="adv-table">
            <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="notification-table">
                <thead>
                    <tr>
                        <th>To</th>
                        <th>Title</th>
                        <th>Short Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
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
    var table = $('#notification-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('notification.index') }}",
          type: 'GET',
          data: function (d) {
            d.area_name = $('#service').val();
          }
        },
        columns: [
            {data: 'notify_to', name: 'notify_to'},
            {data: 'title', name: 'title'},
            {data: 'short_desc', name: 'short_desc'},
            {data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'desc']],
        responsive:true,
        drawCallback: function( settings ) {
        $('[data-toggle="tooltip"]').tooltip(); // for tooltips in controls
        $('.deleteNotification').on('click',function(){
            var x = confirm("Do you want to delete the Notification?");
            if(x == true) { 
             var notificationid = $(this).data('notification'); 
                $.ajax({
                    url: "{{ route('deletenotification') }}",
                    data: { "id": notificationid },
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
});    
</script>
@endsection