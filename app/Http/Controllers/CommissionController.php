<?php

namespace App\Http\Controllers;

use App\Mail\Commission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CommissionController extends Controller
{
    public function index()
    {
        $commissions = DB::table('users')->where('type','=','commission')
                                ->get();
        return view('SDP.commissions.index')->with('commissions', $commissions);
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
                                ->select('departments.name')
                                ->get();

        //create 'commissions' as users

        foreach ($accounts as $account){
                User::create([
                'name' => $account->name.' department',
                'email' => 'dep.'.strtolower($account->name),
                'password' => $this->generatePassword(),
                'type' => 'commission',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        return redirect()->route('index')->with('success-commission', 'Les commissions sont crees avec success');
    }

    public function sendAccounts(Request $data)
    {
        Mail::to($data->email)->send(new Commission($data));
        return back()->with('success', 'Email envoyee avec success');
    }
}
