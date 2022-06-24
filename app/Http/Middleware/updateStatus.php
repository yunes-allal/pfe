<?php

namespace App\Http\Middleware;

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
            if($session->status == 'declaring' && now() >= $session->start_date){
                    DB::table('sessions')->where('id', $session->id)->update(['status' => 'inscription']);
            }else{
                if($session->status == 'inscription' && now() > $session->end_date){
                    DB::table('sessions')->where('id', $session->id)->update(['status' => 'conformity']);
                }else {
                    if($session->status == 'conformity' && now() >= Commission::min('start_date')){
                        DB::table('sessions')->where('id', $session->id)->update(['status' => 'interview']);
                    }else{
                        if($session->status == 'interview' && now() >= Commission::min('start_date') && Note::where('entretien_1',NULL)->count()==0){
                            DB::table('sessions')->where('id', $session->id)->update(['status' => 'sc_works_validation']);
                        }
                    }
                }
            }
        }
        return $next($request);
    }
}
