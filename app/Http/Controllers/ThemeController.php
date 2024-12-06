<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

class ThemeController extends Controller
{
    private $title = "Theme Management";

    public function index()
    {
        $url = Helpers::api('theme/getByUserId/'.Session::get('id'));
        $res = Helpers::reqGet($url);

        if ($res->status == true) {
            $data['title'] = $this->title;
            $data['li'] = "";
            $data['datas'] = $res->data;

            return view('theme_management.index', $data);
        } else if ($res->status == false) {
            return redirect('logout');
        }
    }

    public function update(Request $request)
    {
        $url = Helpers::api('theme/update');

        $param = [
            'user_id' => Session::get('id'),
            'title_apps' => $request->title_apps,
            'title_header' => $request->title_header,
            'subtitle_header' => $request->subtitle_header,
            'title_footer' => $request->title_footer,
            'data_layout_mode' => $request->data_layout_mode,
            'data_topbar' => $request->data_topbar,
            'data_sidebar' => $request->data_sidebar
        ];

        $res = Helpers::reqPost($url, $param);

        if ($res->status == true) {
            $url_tema = Helpers::api('theme/getByUserId/'.Session::get('id'));
            $res_tema = Helpers::reqGet($url_tema);

            $request->session()->regenerate();
            Session::put('title_apps', $res_tema->data->title_apps);
            Session::put('title_header', $res_tema->data->title_header);
            Session::put('subtitle_header', $res_tema->data->subtitle_header);
            Session::put('title_footer', $res_tema->data->title_footer);
            Session::put('data_layout_mode', $res_tema->data->data_layout_mode);
            Session::put('data_topbar', $res_tema->data->data_topbar);
            Session::put('data_sidebar', $res_tema->data->data_sidebar);

            // Helpers::logActivity('Ubah Tema Aplikasi berhasil');
            return redirect('/theme')->with('success', $res->message);
        } else {
            // Helpers::logActivity('Ubah Tema Aplikasi gagal');
            return redirect('/theme')->with('error', $res->message);
        }
    }
}
