<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    private $title = "Users Management";

    public function index()
    {
        $url = Helpers::api('user/getAll');
        $res = Helpers::reqGet($url);

        if ($res->status == true) {
            $data['title'] = $this->title;
            $data['li'] = "";
            $data['datas'] = $res->data;

            return view('user.index', $data);
        } else {
            return null;
        }
    }

    public function create()
    {
        $url = Helpers::api('user/getRoleByStatus');
        $res = Helpers::reqGet($url);

        if ($res->status == true) {
            $data['title'] = $this->title;
            $data['li'] = "Add User";
            $data['datas'] = $res->data;

            return view('user.create', $data);
        } else {
            return null;
        }
    }

    public function store(Request $request)
    {
        $file = request('foto');

        $url = Helpers::api('user/store');

        if ($file != "")
        {
            $file_path = $file->getPathName();
            $file_mime = $file->getClientMimeType();
            $file_uploaded_name = $file->getClientOriginalName('');

            $param = [
                [
                    'name'      => 'foto',
                    'filename'  => $file_uploaded_name,
                    'mime-type' => $file_mime,
                    'contents'  => fopen($file_path, 'r'),
                ],
                [
                    'name'      => 'username',
                    'contents'  => $request->username,
                ],
                [
                    'name'      => 'email',
                    'contents'  => $request->email,
                ],
                [
                    'name'      => 'password',
                    'contents'  => $request->password,
                ],
                [
                    'name'      => 'confirm_password',
                    'contents'  => $request->confirm_password,
                ],
                [
                    'name'      => 'role_id',
                    'contents'  => $request->role_id,
                ],
                [
                    'name'      => 'status',
                    'contents'  => 1,
                ]
            ];
        } else {
            $param = [
                [
                    'name'      => 'username',
                    'contents'  => $request->username,
                ],
                [
                    'name'      => 'email',
                    'contents'  => $request->email,
                ],
                [
                    'name'      => 'password',
                    'contents'  => $request->password,
                ],
                [
                    'name'      => 'confirm_password',
                    'contents'  => $request->confirm_password,
                ],
                [
                    'name'      => 'role_id',
                    'contents'  => $request->role_id,
                ],
                [
                    'name'      => 'status',
                    'contents'  => 1,
                ]
            ];
        }

        $res = Helpers::reqPostMultipart($url, $param);

        if ($res->status == 200) {
            // Helpers::logActivity('Save User data successfully');
            return redirect('/user')->with('success', $res->message);
        } else {
            // Helpers::logActivity('Save User data failed');
            return redirect('/user')->with('error', $res->message);
        }
    }

    public function getById($id)
    {
        $url = Helpers::api('user/getById/'.$id);
        $res = Helpers::reqGet($url);

        if ($res->status == true) {
            $data['title'] = $this->title;
            $data['li'] = "Edit User";
            $data['datas'] = $res->data;

            return view('user.edit', $data);
        } else {
            return null;
        }
    }

    public function update(Request $request)
    {
        $url = Helpers::api('user/update');

        $param = [
            'id' => $request->id,
            'role_id' => $request->role_id,
            'status_user' => $request->status_user
        ];

        $res = Helpers::reqPost($url, $param);

        if ($res->status == true) {
            // Helpers::logActivity('Edit User data successfully');
            return redirect('/user')->with('success', $res->message);
        } else {
            // Helpers::logActivity('Edit User data failed');
            return redirect('/user')->with('error', $res->message);
        }
    }

    public function destroy($id)
    {
        $url = Helpers::api('user/destroy/'.$id);
        $res = Helpers::reqDelete($url);

        if ($res->status == true) {
            // Helpers::logActivity('Delete User data successfully');
            return redirect('/user')->with('success', $res->message);
        } else {
            // Helpers::logActivity('Delete User data failed');
            return redirect('/user')->with('error', $res->message);
        }
    }
}
