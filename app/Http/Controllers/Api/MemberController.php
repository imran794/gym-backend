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

         if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $extension = $file->getClientOriginalExtension();
                $filename = time().".".$extension;
                $file->move('uploads/member/',$filename);
                $photo = $filename;

            }


          $member = Member::create([
              'member_id'     => uniqid(),
              'name'          => $request->name,
              'gender'        => $request->gender,
              'mobile'        => $request->mobile,
              'blood_group'   => $request->blood_group,
              'address'       => $request->address,
              'photo'         => $photo,
              'created_by'    => Auth::id()
           ]);

          


          $member->member_id = date('Y') . str_pad($member->id, 6, 0, STR_PAD_LEFT);
          $member->save();

          return success_response($member,__('message.member.create.success'));
            
        } catch (Exception $e) {
            return error_response(__('message.member.manage.not_found'));
        }
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
        $members =  Member::find($id);

        if ($members) {
            $validator = Validator::make($request->all(),[
            'name'         => 'required|max:50',
            'gender'       => 'required',
            'mobile'       => 'required|min:11|max:11|unique:members,' .$id,
            'blood_group'  => 'required',
            'address'      => 'required',
        ]);

        // if ($validator->fails()) {

        //     return response()->json([
        //         'success'   => false,
        //         'errors'    => $validator->errors()
        //     ]);
        // }

        try {

               if ($request->hasFile('photo')) {

                $image_path = 'uploads/member/'.$members->photo;

                  if (File::exists($image_path)) {
                  File::delete($image_path);
                }

                $file = $request->file('photo');
                $extension = $file->getClientOriginalExtension();
                $filename = time().".".$extension;
                $file->move('uploads/member/',$filename);
                $members->photo = $filename;

            }

             $members->name             = $request->name;
             $members->gender           = $request->gender;
             $members->mobile           = $request->mobile;
             $members->blood_group      = $request->blood_group;
             $members->address          = $request->address;
             $members->photo            = $request->photo;
             $members->member_id         = date('Y') . str_pad($members->id, 6, 0, STR_PAD_LEFT);
             $members->save();

          return success_response($member,__('message.member.create.update'));
            
        } catch (Exception $e) {
            return error_response(__('message.member.manage.not_found'));
        }

        }else{
               return error_response(__('message.member.manage.not_found')); 
        }
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
