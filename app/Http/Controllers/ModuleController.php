<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ModuleController extends Controller
{
    private $title = "Module Management";

    public function index()
    {
        $url = Helpers::api('module/getAll');
        $res = Helpers::reqGet($url);

        if ($res->status == true) {
            $data['title'] = $this->title;
            $data['li'] = "";
            $data['datas'] = $res->data;

            return view('module_management.index', $data);
        } else if ($res->status == false) {
            return redirect('logout');
        }
    }

    public function getById($id)
    {
        $url = Helpers::api('module/getById/'.$id);
        $res = Helpers::reqGet($url);

        if ($res->status == true) {
            $data['title'] = $this->title;
            $data['li'] = "Edit Module Permissions";
            $data['datas'] = $res->data;

            return view('module_management.edit', $data);
        } else {
            return null;
        }
    }

    public function update(Request $request)
    {
        $url = Helpers::api('module/update');

        $param = [
            'id' => $request->module_id,
            'is_superadmin' => ($request->is_superadmin != null ? 1 : 2),
            'module_status' => $request->module_status
        ];

        $res = Helpers::reqPost($url, $param);

        if ($res->status == true) {
            // Helpers::logActivity('Ubah hak akses menu berhasil');
            return redirect('/module')->with('success', $res->message);
        } else {
            // Helpers::logActivity('Ubah hak akses menu gagal');
            return redirect('/module')->with('error', $res->message);
        }
    }
}
