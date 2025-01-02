<x-sidebar>
  <div class="search_content w-100 d-flex">
    <div class="reserve_users_area">
      @foreach($users as $user)
      <div
        class="border one_person"
        style="width: 23%; height: 32%; background-color: #fff; border-radius:5px; box-shadow: 0px 0px 15px -5px #777777; margin: 7px; padding: 15px 15px 0px 15px;">
        <div style="font-weight: 600;">
          <span style="color: #b9bdc2;">ID : </span><span>{{ $user->id }}</span>
        </div>
        <div style="font-weight: 600;"><span style="color: #b9bdc2;">名前 : </span>
          <a href="{{ route('user.profile', ['id' => $user->id]) }}">
            <span style="color: #05aad2;">{{ $user->over_name }}</span>
            <span style="color: #05aad2;">{{ $user->under_name }}</span>
          </a>
        </div>
        <div style="font-weight: 600;">
          <span style="color: #b9bdc2;">カナ : </span>
          <span>({{ $user->over_name_kana }}</span>
          <span>{{ $user->under_name_kana }})</span>
        </div>
        <div style="font-weight: 600;">
          @if($user->sex == 1)
          <span style="color: #b9bdc2;">性別 : </span><span>男</span>
          @elseif($user->sex == 2)
          <span>性別 : </span><span>女</span>
          @else
          <span>性別 : </span><span>その他</span>
          @endif
        </div>
        <div style="font-weight: 600;">
          <span style="color: #b9bdc2;">生年月日 : </span><span>{{ $user->birth_day }}</span>
        </div>
        <div style="font-weight: 600;">
          @if($user->role == 1)
          <span style="color: #b9bdc2;">役職 : </span><span>教師(国語)</span>
          @elseif($user->role == 2)
          <span style="color: #b9bdc2;">役職 : </span><span>教師(数学)</span>
          @elseif($user->role == 3)
          <span style="color: #b9bdc2;">役職 : </span><span>講師(英語)</span>
          @else
          <span style="color: #b9bdc2;">役職 : </span><span>生徒</span>
          @endif
        </div>
        <div style="font-weight: 600;">
          @if($user->role == 4)
          <span style="color: #b9bdc2;">選択科目 :</span>
          @foreach($user->subjects as $subject)
          <span>{{ $subject->subject }}</span>
          @endforeach
          @endif
        </div>
      </div>
      @endforeach
    </div>


    <!-- サイドバー -->
    <div class="search_area w-25">
      <div class="">
        <div>
          <p style="margin-top: 60px; font-size: 18px; margin-bottom: 10px; color: #6b6868;">検索</p>
          <input
            type="text" class="free_word" name="keyword" placeholder="キーワードを検索" form="userSearchRequest"
            style="border: none; background-color: #dbdfe3; height: 40px; border-radius: 5px; padding: 10px; width: 80%; margin-bottom: 10px; font-size: 14px;">
        </div>
        <div>
          <div>
            <lavel style="color: #6b6868; font-size: 14px;">カテゴリ</lavel>
          </div>
          <select
            form="userSearchRequest" name="category"
            style="border: none; background-color: #dbdfe3; margin-bottom: 10px; padding: 7px 15px 7px 10px; border-radius: 5px; font-size: 14px;">
            <option value="name">名前</option>
            <option value="id">社員ID</option>
          </select>
        </div>
        <div>
          <div>
            <label style="margin-bottom: 0px; color: #6b6868; font-size: 14px;">並び替え</label>
          </div>
          <select
            form="userSearchRequest" name="updown"
            style="border: none; background-color: #dbdfe3; margin-bottom: 25px; padding: 7px 30px 7px 10px; border-radius: 5px; font-size: 14px;">
            <option value="ASC">昇順</option>
            <option value="DESC">降順</option>
          </select>
        </div>
        <div class="">
          <p class="m-0 search_conditions" style="color: #6b6868; font-size: 14px;"><span>検索条件の追加</span></p>
          <div class="search_conditions_inner">
            <div>
              <label style="color: #6b6868;">性別</label>
              <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
              <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
              <span>その他</span><input type="radio" name="sex" value="3" form="userSearchRequest">
            </div>
            <div>
              <label style="color: #6b6868;">権限</label>
              <select name="role" form="userSearchRequest" class="engineer">
                <option selected disabled>----</option>
                <option value="1">教師(国語)</option>
                <option value="2">教師(数学)</option>
                <option value="3">教師(英語)</option>
                <option value="4" class="">生徒</option>
              </select>
            </div>
            <div class="selected_engineer">
              <label style="color: #6b6868;">選択科目</label>
              @foreach($subjects as $subject)
              <div>
                <label>{{ $subject->subject }}</label>
                <input type="checkbox" name="subjects" value="{{ $subject->id }}" form="userSearchRequest">
              </div>
              @endforeach
            </div>
          </div>
        </div>
        <div>
          <input type="submit" name="search_btn" value="検索" form="userSearchRequest">
        </div>
        <div>
          <input type="reset" value="リセット" form="userSearchRequest">
        </div>
      </div>
      <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
    </div>
  </div>
</x-sidebar>
