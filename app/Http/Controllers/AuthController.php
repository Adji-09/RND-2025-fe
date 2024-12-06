<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

use Exception;

class AuthController extends Controller
{
    private $title = 'Login';

    public function tutorial()
    {
        if (Session::has('access_token')) {
            return redirect()->back();
        }

        $data['title'] = $this->title;

        return view('auth.tutorial_demo', $data);
    }

    public function webcam()
    {
        if (Session::has('access_token')) {
            return redirect()->back();
        }

        $data['title'] = $this->title;

        return view('auth.webcam_demo', $data);
    }

    public function index()
    {
        if (Session::has('access_token')) {
            return redirect()->back();
        }

        $data['title'] = $this->title;

        return view('auth.login', $data);
    }

    public function face()
    {
        if (Session::has('access_token')) {
            return redirect()->back();
        }

        $data['title'] = $this->title;

        return view('auth.login_face', $data);
    }

    public function loginPost(Request $request)
    {
        $url = Helpers::api('login');

        $request->validate([
            'username' => 'required',
            'password' => 'required',
            // 'geetest_challenge' => 'required|geetest',
            // 'geetest' => config('geetest.server_fail_alert')
        ]);

        $param = [
            'username' => $request->username,
            'password' => $request->password
        ];

        $res = Helpers::reqAuth($url, $param);

        if ($res->status == true) {
            $request->session()->regenerate();
            Session::put('id', $res->data->id);
            Session::put('username', $res->data->username);
            Session::put('email', $res->data->email);
            Session::put('foto', $res->data->foto);
            Session::put('role_id', $res->data->role_id);
            Session::put('role', $res->data->role);
            Session::put('status', $res->data->status);
            Session::put('access_token', $res->headers->access_token);

            Helpers::login_as($res->data->role_id);
            // Helpers::logActivity('Login');

            $url_tema = Helpers::api('theme/getByUserId/'.$res->data->id);
            $res_tema = Helpers::reqGet($url_tema);

            Session::put('title_apps', $res_tema->data->title_apps);
            Session::put('title_header', $res_tema->data->title_header);
            Session::put('subtitle_header', $res_tema->data->subtitle_header);
            Session::put('title_footer', $res_tema->data->title_footer);
            Session::put('data_layout_mode', $res_tema->data->data_layout_mode);
            Session::put('data_topbar', $res_tema->data->data_topbar);
            Session::put('data_sidebar', $res_tema->data->data_sidebar);

            return redirect()->route('dashboard');
        } else {
            return redirect('login')->with('error', $res->message);
        }
    }

    public function loginPostFace(Request $request)
    {
        if ($request->status == true) {
            $request->session()->regenerate();
            Session::put('id', $request->id);
            Session::put('username', $request->username);
            Session::put('email', $request->email);
            Session::put('foto', $request->foto);
            Session::put('role_id', $request->role_id);
            Session::put('role', $request->role);
            Session::put('status', $request->status_user);
            Session::put('access_token', $request->access_token);

            Helpers::login_as($request->role_id);
            // Helpers::logActivity('Login');

            return redirect()->route('dashboard');
        } else {
            return redirect('login/face')->with('error', $request->message);
        }
    }

    public function logout()
    {
        try {
            $url = Helpers::api('logout');

            $param = [
                'username' => Session::get('username')
            ];

            $result = Helpers::reqPost($url, $param);

            // Helpers::logActivity('Logout');

            if ($result->status == true) {
                Session::flush();
                return redirect('login');
            } else {
                Session::flush();
                return redirect('login');
            }
        } catch (Exception $e) {
            Session::flush();
            return redirect('login');
        }
    }
}
