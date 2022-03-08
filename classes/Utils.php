<?php
class Utils
{
	public $result;
	/**
	 *
	 * @param $str
	 * @return mixed
	 */
	private static function wordLetterPairs ($str)
	{
    	$allPairs = array();
		// Tokenize the string and put the tokens/words into an array
		$words = explode(' ', $str);
		// For each word
    	for ($w = 0; $w < count($words); $w ++) {
        	// Find the pairs of characters
        	$pairsInWord = self::letterPairs($words[$w]);
			for ($p = 0; $p < count($pairsInWord); $p ++) {
        	    $allPairs[$pairsInWord[$p]] = $pairsInWord[$p];
        	}
    	}
		return array_values($allPairs);
	}
	/**
	 *
	 * @param $str
	 * @return array
	 */
	private static function letterPairs ($str)
	{
    	$numPairs = mb_strlen($str) - 1;
    	$pairs = array();
		for ($i = 0; $i < $numPairs; $i ++) {
    	    $pairs[$i] = mb_substr($str, $i, 2);
    	}
		return $pairs;
	}
	/**
	 *
	 * @param $str1
	 * @param $str2
	 * @return float
	 */
	public static function compareStrings ($str1, $str2)
	{
    	$pairs1 = self::wordLetterPairs(mb_strtolower($str1));
    	$pairs2 = self::wordLetterPairs(mb_strtolower($str2));
		$union = count($pairs1) + count($pairs2);
		$intersection = count(array_intersect($pairs1, $pairs2));
		return (2.0 * $intersection) / $union;
	}
	
	public static function fetchProPublica($url)
	{
    	$curl = curl_init();
    	//curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    	//curl_setopt($curl, CURLOPT_USERPWD, "username:password");
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        	'X-API-Key: fcmnv9JNpN7v3EpNAtE9O4cX7mFDclTUaxI9C2Wx'
        ));
  		curl_setopt($curl, CURLOPT_URL, "https://api.propublica.org".$url);
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		curl_close($curl);
		return $result;
	}
	
	public static function parseProPublica($json)
	{
		$obj = json_decode($json);
		foreach($obj as $item)
		{
			echo "<p>".$item."</p>";
		}
	}

	public static function fetchSentimentApi($input)
	{
		//$data["lang"] = "en";
		//$data["token"] = "09f81969423248719990f5464f05799c";
		//$data["text"] = $input;
		$data = "lang=en&token=09f81969423248719990f5464f05799c&text=".$input;
    	$curl = curl_init();
    	curl_setopt($curl, CURLOPT_POST, 1);
    	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    	//curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    	//curl_setopt($curl, CURLOPT_USERPWD, "username:password");
		curl_setopt($curl, CURLOPT_URL, "https://api.dandelion.eu/datatxt/sent/v1");
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		curl_close($curl);
		return $result;
	}
	
	public static function getSentiment($type, $score)
	{
		$return = "";
		$return_image = "";
		if($type != "")
		{
			if(round($score, 2) >= round(0.50))
				$return = "hi-positive";
			else if(round($score, 2) >= round(0.10))
				$return = "md-positive";
			else if(round($score, 2) >= round(-0.10))
				$return = "neutral";
			else if(round($score, 2) >= round(-0.50))
				$return = "md-negative";
			else if(round($score, 2) >= round(-1.00))
				$return = "hi-negative";
			if($return != "")
				$return_image = "<div class=\"sprite ".$return."\"></div>";
		}
		return $return_image;
	}
	
	public static function validateDateTime($input)
	{
		$return = true;
		$pieces = explode(" ",$input);
		$dates = explode("-",$pieces[0]);
		$times = explode(":",$pieces[1]);
		// validate year
		if(strlen($dates[0]) != 4)
		{
			$return = false;
		}
		// validate month
		if(strlen($dates[1]) == 1)
		{
			$dates[1] = "0".$dates[1];
		}
		else if(strlen($dates[1]) > 2)
		{
			$return = false;
		}
		// validate day
		if(strlen($dates[2]) == 1)
		{
			$dates[2] = "0".$dates[2];
		}
		else if(strlen($dates[2]) > 2)
		{
			$return = false;
		}
		//validate hour
		if(strlen($times[0]) == 1)
		{
			$times[0] = "0".$times[0];
		}
		else if(strlen($times[0]) > 2)
		{
			$return = false;
		}
		// validate minute
		if(strlen($times[1]) == 1)
		{
			$times[1] = "0".$times[1];
		}
		else if(strlen($times[1]) > 2)
		{
			$return = false;
		}
		//validate second
		if(strlen($times[2]) == 1)
		{
			$times[2]= "0".$times[2];
		}
		else if(strlen($times[2]) > 2)
		{
			$return = false;
		}
		//reassemble datetime
		if($return === true)
		{
			$return = $dates[0]."-".$dates[1]."-".$dates[2]." ".$times[0].":".$times[1].":".$times[2];
		}
		else
		{
			$return = "";
		}
		return $return;
	}
}