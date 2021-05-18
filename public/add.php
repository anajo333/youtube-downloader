<?php

require('../vendor/autoload.php');

$youtube = new \YouTube\YouTubeDownloader();

//$links = $youtube->getDownloadLinks(base64_decode($_GET["url"]));
$links = $youtube->getDownloadLinks(base64_decode($_GET["url"]));
//var_dump($links->getVideoFormats());


$links = check_error_links__v2($links);
print json_encode($links,true);

die();



function check_error_links__v2($links){
	foreach ($links->getCombinedFormats() as $key => $value) {
		$results [] = [
			"url" => $value->url,
			"format" => "mp4, video, ".$value->qualityLabel.", audio",
			"content_length" => $value->contentLength,
		];
	}
	foreach ($links->getVideoFormats() as $key => $value) {
		$results [] = [
			"url" => $value->url,
			"format" => "mp4, video, ".$value->qualityLabel,
			"content_length" => $value->contentLength,
		];
	}
	foreach ($links->getAudioFormats() as $key => $value) {
		$results [] = [
			"url" => $value->url,
			"format" => "mp4, audio",
			"content_length" => $value->contentLength,
		];
	}
	$h200 = false;
	foreach ($results as $keyx => $valuex) {
		if($valuex["content_length"] == NULL){
			unset($results[$keyx]);
			continue;
		}
		$h200 = true;
  	}
	if(!$h200){
		print '<script type="text/javascript">alert("something wrong in your youtube link error code call the admin");</script>';
	}
	return $results;
	
}

function check_error_links($links){
  $curl_arr = array();
  $master = curl_multi_init();

  foreach($links as $key => $value) {
      $url = $value['url'];
      $curl_arr[$key] = curl_init($url);
      curl_setopt($curl_arr[$key], CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl_arr[$key], CURLOPT_HEADER, true);
      curl_setopt($curl_arr[$key], CURLOPT_NOBODY, true);
      curl_setopt($curl_arr[$key], CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
      curl_setopt($curl_arr[$key], CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl_arr[$key], CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl_arr[$key], CURLOPT_MAXREDIRS, 10);
      curl_setopt($curl_arr[$key], CURLOPT_CONNECTTIMEOUT, 20);
      curl_setopt($curl_arr[$key], CURLOPT_TIMEOUT, 30);
      curl_setopt($curl_arr[$key], CURLOPT_FOLLOWLOCATION, true);
      curl_multi_add_handle($master, $curl_arr[$key]);
  }
  do {
      curl_multi_exec($master,$running);
  } while($running > 0);

  foreach ($curl_arr as $key_node => $node) {
      //$results[] = curl_multi_getcontent($node);
      $results[] = [
      "url" => curl_getinfo($node, CURLINFO_EFFECTIVE_URL),
      "content_length" => curl_getinfo($node, CURLINFO_CONTENT_LENGTH_DOWNLOAD),
      "format" => $links[$key_node]["format"] //"format" => "mp4, video, 360p, audio",
    ];
  }
  $h200 = false;
  foreach ($results as $keyx => $valuex) {
    if($valuex["content_length"] == 0){
      unset($results[$keyx]);
      continue;
    }
      $h200 = true;
  }
  if(!$h200){
    print '<script type="text/javascript">alert("something wrong in your youtube link error code call the admin");</script>';
  }
  return $results;
}
function extractVideoId($str){
  if (preg_match('/[a-z0-9_-]{11}/i', $str, $matches)) {
    return $matches[0];
  }
  return false;
}
?>