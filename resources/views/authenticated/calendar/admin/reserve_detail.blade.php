  <!-- スクール予約詳細画面 -->
  <x-sidebar>
    <div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
      <div class="w-75 m-auto">
        <p>
          <!-- Carbon::parse = $dateが日付形式の文字列であれば、Carbonのparseメソッドを使って日付オブジェクトに変換する-->
          <span>{{ \Carbon\Carbon::parse($date)->format('Y年m月d日') }}</span>
          <span class="ml-3">{{ $part }}部</span>
        </p>
        <div class="" style="background-color: #fff; padding: 5px; box-shadow: 0px 0px 15px -5px #777777; border-radius: 5px; margin-bottom: 350px;">
          <table class="detail" style="width: 100%;">
            <tr class="text-center" style="color: #fff; background-color: #05aad2;">
              <th class="" style="border: none;">ID</th>
              <th class="" style="border: none;">名前</th>
              <th class="" style="border: none;">場所</th>
            </tr>
            <tbody>
              <!-- 予約データに紐づくユーザー情報を表示 -->
              @foreach($reservePersons as $reserve)
              @foreach($reserve->users as $user)
              <tr class="text-center" style="height: 35px;">
                <td class="" style="border: none;">{{ $user->id }}</td>
                <td class="" style="border: none;">{{ $user->over_name }} {{ $user->under_name }}</td>
                <td class="" style="border: none;">リモート</td>
              </tr>
              @endforeach
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </x-sidebar>
