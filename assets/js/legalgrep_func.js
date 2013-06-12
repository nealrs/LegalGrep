$(document).ready(function() {
            // initialize plugin
            $("textarea").highlightTextarea({ caseSensitive: false });
            
            $(".highlight_button").click(function() {        	

                // define word RegEx
                var wordRegex = "\\\S*[\\\s]+";
                // define word boundry RegEx
                var wordBoundary = "[^a-z0-9]*\\\s+";

                // get values from form
                var termA  = $("#terma").val();
                var termB  = $("#termb").val();
                var bounds = $("#bounds").val();

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

            // update highlight query on keydown
            $("#terma, #termb, #bounds").keyup(showHighlightMode);

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