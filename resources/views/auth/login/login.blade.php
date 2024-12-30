<x-guest-layout>
  <form class="vh-100" action="{{ route('loginPost') }}" method="POST" style="background-color: #ecf1f5; min-height: 100vh;">
    <h1 class="pb-5" style="padding-top: 10rem; text-align: center;"><img src=" {{ asset('image/atlas-black.png') }}"></h1>
    <div class="w-100 d-flex" style="justify-content:center;">
      <div class="border w-25 user_status" style="background-color: #fff; box-shadow: 0px 0px 15px -5px #777777;">
        <div class="w-75 m-auto pt-5">
          <label class="d-block m-0" style="font-size:13px;">メールアドレス</label>
          <div class="border-bottom border-primary w-100">
            <input type="text" class="w-100 border-0" name="mail_address">
          </div>
        </div>
        <div class="w-75 m-auto pt-5">
          <label class="d-block m-0" style="font-size:13px;">パスワード</label>
          <div class="border-bottom border-primary w-100">
            <input type="password" class="w-100 border-0" name="password">
          </div>
        </div>
        <div class="text-right m-3">
          <input type="submit" class="btn btn-primary" value="ログイン">
        </div>
        <div class="text-center pb-5">
          <a href="{{ route('registerView') }}">新規登録はこちら</a>
        </div>
      </div>
      {{ csrf_field() }}
    </div>
  </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="{{ asset('js/register.js') }}" rel="stylesheet"></script>
</x-guest-layout>
