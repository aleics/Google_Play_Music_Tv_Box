<script type="text/javascript" src="../Scripts/resources.js"></script>
<?php
	/*
	FUNCTIONS.PHP
	On this file we will have all the functions needed on the API
	*/
	//Classes
	//Class of the user information
	class UserInfo{

        var $email;
        var $password;

        function addInfo($e,$p){
                $this->email = $e;
                $this->password = $p;

        }

        }



	//functions needed
	//Get the Auth Variables (SID,LSID,AUTH)
	function GetAuthentificationVariables($body){

		$sid_pos = strpos($body,'SID');
		$lsid_pos = strpos($body,'LSID');
		$auth_pos = strpos($body,'Auth');
		
		$sid = mb_strcut($body,$sid_pos,$lsid_pos-$sid_pos);
		$lsid = mb_strcut($body,$lsid_pos,$auth_pos-$lsid_pos);
		$auth = mb_strcut($body,$auth_pos);
		
		return array($sid,$lsid,$auth);
	}


	//Save Auth variable in one file called 'Auth.txt'
	function SaveAuth($auth_var){
	
		$myFile = '/var/www/GooglePlayWebTv/Info/Auth.txt';
		$fh = fopen($myFile,'w') or die("can't open file");
		fwrite($fh,$auth_var[2]);
		fclose($fh);
	}

	//Save the SID,SSID
	function SaveIDs($auth_var){
		
		$myFile = '/var/www/GooglePlayWebTv/Info/IDs.txt';
		$fh = fopen($myFile,'w') or die ("can't open file");
		fwrite($fh,$auth_var[0]);
		fwrite($fh,$auth_var[1]);
		fclose($fh);
	}
	
	//Save user info
	function SaveUserInfo($email,$password){
		$myFile = '/var/www/GooglePlayWebTv/Info/user.txt';
		$fh = fopen($myFile,'w') or die ("can't open file");
                fwrite($fh,"Email: ".$email." ");
		fwrite($fh,"\n");
                fwrite($fh,"Password: ".$password);
                fclose($fh);
	}
	
	//Save Android ID
	function SaveAndroidId($android_id){
	
	 	$myFile = '/var/www/GooglePlayWebTv/Info/android.txt';
                $fh = fopen($myFile,'w') or die ("can't open file");
                fwrite($fh,"android_id: ".$android_id);
		fclose($fh);
			
	}	
	
	//Check if the user is Authentificated
	function isAuth(){
	return file_exists('/var/www/GooglePlayWebTv/Info/Auth.txt');
	}
	
	//Read User Info
	function ReadUserInfo(){

	$myFile = fopen('/var/www/GooglePlayWebTv/Info/user.txt',"rb");
        $input = fread($myFile,filesize('/var/www/GooglePlayWebTv/Info/user.txt'));
        fclose($myFile);


	$email = str_replace("Email: ",'',$input);
	$emaildef = substr_replace($email,'',strrpos($email,"Password: "));
	return $emaildef;
	}
	
	//Read Android ID
	function ReadAndroidId(){
	
	$myFile = fopen('/var/www/GooglePlayWebTv/Info/android.txt',"rb");
        $input = fread($myFile,filesize('/var/www/GooglePlayWebTv/Info/android.txt'));
        fclose($myFile);

	$android = substr_replace($input,'',0,strlen("android_id: "));
	return $android;

	}


	//Read User IDs	
	function ReadIDs(){
	
	$myFile = fopen('/var/www/GooglePlayWebTv/Info/IDs.txt',"rb");
        $input = fread($myFile,filesize('/var/www/GooglePlayWebTv/Info/IDs.txt'));
        fclose($myFile);

	

	$SID = substr_replace($input,'',0,strlen("SID="));
        $SIDdef = substr_replace($SID,'',strrpos($SID,"LSID="));
	
	$LSID = str_replace($SIDdef,'',$input);
	$LSIDdef = substr_replace($LSID,'',0,strlen("SID=LSID="));
        return array($SIDdef,$LSIDdef);
	}

	
	//Read Auth variable from a file called 'Auth.txt'
	function ReadAuth(){
	
	$myFile = fopen('/var/www/GooglePlayWebTv/Info/Auth.txt',"rb");
	$input = fread($myFile,filesize('/var/www/GooglePlayWebTv/Info/Auth.txt'));
	fclose($myFile);

	$auth = substr($input,strlen("Auth="));
	
	return trim(preg_replace('/\s+/', ' ', $auth));;
	
	}
	
	//Read the tokens (xt, sjsaid)
	function ReadToken(){
	$myFile = fopen('/var/www/GooglePlayWebTv/Info/token.txt',"rb");
        $input = fread($myFile,filesize('/var/www/GooglePlayWebTv/Info/token.txt'));
        fclose($myFile);
        return $input;
	}
	

	//Save the whole Track list in a file called 'TrackList.txt'
	function SaveTrackList($output){
	
	$myFile = fopen("/var/www/GooglePlayWebTv/Info/TrackList.txt","w") or die("can't open the file");
	fwrite($myFile,$output);
	fclose($myFile);

	}
	
	//Save the whole Playlist list in a file called 'PlaylistList.txt'
	function SavePlaylistList($output){
	
	$myFile = fopen("/var/www/GooglePlayWebTv/Info/PlaylistList.txt","w") or die("can't open the file");
        fwrite($myFile,$output);
        fclose($myFile);
	
	}

	//Save the whole songs associated on every Playlist in 'PlaylistSongList.txt'
	function SavePlaylistSongList($output){

	$myFile = fopen("/var/www/GooglePlayWebTv/Info/PlaylistSongList.txt","w") or die("can't open the file");
        fwrite($myFile,$output);
        fclose($myFile);

	}

	//Function of getting the name of song, album, id, etc...
	function GetVariableList($FileName,$str){
	
	$myFile = fopen($FileName,"rb");
	$input = fread($myFile,filesize($FileName));
	
	$lines = file($FileName);
	$output = array();
	foreach($lines as $lineNumber => $line){
		if(strpos($line,$str) !== false){ //in every line that we found $str copy to array output
			$output[] = $line;
		}
	}
	
	fclose($myFile);
	
	$out = DeleteValueDescription($output,$str);

	return $out;
	}

	//Function to get the information (songs,ids,albumref,etc) of one variable (album,artist,etc)
	function GetInfoOf($FileName,$str){ //$str is the variable (album,artist,etc)

	}
	
	//Get All the info of Tracklist and organizate it in arrays
	function GetAllTracksInfo(){

	$FileName = "/var/www/GooglePlayWebTv/Info/TrackList.txt";
	$myFile = fopen($FileName,"rb");
	$input = fread($myFile,filesize($FileName));

        $output = array();
	$info = array();
        $lines = file($FileName);
        $cont = 0;
	$end = false;
        foreach($lines as $lineNumber => $line){
		if(strpos($line,'"kind": "sj#track"') !== false){
			
			while($end == false){
				if(strpos($line,'"albumId":') !== false){$end = true;$info[] = $line;}
				else{$info[] = $line;}
			}
		$output[] = $info;
		$info = array();
                }

        return $output;
	
	}
	}


	//Function to delete name of the variable, and get only the value of the line
	function DeleteValueDescription($input,$str){
	
	$middle = array();
	$output = array();
	$out = array();	
	for($x=0;$x<count($input);$x++){
			$middle[] = str_replace($str,'',$input[$x]); //delete "variable": "
			$output[] = str_replace('",','',$middle[$x]); //delete last ",
			$out[] = substr($output[$x],4,-1); //delete the spaces at the beginning and the end
		}
	return $out;
	}


	//Get the Matrix that we will display on MyLibrary page
	function GetMatrixMyLibrary($titles,$artists,$albums){
	$matrix_output = array();
		if((sizeof($titles) == sizeof($artists)) == sizeof($albums)){
			for($y=0;$y<sizeof($titles);$y++){
				$matrix_output[$y] = array($titles[$y],$artists[$y],$albums[$y]);
			}
		}
	return $matrix_output;
	}

	//Get all tracks list from google	
	function get_all_tracks($auth){
	
	$ch = curl_init('https://www.googleapis.com/sj/v1beta1/tracks');
	$header = 'Authorization: GoogleLogin auth='.$auth;

	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
	curl_setopt($ch,CURLOPT_HTTPHEADER,array($header));

	$output = curl_exec($ch);
	$status = curl_getinfo($ch);

	curl_close($ch);

	return $output;
	}
	
	//Get all playlists list from google
	function get_all_playlists($auth){
	
	$ch = curl_init('https://www.googleapis.com/sj/v1beta1/playlists');
	$header = 'Authorization: GoogleLogin auth='.$auth;
	
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array($header));

        $output = curl_exec($ch);
        $status = curl_getinfo($ch);

        curl_close($ch);

        return $output;
        }
	

	//Get the songs list of every playlist from google
	function get_all_songs_of_playlists($auth){
	
	$ch = curl_init('https://www.googleapis.com/sj/v1beta1/plentries');
        $header = 'Authorization: GoogleLogin auth='.$auth;

        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array($header));

        $output = curl_exec($ch);
        $status = curl_getinfo($ch);

        curl_close($ch);

        return $output;

	}

	 //Display Variables per page
        function DisplayVariablesPerPages($matrix,$num_page,$variables_for_page,$link_play){ 

        $start = 0+($variables_for_page*$num_page);
        $end = ($variables_for_page-1)+($variables_for_page*$num_page);

	

        if($end>=sizeof($matrix)){
                $end = sizeof($matrix);
        }

	if(is_array($matrix[0])) {  //This case will be for the SONGS LIST

        for($y=$start;$y<$end;$y++){
                echo "<tr class='variable_per_page'>";
                for($x=0;$x<sizeof($matrix[0]);$x++){
                    
			if(($x%3)==0){
				
				$link = $link_play."&id=".GetIdofSong($matrix[$y][$x]);
				 echo "<td style='width: 350px;'><input type='image' id='playbuttontracklist' class='buttontracklist' src='../Images/play_logo.png' value='".GetIdofSong($matrix[$y][$x])."' onclick=\"playsong('".GetIdofSong($matrix[$y][$x])."')\"><input type='image' id='pausebuttontracklist' class='buttontracklist' src='../Images/pause_logo.png' style='position: relative; ; top: -1px; display:none;'>".$matrix[$y][$x]."<input type='image' id='morebutton' src='../Images/more.png'></td>";
			}
			else{
				 if($x==2){
				 	echo "<td><a href='../html/albums.php?album=".$matrix[$y][$x]."&page=0'><span>".$matrix[$y][$x]."</a></td>";
				 }
				 else if($x==1){
					echo "<td><a href='../html/artists.php?artist=".$matrix[$y][$x]."&page=0'><span>".$matrix[$y][$x]."</a></td>";
				 }
			}
                }
                echo "</tr>";
        }
	}
	
	else if(!is_array($matrix[0])){	//This case will be for the PLAYLISTS LIST
	
	for($y=$start;$y<$end;$y++){
                echo "<tr class='variable_per_page'>";
		echo "<td> <a href='?playlist=".$matrix[$y]."&page=0'><span>".$matrix[$y]."</td>"; 
		echo "</tr>";

        }
	}
	}

	//Return the number of pages that we will need for one list of tracks, playlists, etc.
	function NumberOfPages($matrix){
	
	$numberelements = 0;
        
	for($x=0;$x<sizeof($matrix);$x++){
		$numberelements++;
	}
	$numberpages = floor($numberelements/14);
	return $numberpages;
	
	}

	//Search one song on the list of all songs
	function SearchSong($name,$matrix){
	
	$number_all_songs = sizeof($matrix);
	$song_album_artist = sizeof($matrix[0]);
	$found = false;

	$cont_founds = 0;
	$all_songs_found = array();	

	 for($y=0;$y<$number_all_songs;$y++){
                for($x=0;$x<$song_album_artist;$x++){
		
			if($name == $matrix[$y][$x]){
				$found = true;
				$song_found = $matrix[$y];
	
				$all_songs_found[$cont_founds] = $song_found;
				$cont_founds++;
				
				
				}

		}
	}
	
	return $all_songs_found;

	}


	//Display the Playlists Submenu
	function DisplayPlaylistsSubmenu($playlists){
	echo "<ul id='submenuallplaylists'>";
	for($i=0;$i<sizeof($playlists);$i++){
		
		echo "<li id='submenuplaylist'><a href='http://ec2-54-195-232-8.eu-west-1.compute.amazonaws.com/GooglePlayWebTv/html/Playlists.php?playlist=".$playlists[$i]."&page=0'>".$playlists[$i]."</a><input type='image' id='morebuttonsubmenuplaylist' src='../Images/more.png'></li>";
	
	}
	echo "</ul>";
	}

	function DisplayListenNowImage($image_urls){

	

	}
	
	
	//Display the Image Block of Playlist, album, etc.	
	function DisplayAllImageBlock($image_urls,$type,$information,$typeimage){
	
	switch($typeimage){
		case 'Playlist':
				DisplayImageBlock($image_urls,$type,$information,"../html/Playlists?playlist=".$information[0]."&page=0");	
				break;
		case 'Album':
				DisplayImageBlock($image_urls,$type,$information,"../html/albums?album=".$information[0]."&page=0");
				break;
	}
	}

	//Display the Image Block. Here you can choose the size: small or big.	
	function DisplayImageBlock($image_urls,$type,$information,$link){
	
	switch($type){
		
		case 'big':
		echo "<div class='bigcard_image'>";
		echo "<a href='".$link."'>";
	
		if(is_array($image_urls)){	
		DisplayImageCard($image_urls,'big');
		}

		else{
		echo "<img src='".$image_urls."' style='width:382px; height:382px;'>";
		}

		echo "</a>";
		echo "</div>";
		echo "<div class='imagedetails_ListenNow'>";
		echo "<a class='footerimage_ListenNow' href='".$link."' style='position: relative;'>".$information[0]."</a>";
		echo "<p class='footerimage_ListenNow'>".$information[1]."</p>";
		echo "</div>";
		break;

		case 'little':
		echo "<div class='littlecard_image'>";
		echo "<a href='".$link."'>";
		if(is_array($image_urls)){
                DisplayImageCard($image_urls,'little');
                }
                else{
                echo "<img src='".$image_urls."' style='width:160px; height:161px;'>";
                }
		echo "</a>";
                echo "</div>";
		echo "<div class='imagedetails_ListenNow' id='little'>";
                echo "<a class='footerimage_ListenNow' href='".$link."' id='little' style='position: relative;'>".$information[0]."</a>";
                echo "<p class='footerimage_ListenNow' id='little'>".$information[1]."</p>";
		echo "</div>";
		break;

	}
	} 
	
	//Display one Image Card
	function DisplayImageCard($image_urls,$type){


	switch($type){
	case 'big':
	for($i=0;$i<sizeof($image_urls);$i++){
	
		echo "<img src='".$image_urls[$i]."' style='width:191px; height:191px;'>";
	}
	break;

	case 'little':
	for($i=0;$i<sizeof($image_urls);$i++){

                        echo "<img src='".$image_urls[$i]."' style='width:80px; height:81px;'>";

                }
	break;
	}
	}


	//Function to decode the Stream url
        function CleanStreamUrl($stream){

                $stream_cl = substr($stream,strlen('{"tier":1,"url":"'),strlen($stream)-strlen('{"tier":1,"url":"')-2);
                $stream_clean =  ReplaceSerieStringsinString(ReplaceSerieStringsinString($stream_cl,'\u003d','='),'\u0026','&');
                $streamout =  $stream_clean.'&ps=f';

        return $streamout;

        }

        //Function to replace strings in one string
        function ReplaceSerieStringsInString($str,$oldstring,$newstring){


        $tmpOldStrLength = strlen($oldstring);

        while (($offset = strpos($str, $oldstring, $offset)) !== false) {
          $str = substr_replace($str, $newstring, $offset, $tmpOldStrLength);
        }

        return $str;

        }


        //function to do a get request
        function get_to_url($url,$headers){



                $ch = curl_init($url);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
                curl_setopt($ch, CURLOPT_VERBOSE, 1);
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
                if(!is_array($headers)){ curl_setopt($ch,CURLOPT_HTTPHEADER,array($headers));}
                else{ curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);}

                $output = curl_exec($ch);
                $status = curl_getinfo($ch,CURLINFO_HTTP_CODE);

                $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                $header_response = substr($output, 0, $header_size);
                $body = substr($output, $header_size);

                curl_close($ch);
                return array($body,$header_response,$status);
        }

	//function to turn array to url parameters
        function array_to_url($data){
            $fields = '';
            foreach ($data as $key => $value) {
                $fields .= $key . '=' . $value . '&';
            }
            rtrim($fields, '&');

            return $fields;
        }

        //Function to Save the xt and sjsaid Token
        function SavextToken($xt,$sjsaid){

                $myFile = '/var/www/GooglePlayWebTv/Info/xttoken.txt';
                $fh = fopen($myFile,'w') or die ("can't open file");
                fwrite($fh,$xt);
                fwrite($fh,"\n");
                fwrite($fh,$sjsaid);
                fclose($fh);

        }

        //Function to Read the xt Token from file
        function ReadxtToken(){
        $myFile = fopen('/var/www/GooglePlayWebTv/Info/xttoken.txt',"rb");
        $input = fread($myFile,filesize('/var/www/GooglePlayWebTv/Info/xttoken.txt'));
        fclose($myFile);


        $xt = str_replace("xt=",'',$input);
        $xtdef = substr_replace($xt,'',strrpos($xt,"sjsaid="));
        return trim(preg_replace('/\s+/', ' ', $xtdef));
        }

        //Function to Read the sjsaid Token from file
        function ReadsjsaidToken(){

        $myFile = fopen('/var/www/GooglePlayWebTv/Info/xttoken.txt',"rb");
        $input = fread($myFile,filesize('/var/www/GooglePlayWebTv/Info/xttoken.txt'));
        fclose($myFile);


        $sj = substr_replace($input,'',0,strrpos($input,"sjsaid="));
        $sjdef = str_replace("sjsaid=",'',$sj);
        return $sjdef;

        }

	//Function to get the Stream Url of the Track
	function GetStreamUrlTrack($songid){
        $xt = ReadxtToken();
        $sjsaid = ReadsjsaidToken();

        $cont = 0;
        $url = 'https://play.google.com/music/play?u=0&songid='.$songid.'&pt=e';
        $auth_header = 'Authorization: GoogleLogin auth='.ReadAuth();
        $cookie_header = 'Cookie: sjsaid='.$sjsaid.'; xt='.$xt.';';
        $headers = array($auth_header,$cookie_header);

        $out = get_to_url($url,$headers);
        $stream_url =  $out[0];

        $stream_url_cl = CleanStreamUrl($stream_url);

        return $stream_url_cl;
        }

	//Function to get the Audio File
        function GetAudioFile($stream_url){

        $header = 'Referer: https://play.google.com/music/listen';

        $audio_file = get_to_url($stream_url,$header);

        return $audio_file;

        }


	//Function to save the audio file
	function SaveAudioFile($audio_file){
	$myFile = '/var/www/GooglePlayWebTv/Contents/Audio/song.mp3';
        $fh = fopen($myFile,'w') or die("can't open file");
        fwrite($fh,$audio_file[0]);
        fclose($fh);
	
	}


?>
