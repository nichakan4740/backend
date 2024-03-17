<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    protected $admin;

    public function __construct()
    {
        $this->admin = new Admin();
    }


    /*** list รายชื่อทั้งหมด.*/
    public function indexuser()
    {
        $data = $this->admin->all();
        if ($data->isEmpty()) {
            return response()->json(['message' => 'ไม่มีข้อมูล'], 200);
        }
        return $data;
    }

    /** * list ชื่อตาม id */
    public function showuserwithid(string $id)
    {
        $admin = $this->admin->find($id);
        if (!$admin) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return $admin;
    }
    


    /** * ลบ */
    public function destroyuser(string $id)
    {
        $admin = $this->admin->find($id);
        if (!$admin) {
            throw ValidationException::withMessages(['message' => 'Mysugar not found']);
        }
        $admin->delete();
        return response()->json(['message' => 'Mysugar deleted successfully']);
    }


    /* edituser */
    public function updateuser(Request $request, string $id)
    {
        $admin = $this-> admin->find($id);
        $admin->update($request->all());
        return  $admin;
    }
}
