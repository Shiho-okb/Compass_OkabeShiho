<!-- スクール予約画面 -->
<x-sidebar>
  <div class="vh-100 pt-5" style="background:#ECF1F6;">
    <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
      <div class="w-75 m-auto border" style="border-radius:5px;">
        <!-- カレンダータイトル -->
        <p class="text-center">{{ $calendar->getTitle() }}</p>
        <!-- カレンダー表示 -->
        <div class="">
          {!! $calendar->render() !!}
        </div>
      </div>
      <div class="text-right w-75 m-auto">
        <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
      </div>
    </div>
  </div>

  <!-- モーダルの中身をここに記載 -->
  <!-- 予約削除 -->
  <div class="modal js-modal" style="display: none;">
    <div class="modal__bg js-modal-close"></div>
    <div class="modal__content">
      <form method="POST" action="{{ route('deleteParts') }}">
        @csrf
        <input type="hidden" id="modal-reserve-id" name="reserveId" value="">
        <p>予約日：<span id="reserve-date"></span></p>
        <p>時間：<span id="reserve-part"></span></p>
        <p>上記の予約をキャンセルしてもよろしいですか？</p>
        <div class="d-flex justify-content-between mt-3">
          <button type="button" class="btn btn-secondary js-modal-close">閉じる</button>
          <button type="submit" class="btn btn-danger">削除</button>
        </div>
      </form>
    </div>
  </div>
  <!-- モーダルの中身をここに記載 -->
</x-sidebar>
