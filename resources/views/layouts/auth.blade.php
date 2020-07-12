<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Point of Sale</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name='csrf-token' content="{{ csrf_token() }}">

        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('/css/icons.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('/css/style.css')}}" rel="stylesheet" type="text/css">

        <style>
            html, body {
                margin: 0;
                padding: 0;
            }
        </style>
    </head>
    <body>
        <!-- Loader -->
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    <div class="rect5"></div>
                </div>
            </div>
        </div>

        <div id="app">
            <auth-page></auth-page>
        </div>

        <!-- jQuery  -->
        <script src="{{asset('/js/jquery.min.js')}}"></script>
        <script src="{{asset('/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('/js/modernizr.min.js')}}"></script>
        <script src="{{asset('/js/detect.js')}}"></script>
        <script src="{{asset('/js/fastclick.js')}}"></script>
        <script src="{{asset('/js/jquery.slimscroll.js')}}"></script>
        <script src="{{asset('/js/jquery.blockUI.js')}}"></script>
        <script src="{{asset('/js/waves.js')}}"></script>
        <script src="{{asset('/js/jquery.nicescroll.js')}}"></script>
        <script src="{{asset('/js/jquery.scrollTo.min.js')}}"></script>

        <!-- App js -->
        <script src="{{mix('/js/app.js')}}"></script>
        <script src="{{asset('/js/app_template.js')}}"></script>
    </body>
</html>