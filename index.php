<?php

// set defaults
	$term_a = "in*"; 
	$term_as = "in*";
	$term_as = preg_quote($term_a);
	$term_as = str_replace('*', '[\\\S]*', $term_as);

	$term_b = "*em*"; 
	$term_bs = "*em*";
	$term_bs = preg_quote($term_b);
	$term_bs = str_replace('*', '[\\\S]*', $term_bs);
	
	$bounds = 10;

	$input_text = "
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam condimentum dolor sed dui pretium sit amet aliquam ipsum fringilla. Fusce eget sem et orci feugiat interdum in ac dui. Integer nec diam semper massa vestibulum egestas vel venenatis ante. Curabitur sollicitudin dui non nisl vestibulum vestibulum varius neque convallis. Maecenas sem sem, fringilla ut tincidunt convallis, accumsan et leo. Integer ultrices nisi vitae nulla rhoncus vestibulum. In et arcu neque.

Nam pretium tellus ac libero sollicitudin ut bibendum tortor fermentum. Morbi sagittis urna at nisi ultrices feugiat. Nulla facilisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer blandit accumsan dignissim. Sed sagittis augue quis purus sodales sed pulvinar ipsum mattis. Curabitur ac felis nisl, eget scelerisque nisl. Etiam massa elit, imperdiet eu placerat vitae, interdum ullamcorper quam. Donec posuere sem vel mi elementum facilisis. Sed nec mauris sed massa euismod ornare.

Pellentesque tellus turpis, fringilla tempus laoreet eu, malesuada non enim. Nullam eu massa orci, a sagittis massa. Praesent ligula sapien, euismod sed dapibus quis, imperdiet vitae justo. Cras purus purus, placerat eu pretium sed, facilisis quis lectus. Vivamus quis hendrerit arcu. Sed vitae risus sed diam imperdiet rhoncus. Curabitur euismod sem id leo consequat sed porttitor mauris tristique. Sed ante ante, aliquet sit amet ornare nec, viverra vitae sapien. Suspendisse fringilla, nulla in viverra venenatis, nisi lectus porttitor nulla, sed dignissim quam nunc vel eros. Integer lobortis odio lacinia elit sagittis rutrum vel vel est. Fusce imperdiet tempus neque sed aliquam. Integer sed odio libero, a faucibus mi. In vel eros urna, quis dapibus nunc. Nulla facilisi. Curabitur molestie est non metus tincidunt adipiscing. Etiam sollicitudin scelerisque nibh, a gravida lacus facilisis ut.

Aliquam et arcu nec ante fermentum placerat id quis neque. Vivamus cursus nunc ac nibh viverra quis accumsan tortor gravida. Proin viverra mi eu erat vulputate vehicula. Donec ultricies, nunc ut pharetra rhoncus, nulla eros pharetra justo, non convallis diam ipsum ut arcu. Proin id lacus nisl. Fusce lacus eros, pharetra non porta sed, placerat pellentesque nulla. Fusce sit amet cursus diam. Ut a nisl non elit feugiat sollicitudin quis id orci. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.

Nam consequat sagittis mollis. Sed faucibus egestas nunc, non rutrum elit fringilla ac. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nullam iaculis purus eu nibh aliquet et facilisis enim interdum. Aliquam convallis laoreet elit et volutpat. Duis posuere blandit auctor. Integer tincidunt tellus gravida dui fringilla in pellentesque purus ultricies. Nunc a tempus tortor. Aenean eu nunc in justo venenatis porta. Etiam viverra quam vitae odio aliquam sed accumsan magna dignissim. Aliquam erat volutpat. Aliquam feugiat ultrices tempor. Sed in nisi elit. Nulla facilisi. Mauris orci est, pharetra in pellentesque non, consectetur nec ante.
";

$wordRegex = '\\\S*[\\\s]+';
$bookmarklet = "javascript:(function(){var t=window.getSelection?window.getSelection().toString():document.selection.createRange().text;t=encodeURIComponent(t);window.location='http://nealshyam.com/legal/index.php?input_text='+t;})()";

// Output
echo'<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>LegalGrep</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content = "LegalGrep highlights all passages which contain two key phrases within a set proximity.">
    <meta name="author" content = "Neal Shyam and Eric Justusson">

    <!-- CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" MEDIA="handheld, screen"/>
    
    <style>
      body {padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */}
    </style>

    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">    
    <link href="assets/css/print.css" rel="stylesheet" media="print" />

	<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<link type="text/css" rel="stylesheet" href="assets/css/jquery.highlighttextarea.css" />
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	
	<!---- BEGIN HIGHLIGHT TEXT AREA ---->	
	<link type="text/css" rel="stylesheet" href="assets/css/jquery.highlighttextarea.css" />
	<script type="text/javascript" src="assets/js/jquery.highlighttextarea.js"></script>
	<script type="text/javascript" src="assets/js/preg_quote.js"></script>
	<script type="text/javascript">
   	 $(document).ready(function() {
   	 	$("#go").click(function() {
   	 		  
   	 		  var terma_s = $("#terma").val();
   	 		  var terma = preg_quote(terma_s, "g");
   	 		  var terma = terma_s.replace("*", "[\\\S]*");
			  
			  var termb_s = $("#termb").val();
			  var termb = preg_quote(termb_s, "g");
			  var termb = termb_s.replace("*", "[\\\S]*");
			  
			  var bounds = $("#bounds").val();
			  
			  var wordregex = "\\\S*[\\\s]+";
			  
	          alert("Term A: " + terma + " , Term B: " + termb + ", Proximity: " + bounds);
   	 		  
			  $("textarea").highlightTextarea({
					  words: ["("+ terma +"[^a-z0-9]*\\\s+("+ wordregex +"){0,"+ (bounds-2) +"}"+ termb +"[^a-z0-9]*\\\s+)"],
					  caseSensitive: false
				  
			 });
     	}); 
   	 });
	</script>
	<!---- END HIGHLIGHT TEXT AREA ---->

	<!---- SHARE THIS BLOCK ------->
	<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
	<script type="text/javascript">stLight.options({publisher: "ur-fac0377b-c7eb-18d4-b99f-7057b5df1fa", doNotHash: false, doNotCopy: false, hashAddressBar: true});</script>
	<!---- END SHARE THIS BLOCK --->

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="assets/ico/favicon.ico">
  </head>

  <body>
  
 	<!-- BEGIN Google Analytics -->
	<script>
  		(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
  		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  		})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');

  		ga(\'create\', \'UA-41047928-1\', \'nealshyam.com\');
  		ga(\'send\', \'pageview\');

	</script>
 	<!-- END Google Analytics -->

    <div class="navbar navbar-inverse navbar-fixed-top hideme">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a data-toggle="tooltip" title="A friend asked if this was possible. It is." class = "tip brand" href="#">LegalGrep</a>
          <div class="nav-collapse collapse">
          <ul class="nav">
              <li><a class = "tip" data-toggle="tooltip" title="Neal & Eric work at ADstruc" href="#">&copy; 2013 Neal [App] & Eric [RegEx]</a></li>
              <li><a class = "tip" data-toggle="tooltip" title="Got feedback?" href="mailto:me@nealshyam.com?subject=LegalGrep">Bugs + Questions</a></li>
              <li><a class = "tip" data-toggle="tooltip" title="This bookmarklet runs LegalGrep on any selected text" href="'.$bookmarklet.'">Bookmarklet</a></li>
              <li><a class = "tip" data-toggle="tooltip" title="Help us get that social juice!"><span class=\'st_facebook_hcount\' displayText=\'Facebook\'></span><span class=\'st_twitter_hcount\' displayText=\'Tweet\'></span><span class=\'st_linkedin_hcount\' displayText=\'LinkedIn\'></span></a></li>

            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    
    <div class = "container ">    	
    	<div class = "row ">
			<div class = "span10 ">
				<legend class="hideme">Highlight all passages containing terms A & B within proximity C. Print to Export.</legend>
				
				<div class = "row hideme">
					<div class = "span3"><p class="text-left"><span class="badge badge-success">A</span> Highlight passages where <i class="icon-chevron-down"></i></p></div>
					<div class = "span3"><p class="text-left"><span class="badge badge-success">B</span> and <i class="icon-chevron-down"></i></p></div>
					<div class = "span2"><p class="text-left"><span class="badge badge-success">C</span> appear within <i class="icon-chevron-down"></i></p> </div>	
					<div class = "span2"><p class="text-left">words of each other.</p></div>	
				</div>
		
				<div class = "row hideme">	
					
					<div class = "span3">
						<input id ="terma" type="text"  data-toggle="tooltip" title="Leading & trailing wildcards (*) accepted" class=" tip input-block-level" placeholder="Enter Term A" name = "term_a" value ="'.$term_a.'">
					</div>
			
					<div class = "span3">
						<input id ="termb" type="text" data-toggle="tooltip" title="passage must begin with term A and end with term B" class=" tip input-block-level" placeholder="Enter Term B" name = "term_b" value ="'.$term_b.'">
					</div>
			
					<div class = "span2">
						<select id ="bounds" name="bounds" class="input-block-level">
							<option value = "5" '; if ($bounds == 5){echo 'selected';} echo'>5</option>
							<option value = "10" '; if ($bounds == 10){echo 'selected';} echo'>10</option>
							<option value = "25" '; if ($bounds == 25){echo 'selected';} echo'>25</option>
							<option value = "50" '; if ($bounds == 50){echo 'selected';} echo'>50</option>
							<option value = "100" '; if ($bounds == 100){echo 'selected';} echo'>100</option>
						</select>
					</div>
			
					<div class = "span1">
						<button id ="go" type="button" data-toggle="tooltip" title="Click to highlight" class=" tip btn btn-primary btn-block"><i class="icon-search icon-white"></i></button>
					</div>
			
					<div class = "span1">
						<button type="button" data-toggle="tooltip" title="Print to export full highlighted document. Remember to turn on background colors & images." class=" tip btn btn-inverse btn-block" onClick="window.print()"><i class="icon-print icon-white"></i></button>
					</div>
			
				</div>
		
				<div class = "row ">	
					<div class = "span10 ">

						<div class = "hide_def"><p>LegalGrep &copy; 2013 <a href="http://nealshyam.com/legal">Neal & Eric</a> &nbsp;<a href="mailto:me@nealshyam.com?subject=LegalGrep">Bugs & Questions</a>. </p><p>Highlight all passages where <strong>'.$term_a.'</strong> and <strong>'.$term_b.'</strong> appear within <strong>'.$bounds.'</strong> words of each other.</p><hr/></div>
					
						<textarea style= "overflow:hidden;" rows="22" class="input-block-level hideme lprint" name="input_text" placeholder="Paste source text">'.$input_text.'</textarea>
						
					</div>
				</div>
			</div>
			
			<div class = "span2 hidden-tablet hidden-phone hideme">
				<div class = "row">
					<div id = "adbox" class = "text-right">
						<script type="text/javascript"><!--
						google_ad_client = "ca-pub-0448627255152048";
						/* Legal Grep */
						google_ad_slot = "3239961821";
						google_ad_width = 160;
						google_ad_height = 600;
						//-->
						</script>
						
						<script type="text/javascript"
							src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
						</script>
						
					</div>
				</div>
			</div>
		<script>$(".tip").tooltip({placement:"bottom"})</script>	
    	</div>
    	
    	
    </div>

  </body>
</html>';
?>