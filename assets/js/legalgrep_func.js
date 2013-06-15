$(document).ready(function() {
			// set page defaults
			
			$("#terma").val("in*");
            $("#termb").val("*em*");
            $("#text-to-query").val("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam condimentum dolor sed dui pretium sit amet aliquam ipsum fringilla. Fusce eget sem et orci feugiat interdum in ac dui. Integer nec diam semper massa vestibulum egestas vel venenatis ante. Curabitur sollicitudin dui non nisl vestibulum vestibulum varius neque convallis. Maecenas sem sem, fringilla ut tincidunt convallis, accumsan et leo. Integer ultrices nisi vitae nulla rhoncus vestibulum. In et arcu neque.\n\rNam pretium tellus ac libero sollicitudin ut bibendum tortor fermentum. Morbi sagittis urna at nisi ultrices feugiat. Nulla facilisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer blandit accumsan dignissim. Sed sagittis augue quis purus sodales sed pulvinar ipsum mattis. Curabitur ac felis nisl, eget scelerisque nisl. Etiam massa elit, imperdiet eu placerat vitae, interdum ullamcorper quam. Donec posuere sem vel mi elementum facilisis. Sed nec mauris sed massa euismod ornare.\n\rPellentesque tellus turpis, fringilla tempus laoreet eu, malesuada non enim. Nullam eu massa orci, a sagittis massa. Praesent ligula sapien, euismod sed dapibus quis, imperdiet vitae justo. Cras purus purus, placerat eu pretium sed, facilisis quis lectus. Vivamus quis hendrerit arcu. Sed vitae risus sed diam imperdiet rhoncus. Curabitur euismod sem id leo consequat sed porttitor mauris tristique. Sed ante ante, aliquet sit amet ornare nec, viverra vitae sapien. Suspendisse fringilla, nulla in viverra venenatis, nisi lectus porttitor nulla, sed dignissim quam nunc vel eros. Integer lobortis odio lacinia elit sagittis rutrum vel vel est. Fusce imperdiet tempus neque sed aliquam. Integer sed odio libero, a faucibus mi. In vel eros urna, quis dapibus nunc. Nulla facilisi. Curabitur molestie est non metus tincidunt adipiscing. Etiam sollicitudin scelerisque nibh, a gravida lacus facilisis ut.\n\rAliquam et arcu nec ante fermentum placerat id quis neque. Vivamus cursus nunc ac nibh viverra quis accumsan tortor gravida. Proin viverra mi eu erat vulputate vehicula. Donec ultricies, nunc ut pharetra rhoncus, nulla eros pharetra justo, non convallis diam ipsum ut arcu. Proin id lacus nisl. Fusce lacus eros, pharetra non porta sed, placerat pellentesque nulla. Fusce sit amet cursus diam. Ut a nisl non elit feugiat sollicitudin quis id orci. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.\n\rNam consequat sagittis mollis. Sed faucibus egestas nunc, non rutrum elit fringilla ac. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nullam iaculis purus eu nibh aliquet et facilisis enim interdum. Aliquam convallis laoreet elit et volutpat. Duis posuere blandit auctor. Integer tincidunt tellus gravida dui fringilla in pellentesque purus ultricies. Nunc a tempus tortor. Aenean eu nunc in justo venenatis porta. Etiam viverra quam vitae odio aliquam sed accumsan magna dignissim. Aliquam erat volutpat. Aliquam feugiat ultrices tempor. Sed in nisi elit. Nulla facilisi. Mauris orci est, pharetra in pellentesque non, consectetur nec ante.");

            // initialize plugin
            $("textarea").highlightTextarea({ caseSensitive: false });
            
            $(".highlight_button").click(function() {        	

                // define word RegEx
                var wordRegex = "\\\S*[\\\s]+";
                // define word boundry RegEx
                var wordBoundary = "[^a-z0-9]*\\\s+";

                // get values from form & set print proxy variables
                var termA  = $("#terma").val();
                	var termAp = termA;
                var termB  = $("#termb").val();
                	var termBp = termB;
                var bounds = $("#bounds").val();
					var boundsp = bounds;
					
                // build regex for in between words
                var inBetweenWords = "(WORDREGEX){0,MAXWORDS}";
                // fill with correct values
                // done this way just to make it more readable
                inBetweenWords = inBetweenWords.replace("WORDREGEX", wordRegex);
                inBetweenWords = inBetweenWords.replace("MAXWORDS", (bounds - 2));

                // escape any RegEx special characters
                // from search terms
                termA = preg_quote(termA);
                termB = preg_quote(termB);

                // replace wildcards (*) with wildcard RegEx on search terms
                // the wildcard will be escaped from the preg_quote
                // function, so search for escaped version
                termA = termA.replace(/\\\*/g, "[\\\S]*");
                termB = termB.replace(/\\\*/g, "[\\\S]*");

                // append word boundary regex to terms
                termA += wordBoundary;
                termB += wordBoundary;

                // build forward search regex string (i.e. A -> B)
                var forwardSearch = wordBoundary + termA + inBetweenWords + termB;
                // build forward search regex string (i.e. B -> A)
                var reverseSearch = wordBoundary + termB + inBetweenWords + termA;

				// run search query & call plugin
                $("textarea").highlightTextarea("setWords", [forwardSearch, reverseSearch]);
				
				// toggle text area & display div, copy innerhtml from highlighter into display div, and replace newlines with <br>
				$(".highlightTextarea").hide(0);	
				$("#toggle").html($(".highlighter").html().replace(/\n/g, "<br />"));
				$("#toggle").show(0);
				
				// toggle print/search/edit buttons based on current visibility state.
                $(".buttons-container").hide();
				$(".highlighted-buttons-container").show();
                // show highlighting
                $(".highlighterContainer").show();
                
                // update print stylesheet header phrase using print proxy variables
                document.getElementById('termAp').innerHTML = termAp;
                document.getElementById('termBp').innerHTML = termBp;
                document.getElementById('boundsp').innerHTML = boundsp;
                
                // update modal variables (count # of words entered, and number of spans/classes with .highlight class
                var raw_wordcount = $('#text-to-query').val().split(/\s/g).length;
                var highlight_wordcount = (document.getElementsByClassName("highlight").length)/2;
                
                //var saved_highlighters = highlight_wordcount;
                var saved_hours = Math.round((raw_wordcount/3000)*10)/10;
                var saved_dollars = Math.round(saved_hours*400);
                
                document.getElementById('num_hours').innerHTML = saved_hours;
                document.getElementById('num_dollars').innerHTML = saved_dollars;
								
            });
            
            // handle edit button click event
            $(".edit_button").click(function() {
                $(".buttons-container").show();
                $(".highlighted-buttons-container").hide();
                $(".highlighterContainer").hide();
            	$(".highlightTextarea").show(0);
            	$("#toggle").hide(0);
            });

            var showEditMode = function(e, focus) {
                var $editButton = $(".edit_button");
                if ($editButton.is(":visible")) {
                    $editButton.click();
                    if (focus) {
                        window.setTimeout(function(){
                            $("#text-to-query").focus();
                        }, 0);
                    }
                }                
            };

            var showHighlightMode = function() {
                $(".highlight_button").click();
            };

            // update highlight query on keyup
            $("#terma, #termb").keyup(_.debounce(showHighlightMode, 500));

            // switch back to edit mode highlighted text is clicked
            $("#toggle").on("mousedown click", function() {
                showEditMode(null, true);
            });

            // switch back to edit mode highlighted text is clicked
            $("#text-to-query").mouseout(showHighlightMode);

            // execute query when bounds change
            $("#bounds").change(showHighlightMode);

            // handle print click event
            $(".print_button").click(function() {                
                window.print();
            });
            
            // initliaze highlight again
            showHighlightMode();
        });
