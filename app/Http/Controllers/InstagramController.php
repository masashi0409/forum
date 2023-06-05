<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstagramController extends Controller
{
    public function index ()
    {
        $baseUrl = "http://graph.instagram.com/me/media?";

        // アクセストークン
        $accessToken = "IGQVJYa2ZAxMEc5MXBvaVNEV1ZAONzJ0X0t1eTcxZAjhKUjhleWxzSEtZATkY0dnkzTVRoZAXUwY3ZApYzJzYmt2MmpDVlBoNlhicXZA6UWRJNDFGTGpLUUFranZA1dHdwMmFWWTZAXWjhqREFHOGU4VThTWGxvaQZDZD";

        // curlセッション初期化
        $ch = curl_init();

        $url = "https://graph.instagram.com/me/media?fields=id%2Ccaption%2Cpermalink%2Cmedia_url%2Cthumbnail_url&access_token=" . $accessToken;


        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $responseText = curl_exec($ch);

        $result = json_decode($responseText, true);

        curl_close($ch);

        return view('instagram', [
            'mediaData' => $result['data'],
            'paging' => $result['paging']
        ]);
    }
}
