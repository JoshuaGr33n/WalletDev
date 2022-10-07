<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="images/favicon.png">
    <!--Core CSS -->
    <link href="{{ asset('/bs3/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrap-reset.css') }}" rel="stylesheet">
    <link href="{{ asset('/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    @yield('style')
    <!-- Custom styles for this template -->
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style-responsive.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/js/gritter/css/jquery.gritter.css') }}" />
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="{{ asset('/js/ie8-responsive-file-warning.js') }}"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
  <section id="container">
    @include('includes.header')
    @include('includes.sidebar')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        @yield('content')
        </section>
    </section aa>
  </section bbb>
  <!--Core js-->
  <script src="{{ asset('/js/jquery.js') }}"></script>
  <script src="{{ asset('/bs3/js/bootstrap.min.js') }}"></script>
  <script class="include" type="text/javascript" src="{{ asset('/js/jquery.dcjqaccordion.2.7.js') }}"></script>
  <script src="{{ asset('/js/jquery.scrollTo.min.js') }}"></script>
  <script src="{{ asset('/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js') }}"></script>
  <script src="{{ asset('/js/jquery.nicescroll.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/gritter/js/jquery.gritter.js') }}"></script>
  @yield('scripts')
  <script src="{{ asset('/js/scripts.js') }}"></script>
</body>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modal_title"></h4>
            </div>
            <div class="modal-body" id="modal_body"></div>
            <div class="modal-footer" id="modal_footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                <button class="btn btn-success" type="button">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- modal -->
<!-- /.small modal -->
<div class="modal fade bs-modal-sm" id="small_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="sm_modal_title"></h4>
            </div>
            <div class="modal-body" id="sm_modal_body"></div>
            <div class="modal-footer" id="sm_modal_footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
                <button type="button" id="continuemodal" class="btn green">Yes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.small modal -->

</html>