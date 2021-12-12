<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Doctor Registration </title>

        <!-- Bootstrap -->
        <link href="/bower_components/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="/bower_components/gentelella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- Animate.css -->
        <link href="https://colorlib.com/polygon/gentelella/css/animate.min.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="/bower_components/gentelella/build/css/custom.min.css" rel="stylesheet">
    </head>

    <body class="login">
        <div>

            <div class="login_wrapper">
                <div  class="row">
                    <div class="col-md-5">
                    </div>
                     <div class="col-md-7">
                           
                                <img class="img-responsive" src="/images/c2p-logo.png" width="150">
                            
                        </div>
                    </div>
                    <section >
                        <div class="row text-center">
                         <h1 class="register-heading"> You have successfully registered. </h1>
                         <h4 class="register-heading"> <a href="{{url('admin/login')}}">Login</a> </h4>
                     </div>
                    
                        
                    </section>
                </div>
            </div>
        </div>
    </body>
    <style type="text/css">
        .login_wrapper {
    right: 0px;
    margin: 0px auto;
    margin-top: 5%;
    max-width: 50%;
    position: relative;
}
    </style>
</html>