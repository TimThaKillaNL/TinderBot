<?php
	
	// GET request
	function GetRequest($url, $headers)
	{
		$ch = curl_init();
		
		curl_setopt_array(
			$ch,
			array(
				CURLOPT_URL => $url,
				CURLOPT_HTTPHEADER => $headers,
				CURLOPT_HEADER => 0,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_RETURNTRANSFER => true
			)
		);
		
		return curl_exec($ch);
	}
	
	// POST request
	function PostRequest($url, $headers, $array)
	{
		$ch = curl_init();
		
		curl_setopt_array(
			$ch,
			array(
				CURLOPT_URL => $url,
				CURLOPT_HTTPHEADER => $headers,
				CURLOPT_HEADER => 0,
				CURLOPT_POSTFIELDS => json_encode($array),
				CURLOPT_RETURNTRANSFER => true
			)
		);
		
		return curl_exec($ch);
	}
	
?>