<!-- スクール予約確認画面 -->
<x-sidebar>
<div class="w-75 m-auto">
  <div class="w-100">
    <!-- カレンダータイトル -->
    <p>{{ $calendar->getTitle() }}</p>
    <!-- カレンダー表示 -->
    <p>{!! $calendar->render() !!}</p>
  </div>
</div>
</x-sidebar>
