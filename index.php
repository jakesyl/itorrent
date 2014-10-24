<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>iTorrent - Instant torrents search</title>
<meta name = "description" content = "An instant torrents search engine.">
<script type = "text/javascript" src = "scripts/jquery.js"></script>
<style type = "text/css">
body{
	font-family: calibri;
}
.q{
	width: 600px;
	color: #000000;
	font-size: 17px;
	padding: 6px;
	margin: 2px;
	border: 1px solid #c7c7c7;
	-webkit-border-radius:4px;
	-moz-border-radius:4px;
	border-radius:4px;
	outline-color: #a71b1f;
	-moz-transition: border 0.5s ease-in-out, box-shadow 0.5s ease-in-out;
    -ms-transition: border 0.5s ease-in-out, box-shadow 0.5s ease-in-out;
    -o-transition: border 0.5s ease-in-out, box-shadow 0.5s ease-in-out;
    transition: border 0.5s ease-in-out, box-shadow 0.5s ease-in-out;
}
.q:focus {
	box-shadow: 0 0 7px #78C2FF;
	outline: none;
}
.sbtn{
	font-family: calibri;
	font-size: 18px;
}
#main{
	text-align: center;
}
.working{
	background: url("images/loading.gif") no-repeat right center;
}
.sb_pag, .sw_menu{
	display: none;
}
#results{
	margin-left: auto;
	margin-right: auto;
	width: 610px;
}
.sb_meta{
	font-color: #298A08;
}
</style>
<script type="text/javascript">
var timer;
function getHash(){
  return decodeURIComponent(window.location.hash.substring(1));
}

function search(sq){
	$("#q").addClass('working');
	clearTimeout(timer);
	timer = setTimeout(function () {
		$("#results").load("search.php?q=" + encodeURIComponent(sq), function() {
		$("#q").removeClass("working");
		window.location.replace("#" + encodeURI(sq));
		query = "";
		});
	}, 2000);
	return;
}

function clear(){
	window.location.replace("#");
	clearTimeout(timer);
	$("#q").removeClass("working");
	$("#results").html("");
	query = "";
	return;
}

$(document).ready(function(){
	$(".q").keyup(function(){
		var query = $("#q").val();
		if(query!=""){
			search(query);
		}else{
			clear();
		}
	});
	$("#q").focus();
	if(getHash()!=""){
		$("#q").val(getHash());
		search(getHash());
	}
});
</script>
</head>
<body>

<div id="main">
<br/><br/><br/><br/><br/><br/><br/>
<h2>Instant torrents search</h2>
<br/>
<input type="text" name="q" id="q" class="q" autocomplete="off">
</div>
<br/>
<div id = "results"></div>
<br/>
<p align="center">Developed by <a href = "https://github.com/greekdev">GreekDev</a> - 28/8/2013</p>
<br/>
</body>
</html>