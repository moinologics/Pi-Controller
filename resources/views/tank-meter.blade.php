<!DOCTYPE html>
<html>
<head>
	<title>water tank percentage</title>
	<link rel="stylesheet" href="{{url('/assets/libs/css/bootstrap.min.css')}}">
	<script src="{{url('/assets/libs/js/jquery.min.js')}}"></script> 
	<script src="{{url('/assets/libs/js/fluid-meter.js')}}"></script> 
	<style>
		body{
			height: 100vh;
		}
		h3{
			font-size: 5vw;
			color: "#16E1FF";
		}
	</style>
</head> 
<body>

	<div class="container-fluid h-100">
		<div class="row align-items-center h-100">
			<div class="col-12 text-center">
				<div class="px-5 py-3 d-inline-block rounded" id="title">
					<h3 class="text-light">Water Tank Meter</h3>
				</div>
				
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
		        size: (vw>1000) ? (vw*0.4) : (vw*0.8),
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
    		$.get('/tank-meter?getpercent', function(data,status){
    			if(status == 'success')
    			{
    				fm.setPercentage(data.filled_percentage);
    				if(data.filling)
    				{
    					$('#title').removeClass('bg-danger').addClass('bg-success')
    				}
    				else{
    					$('#title').removeClass('bg-success').addClass('bg-danger')
    				}
    			}
    			else{
    				console.log(status);
    			}
    		});
	}

//	document.write(document.documentElement.clientWidth)

	var fm = new FluidMeter();

	meter_init(fm);
    
    setInterval(refresh_percentage, 10 * 1000, fm); // 10 seconds
</script>
