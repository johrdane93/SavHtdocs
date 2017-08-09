

<html>

    <head>

        <title>CV</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    </head>

     <style type="text/css">
        * { 
            margin: 0; 
            padding: 0; 
        }
         
        body { 
            font: 16px Helvetica, Sans-Serif; 
            line-height: 24px; 
        }
         
        .clear { 
            clear: both; 
        }
        
        #page-wrap { 
            width: 100%; 
            margin: 40px 50px 60px; 
        }
        
       
        h1 { 
            margin: 0 0 16px 0; 
            padding: 0 0 16px 0; 
            font-size: 42px; 
            font-weight: bold; 
            letter-spacing: -2px; 
            border-bottom: 1px solid #999; 
        }
         
        h2 { 
            font-size: 20px; 
            margin: 0 0 6px 0; 
            position: relative; 
        }
         
        h2 span { 
            position: absolute; 
            bottom: 0; 
            right: 0; 
            font-style: italic; 
            font-family: Georgia, Serif; 
            font-size: 16px; 
            color: #999; 
            font-weight: normal; 
        }
        
         
        a { 
            color: #999; 
            text-decoration: none; 
            border-bottom: 1px dotted #999; 
        }
        
        
        #objective { 
            width: 800px; 
            float: left; 
            margin-left: 30px;
        }
        
        #objective p { 
            font-family: Georgia, Serif; 
            font-style: italic; 
            color: #666; 
        
        }
        
         dt { 
             font-style: italic; 
             font-weight: bold; 
             font-size: 18px; 
             text-align: right; 
             padding: 0 26px 0 0; 
             width: 150px; 
             float: left; 
             height: 100px; 
             border-right: 1px solid #999;  
         }
         
        dd { 
            width: 800px; 
            float: left; 
            margin-left: 20px;
        }
        
        dd.clear {
            float: none; 
            margin: 0; 
            height: 15px; 
        }
         
     </style>

<body>

    <div id="page-wrap">
    
    
        <div id="contact-info" >
            <h1><?= $personal['name'] ?></h1>
        
            <p>
                Phone: <?= $personal['phone'] ?><br />
                Email: <?= $personal['email'] ?>
            </p>
        </div>
                
        <div id="objective">
            <p>
                <?= $personal['objectives'] ?>
            </p>
        </div>
        
        <div class="clear"></div>
        
        <dl>
            <dd class="clear"></dd>
            
            <dt>Education</dt>
            <?php
                        foreach($edu as $ed)
                        { ?>
                        <dd>
                            <h2><?= $ed['institution'] ?></h2>
                            <p><?= $ed['degree'] ?></p>
                            <p>Passed with <?= $ed['percentage'] ?> percent marks in all fields</p>
                        </dd>
            <?php } ?>
            
            <dd class="clear"></dd>
            
            <dt>Internships And Projects</dt>
            <?php 
                        foreach($work as $wk)
                        { ?>
                            <dd>
                               <h2><?= $wk['position'] ?> at <?= $wk['organisation'] ?></h2>
                               <p class="subDetails"><?= $wk['duration'] ?> months</p>
                               <p><?= $wk['details'] ?></p>
                            <dd>
            <?php } ?>
            
            <dd class="clear"></dd>
            
            <dt>Achievements</dt>
                        <dd>
                            <?php
                            foreach($edu as $ed)
                            { ?>
                            <p><strong>At <?= $ed['institution'] ?>:</strong></p>
                            <p><?= $ed['achievements'] ?></p>
                            <?php } ?>
                            <?php
                            foreach($work as $wk)
                            { ?>
                            <p><strong>At <?= $wk['organisation'] ?>:</strong></p>
                            <p><?= $wk['achievements'] ?></p>
                            <?php } ?>
                            <p><strong>Others:</strong></p>
                            <p><?= $personal['achievements'] ?></p>
                        </dd>
            
            <dd class="clear"></dd>
            
            
            
            <dt>Personal Profile</dt>
                        <dd>
                            <p><strong>Date of Birth:</strong><?= $personal['dob'] ?><p>
                            <p><strong>Address:</strong><?= $personal['address'] ?><p>

                        </ul>
            
            <dd class="clear"></dd>
        </dl>
        
        <div class="clear"></div>
    
    </div>
	<button onclick="printFunc()">Print</button>
</body>
<script>
		function printFunc(){
			var details = <?php echo '{"filename":"cvPrint","personal":[' . json_encode($personal) . '],"work":' . json_encode($work) . ',"edu":' . json_encode($edu) .'}'?> ;
			$.post("/capture",details,function(data){
				console.log("Generated "+data);
			});
		}
</script>

</html>