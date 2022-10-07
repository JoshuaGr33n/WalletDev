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
                Manage user
                <span class="tools pull-right">
                    <a href="{{ route('user.create') }}" data-toggle="tooltip" title="Add" class="btn btn-primary btn-sm" data-toggle="tooltip" data-original-title="Add New">
                        <i class="fa fa-plus"></i> Add New User
                    </a>
                </span>
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="dynamic-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Role</th>
                                <th>User Name</th>
                                <th>Email</th>
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
          url: "{{ route('user.index') }}",
          type: 'GET',
          data: function (d) {
            d.full_name = '';
          }
        },
        columns: [
            {data: 'full_name', name: 'full_name'},
            {data: 'roleId', name: 'roleId'},
            {data: 'user_name', name: 'user_name'},
            {data: 'email', name: 'email'},
            {data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'desc']],
        responsive:true,
        drawCallback: function( settings ) {
        $('[data-toggle="tooltip"]').tooltip(); // for tooltips in controls
        $('.deleteuser').on('click',function(){
            var x = confirm("Do you want to delete the user?");
            if(x == true) { 
             var userid = $(this).data('user'); 
                $.ajax({
                    url: "{{ route('deleteuser') }}",
                    data: { "id": userid },
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