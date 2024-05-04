<?php

namespace App\Http\Controllers;

use App\Models\FpAttendance;
use App\Models\FpUser;
use Illuminate\Http\Request;
use Rats\Zkteco\Lib\ZKTeco;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function finger_user()
    {

        $zk = new ZKTeco(env("IP_FINGERPRINT"));
        $zk->connect();

        foreach ($zk->getUser() as $user){
            FpUser::create($user);
        }
    }

    public function finger()
    {

    $zk = new ZKTeco('192.168.8.142');
    $zk = new ZKTeco(env("IP_FINGERPRINT"));
    $zk->connect();

    foreach ($zk->getAttendance() as $attendance){
        FpAttendance::create($attendance);
    }

       return json_encode($zk->getUser());
        return $zk->getAttendance();

    }

    public function attendancetest()
    {

        $data=FpAttendance::first();

        return $data;
    }
}
