<html>
    <head>
        <title>Resume</title>
        <link href='http://fonts.googleapis.com/css?family=Rokkitt:400,700|Lato:400,300' rel='stylesheet' type='text/css'>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    </head>
    <style>
        body,div,h1,h2,h3,h4,h5,h6,p,em,ul,li,article,section{
            border:0;
            font:inherit;
            font-size:100%;
            margin:0;
            padding:0;
            vertical-align:baseline;
        }

        article,details,section {
            display:block;
        }

        body {
            background: #ffffff; 
            font-family: 'Lato', helvetica, arial, sans-serif; 
            font-size: 16px; 
            color: #222;}

        .clear {clear: both;}

        p {
            font-size: 1em;
            line-height: 1.4em;
            margin-bottom: 20px;
            color: #444;
        }

        #resume {
            width: 100%;
            background: #f3f3f3;
        }

        .mainDetails {
            padding: 25px 35px;
            border-bottom: 2px solid #cf8a05;
            background: #ededed;
        }

        #name h1 {
            font-size: 2.5em;
            font-weight: 700;
            font-family: 'Rokkitt', Helvetica, Arial, sans-serif;
            margin-bottom: -6px;
        }

        #name h2 {
            font-size: 2em;
            margin-left: 2px;
            font-family: 'Rokkitt', Helvetica, Arial, sans-serif;
        }

        #mainArea {
            padding: 0 40px;
        }

        #name {
            float: left;
        }

        #contactDetails {
            float: right;
        }

        #contactDetails ul {
            list-style-type: none;
            font-size: 0.9em;
            margin-top: 2px;
        }

        #contactDetails ul li {
            margin-bottom: 3px;
            color: #444;
        }

        section {
            border-top: 1px solid #dedede;
            padding: 20px 0 0;
        }

        section:first-child {
            border-top: 0;
        }

        section:last-child {
            padding: 20px 0 10px;
        }

        .sectionTitle {
            float: left;
            width: 25%;
        }

        .sectionContent {
            float: right;
            width: 72.5%;
        }

        .sectionTitle h1 {
            font-family: 'Rokkitt', Helvetica, Arial, sans-serif;
            font-style: italic;
            font-size: 1.5em;
            color: #cf8a05;
        }

        .sectionContent h2 {
            font-family: 'Rokkitt', Helvetica, Arial, sans-serif;
            font-size: 1.5em;
            margin-bottom: -2px;
        }

        .subDetails {
            font-size: 0.8em;
            font-style: italic;
            margin-bottom: 3px;
        }

        .achievement {
            list-style-type: none;
            margin-bottom: 20px;
            font-size: 1em;
            color: #444;
        }

        .achievement ul li {
            margin-bottom: 3px;
        }
        
    </style>
    <body id="resume">
        <div >
            <div class="mainDetails">
                <div id="name">
                        <h1><?= $personal['name'] ?></h1> 
                    <h2><?= $work[0]['position'] ?></h2>
                </div>

                <div id="contactDetails">
                    <ul>
                        <li>e: <?= $personal['email'] ?></li>
                        <li>m: <?= $personal['phone'] ?></li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>

            <div id="mainArea">
				
				<section>
                    <div class="sectionTitle">
                        <h1>Work Experience</h1>
                    </div>

                    <div class="sectionContent">
                        <?php 
                        foreach($work as $wk)
                        { ?>
                            <article>
                               <h2><?= $wk['position'] ?> at <?= $wk['organisation'] ?></h2>
                               <p class="subDetails"><?= $wk['duration'] ?> months</p>
                               <p><?= $wk['details'] ?></p>
                            </article>
                        <?php } ?>

                    </div>
                    <div class="clear"></div>
                </section>
				
                <section>
                    <div class="sectionTitle">
                        <h1>Education</h1>
                    </div>

                    <div class="sectionContent">
                        <?php
                        foreach($edu as $ed)
                        { ?>
                        <article>
                            <h2><?= $ed['institution'] ?></h2>
                            <p class="subDetails"><?= $ed['degree'] ?></p>
                            <p>Passed with <?= $ed['percentage'] ?> percent marks in all fields</p>
                        </article>
                        <?php } ?>
                    </div>
                    <div class="clear"></div>
                </section>

                <section>
                    <div class="sectionTitle">
                        <h1>Achievements</h1>
                    </div>

                    <div class="sectionContent">
                        <ul class="achievement">
                            <?php
                            foreach($edu as $ed)
                            { ?>
                            <li><strong>At <?= $ed['institution'] ?>:</strong></li>
                            <li><?= $ed['achievements'] ?></li>
                            <?php } ?>
                            <?php
                            foreach($work as $wk)
                            { ?>
                            <li><strong>At <?= $wk['organisation'] ?>:</strong></li>
                            <li><?= $wk['achievements'] ?></li>
                            <?php } ?>
                            <li><strong>Others:</strong></li>
                            <li><?= $personal['achievements'] ?></li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                </section>

                <section>
                    <article>
                        <div class="sectionTitle">
                            <h1>Personal Profile</h1>
                        </div>

                        <div class="sectionContent">
                            <ul class="achievement">
                            <li><strong>Date of Birth:</strong><?= $personal['dob'] ?></li>
                            <li><strong>Address:</strong><?= $personal['address'] ?></li>

                        </ul>
                        </div>
                    </article>
                    <div class="clear"></div>
                </section>
            </div>
        </div>
		<button onclick="printFunc()">Print</button>
    </body>
	<script>
		function printFunc(){
			var details = <?php echo '{"filename":"resumePrint","personal":[' . json_encode($personal) . '],"work":' . json_encode($work) . ',"edu":' . json_encode($edu) .'}'?> ;
			$.post("/capture",details,function(data){
				console.log("Generated "+data);
			});
		}
	</script>
</html>