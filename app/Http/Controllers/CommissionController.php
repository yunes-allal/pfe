<?php

namespace App\Http\Controllers;

use App\Mail\CommissionAccount;
use App\Models\Commission;
use App\Models\Session;
use App\Models\Note;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CommissionController extends Controller
{
    public function index()
    {
        if(Commission::count()){
        return view('SDP.commissions.index')->with('commissions', Commission::all());
        }
        else{
            return redirect()->route('index')->with('info', 'Vous n\'avez déclaré aucun besoin');
        }
    }

    public function generatePassword()
    {
        $lowercase = range('a','z');
        $uppercase = range('A','Z');
        $digits = range(0,9);
        $special = ['!', '@', '#', '$', '%', '*'];
        $chars = array_merge($lowercase, $uppercase, $digits, $special);
        $length = 10;

        do {
            $password = array();

            for ($i=0; $i <= $length ; $i++) {
                $index = rand(0, count($chars)-1);
                array_push($password, $chars[$index]);
            }
        } while (empty(array_intersect($special, $password)));
        return implode('', $password);
    }

    public function createCommissions(){
        $accounts = DB::table('departments')->join('besoins','departments.id','=','besoins.department_id')
                                ->groupBy('departments.id')
                                ->select('departments.id','departments.name')
                                ->get();
        //create 'commissions' as users

        foreach ($accounts as $account){
            $email = strtolower($account->name).'@department';
            $password = $this->generatePassword();
                User::create([
                'name' => $account->name.' department',
                'email' => $email,
                'password' => Hash::make($password),
                'type' => 'commission',
                'created_at' => now(),
                'updated_at' => now()
            ]);
                Commission::create([
                    'department_id' => $account->id,
                    'email' => $email,
                    'password' => $password,
                ]);
        }
        return redirect()->route('critères.index')->with('success', 'Les commissions sont créés avec succès');
    }

    public function updateState()
    {
        foreach (Commission::all() as $item) {
            Commission::where('email', $item->email)->update([
                'start_date' => NULL,
                'end_date' => NULL
            ]);
        }
        if(Session::where('status','interview')->count()){
            foreach (Commission::all() as $item) {
                $password = $this->generatePassword();
                User::where('email',$item->email)->update([
                    'password' => Hash::make($password),
                    'updated_at' => now()
                ]);
                Commission::where('email', $item->email)->update([
                    'start_date' => NULL,
                    'end_date' => NULL,
                    'password' => $password,
                    'sent_to' => NULL,
                ]);
            }
        }
        return redirect()->route('commission.mail')->with('info', 'vous devez spécifier la date de début et la date de fin');
    }
    public function resendAccounts(Request $request)
    {
        $password = $this->generatePassword();
        User::where('email',$request->email)->update([
            'password' => Hash::make($password),
            'updated_at' => now()
        ]);
        Commission::where('email', $request->email)->update([
            'password' => $password,
            'sent_to' => NULL,
            'start_date' => NULL,
            'end_date' => NULL
        ]);
        return redirect()->route('commission.index');
    }
    public function sendAccounts(Request $data)
    {
        $data->validate([
            'start_date' => 'required|date',
            'periode' => 'required|numeric',
            'email' => 'required|email'
        ]);

        DB::table('commissions')
            ->where('email', '=', $data->email_dep)
            ->update([
                'start_date' => $data->start_date,
                'end_date' => Carbon::createFromDate($data->start_date)->addDays($data->periode),
                'sent_to' => $data->email,
            ]);

        Mail::to($data->email)->send(new CommissionAccount($data));
        return redirect()->route('commission.index')->with('success', 'Email envoyée');
    }


    public function getCandidates()
    {
        if(Session::where('status','conformity')->count()){
            $commission = Commission::where('email', Auth::user()->email)->select('start_date')->first();
            if(now() < $commission->start_date){
                return redirect()->route('home')->with('info', 'Attendez s\'il vous plaît jusqu\'au jour du début de votre processus');
            }else{
                return view('commission.conformite.candidates');
            }
        }else{
            if(Session::where('status','interview')->count()){
                $commission = Commission::where('email', Auth::user()->email)->select('start_date')->first();
                if(now() < $commission->start_date){
                    return redirect()->route('home')->with('info', 'Attendez s\'il vous plaît jusqu\'au jour du début de votre processus');
                }else{
                    return view('commission.entretien.candidates');
                }
            }else{
                if(Session::where('status','sc_works_validation')->count()){
                    return view('commission.scientifique.candidates');
                }
            }
        }
    }

    public function conformed(Request $request)
    {
        DB::table('dossiers')->where('user_id', $request->user_id)->update(['is_conformed' => $request->decision]);
        if($request->decision=="1"){
            Note::create([
                'dossier_id' => $request->dossier_id,
            ]);
            Message::create([
                'user_id' => Auth::id(),
                'subject' => 'conforme',
                'body' => 'Félicitations, votre dossier a été approuvé avec succès. Attendez juste la date d\'entretien.#Suivez votre inbox!',
                'sent_to' => $request->user_id,
            ]);
        }else{
            Message::create([
                'user_id' => Auth::id(),
                'subject' => 'non-conforme',
                'body' => 'Malheureusement, votre dossier a été rejeté par la commission de conformité.#La raison: '.$request->decision,
                'sent_to' => $request->user_id
            ]);
        }
        return redirect()->back();
    }
}
