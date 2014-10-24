<?php
//error_reporting(0);
include('rss_php.php');

function between($content,$start,$end){
    $r = explode($start, $content);
    if (isset($r[1])){
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
}

function time_stamp($session_time){ 
	$time_difference = time() - $session_time; 
	if($time_difference<0){
		$time_difference = $session_time - time();
	}
	$seconds = $time_difference; 
	$minutes = round($time_difference / 60 );
	$hours = round($time_difference / 3600 ); 
	$days = round($time_difference / 86400 ); 
	$weeks = round($time_difference / 604800 ); 
	$months = round($time_difference / 2419200 ); 
	$years = round($time_difference / 29030400 ); 

	if($seconds <= 60){
		$ago = "$seconds seconds ago"; 
	}
	elseif($minutes <=60){
		if($minutes==1){
			$ago = "1 minute ago"; 
		}
		else{
			$ago = "$minutes minutes ago"; 
		}
	}
	elseif($hours <=24){
		if($hours==1){
			$ago = "1 hour ago";
		}else{
			$ago = "$hours hours ago";
		}
	}
	elseif($days <=7){
		if($days==1){
			$ago = "1 day ago";
		}else{
			$ago = "$days days ago";
		} 
	}
	elseif($weeks <=4){
		if($weeks==1){
			$ago = "1 week ago";
		}else{
			$ago = "$weeks weeks ago";
		}
	}
	elseif($months <=12){
		if($months==1){
			$ago = "1 month ago";
		}else{
			$ago = "$months months ago";
		} 
	}else{
		if($years==1){
			$ago = "1 year ago";
		}else{
			$ago = "$years years ago";
		}
	}
	return $ago;
}

//search query
$uquery = urlencode(htmlspecialchars($_GET['q']));
$query = urldecode($uquery);
if(empty($uquery)){
	die();
}
?>
Viewing <span id="total">0</span> torrents for: <?php echo $query; ?>
<br/><br/>
<?php
if(!empty($uquery)){
$url = "http://torrentz.eu/feed?q=$uquery";
//------------------------------------------------------------------------
	$rss = new rss_php;
    $rss->load($url);
    $items = $rss->getItems();
	$total = 0;
    foreach($items as $index => $item) {
		$title = $item['title'];
		$enc_title = urlencode($title);
		$link = $item['link'];
        $size = number_format(between($item['description'], "Size: ", " MB"), 0, ',', '.');
		$seeds = str_replace(',', '.', between($item['description'],"Seeds: ", " Peers:"));
		$peers = str_replace(',', '.', between($item['description'],"Peers: ", " Hash:"));
		$chunks = explode(" Hash: ", $item['description']);
		$hash = $chunks[1];
		$date = time_stamp(strtotime($item['pubDate']));
		$total++;
		echo "<a href='$link' title='$title' target='blank'>$title</a> - <a href='magnet:?xt=urn:sha1:$hash&dn=$enc_title'>Magnet</a><br>Size: $size MB - Seeds: $seeds - Peers: $peers - $date<br/><br/>";
    }
//------------------------------------------------------------------------
}
?>
<script type="text/javascript">
$("#total").html("<?php echo $total; ?>");
</script>