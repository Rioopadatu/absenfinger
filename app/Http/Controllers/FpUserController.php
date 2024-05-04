<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFpUserRequest;
use App\Http\Requests\UpdateFpUserRequest;
use App\Models\FpUser;
use App\Repositories\FpUserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
use Rats\Zkteco\Lib\ZKTeco;
use Response;

class FpUserController extends AppBaseController
{
    /** @var  FpUserRepository */
    private $fpUserRepository;

    public function __construct(FpUserRepository $fpUserRepo)
    {
        $this->fpUserRepository = $fpUserRepo;
    }

    /**
     * Display a listing of the FpUser.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $fpUsers = $this->fpUserRepository->all();

        return view('fp_users.index')
            ->with('fpUsers', $fpUsers);
    }

    /**
     * Show the form for creating a new FpUser.
     *
     * @return Response
     */
    public function create()
    {
        return view('fp_users.create');
    }

    /**
     * Store a newly created FpUser in storage.
     *
     * @param CreateFpUserRequest $request
     *
     * @return Response
     */
    public function store(CreateFpUserRequest $request)
    {
        $input = $request->all();

        $fpUser = $this->fpUserRepository->create($input);

        Flash::success('Fp User saved successfully.');

        return redirect(route('fpUsers.index'));
    }

    /**
     * Display the specified FpUser.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $fpUser = $this->fpUserRepository->find($id);

        if (empty($fpUser)) {
            Flash::error('Fp User not found');

            return redirect(route('fpUsers.index'));
        }

        return view('fp_users.show')->with('fpUser', $fpUser);
    }

    /**
     * Show the form for editing the specified FpUser.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $fpUser = $this->fpUserRepository->find($id);

        if (empty($fpUser)) {
            Flash::error('Fp User not found');

            return redirect(route('fpUsers.index'));
        }

        return view('fp_users.edit')->with('fpUser', $fpUser);
    }

    /**
     * Update the specified FpUser in storage.
     *
     * @param int $id
     * @param UpdateFpUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFpUserRequest $request)
    {
        $fpUser = $this->fpUserRepository->find($id);

        if (empty($fpUser)) {
            Flash::error('Fp User not found');

            return redirect(route('fpUsers.index'));
        }

        $fpUser = $this->fpUserRepository->update($request->all(), $id);

        Flash::success('Fp User updated successfully.');

        return redirect(route('fpUsers.index'));
    }

    /**
     * Remove the specified FpUser from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $fpUser = $this->fpUserRepository->find($id);

        if (empty($fpUser)) {
            Flash::error('Fp User not found');

            return redirect(route('fpUsers.index'));
        }

        $this->fpUserRepository->delete($id);

        Flash::success('Fp User deleted successfully.');

        return redirect(route('fpUsers.index'));
    }

    public function fpuser_sync(){
        $zk = new ZKTeco(env("IP_FINGERPRINT"));

        if(!$zk->connect()){
            Flash::error('Koneksi dengan alat bermasalah.');
            return redirect(route('fpUsers.index'));
        }


        //return $zk->getUser();
        DB::transaction(function () use($zk){
            $users=[];
            foreach ($zk->getUser() as $user){
                $user['id']=substr($user['userid'],0,9);
                array_push($users,$user);
            }

            FpUser::upsert($users,[
                'uid',
                'id',
                'userid',
                'name',
                'role',
                'password',
                'cardno'
            ],['name','id']);
        });


        Flash::success('Fp User Sync successfully.');
        return redirect(route('fpUsers.index'));
    }

    public function fpuser_sync_test(){
        $zk = new ZKTeco(env("IP_FINGERPRINT"));
        $zk->connect();

        /*foreach ($zk->getUser() as $user){
            $user['id']=substr($user['userid'],0,9);

        }*/
        DB::transaction(function () use($zk){
            FpUser::upsert($zk->getUser(),[
                'uid',
                'id',
                'userid',
                'name',
                'role',
                'password',
                'cardno'
            ],['name']);
        });


        Flash::success('Fp User Sync successfully.');
        return redirect(route('fpUsers.index'));
    }
}
