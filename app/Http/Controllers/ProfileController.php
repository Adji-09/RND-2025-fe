<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    private $title = 'Profile';

    public function index()
    {
        $url = Helpers::api('profile/'.Session::get('id'));
        $res = Helpers::reqGet($url);

        $url_face = Helpers::api('list_face/'.Session::get('id'));
        $res_face = Helpers::reqGet($url_face);

        if ($res->status == true) {
            $data['title'] = $this->title;
            $data['datas'] = $res->data;
            $data['faces'] = $res_face->data;

            return view('profile.index', $data);
        } else if ($res->status == false) {
            return redirect('logout');
        }
    }

    public function change_profile(Request $request)
    {
        $file = request('foto');

        $url = Helpers::api('change_profile');

        if ($file != "") {
            $file_uploaded_name = $file->getClientOriginalName('');
            $file_mime = $file->getClientMimeType();
            $file_path = $file->getPathName();

            $param = [
                [
                    'name'      => 'id',
                    'contents'  => $request->id,
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
                    'name'      => 'foto',
                    'filename'  => $file_uploaded_name,
                    'mime-type' => $file_mime,
                    'contents'  => fopen($file_path, 'r'),
                ]
            ];
        } else {
            $param = [
                [
                    'name'      => 'id',
                    'contents'  => $request->id,
                ],
                [
                    'name'      => 'username',
                    'contents'  => $request->username,
                ],
                [
                    'name'      => 'email',
                    'contents'  => $request->email,
                ]
            ];
        }

        $res = Helpers::reqPostMultipart($url, $param);

        if ($res->status == true) {
            $url_profile = Helpers::api('profile/'.Session::get('id'));
            $res_profile = Helpers::reqGet($url_profile);

            $request->session()->regenerate();
            Session::put('username', $res_profile->data[0]->username);
            Session::put('email', $res_profile->data[0]->email);
            Session::put('foto', $res_profile->data[0]->foto);

            // Helpers::logActivity('Change profile success');
            return redirect('/profile')->with('success', $res->message);
        } else {
            // Helpers::logActivity('Change profile failed');
            return redirect('/profile')->with('error', $res->message);
        }
    }

    public function change_password(Request $request)
    {
        $url = Helpers::api('change_password');

        $param = [
            'id' => $request->id,
            'current_password' => $request->current_password,
            'new_password' => $request->new_password,
            'confirm_password' => $request->confirm_password
        ];

        $res = Helpers::reqPost($url, $param);

        if ($res->status == true) {
            // Helpers::logActivity('Change Password successfully');
            return redirect('/profile')->with('success_password', $res->message);
        } else {
            // Helpers::logActivity('Change Password failed');
            return redirect('/profile')->with('error', $res->message);
        }
    }

    public function face_enroll(Request $request)
    {
        $url = Helpers::api('face_enroll');

        $param = [
            'user_id' => Session::get('id'),
            'image_id' => $request->image_id
        ];

        $res = Helpers::reqPost($url, $param);

        if ($res->status == true) {
            // Helpers::logActivity('Edit User data successfully');
            return redirect('/profile')->with('success', $res->message);
        } else {
            // Helpers::logActivity('Edit User data failed');
            return redirect('/profile')->with('error', $res->message);
        }
    }

    public function remove_face($id)
    {
        $url = Helpers::api('remove_face/'.$id);
        $res = Helpers::reqDelete($url);

        if ($res->status == true) {
            // Helpers::logActivity('Hapus data Jenis Kasus berhasil');
            return redirect('/profile')->with('success', $res->message);
        } else {
            // Helpers::logActivity('Hapus data Jenis Kasus gagal');
            return redirect('/profile')->with('error', $res->message);
        }
    }
}
