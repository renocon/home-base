<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Data Viz</title>
</head>
<body>
	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="d3.min.js" charset="utf-8"></script>
	<script src="parcoords.js"></script>
	<link rel="stylesheet" href="parcoords.css">
	<script>

	var names = [];
	var labels = [];

	function applyName(x){

		labels.eq(x).text(names[x]);
	}


	function getMeta(){
		var len = $('.label').length;
		labels = $('.label');
     	console.log(labels);
     	for(var x = 0 ;x<len;x++)applyName(x);
	}

	$(document).ready(function(){

		var rid = setInterval(function(){
			$('#loading').append('<br>Loading...');
		},2000);

		var request = $.ajax({
	        type: 'GET',
	        url: "getdata.php",
	        dataType: 'json',
	        success: function(data) {
	                       
	        	$('#loading').empty();
	        	clearInterval(rid);
	            var pc = d3.parcoords()("#example")
				  .data(data.data)
				  .render()
				  .ticks(3)
				  .createAxes();

				 console.log(pc);  
				 names = data.names;
				 getMeta();
		       },
		    error: function(jqXHR, textStatus, errorThrown) {
		    	$('#loading').empty();
		    	clearInterval(rid);
		    	$('#loading').append('error');
		         
		         }
        });

     	$.ajax(request);

     });

     	

	</script>
	<div id="loading">Loading...</div>
	<div class="parcoords" id='example' style="width:1100px;height:668px"></div>
</body>
</html>