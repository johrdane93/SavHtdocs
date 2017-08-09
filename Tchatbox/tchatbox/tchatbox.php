<?php
$json_file = file_get_contents('conf.json');
$jfo = json_decode($json_file);
$name = $jfo[0]->name;
$pwd = encrypt_decrypt('decrypt',$jfo[0]->pwd);
$url = $jfo[0]->url;
?>

<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $name; ?></title> 
    <link rel="stylesheet" href="style.css" type="text/css" />  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript" src="chat.js"></script>
    <script type="text/javascript">
		var name = "init";
        var chat =  new Chat();
		var color = getColor();
		
    	$(function() {	
			chat.getState();
			
			$(window).bind('beforeunload', function(){
				name = $usernameInput.val();
				chat.send(name + " a quitté la salle", name, color);
			});
			
			var $loginPage = $('.login.page'); // The login page
			var $chatPage = $('.chat.page'); // The chatroom page
			var $usernameInput = $('.usernameInput'); // Input for username
			$('.usernameInput').keyup(function(e) {	
				if (e.keyCode == 13) {
				$loginPage.fadeOut();
				$chatPage.show();
				name = $usernameInput.val();
				if (!name || name === ' ') {name = "Inconnu";}
				name = name.replace(/(<([^>]+)>)/ig,"");
				chat.send(name + " a rejoint la salle", name, color);
				document.getElementById('inputMessage').focus();
				}
			});
    		 
    		 // watch textarea for key presses
             $(".inputMessage").keydown(function(event) {  
                 var key = event.which;  
           
                 //all keys including return.  
                 if (key >= 33) {
                     var maxLength = $(this).attr("maxlength");  
                     var length = this.value.length;  
                     
                     // don't allow new content if length is maxed out
                     if (length >= maxLength) {  
                         event.preventDefault();  
                     }  
                  }  
    		 																																																});
    		 // watch textarea for release of key press
    		 $('.inputMessage').keyup(function(e) {
				  var elem = document.getElementById('chatArea');
				  elem.scrollTop = elem.scrollHeight;
    			  if (e.keyCode == 13) {
                    var text = $(this).val();
    				var maxLength = $(this).attr("maxlength");  
                    var length = text.length; 
                    
                    // send 
                    if (length <= maxLength + 1) { 
    			        chat.send(text, name, color);	
    			        $(this).val("");
                    } else {
    					$(this).val(text.substring(0, maxLength));
    				}
    			  }
             });
    	});
    </script>
</head>

<body onload="setInterval('chat.update()', 1000)">
	<ul class="pages">
		<li class="chat page">
			<span class='RoomName'><?php echo $name ?></span>
			<a class="icon" target ='_blank' href="download_room_zip.php" title="Télécharger la salle" onclick="return confirm('Attention\n\nCette fonctionnalité est reservée aux utilisateurs confirmés pour mettre en place la salle sur leur propre serveur web.\nLes instructions pour la mise en place se trouvent dans le fichier readme.txt du zip.\n\nEtes vous sûr de vouloir continuer ?')"><img src="images/dl_zip.png" /></a>
			<a class="icon" target='_blank' href="download_content_html.php" title="Télécharger la discussion en html"><img src="images/dl_html.png" /></a>
			<a class="icon" target ='_blank' href="download_content_csv.php" title="Télécharger la discussion en csv"><img src="images/dl_csv.png" /></a>
			<hr>
			<div class="chatArea" id="chatArea">
			<?php
			if(file_exists('chat.txt')){
				$lines = file('chat.txt');
				if(count($lines) > 10000){
					file_put_contents('chat.txt', "<span class='pseudo' style=\"color:#3b88eb;\">init</span><span>init</span><span class='time'>00:00</span>\r\n");
				}
				$text = array();
				foreach($lines as $line){
					array_push($text,$line);
				}
			}
			
			foreach($text as $Message){
				echo $Message."<br><br>";
			}
			?>
			</div>
			<form>
				<textarea class="inputMessage" id="inputMessage" maxlength = '100'></textarea>
			</form>
		</li>
		<li class="login page">
			<div class="form">
			<h3 class="title">Entrez un pseudonyme</h3>
			<input class="usernameInput" type="text" maxlength="14" />
			</div>
		</li>
	</ul>
</body>
</html>