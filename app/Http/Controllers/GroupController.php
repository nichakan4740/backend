<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Group; 

class GroupController extends Controller
{



    # GroupController.php

    public function store()
    {
        $group = Group::create(['name' => request('name')]);

        $users = collect(request('users'));
        $users->push(auth()->user()->id);

        $group->users()->attach($users);

        /* เพิ่มเข้ามา */
        broadcast(new GroupCreated($group))->toOthers();

        return $group;
    }

}
