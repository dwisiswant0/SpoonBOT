<?php
namespace dwisiswant0;

class SpoonBOT {
	public function __construct($token) {
		$this->token = $token;
		$this->host  = "spooncast.net";
		$this->api   = "id-api." . $this->host;
	}

	private function parseJson($string) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}

	private function request($id = null, $endpoint, $data = null) {
		$endpoint = preg_replace("/%/", $id, "https://" . $this->api . $endpoint);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $endpoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		$headers = array();
		$headers[] = "Host: {$this->api}";
		$headers[] = "Connection: close";
		$headers[] = "Content-Length: " . strlen($data);
		$headers[] = "Pragma: no-cache";
		$headers[] = "Cache-Control: no-cache";
		$headers[] = "Accept: application/json";
		$headers[] = "Dnt: 1";
		$headers[] = "Authorization: Token {$this->token}";
		$headers[] = "User-Agent: Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_7; rv:24.0) Gecko/20100101 Firefox/24.0";
		$headers[] = "Origin: https://www.{$this->host}";
		$headers[] = "Sec-Fetch-Site: same-site";
		$headers[] = "Sec-Fetch-Mode: cors";
		$headers[] = "Referer: https://www.{$this->host}/";
		$headers[] = "Accept-Language: id,en-US;q=0.9,en;q=0.8";
		$headers[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		if ($data !== null) curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			exit("Error:" . curl_error($ch));
		}
		curl_close($ch);
		$parsed = $this->parseJson($result);

		return ($parsed ? json_decode($result, 1) : false);
	}

	public function follow($id) {
		return $this->request($id, "/users/%/follow/");
	}

	public function unfollow($id) {
		return $this->request($id, "/users/%/unfollow/");
	}

	public function block($id) {
		return $this->request($id, "/users/%/block/");
	}

	public function unblock($id) {
		return $this->request($id, "/users/%/unblock/");
	}

	public function report($id) {
		return $this->request($id, "/users/%/report/");
	}

	public function impression($id, $impress_id) {
		return $this->request($id, "/users/%/impression/", array("new_impression_ids" => 11));
	}

	public function join($id) {
		return $this->request($id, "/lives/%/join/");
	}

	public function leave($id) {
		return $this->request($id, "/lives/%/leave/");
	}

	public function like($id) {
		return $this->request($id, "/lives/%/like/");
	}

	public function play($id) {
		return $this->request($id, "/casts/%/play/");
	}
}