<!-- スクール枠登録画面 -->

<style>
  .w-30 {
    width: 30% !important;
  }

  .table tr {
    text-align: center;
  }

  .table p {
    margin-bottom: 0 !important;
  }
</style>

<x-sidebar>
  <div class="pt-5 pb-5" style="background:#ECF1F6;">
    <div class="border w-75 m-auto pt-5 pb-4" style="border-radius:5px; background:#FFF; box-shadow: 0px 0px 15px -5px #777777;">
      <div class="m-auto w-75" style="border-radius:5px;">
        <!-- カレンダータイトル -->
        <p class="text-center">{{ $calendar->getTitle() }}</p>
        <!-- カレンダー表示 -->
        <div class="">
          {!! $calendar->render() !!}
        </div>
      </div>
      <div class="w-75 text-right" style="margin: 1.5rem auto 0rem">
        <input type="submit" class="btn btn-primary" value="登録" form="reserveSetting" onclick="return confirm('登録してよろしいですか？')">
      </div>
    </div>
  </div>

</x-sidebar>
