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
                         <h3 class="register-heading">Doctor Registration</h3>
                     </div>
                         @if(session()->has('success'))
                            <div class="alert alert-success" >
                                {{ session()->get('success') }}
                            </div>
                            @endif
                        @if (count($errors) > 0)
                    <div class = "alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                   
                    @endif
                       {!! Form::open(['method' => 'POST', 'url' =>'register_user','enctype'=>"multipart/form-data"]) !!}
                            
                            <div class="row">
                                 <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text"  name="name" class="form-control" placeholder="Name *"  value="{{old('name')}}" required />
                                </div>
                                </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <input type="text" name="mobile_no" maxlength="10"   class="form-control" value="{{old('mobile_no')}}" placeholder=" Phone  *" required />
                                 </div>
                             </div>
                            
                            </div>

                            <div class="row">
                                 <div class="col-md-6">
                                <div class="form-group">
                                            <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="Your Email *" required />
                                        </div>
                                </div>
                                 <div class="col-md-6">
                                 <div class="form-group">
                                            {!! Form::select('specialization', $sp, old('specialization'), ['class' => 'form-control']) !!}  
                                        </div>
                                </div>
                                
                            </div>
                           <div class="row">
                            <div class="col-md-6">
                                 <div class="form-group">
                                            <input type="text" value="{{old('address')}}"  name="address" class="form-control" placeholder="Address "  />
                                        </div>
                                </div>
                             <div class="col-md-6">
                            <div class="form-group">
                                            <input type="password" name="password" class="form-control" placeholder="Password *" required />
                                        </div>
                           </div>
                         </div>
                          
                         <div class="row" >
                             <div class="col-md-12">
                              
                          <input   class="btn btn-info btn-block" type="submit"  value="Register"/>
                      </div>
                  </div>
                             {!! Form::close() !!}

                            <div class="clearfix"></div>
                        </form>
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