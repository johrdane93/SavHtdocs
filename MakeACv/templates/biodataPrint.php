<html>
<head>

	<title>Biodata</title>

	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css"/> 
	<link rel="stylesheet" type="text/css"/>

</head>
    <style>

        
            body { 
                font-family: Georgia; 
                color: #444; 
            }

            #inner { 
                padding: 10px 80px;
                background: #ffffff;  
                border-width: 8px 0 2px 0; 
            }

            .yui-gf { 
                margin-bottom: 2em; 
                padding-bottom: 2em; 
                border-bottom: 1px solid #ccc; 
            }


            #hd { 
                margin: 2.5em 0 3em 0; 
                padding-bottom: 1.5em; 
                border-bottom: 1px solid #ccc 
            }
            #hd h2 { 
                text-transform: uppercase; 
                letter-spacing: 2px; 
            }
            #bd{
                margin-bottom: 2em; 
            }


            #hd h1 { 
                font-size: 48px; 
                text-transform: uppercase; 
                letter-spacing: 3px; 
            }

            h2 { 
                font-size: 152% 
            }
            h3, h4 { 
                font-size: 122%; 
            }
            h1, h2, h3, h4 { 
                color: #333; 
            }
        
            p { 
                font-size: 100%; 
                line-height: 18px; 
                padding-right: 3em; 
            }
        

            p.enlarge { 
                font-size: 144%; 
                padding-right: 6.5em; 
                line-height: 24px; 
            }

            p.enlarge span { 
                color: #000 
            }
            .contact-info { 
                margin-top: 7px; 
            }
            .first h2 { 
                font-style: italic; 
            }


            .job { 
                position: relative; 
                margin-bottom: 1em; 
                padding-bottom: 1em; 
                border-bottom: 1px solid #ccc; 
            }

            .job h4 { 
                position: absolute; 
                top: 0.35em; 
                right: 0 
            }

            .yui-gf .yui-u{width:80.2%;}
            .yui-gf div.first{width:12.3%;}



    </style>
    
    
    
    <body>
    

        <div id="doc2">
            <div id="inner">

                <div id="hd">
                    <div class="yui-gc">
                        <div class="yui-u first">
                            <h1>{{ personal[0].name }}</h1> 
                        </div>

                        <div class="yui-u">
                            <div class="contact-info">
                                <h3>{{ personal[0].email }}</h3>
                                <h3>{{ personal[0].phone }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="bd">
                    <div id="yui-main">
                        <div class="yui-b">

                            <div class="yui-gf">
                                <div class="yui-u first">
                                    <h2>Career Objective</h2>
                                </div>
                                <div class="yui-u">
                                    <p class="enlarge">
									{{ personal[0].objectives }}</p>
                                </div>
                            </div>

                            <div class="yui-gf">
                                <div class="yui-u first">
                                    <h2>Personal Profile</h2>
                                </div>
                                <div class="yui-u">
                                    <p class="enlarge">Father's Name: {{ personal[0].fname }}</p>
                                    <p class="enlarge">Date of Birth: {{ personal[0].dob }}</p>
                                    <p class="enlarge">Address: {{ personal[0].address }}</p>
                                    <p class="enlarge">Hobby: {{ personal[0].hobby }}</p>

                                </div>
                            </div>

                            <div class="yui-gf">

                                <div class="yui-u first">
                                    <h2>Education</h2>
                                </div>

                                <div class="yui-u">

                                    {% for ed in edu %}
                                    <div class="job">
                                        <h2>{{ ed.institution }}</h2>
                                        <h3 class="subDetails">{{ ed.degree }}</h3>
                                        <h3>Passed with {{ ed.percentage }} percent marks in all fields</h3>
                                    </div>
                                    {% endfor %}
                               </div>
                            </div>

                            <div class="yui-gf">

                                <div class="yui-u first">
                                    <h2>Experience</h2>
                                </div>

                                <div class="yui-u">
                                    {% for wk in work %}

                                    <div class="job">
                                        <h2>{{ wk.organisation }}</h2>
                                        <h3>{{ wk.position }}</h3>
                                        <h4>{{ wk.duration }} months </h4>
                                        <h3>{{ wk.details }} </h3>
                                    </div>
                                    {% endfor %}

                                </div>
                            </div>

                            <div class="yui-gf">

                                <div class="yui-u first">
                                    <h2>Achievements</h2>
                                </div>

                                <div class="yui-u">
                                    {% for ed in edu %}
                                    <div class = "job">
                                        <h2><strong>At {{ ed.institution }}:</strong></h2>
                                        <h3>{{ ed.achievements }}</h3>
                                    </div>
                                     {% endfor %}
                                    {% for wk in work %}
                                    <div class = "job">
                                        <h2><strong>At {{ wk.organisation }}:</strong></h2>
									<h3> {{ wk.achievements }}</h3>
                                    </div>
                                    {% endfor %}
                                    <div class = "job">
                                        <h2><strong>Others:</strong></h2>
                                        <h3>{{ personal[0].achievements }}</h3>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
				</div>
			</div>
        </div>
    </body>
</html>

