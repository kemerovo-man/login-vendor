<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script
            src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .form-horizontal .form-group {
            margin-left: 0;
            margin-right: 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row" style="margin-top: 100px;">
        <div class="col-sm-8 col-sm-offset-2">
            {!! Form::open(['method' => 'POST', 'url' => '/' . config('login.loginRoute', 'login'), 'class'=>'form-horizontal'])!!}
            @if(isset($errors))
                @foreach($errors->all() as $error)
                    <div class="col-sm-offset-2 col-sm-10">
                        <p class="text-danger">{!! $error !!}</p>
                    </div>
                @endforeach
            @endif
            <div class="form-group">
                {!! Form::label('login', 'Логин') !!}
                {!! Form::text('login', '', ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('password', 'Пароль') !!}
                {!! Form::password('password', ['class'=>'form-control']) !!}
            </div>
            <input type="hidden" name="redirect_to" value="{{$redirectTo}}">
            {{ csrf_field() }}
            {!! Form::submit('Войти', ['class'=>'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>

</body>
</html>
