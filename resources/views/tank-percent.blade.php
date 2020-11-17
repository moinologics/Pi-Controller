<!DOCTYPE html>
<html>
<head>
	<title>water tank percentage</title> 
    	<style>
        .content-center{
        	justify-content: center; 
         	align-items: center;
          min-height: 100vh;
          display: flex;
        }
        .font-largest{ 
        	font-size : 70px;
        }
    </style> 
</head> 
<body> 
	<div class="content-center">
		<div class="box">
			<h1 class="font-largest">Tank percent : <span id="percent">{{$percent}}</span> %</h1>
        	</div>
     </div>
</body>
</html>

<script>
    
    function refresh_percentage()
    {
    		var xhttp = new XMLHttpRequest(); 
        	xhttp.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){ 
				document.getElementById('percent').innerText = xhttp.responseText.trim();
				console.log(xhttp.responseText);
			}
        	};
        	xhttp.open('GET','/tank-percent?getpercent',true);
        	xhttp.send();
    }
    
    setInterval(refresh_percentage, 10 * 1000); // 10 seconds
</script>
