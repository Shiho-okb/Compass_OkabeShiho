<?php
namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

// スクール予約画面
class CalendarView{

  private $carbon;
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  // カレンダータイトル作成のためのメソッド
  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  // カレンダー作成のためのメソッド
  function render()
  {
    //カレンダー全体の基本構造
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th>土</th>';
    $html[] = '<th>日</th>';
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
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");

        // 日付ごとのセル生成
        // 現在または過去の日付
        if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
          $html[] = '<td class="past-day calendar-td">';
          $html[] = $day->render();
          $html[] = $day->getDate();

          // 過去日の予約状態を表示
          if (in_array($day->everyDay(), $day->authReserveDay())) {
            $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
            if ($reservePart == 1) {
              $reservePart = "1部";
            } else if ($reservePart == 2) {
              $reservePart = "2部";
            } else if ($reservePart == 3) {
              $reservePart = "3部";
            }
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">' . $reservePart . '参加</p>';
          } else {
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">受付終了</p>';
          }

        // 未来の日付
        } else {
          $html[] = '<td class="calendar-td ' . $day->getClassName() . '">';
          $html[] = $day->render();
          $html[] = $day->getDate();

          // 未来日の予約枠選択
          if (in_array($day->everyDay(), $day->authReserveDay())) {
            $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
            if ($reservePart == 1) {
              $reservePart = "リモ1部";
            } else if ($reservePart == 2) {
              $reservePart = "リモ2部";
            } else if ($reservePart == 3) {
              $reservePart = "リモ3部";
            }
            $html[] = '<button type="submit" class="btn btn-danger p-0 w-75" name="delete_date" style="font-size:12px" value="' . $day->authReserveDate($day->everyDay())->first()->setting_reserve . '">' . $reservePart . '</button>';
          } else {
            $html[] = $day->selectPart($day->everyDay());
          }
        }
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }

    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">' . csrf_field() . '</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">' . csrf_field() . '</form>';

    return implode('', $html);
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
