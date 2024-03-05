<?php

namespace App\Http\Controllers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;


use Illuminate\Http\Request;

use App\Models\Group; // เพิ่มการ import

class GroupController extends Controller
{
    protected $group;

    public function __construct()
    {
        //some functions can only be executed by group admin/owner
        $this->middleware('owner')->only(['edit', 'update', 'delete', 'remove_user']);

        //the group will only be accessed by a member
        $this->middleware('member')->only('show');

        $this->group = new Group();
    }


    //display form to create a group
    public function create_form()
    {
        return view('group.create');
    }


    public function create(Request $request)
    {
        // กำหนดเงื่อนไขในการ validate ข้อมูลก่อนการสร้าง
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'master_id' => 'required'
        ]);
    
        //generate a code for the group
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($characters), rand(0, 9), 7);
    
        // Create the group using the MasterAdmins model
        $group = Group::create([
            'name' => $request->name,
            'code' => $code,
            'master_id' =>  $request->master_id
        ]);
    
        // ตรวจสอบว่าข้อมูลที่ส่งเข้ามาถูกต้องตามเงื่อนไขหรือไม่
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
       // สร้าง response ตอบกลับมาให้กับผู้ใช้
         return response()->json(['group' => $group], 201);
    }
    
    

    








    //display the form to join a group
    public function join_form()
    {
        return view('group.join');
    }

    //user join a group by entering the code
    public function join(Request $request)
    {
        $this->validate($request, [
            'code' => 'required'
        ]);

        $code = $request->code;

        $group = Group::where('code', $code)->first();

        //if the group exists
        if ($group)
        {
            try 
            {
                //we add the user to the group and we redirect him to the home page with a success message

                $group->participants()->attach(auth()->user()->id);

                return redirect('/home')->with('success', 'Group joined');
            } 
            catch (\Throwable $th) 
            {
                //Display an error if the user is already in the group
                return redirect()->back()->with('error', 'You are already a member of this group');
            }
        }
        else
        {
            //if the group doesn't exist we throw an error
            return redirect()->back()->with('error', 'Group not found');
        }
    }






    //show group page with messages
    public function show_group($id)
    {
        $group = Group::find($id);

        $messages = $group->messages()->get();

        return view('group.show', compact(['group', 'messages']));
    }




    //display the form to edit the name of a group
    public function edit($id)
    {
        $group = Group::find($id);

        return view('group.edit', compact('group'));
    }






    //change the name of the group
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $group = Group::find($id);

        $group->name = $request->name;

        $group->save();

        return redirect('/group/'. $id)->with('success', 'Group name has been changed');
    }



    //delete a groupe and remove every participant
    public function delete($id)
    {
        $group = Group::find($id);

        $group->participants()->detach();

        $group->delete();

        return redirect('/home')->with('success', 'Group has been deleted');
    }



    //display the members of a group, the admin can then decide who to remove
    public function members_list($id)
    {
        $group = Group::find($id);

        $group_members = $group->participants()->get();

        $group_id = $id;

        return view('group.members_list', compact(['group_members', 'group_id']));
    }





    //remove the user from a group
    public function remove_user($id, $user_id)
    {
        $group = Group::find($id);

        $group->participants()->detach($id);

        return redirect()->back()->with('success', 'A user has been removed');
    }
}


