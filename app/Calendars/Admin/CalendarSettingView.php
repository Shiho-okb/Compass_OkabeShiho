<?php
namespace App\Calendars\Admin;
use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;

// スクール枠登録画面
class CalendarSettingView{
  private $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  // カレンダータイトル作成のためのメソッド
  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  // カレンダー作成のためのメソッド
  public function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table m-auto border">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th class="border">月</th>';
    $html[] = '<th class="border">火</th>';
    $html[] = '<th class="border">水</th>';
    $html[] = '<th class="border">木</th>';
    $html[] = '<th class="border">金</th>';
    $html[] = '<th class="day-sat border">土</th>';
    $html[] = '<th class="day-sun border">日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    // カレンダーに表示する「週」のデータを取得
    $weeks = $this->getWeeks();

    // 各週のループ処理
    foreach ($weeks as $week) {
      $html[] = '<tr class="' . $week->getClassName() . '">';
      // 各日のループ処理
      $days = $week->getDays();
      foreach ($days as $day) {
      // 日付の範囲を取得
        $startDay = $this->carbon->format("Y-m-01");
        $toDay = $this->carbon->format("Y-m-d");

        $isPastDay = $startDay <= $day->everyDay() && $toDay >= $day->everyDay();
        $isSaturday = \Carbon\Carbon::parse($day->everyDay())->isSaturday();
        $isSunday = \Carbon\Carbon::parse($day->everyDay())->isSunday();

        // 日付ごとのセル生成
        if ($isPastDay) {
          if ($isSaturday) {
            $html[] = '<td class="past-day border past-saturday">';
          } elseif ($isSunday) {
            $html[] = '<td class="past-day border past-sunday">';
          } else {
            $html[] = '<td class="past-day border">';
          }
        } else {
          $html[] = '<td class="border ' . $day->getClassName() . '">';
        }
        $html[] = $day->render();

        //カレンダーの日付ごとに予約状況を表示
        $html[] = '<div class="adjust-area">';
        // $startDay から $toDay までの範囲に $day->everyDay() が含まれているかを確認
        // 過去日や未来日を区別するための条件
        if ($day->everyDay()) {
          // 現在または過去の日付
          if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
            $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-30" style="height:20px;" name="reserve_day[' . $day->everyDay() . '][1]" type="text" form="reserveSetting" value="' . $day->onePartFrame($day->everyDay()) . '" disabled></p>';
            $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-30" style="height:20px;" name="reserve_day[' . $day->everyDay() . '][2]" type="text" form="reserveSetting" value="' . $day->twoPartFrame($day->everyDay()) . '" disabled></p>';
            $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-30" style="height:20px;" name="reserve_day[' . $day->everyDay() . '][3]" type="text" form="reserveSetting" value="' . $day->threePartFrame($day->everyDay()) . '" disabled></p>';
            // 未来の日付
          } else {
            $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-30" style="height:20px;" name="reserve_day[' . $day->everyDay() . '][1]" type="text" form="reserveSetting" value="' . $day->onePartFrame($day->everyDay()) . '"></p>';
            $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-30" style="height:20px;" name="reserve_day[' . $day->everyDay() . '][2]" type="text" form="reserveSetting" value="' . $day->twoPartFrame($day->everyDay()) . '"></p>';
            $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-30" style="height:20px;" name="reserve_day[' . $day->everyDay() . '][3]" type="text" form="reserveSetting" value="' . $day->threePartFrame($day->everyDay()) . '"></p>';
          }
        }
        $html[] = '</div>';
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }

    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="'.route('calendar.admin.update').'" method="post" id="reserveSetting">'.csrf_field().'</form>';
    return implode("", $html);
  }


  // カレンダーに表示する「週のデータ」計算のためのメソッド
  protected function getWeeks(){
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while($tmpDay->lte($lastDay)){
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
