<!DOCTYPE HTML>
<?php include '/var/www/GooglePlayWebTv/php/displays.php';
	$isauth = isAuth();
	if(!isAuth()){ header('Location: ../index.php'); }
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <!-- Title tag just for valid html5, can not be seen -->
        <title>Google Play TV Box</title>
        <style> .removed{display:none!important;} .invisible{visibility:hidden!important;width:0px!important;height:0px!important;overflow:hidden!important;}</style>
        <link rel="stylesheet" href="../Contents/default.css">
		<script src="../Lib/jquery-2.0.3.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
 		<script type="text/javascript" src="../Scripts/menu_jquery.js"></script>
		<script type="text/javascript" src="../Scripts/keycodes.js"></script>
		<script type="text/javascript" src="../Scripts/resources.js"></script>
		
	</head>
	
	<title>Google Play for TV Box</title>

	<body style="background: white; position: absolute; left: 60px;">
	
	<header>

	<img src="../Images/google_toolbar.jpg" id="toolbarlogo">

	<input type="image" name="logout" src="../Images/logoutbutton.jpg" class="button" id="logoutbutton" name='logout' value='logout' onclick="logout()">
	<a href="../html/Settings.php"><input type="image" name="configuration" src="../Images/Configure.jpg" class="button" id="configurationbutton" name='configuration' value='configuration'></a>
	</header>
	
	<div id="toolbarmusic"> Music Menu </div>
	
	
	<div id='toolbarmenu'>
		<ul id='toolbarmenu'>
			<li><a href='./main.php' id="ListenNow"><span>Listen Now</span></a></li>
			<li><a href='./MyLibrary.php?page=0' id="MyLibrary"><span>My Library</span></a></li>
			<li><a href='./Explore.php' id="Explore"><span>Explore</span></a></li>
			<li><a href='./Playlists.php?page=0' id="Playlists"><span>Playlists</span></a>

        		 <?php DisplayPlaylistsSubmenu( DisplayPlaylists());?>
    </li>    
</ul>
</div>


<!-- Headers of every part of the menu -->
<header><a class="headerbox">Listen Now</a></header>

<!--<canvas height="500px" width="500px" id="micanvas" style="position:absolute; left: 205px; top:180px;">Su navegador</canvas>-->


<script>
/*var canvas = document.getElementById("micanvas");
var ctx = canvas.getContext("2d");

ctx.fillStyle="#f00";
ctx.fillRect(10,10,322,322);*/
</script>	

<?php
	$playlists = DisplayPlaylists();
	
	$chosenplaylist = $playlists[rand(0,(sizeof($playlists)-1))];
	
	for($x=0;$x<2;$x++){
	$image_urls = DisplayImageURL('playlist',$chosenplaylist);
	$image_urls_matrix[$x] = $image_urls;
	$image_urls = array();
	}
	


	DisplayImageBlock($image_urls_matrix[0],'#','big');
	DisplayImageBlock($image_urls_matrix[1],'#','little');


?>
	
	
</body>
</html>
