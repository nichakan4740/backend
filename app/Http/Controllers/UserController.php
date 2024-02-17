<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }


    /*** list รายชื่อทั้งหมด.*/
    public function indexuser()
    {
        $data = $this->user->all();
        if ($data->isEmpty()) {
            return response()->json(['message' => 'ไม่มีข้อมูล'], 200);
        }
        return $data;
    }

    /** * list ชื่อตาม id */
    public function showuserwithid(string $id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return $user;
    }
    


    /** * ลบ */
    public function destroyuser(string $id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            throw ValidationException::withMessages(['message' => 'Mysugar not found']);
        }
        $user->delete();
        return response()->json(['message' => 'Mysugar deleted successfully']);
    }


    /* edituser */
    public function updateuser(Request $request, string $id)
    {
        $user = $this-> user->find($id);
        $user->update($request->all());
        return  $user;
    }
}
