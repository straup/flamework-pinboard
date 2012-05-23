<?php

	loadlib("http");

	#################################################################

	$GLOBALS['pinboard_api_endpoint'] = 'https://api.pinboard.in/v1/';

	#################################################################

	function pinboard_api_call($method, $args=array(), $more=array()){

		$endpoint  = $GLOBALS['pinboard_api_endpoint'];

		$auth = array();

		if (isset($more['username'])){
			$auth[] = $more['username'];
		}

		if (isset($more['password'])){
			$auth[] = $more['password'];
		}

		if (count($auth) == 2){

			$auth = implode(":", $auth);
			$endpoint = preg_replace("/api.pinboard.in/", "{$auth}@api.pinboard.in", $endpoint );
		}

		$args['format'] = 'json';
		$query = "?" . http_build_query($args);

		$url = $endpoint . $method . $query;

		$rsp = http_get($url, $more);

		if (! $rsp['ok']){
			return $rsp;
		}

		if (preg_match('/<result code="([^"]+)"/', $rsp['body'], $m)){
			return ($m[1] == 'done') ? okay() : not_okay($m[1]);
		}

		# FIX ME: pinboard appears to be returning bunk JSON?

		$data = json_decode($rsp['body'], 'as hash');

		if (! $data){
			return not_okay('failed to decode JSON');
		}

		return okay(array(
			'rsp' => $data
		));
	}

	#################################################################
?>
