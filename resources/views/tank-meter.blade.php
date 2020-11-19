<!DOCTYPE html>
<html>
<head>
	<title>water tank percentage</title>
	<link rel="stylesheet" href="{{url('/assets/libs/css/bootstrap.min.css')}}">
	<script src="{{url('/assets/libs/js/fluid-meter.js')}}"></script> 
	<style>
		body{
			height: 100vh;
		}
	</style>
</head> 
<body>

	<div class="container-fluid h-100 border">
		<div class="row align-items-center h-100">
			<div class="col-12 border text-center">
				<h3>Water Tank Meter</h3>
				<div id="fluid-meter"></div>
			</div>
		</div>
	</div>
  
</body>
</html>

<script>

	function meter_init(fm)
	{
		var vw = document.documentElement.clientWidth;
		
		fm.init({
		    targetContainer: document.getElementById("fluid-meter"),
		    fillPercentage: {{$percent}},
		    options: {
		        fontSize: "60px",
		        drawPercentageSign: true,
		        drawBubbles: true,
		        size: (vw>1000) ? (vw*0.5) : (vw*0.8),
		        borderWidth: 30,
		        backgroundColor: "#e2e2e2",
		        foregroundColor: "#fafafa",
		        foregroundFluidLayer: {
		            fillStyle: "#16E1FF",
		            angularSpeed: 30,
		            maxAmplitude: 10,
		            frequency: 30,
		            horizontalSpeed: -20
		        },
		        backgroundFluidLayer: {
		            fillStyle: "#00ffee",
		            angularSpeed: 100,
		            maxAmplitude: 5,
		            frequency: 22,
		            horizontalSpeed: 20
		        }
		    }
		});
	}
    	
    	function refresh_percentage(fm)
    	{
    		var xhttp = new XMLHttpRequest(); 
    		xhttp.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){ 
				fm.setPercentage(Number(xhttp.responseText.trim()));
				console.log(xhttp.responseText);
			}
		};
		xhttp.open('GET','/tank-meter?getpercent',true);
		xhttp.send();
	}

//	document.write(document.documentElement.clientWidth)

	var fm = new FluidMeter();

	meter_init(fm);
    
    setInterval(refresh_percentage, 10 * 1000, fm); // 10 seconds
</script>
