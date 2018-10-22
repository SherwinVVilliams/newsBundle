<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 18.04.2017
 * Time: 13:04
 */

namespace App\Http\Controllers\System;


use App\Http\Controllers\AppController;
use App\Mail\Handle;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HandleController extends AppController {


	public function index(Request $request) {
		if(env('APP_DEBUG')) return response()->json(true); //For Debug

		$subject = 'Запрос '.$_POST['art_post_pagetitle'];
		$content = '';

		$summary = '';
		$summary .= $request->input('name') ? $request->input('name')[1].' ' : '';
		$summary .= $request->input('email') ? $request->input('email')[1].' ' : '';

		$client   = new Client();
		$response = $client->post('https://art-sites.atlassian.net/rest/api/2/issue', [
			'headers'  => ['Content-Type' => 'application/json'],
			'auth' => [
				env('JIRA_USERNAME'),
				env('JIRA_PASSWORD')
			],
			'json' => [
				"fields" => [
					'project'     => [
						"key" => "LT"
					],
					"summary" => $summary,
					"description" => Handle::contentMakerText($request->all()),
					"issuetype"   => [
						"name" => "Lead"
					]
				]

			]
		]);


		if (\Auth::check()) {
			$user    = \Auth::user();
			$content .= "<tr>\n<td align='right'>ID Пользователя и Имя</td><td>:</td><td>".$user->id.' | '.$user->name.' '.$user->last_name."</td>\n</tr>";
		}
		$content = Handle::contentMakerHTML($request->all(), $content);

		$this->arTeam($request->all());

		\Mail::to(\C::val('mail_to'))->send(new Handle($subject, $content));

		return response()->json(true);
	}

	private function arTeam($i) {
		$data = [];
		if (isset($i["name"])) {
			$data["name"] = $i["name"][1];
		}
		if (isset($i["phone"])) {
			$data["phone"] = $i["phone"][1];
		}
		if (isset($i["email"])) {
			$data["email"] = $i["email"][1];
		}

		$params = [
			"key"  => "IcC3Rz48Y3cwF4fv8Zen1a54qxRQir",
			"data" => json_encode($data)
		];

		return $this->get_web_page('http://team.art-sites.org/lead/remote/add', "POST", http_build_query($params));
	}

	private function get_web_page($url, $method = "GET", $data = '') {
		$user_agent = 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
		if ($method == "GET") {
			$POST = false;
		} else {
			$POST = true;
		}

		$options = array(
			CURLOPT_CUSTOMREQUEST  => $method,        //set request type post or get
			CURLOPT_POST           => $POST,        //set to GET
			CURLOPT_POSTFIELDS     => $data,
			CURLOPT_USERAGENT      => $user_agent, //set user agent
			CURLOPT_RETURNTRANSFER => true,     // return web page
			CURLOPT_HEADER         => false,    // don't return headers
			CURLOPT_FOLLOWLOCATION => true,     // follow redirects
			CURLOPT_ENCODING       => "",       // handle all encodings
			CURLOPT_AUTOREFERER    => true,     // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
			CURLOPT_TIMEOUT        => 120,      // timeout on response
			CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
		);

		$ch = curl_init($url);
		curl_setopt_array($ch, $options);
		$content = curl_exec($ch);
		$err     = curl_errno($ch);
		$errmsg  = curl_error($ch);
		$header  = curl_getinfo($ch);
		curl_close($ch);

		$header['errno']   = $err;
		$header['errmsg']  = $errmsg;
		$header['content'] = $content;

		return $header;
	}


}