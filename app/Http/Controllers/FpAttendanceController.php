<?php

namespace App\Http\Controllers;

use App\DataTables\FpAttendanceDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateFpAttendanceRequest;
use App\Http\Requests\UpdateFpAttendanceRequest;
use App\Jobs\SaveAttendance;
use App\Models\FpAttendance;
use App\Models\FpUser;
use App\Repositories\FpAttendanceRepository;
use Carbon\Carbon;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\DB;
use Rats\Zkteco\Lib\ZKTeco;
use Response;

class FpAttendanceController extends AppBaseController
{
    /** @var  FpAttendanceRepository */
    private $fpAttendanceRepository;

    public function __construct(FpAttendanceRepository $fpAttendanceRepo)
    {
        $this->fpAttendanceRepository = $fpAttendanceRepo;
    }

    /**
     * Display a listing of the FpAttendance.
     *
     * @param FpAttendanceDataTable $fpAttendanceDataTable
     * @return Response
     */
    public function index(FpAttendanceDataTable $fpAttendanceDataTable)
    {
        return $fpAttendanceDataTable->render('fp_attendances.index');
    }

    /**
     * Show the form for creating a new FpAttendance.
     *
     * @return Response
     */
    public function create()
    {
        $fpUsers=FpUser::pluck('name','id');
        return view('fp_attendances.create',compact('fpUsers'));
    }

    /**
     * Store a newly created FpAttendance in storage.
     *
     * @param CreateFpAttendanceRequest $request
     *
     * @return Response
     */
    public function store(CreateFpAttendanceRequest $request)
    {
        $input = $request->all();

        $fpAttendance = $this->fpAttendanceRepository->create($input);

        Flash::success('Fp Attendance saved successfully.');

        return redirect(route('fpAttendances.index'));
    }

    public function apiabsen(CreateFpAttendanceRequest $request)
    {
        //dd(Carbon::now());
        $nip = $request->only('nip');
        $userfp=FpUser::where('userid',$nip)->first();
        if(!empty($userfp)){
            $fpAttendance = $this->fpAttendanceRepository->create([
                'id'=>$userfp->id,
                'timestamp'=>Carbon::now(),
                'type'=>0
            ]);

            return $fpAttendance;
        }else{
            return 'gagal';
        }
    }

    /**
     * Display the specified FpAttendance.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $fpAttendance = $this->fpAttendanceRepository->find($id);

        if (empty($fpAttendance)) {
            Flash::error('Fp Attendance not found');

            return redirect(route('fpAttendances.index'));
        }

        return view('fp_attendances.show')->with('fpAttendance', $fpAttendance);
    }

    /**
     * Show the form for editing the specified FpAttendance.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $fpAttendance = $this->fpAttendanceRepository->find($id);

        if (empty($fpAttendance)) {
            Flash::error('Fp Attendance not found');

            return redirect(route('fpAttendances.index'));
        }

        return view('fp_attendances.edit')->with('fpAttendance', $fpAttendance);
    }

    /**
     * Update the specified FpAttendance in storage.
     *
     * @param  int              $id
     * @param UpdateFpAttendanceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFpAttendanceRequest $request)
    {
        $fpAttendance = $this->fpAttendanceRepository->find($id);

        if (empty($fpAttendance)) {
            Flash::error('Fp Attendance not found');

            return redirect(route('fpAttendances.index'));
        }

        $fpAttendance = $this->fpAttendanceRepository->update($request->all(), $id);

        Flash::success('Fp Attendance updated successfully.');

        return redirect(route('fpAttendances.index'));
    }

    /**
     * Remove the specified FpAttendance from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $fpAttendance = $this->fpAttendanceRepository->find($id);

        if (empty($fpAttendance)) {
            Flash::error('Fp Attendance not found');

            return redirect(route('fpAttendances.index'));
        }

        $this->fpAttendanceRepository->delete($id);

        Flash::success('Fp Attendance deleted successfully.');

        return redirect(route('fpAttendances.index'));
    }

    public function fpAttendances_sync()
    {
        //Mesin2
        $zk2 = new ZKTeco(env("IP_FINGERPRINT_SECONDARY"));

        if(!$zk2->connect()){
            Flash::error('Koneksi dengan alat bermasalah (mesin2)');
            return redirect(route('fpAttendances.index'));
        }

        DB::transaction(function () use($zk2){
            foreach (array_chunk($zk2->getAttendance(),100) as $t)
            {
                foreach ($t as $key=>$k)
                {
                    if(empty(FpUser::where('id',$k['id'])->first())){
                        unset($t[$key]);
                    }
                }
                dispatch(new SaveAttendance($t,'mesin2'));

                collect($t)->each(function (array $row) {
                    $fp = FpAttendance::firstOrCreate(
                        ['uid' => $row['uid'],'mesin'=>'mesin2','timestamp' => $row['timestamp']],
                        ['id' => $row['id'],'timestamp' => $row['timestamp'],'type' => $row['type'],'state' => $row['state']]
                    );
                });
            }
            $zk2->clearAttendance();
        });

        /*$t=array(array('nama'=>'eko'),array('nama'=>'dadang'),array('nama'=>'anton'));
        foreach ($t as $key=>&$k)
        {
            $k['mesin'] = 'mesin1';
            if(($k['nama']==='eko')){
                unset($t[$key]);
            }
        }

        dd($t);*/
        $zk = new ZKTeco(env("IP_FINGERPRINT"));

        if(!$zk->connect()){
            Flash::error('Koneksi dengan alat bermasalah.');
            return redirect(route('fpAttendances.index'));
        }
/*
        foreach ($zk->getAttendance() as $attendance){
            FpAttendance::create($attendance);
        }*/

        /*DB::transaction(function () use($zk){

        });*/
        //dd($zk->getAttendance());

        DB::transaction(function () use($zk){
        foreach (array_chunk($zk->getAttendance(),100) as $t)
        {
            /*foreach ($t as &$k)
            {
                $k['mesin'] = 'mesin1';
            }*/

            /*foreach ($t as $key=>$k)
            {
                if(empty(FpUser::where('id',$k['id'])->first())){
                    unset($t[$key]);
                }
            }*/
            dispatch(new SaveAttendance($t,'mesin1'));
            /*collect($t)->each(function (array $row) {
                $fp = FpAttendance::firstOrCreate(
                    ['uid' => $row['uid'],'mesin'=>'mesin1','timestamp' => $row['timestamp']],
                    ['id' => $row['id'],'timestamp' => $row['timestamp'],'type' => $row['type'],'state' => $row['state']]
                );
            });*/

            /*FpAttendance::upsert($t,
                [
                    'uid',
                    'mesin'
                ],
                [
                    'id',
                    'timestamp',
                    'type',
                    'state',
                ]
            );*/
        }
            //$zk->clearAttendance();
        });




        Flash::success('Fp Attendance Sync successfully.');
        return redirect(route('fpAttendances.index'));
    }

    public function fpAttendances_sync_clear()
    {
        //Mesin2
        $zk2 = new ZKTeco(env("IP_FINGERPRINT_SECONDARY"));

        if(!$zk2->connect()){
            Flash::error('Koneksi dengan alat bermasalah (mesin2)');
            return redirect(route('fpAttendances.index'));
        }

        DB::transaction(function () use($zk2){
            foreach (array_chunk($zk2->getAttendance(),100) as $t)
            {
                /*foreach ($t as $key=>$k)
                {
                    if(empty(FpUser::where('id',$k['id'])->first())){
                        unset($t[$key]);
                    }
                }*/
                dispatch(new SaveAttendance($t,'mesin2'));

                /*collect($t)->each(function (array $row) {
                    $fp = FpAttendance::firstOrCreate(
                        ['uid' => $row['uid'],'mesin'=>'mesin2','timestamp' => $row['timestamp']],
                        ['id' => $row['id'],'timestamp' => $row['timestamp'],'type' => $row['type'],'state' => $row['state']]
                    );
                });*/
            }
            $zk2->clearAttendance();
        });

        /*$t=array(array('nama'=>'eko'),array('nama'=>'dadang'),array('nama'=>'anton'));
        foreach ($t as $key=>&$k)
        {
            $k['mesin'] = 'mesin1';
            if(($k['nama']==='eko')){
                unset($t[$key]);
            }
        }

        dd($t);*/
        $zk = new ZKTeco(env("IP_FINGERPRINT"));

        if(!$zk->connect()){
            Flash::error('Koneksi dengan alat bermasalah.');
            return redirect(route('fpAttendances.index'));
        }
        /*
                foreach ($zk->getAttendance() as $attendance){
                    FpAttendance::create($attendance);
                }*/

        /*DB::transaction(function () use($zk){

        });*/
        //dd($zk->getAttendance());

        DB::transaction(function () use($zk){
            foreach (array_chunk($zk->getAttendance(),100) as $t)
            {
                /*foreach ($t as &$k)
                {
                    $k['mesin'] = 'mesin1';
                }*/

                /*foreach ($t as $key=>$k)
                {
                    if(empty(FpUser::where('id',$k['id'])->first())){
                        unset($t[$key]);
                    }
                }*/
                dispatch(new SaveAttendance($t,'mesin1'));
                /*collect($t)->each(function (array $row) {
                    $fp = FpAttendance::firstOrCreate(
                        ['uid' => $row['uid'],'mesin'=>'mesin1','timestamp' => $row['timestamp']],
                        ['id' => $row['id'],'timestamp' => $row['timestamp'],'type' => $row['type'],'state' => $row['state']]
                    );
                });*/

                /*FpAttendance::upsert($t,
                    [
                        'uid',
                        'mesin'
                    ],
                    [
                        'id',
                        'timestamp',
                        'type',
                        'state',
                    ]
                );*/
            }
            $zk->clearAttendance();
        });




        Flash::success('Fp Attendance Sync successfully.');
        return redirect(route('fpAttendances.index'));
    }
}
