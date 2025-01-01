<x-sidebar>
  <div class="vh-100 border" style="padding: 10px;">
    <span style="margin-left: 0.5rem; margin-right: 0.5rem;">{{ $user->over_name }}</span><span>{{ $user->under_name }}さんのプロフィール</span>
    <div class="top_area w-75 m-auto pt-5">
      <div class="user_status p-3" style="box-shadow: 0px 0px 15px -5px #777777;">
        <p>名前 : <span>{{ $user->over_name }}</span><span class="ml-1">{{ $user->under_name }}</span></p>
        <p>カナ : <span>{{ $user->over_name_kana }}</span><span class="ml-1">{{ $user->under_name_kana }}</span></p>
        <p>性別 : @if($user->sex == 1)<span>男</span>@else<span>女</span>@endif</p>
        <p>生年月日 : <span>{{ $user->birth_day }}</span></p>
        <div style="margin-bottom: 15px;">選択科目 :
          @foreach($user->subjects as $subject)
          <span>{{ $subject->subject }}</span>
          @endforeach
        </div>
        <div class="">
          @can('admin')
          <span class="subject_edit_btn" style="font-size:16px; color: #05aad2; margin-right: 15px;">選択科目の登録</span>
          <!-- 矢印アイコン -->
          <span class="accordion-button"></span>
          <div class="subject_inner">
            <form action="{{ route('user.edit') }}" method="post" style="display: flex; align-items: center;">
              @foreach($subjects as $subject)
              <div>
                <label style="margin-top: 0.5rem;">{{ $subject->subject }}</label>
                <input style="margin-right: 10px;" type="checkbox" name="subjects[]" value="{{ $subject->id }}">
              </div>
              @endforeach
              <input type="submit" value="登録" class="btn btn-primary">
              <input type="hidden" name="user_id" value="{{ $user->id }}">
              {{ csrf_field() }}
            </form>
          </div>
          @endcan
        </div>
      </div>
    </div>
  </div>

</x-sidebar>
