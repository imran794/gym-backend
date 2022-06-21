<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Validator;
use Auth;
use Storage;


class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::with('user')->select( 'member_id','name','gender','mobile','blood_group','address','photo','start_date','end_date','lock','card_no','created_by','status')->paginate(10);

        return success_response($members,'Member Get Success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'         => 'required|max:50',
            'gender'       => 'required',
            'mobile'       => 'required|min:11|max:11|unique:members',
            'blood_group'  => 'required',
            'address'      => 'required',
            'photo'        => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
        'success'   => false,
        'errors'    => $validator->errors()
          ]);
        }

        try {

            $photo = $this->image_upload($request->phote, 'members');

          $member = Member::create([
              'member_id'     => uniqid(),
              'name'          => $request->name,
              'gender'        => $request->gender,
              'mobile'        => $request->mobile,
              'blood_group'   => $request->blood_group,
              'address'       => $request->address,
              'photo'         => $photo['path'],
              'created_by'    => Auth::id()
           ]);

          $member->member_id = date('Y') . str_pad($member->id, 6, 0, STR_PAD_LEFT);
          $member->save();

          return success_response($member,__('message.member.create.success'));
            
        } catch (Exception $e) {
            return error_response(__('message.member.manage.not_found'));
        }
    }

    public function image_upload($image, $dir)
    {
        $file       = explode(';base64,', $image);
        $file1      = explode('/', $file[0]);
        $exten      = end($file1);
        $file_name  =  uniqid().date('-Ymd-his'). $exten;
        $image_data = str_replace(',','', $file[1]);

        Storage::disk('public')->put($dir . "/" . $file_name, base64_decode($image_data));

        return  [
            'name' => $file_name,
            'path' => Storage::disk('public')->url($dir . "/" . $file_name)
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $members =  Member::with('user')->find($id);
        return $members ? success_response($members) : error_response(__("message.member.manage.not_found"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member =  Member::find($id);

        if ($member) {
           $member->delete();
           return success_response([],__('message.member.manage.deleted'));
        }
        else{
          return error_response(__("message.member.manage.not_found"));
        }
    }
}
