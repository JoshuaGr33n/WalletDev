@extends('layouts.layout_admin')
@section('style')
<!--dynamic table-->
<link href="{{ asset('/js/advanced-datatable/css/demo_page.css') }}" rel="stylesheet" />
<link href="{{ asset('/js/advanced-datatable/css/demo_table.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('/js/data-tables/DT_bootstrap.css') }}" />
@endsection
@section('content')
<!-- page start-->

<div class="row" id="app">
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

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script> -->
<!--common script init for all pages-->
<!--<script src="{{ asset('/js/scripts.js') }}"></script>-->

<!--dynamic table initialization -->
<!--<script src="{{ asset('/js/dynamic_table_init.js') }}"></script>-->
<script type="text/javascript">
    $(document).ready(function() {
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
                data: function(d) {
                    d.first_name = '';
                }
            },
            columns: [{
                    data: 'first_name',
                    name: 'first_name'
                },
                {
                    data: 'last_name',
                    name: 'last_name'
                },
                {
                    data: 'phone_number',
                    name: 'phone_number'
                },
                {
                    data: 'email',
                    name: 'email'
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
                [0, 'desc']
            ],
            responsive: true,
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip(); // for tooltips in controls
                $('.deleteuser').on('click', function() {
                    var x = confirm("Do you want to delete the user?");
                    if (x == true) {
                        var userid = $(this).data('user');
                        $.ajax({
                            url: "{{ route('deleteAppUser') }}",
                            data: {
                                "id": userid
                            },
                            type: "post",
                            dataType: "json",
                            success: function(data) {
                                window.location.reload();
                            }
                        });
                    }
                });
            }
        });
        $('.search-custom').keyup(function() {
            table.draw(true);
        });
    });
    function deleteUser(id) {
        var table2 = $('#appuser-table').DataTable();
        var x = confirm("Do you want to change the status?"+id);
        if (x == true) {
            $.ajax({
                url: "{{ route('deleteAppUser') }}",
                data: {
                    "id": id
                    // "status": status
                },
                type: "post",
                dataType: "json",
                success: function(data) {
                    table2.ajax.reload();
                }
            });
        }
    }
    function changeStatus(id, status) {
        var table2 = $('#appuser-table').DataTable();
        var x = confirm("Do you want to change the status?");
        if (x == true) {
            $.ajax({
                url: "{{ route('changeStatus') }}",
                data: {
                    "id": id,
                    "status": status
                },
                type: "post",
                dataType: "json",
                success: function(data) {
                    table2.ajax.reload();
                }
            });
        }
    }

    function getTransactionForm(user_id) {
        $('#myModal').modal();
        $('#modal_footer').html('');
        $('#modal_title').html('Transaction Form');
        if (user_id) {
            $.ajax({
                url: "{{ route('getTransactionForm') }}",
                data: {
                    "user_id": user_id
                },
                type: "post",
                dataType: "html",
                success: function(html) {
                    $('#modal_body').html(html);
                }
            });
        }
    }

    function addTransaction() {
        var type = $('input[name="transaction_type"]:checked').val();
        var outlet_id = $('#tranasaction_form #outlet_id').val();
        var amount = $('#tranasaction_form #amount').val();
        var user_id = $('#tranasaction_form #user_id').val();
        if ((type != undefined) && outlet_id && amount) {
            $.ajax({
                url: "{{ route('addTransaction') }}",
                data: {
                    "user_id": user_id,
                    "type": type,
                    "outlet_id": outlet_id,
                    "amount": amount
                },
                type: "post",
                dataType: "json",
                success: function(res) {
                    if (res.status == 'failed') {
                        if (res.error.amount) {
                            alert(res.error.amount);
                        } else if (res.error.outlet_id) {
                            alert(res.error.outlet_id);
                        } else if (res.error.type) {
                            alert(res.error.type);
                        } else {
                            alert('Some problem found. Please try again.');
                        }
                    } else {
                        alert(res.message);
                        window.location.reload();
                    }

                }
            });
        }
    }

    // $(document).ready(function() {

    //     // Delete 
    //     $('.deleteCustomer').click(function() {
    //         var el = this;
    //         // Delete id
    //         var deleteid = $(this).data('id');

    //         // var fname = $(".fname" + deleteid).text();
    //         // var lname = $(".lname" + deleteid).text();

    //         $.confirm({
    //             title: 'WARNING!',
    //             content: 'Are you sure you want to remove  from your followers list?',
    //             buttons: {
    //                 Yes: {
    //                     text: 'Yes',
    //                     btnClass: 'btn-danger',
    //                     action: function() {
    //                         // AJAX Request
    //                         $.ajax({
    //                             url: '{{ route("deleteAppUser") }}',
    //                             type: 'POST',
    //                             data: {
    //                                 id: deleteid,
    //                                 csrfmiddlewaretoken: $('input[name=csrfmiddlewaretoken]').val()
    //                             },
    //                             success: function(response) {
    //                                 if (response == 1) {
    //                                     // Remove row from Table
    //                                     $(el).closest('tr').css('background', 'red');
    //                                     $(el).closest('tr').fadeOut(800, function() {
    //                                         $(this).remove();
    //                                     });
    //                                 } else {
    //                                     alert('Invalid Selection.');
    //                                 }

    //                             }

    //                         });
    //                         setInterval('location.reload()', 1000);
    //                     }
    //                 },
    //                 cancel: function() {

    //                 }
    //             }
    //         });

    //     });

    // });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.16/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<script type="text/javascript">
    const app = new Vue({
        el: '#app',

        data: {
            form: {
                title: '',
                status: '',
            },
            allerros: [],
            success: false,
            // users: [],
            feedback: 0,
            label: '',
        },
        // mounted() {
        //     window.axios.get('{{url("users")}}').then(res => {
        //         this.users = res.data
        //         console.log(this.users)
        //     })
        // },
        methods: {
            onSubmit() {
                dataform = new FormData();
                dataform.append('title', this.form.title);
                dataform.append('status', this.form.status);
                console.log(this.form.title);

                axios.post('{{url("create_category")}}', dataform).then(response => {
                    console.log(response);
                    this.allerros = [];
                    this.form.title = '';
                    this.form.status = '';
                    this.success = true;
                    if (response.data.success === 1) {
                        this.success = true;
                    }
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }).catch((error) => {
                    this.allerros = error.response.data.errors;
                    this.success = false;
                });
            },
            activate(id) {
                console.log(id);
                axios.put('{{url("update_category_status")}}/' + id, {

                    })
                    .then(response => {
                        if (response.data.res == id) {
                            this.feedback = id;
                            this.label = response.data.label;
                            console.log(this.label);
                        }
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            deactivate(id) {
                console.log(id);
                axios.put('{{url("update_category_status")}}/' + id, {

                    })
                    .then(response => {
                        if (response.data.res == id) {
                            console.log(id);
                            this.feedback = id;
                            this.label = response.data.label;
                            console.log(this.label);
                        }
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            deleteUser4(id) {
                $.confirm({
                    title: 'Delete',
                    content: 'Warning! Taking off this Category erases all tasks within. Are you sure you wish to proceed?',
                    buttons: {
                        Yes: {
                            text: 'Yes',
                            btnClass: 'btn-danger',
                            action: function() {
                                axios.delete('{{url("deleteCategory")}}/' + id)
                                    .then(response => {
                                        if (response.data.res == 1) {
                                            $('.delete' + id).closest('tr').css('background', 'red');
                                            $('.delete' + id).closest('tr').fadeOut(800, function() {
                                                $(this).remove();
                                            });
                                        } else {
                                            alert('Invalid Selection.');
                                        }
                                    })
                                    .catch(error => {
                                        console.log(error);
                                    })
                                setInterval('location.reload()', 1000);

                            }
                        },
                        cancel: function() {

                        }
                    }
                });
            }
        }
    });
</script>
@endsection