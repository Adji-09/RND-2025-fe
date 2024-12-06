<?php

namespace App\Helpers;

use App\Models\Module;
use App\Models\LogActivity;
use App\Models\UsersRole;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

use Jenssegers\Agent\Facades\Agent;

class Helpers
{
    public static function getModule()
    {
        $module = null;

        if (Session::get('role_id') == 1) {
            $module = [
                'menu' => Module::where('module_parent', 0)
                    ->where('module_status', 1)
                    ->where('is_superadmin', 1)
                    ->orderBy('module_position', 'ASC')
                    ->get(),
            ];
        }

        return $module;
    }

    public static function login_as($id_role)
    {
        $login_as = UsersRole::where('id', $id_role)->first();

        Session::put('login_as', $login_as['role']);
    }

    public static function api($endPoint)
    {
        $endpoint = "http://localhost:8010/api/" . $endPoint;

        return $endpoint;
    }

    public static function url()
    {
        $url = "http://localhost:8010/";

        return $url;
    }

    public static function reqAuth($url, $array)
    {
        $client = new Client();

        try {
            $res = $client->request('POST', $url, [
                'form_params' => $array,
                'verify' => false
            ]);

            if ($res->getStatusCode() == 200) {
                return json_decode($res->getBody());
            } else {
                return response()->json(['status' => false, 'message' => 'Check Your Code !']);
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $res = $response->getBody()->getContents();

            return json_decode($res);
        }
    }

    public static function reqPost($url, $array)
    {
        $client = new Client();
        $access_token = Session::get('access_token');

        try {
            $res = $client->request('POST', $url, [
                'form_params' => $array,
                'headers' => [
                    'Authorization' => 'Bearer ' . $access_token,
                    'Accept' => 'application/json'
                ],
                'verify' => false
            ]);

            if ($res->getStatusCode() == 200) {
                return json_decode($res->getBody());
            } else {
                return response()->json(['status' => false, 'message' => 'Check Your Code !']);
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $res = $response->getBody()->getContents();

            return json_decode($res);
        }
    }

    public static function reqPostMultipart($url, $array)
    {
        $client = new Client();
        $access_token = Session::get('access_token');

        try {
            $res = $client->request('POST', $url, [
                'multipart' => $array,
                'headers' => [
                    'Authorization' => 'Bearer ' . $access_token,
                    'Accept' => 'application/json'
                ],
                'verify' => false
            ]);

            if ($res->getStatusCode() == 200) {
                return json_decode($res->getBody());
            } else {
                return response()->json(['status' => false, 'message' => 'Check Your Code !']);
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $res = $response->getBody()->getContents();

            return json_decode($res);
        }
    }

    public static function reqGet($url)
    {
        $client = new Client();
        $access_token = Session::get('access_token');

        try {
            $res = $client->request('GET', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $access_token,
                    'Accept' => 'application/json'
                ],
                'verify' => false
            ]);

            if ($res->getStatusCode() == 200) {
                return json_decode($res->getBody());
            } else {
                return response()->json(['status' => false, 'message' => 'Check Your Code !']);
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $res = $response->getBody()->getContents();

            return json_decode($res);
        }
    }

    public static function reqDelete($url)
    {
        $client = new Client();

        $access_token = Session::get('access_token');

        try {
            $res = $client->request('DELETE', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $access_token,
                    'Accept' => 'application/json'
                ],
                'verify' => false
            ]);

            if ($res->getStatusCode() == 200) {
                return json_decode($res->getBody());
            } else {
                return response()->json(['status' => false, 'message' => 'Check Your Code !']);
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $res = $response->getBody()->getContents();

            return json_decode($res);
        }
    }

    public static function logActivity($activity)
    {
        date_default_timezone_set("Asia/Jakarta");

        $browser = Agent::browser();
        $versionB = Agent::version($browser);

        $platform = Agent::platform();
        $versionP = Agent::version($platform);

        $data = new LogActivity();
        $data->id_user = Session::get('id');
        $data->activity = $activity;
        $data->browser = $browser . " " . $versionB;
        $data->platform = $platform . " " . $versionP;
        $data->ip_address = Request::getClientIp(true);
        $data->save();
    }

    public static function dayName($value)
    {
        switch ($value) {
            case "Sunday":
                $string = 'Sunday';
                break;
            case "Monday":
                $string = 'Monday';
                break;
            case "Tuesday":
                $string = 'Tuesday';
                break;
            case "Wednesday":
                $string = 'Wednesday';
                break;
            case "Thursday":
                $string = 'Thursday';
                break;
            case "Friday":
                $string = 'Friday';
                break;
            case "Saturday":
                $string = 'Saturday';
                break;

            default:
                $string = '-';
                break;
        }

        return $string;
    }

    public static function monthName($value)
    {
        switch ($value) {
            case "01":
                $string = 'January';
                break;
            case "02":
                $string = 'February';
                break;
            case "03":
                $string = 'March';
                break;
            case "04":
                $string = 'April';
                break;
            case "05":
                $string = 'May';
                break;
            case "06":
                $string = 'June';
                break;
            case "07":
                $string = 'July';
                break;
            case "08":
                $string = 'August';
                break;
            case "09":
                $string = 'September';
                break;
            case "10":
                $string = 'October';
                break;
            case "11":
                $string = 'November';
                break;
            case "12":
                $string = 'December';
                break;

            default:
                $string = '-';
                break;
        }

        return $string;
    }
}
