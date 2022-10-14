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
                Manage App user
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="appuser-table">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Phone</th>
                                <th>Email</th>
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
    var table = $('#appuser-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('appuser.index') }}",
          type: 'GET',
          data: function (d) {
            d.first_name = '';
          }
        },
        columns: [
            {data: 'first_name', name: 'first_name'},
            {data: 'last_name', name: 'last_name'},
            {data: 'phone_number', name: 'phone_number'},
            {data: 'email', name: 'email'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false},
            {data: 'actions', name: 'actions'},
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
function changeStatus(id, status){
    var table2 = $('#appuser-table').DataTable();
    var x = confirm("Do you want to change the status?");
    if(x == true) { 
        $.ajax({
            url: "{{ route('changeStatus') }}",
            data: { "id": id, "status": status },
            type: "post",
            dataType: "json",
            success: function (data) {
               table2.ajax.reload();
            }
        });
    }
}
function getTransactionForm(user_id){
    $( '#myModal' ).modal();
    $( '#modal_footer' ).html('');
    $( '#modal_title' ).html( 'Transaction Form' );
    if(user_id) {
        $.ajax({
            url: "{{ route('getTransactionForm') }}",
            data: { "user_id": user_id },
            type: "post",
            dataType: "html",
            success: function (html) {
               $( '#modal_body' ).html(html);
            }
        });
    }
}
function addTransaction(){
    var type = $('input[name="transaction_type"]:checked').val();
    var outlet_id = $('#tranasaction_form #outlet_id').val();
    var amount = $('#tranasaction_form #amount').val();
    var user_id = $('#tranasaction_form #user_id').val();
    if((type != undefined) && outlet_id && amount) {
        $.ajax({
            url: "{{ route('addTransaction') }}",
            data: { "user_id": user_id,"type": type,"outlet_id": outlet_id,"amount": amount },
            type: "post",
            dataType: "json",
            success: function (res) {
                if(res.status == 'failed'){
                    if(res.error.amount){
                        alert(res.error.amount);
                    }else if(res.error.outlet_id){
                        alert(res.error.outlet_id);
                    }else if(res.error.type){
                        alert(res.error.type);
                    }else{
                        alert('Some problem found. Please try again.');
                    }
                }else{
                    alert(res.message);
                    window.location.reload();
                }

            }
        });
    }
}
</script>
@endsection