<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

//スクール予約画面のメソッドのグループ(まとまり)
class CalendarController extends Controller
{
    // カレンダー表示のためのメソッド
    public function show(){
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    // 予約のためのメソッド
    public function reserve(Request $request){
        DB::beginTransaction();
        try{
            $getPart = $request->getPart;
            $getDate = $request->getData;
            // dd($getDate, $getPart);
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            foreach($reserveDays as $key => $value){
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                $reserve_settings->decrement('limit_users');
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

    // 予約削除のためのメソッド
    public function deleteParts(Request $request){
        // dd($request);
        DB::beginTransaction();
        try {
            // フォームから送信された予約IDを取得
            // 'reserveId'フィールドを取得
            $reserveId = $request->input('reserveId');

            // 該当する予約設定を取得
            $reserveSettings = ReserveSettings::find($reserveId);

            // 該当する予約設定が見つからない場合
            if (!$reserveSettings) {
                return redirect()->route('calendar.general.show');
            }
            // reserve_setting_users テーブルからログインユーザーとの関連を削除
            $reserveSettings->users()->detach(Auth::id());

            // ReserveSettings テーブルの人数をインクリメント
            $reserveSettings->increment('limit_users');

            // トランザクションの確定
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }
}
