<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\FpIzinDataTable;
use App\Http\Requests\CreateFpIzinRequest;
use App\Http\Requests\UpdateFpIzinRequest;
use Auth;
use App\Repositories\FpIzinRepository;
use App\Models\FpIzin;
use App\Models\FpUser;
use Carbon\Carbon;
use Flash;

class FpIzinController extends Controller
{
    private $FpIzinRepository;
    public function __construct(FpIzinRepository $FpIzinRepository)
    {
        $this->fpIzinRepository = $FpIzinRepository;
    }
    public function index(FpIzinDataTable $FpIzinDataTable)
    {
        return $FpIzinDataTable->render('fp_izin.index');
    }

    public function create()
    {
        $user_id = Auth::user()->id;

        $Fpusers = FpUser::where('uid', $user_id)->first();
        $fpIzin_role = FpIzin::where('fp_user_uid', $Fpusers->userid)->first();

        return view('fp_izin.create', compact('Fpusers','fpIzin_role','user_id'));
    }

    public function store(CreateFpIzinRequest $request)
    {
        $input = $request->all();
        $fpIzin = $this->fpIzinRepository->create($input);
        // Flash message and redirect
        Flash::success('Fp Izin saved successfully.');
        return redirect(route('fpIzins.index'));
    }

    public function show($uid)
    {
        $fpIzin = $this->fpIzinRepository->find($uid);
        $carbon = Carbon::setLocale('id');

        $tanggal_mulai = Carbon::parse($fpIzin->tanggal_mulai)->translatedFormat('l, j F Y');
        $tanggal_berakhir = Carbon::parse($fpIzin->tanggal_berakhir)->translatedFormat('l, j F Y');

        return view('fp_izin.show', compact('fpIzin', 'tanggal_mulai', 'tanggal_berakhir'));
    }
    public function edit($id)
    {
        $fpIzin = $this->fpIzinRepository->find($id);
        $user_id = Auth::user()->id;
        $Fpusers = FpUser::where('uid', $user_id)->first();
        // $fpIzin_role = FpIzin::where('fp_user_uid', $Fpusers->userid)->first();

        return view('fp_izin.edit', compact('fpIzin','Fpusers'));
    }

    public function update(UpdateFpIzinRequest $request, $uid)
    {
        $fpIzin = $this->fpIzinRepository->update($request->all(),$uid);


        Flash::message('Izin Update successfully');
        return redirect(route('fpIzins.index'));
    }
    public function destroy($uid)
    {
        $fpIzin = $this->fpIzinRepository->find($uid);
        $fpIzin->delete();
        Flash::success('Fp Izin deleted successfully.');
        return redirect(route('fpIzins.index'));
    }
}
