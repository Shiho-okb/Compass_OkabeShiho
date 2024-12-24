<?php
namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;

// スクール予約確認画面の部品
class CalendarWeekDay{
  protected $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  function getClassName(){
    return "day-" . strtolower($this->carbon->format("D"));
  }

  function render(){
    return '<p class="day">' . $this->carbon->format("j") . '日</p>';
  }

  function everyDay(){
    return $this->carbon->format("Y-m-d");
  }


  function dayPartCounts($ymd)
  {
    $html = [];

    $one_part_count = ReserveSettings::where('setting_reserve', $ymd)
      ->where('setting_part', '1')
      ->withCount('users') // users リレーションをカウント
      ->pluck('users_count')
      ->sum();

    $two_part_count = ReserveSettings::where('setting_reserve', $ymd)
    ->where('setting_part', '2')
    ->withCount('users') // users リレーションをカウント
    ->pluck('users_count')
    ->sum();

    $three_part_count = ReserveSettings::where('setting_reserve', $ymd)
    ->where('setting_part', '3')
    ->withCount('users') // users リレーションをカウント
    ->pluck('users_count')
    ->sum();

    $html[] = '<div class="text-left">';

    // 1部のリンクと予約人数
    $html[] = '<div>';
    $html[] = '<a href="' . route('calendar.admin.detail', ['date' => $ymd, 'part' => 1]) . '" class="day_part m-0 pt-1"> 1部 </a>';
    $html[] = '<span class="day_part m-0 pt-1">' . $one_part_count . '</span>';
    $html[] = '</div>';

    // 2部のリンクと予約人数
    $html[] = '<div>';
    $html[] = '<a href="' . route('calendar.admin.detail', ['date' => $ymd, 'part' => 2]) . '" class="day_part m-0 pt-1"> 2部 </a>';
    $html[] = '<span class="day_part m-0 pt-1">' . $two_part_count . '</span>';
    $html[] = '</div>';

    // 3部のリンクと予約人数
    $html[] = '<div>';
    $html[] = '<a href="' . route('calendar.admin.detail', ['date' => $ymd, 'part' => 3]) . '" class="day_part m-0 pt-1"> 3部 </a>';
    $html[] = '<span class="day_part m-0 pt-1">' . $three_part_count . '</span>';
    $html[] = '</div>';

    $html[] = '</div>';
    return implode("", $html);
  }


  function onePartFrame($day){
    $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first();
    if($one_part_frame){
      $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first()->limit_users;
    }else{
      $one_part_frame = "20";
    }
    return $one_part_frame;
  }
  function twoPartFrame($day){
    $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
    if($two_part_frame){
      $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first()->limit_users;
    }else{
      $two_part_frame = "20";
    }
    return $two_part_frame;
  }
  function threePartFrame($day){
    $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
    if($three_part_frame){
      $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first()->limit_users;
    }else{
      $three_part_frame = "20";
    }
    return $three_part_frame;
  }

  //
  function dayNumberAdjustment(){
    $html = [];
    $html[] = '<div class="adjust-area">';
    $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>';
    $html[] = '</div>';
    return implode('', $html);
  }
}
