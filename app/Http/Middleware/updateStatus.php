<?php

namespace App\Http\Middleware;

use App\Models\Besoin;
use Closure;
use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\Note;
use App\Models\Commission;
use Illuminate\Support\Facades\DB;

class updateStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($session = Session::where('status','!=', 'off')->first()){
            $besoin = Besoin::where('session_id', $session->id)->sum('positions_number');
            if($session->status == 'declaring' && now() >= $session->start_date && $session->global_number==$besoin && Commission::count()){
                    DB::table('sessions')->where('id', $session->id)->update(['status' => 'inscription']);
            }else{
                if($session->status == 'inscription' && now() >= $session->end_date){
                    DB::table('sessions')->where('id', $session->id)->update(['status' => 'conformity']);
                }else {
                    if($session->status == 'conformity' && Commission::max('end_date') && now() >= Commission::max('end_date')){
                        DB::table('sessions')->where('id', $session->id)->update(['status' => 'interview']);
                    }else{
                        if($session->status == 'interview' && now() >= Commission::max('end_date') && Note::where('entretien_1',NULL)->count()==0){
                            app('App\Http\Controllers\CommissionController')->updateState();
                            DB::table('sessions')->where('id', $session->id)->update(['status' => 'sc_works_validation']);
                        }else{
                            if($session->status == 'sc_works_validation' && now() >= Commission::max('end_date') && Note::where('ts_1',NULL)->count()==0){
                                app('App\Http\Controllers\CommissionController')->updateState();
                                DB::table('sessions')->where('id', $session->id)->update(['status' => 'deliberation']);
                            }
                        }
                    }
                }
            }
        }
        return $next($request);
    }
}
