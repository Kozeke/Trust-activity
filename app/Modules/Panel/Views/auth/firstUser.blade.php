@extends('Panel::layouts/auth')

@section('content')

 
<div class="login-section">
  <div class="mask rgba-black-strong"></div>

  <div class="card login-form reg-admin-form">
    <div class="card-body">
      <div class="form-header aqua-gradient rounded">
          <h3 class="my-3"><i class="fa fa-lock"></i> Добро пожаловать</h3>
      </div>
      <p>Создайте аккаунт администратора</p>
      <form method="POST" action="/auth/register"> 
        {{ csrf_field() }}
        <div class="md-form">
            <i class="fa fa-envelope prefix"></i>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
            <label for="email" >Адрес электронной почты</label>
        </div>
        <div class="md-form">
            <i class="fa fa-lock prefix"></i>
            <input type="password" id="password" name="password" class="form-control" value="">
            <label for="password" >Пароль</label>
        </div>  
        <div class="md-form">
            <i class="fa fa-lock prefix"></i>
            <input type="password" id="password-confirm" name="password_confirmation" class="form-control" value="">
            <label for="password-confirm" >Повторите пароль</label>
        </div>  
        <div class="text-center mt-4">
            <button class="btn aqua-gradient waves-effect waves-light" type="submit">Войти</button>
        </div>
      </form>      
    </div>


  </div>

</div>








 
@endsection

 