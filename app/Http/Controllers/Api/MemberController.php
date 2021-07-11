<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Member;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $members = Member::all();
        return response()->json(['ok' => true, 'data' => $members], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $members = new Member();
        $members->name = $request->name;
        $members->dad_last_name = $request->dad_last_name;
        $members->mom_last_name = $request->mom_last_name;
        $members->dir_foto = $request->dir_foto;
        $members->ci = $request->ci;
        $members->phone = $request->phone;
        $members->birth_date = $request->birth_date;
        $members->enabled = $request->false;
        return response()->json(['ok' => true, 'message' => ' se creo exitosamente'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Member $member
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        try {
            $data = Member::FindOrFail($id);
            return response()->json(['ok' => true, 'data' => $data], 201);
        } catch (\Exception $e) {
            return response()->json(['ok' => false, 'message' => 'Member not found','error'=>$e],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Member $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Member $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        try {
            $members = Member::FindOrFail($id);
            $members->name = $request->name;
            $members->dad_last_name = $request->dad_last_name;
            $members->mom_last_name = $request->mom_last_name;
            $members->dir_foto = $request->dir_foto;
            $members->ci = $request->ci;
            $members->phone = $request->phone;
            $members->birth_date = $request->birth_date;
            $members->save();
            return response()->json(['ok' => true, 'message' => ' se actualizo exitosamanete'], 200);
        }catch (\Exception $e){
            return response()->json(['ok' => false, 'message' => 'Member not found!', 'error' => $e], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Member $member
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $member = Member::FindOrFail($id);
        if ($member) {
            $member->delete();
        } else {
            return response()->json(['ok' => false, 'message' => 'Error  no existe usuario.'], 409);
        }
        return response()->json(['ok' => true, 'message' => ' se elimino exitosamente'], 200);
    }
}
