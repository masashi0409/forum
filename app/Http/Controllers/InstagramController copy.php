<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstagramController extends Controller
{
    public function index ()
    {
        $baseUrl = "http://graph.instagram.com/me/media?";

        // アクセストークン
        $accessToken = "IGQVJVR3M4M1ZAqNkN0ZAlJiR3RpUTV3SkJhZAkVueG1xSzM0SEpGZAml0aGF6ZAF9mS2tvd1g5NlR0M3ZADSnFpWDB4QlMxNWRrY1lsUHdVQWNmQVRiZAGw5NnNqWWRydzY1dC1yUUt6M3Vn";

        // パラメータ設定
        // $params = [
        //     'fields' => implode(',', [
        //             'id',
        //             'caption',
        //             'permalink',
        //             'media_url',
        //             'thumbnail_url',
        //         ]),
        //     'access_token' => $accessToken
        // ];

        // curlセッション初期化
        $ch = curl_init();

        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // curl_setopt($ch, CURLOPT_URL, $baseUrl . http_build_query($params));

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
