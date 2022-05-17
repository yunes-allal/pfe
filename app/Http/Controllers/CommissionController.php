<?php

namespace App\Http\Controllers;

use App\Mail\CommissionAccount;
use App\Models\Commission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CommissionController extends Controller
{
    public function index()
    {
        if(Commission::count()){
          $commissions = DB::table('commissions')->where('sent_to', '=', NULL)->get();
        return view('SDP.commissions.index')->with('commissions', $commissions);
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
        $length = 8;

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
        return redirect()->route('criteres.index')->with('success', 'Les commissions sont crees avec success');
    }

    public function sendAccounts(Request $data)
    {

        DB::table('commissions')
            ->where('email', '=', $data->email_dep)
            ->update(['sent_to' => $data->email]);

        Mail::to($data->email)->send(new CommissionAccount($data));
        return redirect()->route('commission.index')->with('success', 'Email envoyee avec success');
    }
}
