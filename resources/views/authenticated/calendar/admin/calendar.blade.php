<!-- スクール予約確認画面 -->

<style>
  .table tr {
    text-align: center;
  }

  .table p {
    margin-bottom: 0 !important;
  }
</style>

<x-sidebar>
  <div class="pt-5 pb-5 d-flex" style="background:#ECF1F6;">
    <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF; box-shadow: 0px 0px 15px -5px #777777;">
      <div class="w-75 m-auto" style="border-radius:5px;">
        <!-- カレンダータイトル -->
        <p class="text-center">{{ $calendar->getTitle() }}</p>
        <!-- カレンダー表示 -->
        <div class="">
          {!! $calendar->render() !!}
        </div>
      </div>
    </div>
  </div>

</x-sidebar>
