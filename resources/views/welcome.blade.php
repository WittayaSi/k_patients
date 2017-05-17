<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>K-Patients</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app-style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">

        <!-- Scripts -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" charset="utf-8"></script>
        <script src="{{ asset('/js/bootstrap.min.js')}}" charset="utf-8"></script>
        
    </head>
    <body>
        @if(!Auth::guest())
            <script type="text/javascript">
                window.location = "{{ url('/home') }}";
            </script>
        @else

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header alert alert-success">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <center><h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus fa-lg"></i>&nbsp&nbsp ลงทะเบียน</h4></center>
                        </div>
                        <div class="modal-body">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    <!--@if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif-->
                                    @if(Session::has('errors'))
                                        <script>
                                            $(document).ready(function(){
                                                $('#myModal').modal({show: true});
                                            })
                                        </script>
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times fa-fw"></i> ยกเลิก</button>
                            <button type="submit" class="btn btn-primary btn-sm" name="form_r"><i class="fa fa-save fa-fw"></i> บันทึก</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
              </form>
            <!-- /.modal-dialog -->
            </div>
            <!-- end modal -->

            <div class="flex-center position-ref full-height">
                
                <div class="content col-md-8">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="title">
                                <i class="fa fa-vcard fa-lg"></i> ระบบติดตามและนัดหมาย <small>( คนไข้ในพระราชานุเคราะห์ )</small>
                            </div>
                        </div>
                        <div class="panel-body center">
                            <!-- panel body -->
                            <div class="col-md-7">
                                <img src="{{ asset('images/srt.jpg') }}" width="100%"/>
                            </div>

                            <div class="col-md-5">
                                <a class="btn btn-primary btn-sm pull-right m-b-md" data-toggle="modal" data-target="#myModal" style="cursor:pointer;"><i class="fa fa-user-plus fa-fw"></i> ลงทะเบียน</a>
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <i class="fa fa-sign-in"></i> เข้าสู่ระบบ
                                    </div>
                                    <div class="panel-body">
                                        <!-- login form -->
                                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                                            {{ csrf_field() }}

                                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                <label for="email" class="col-md-4 control-label">E-mail</label>

                                                <div class="col-md-7">
                                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                                    @if ($errors->has('email'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                                <label for="password" class="col-md-4 control-label">Password</label>

                                                <div class="col-md-7">
                                                    <input id="password" type="password" class="form-control" name="password" required>

                                                    @if ($errors->has('password'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-8 col-md-offset-2">
                                                    <button type="submit" class="btn btn-success btn-block btn-login" name="form_l">
                                                        เข้าสู่ระบบ
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- end login form -->
                                    </div>
                                </div>
                            </div>
                            <!-- end panel body -->
                        </div>
                        <div class="panel-footer">
                            &copy;2017 ( พัฒนาโดย ทีม IT สสอ.ท่าสองยาง ) <br>
                            <i class="fa fa-phone fa-fw"></i> 055589116 :: <a href="https://www.facebook.com/groups/966421443401684/" target="_blank">IT-Facebook</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </body>
</html>
