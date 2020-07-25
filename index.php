<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pi Controller</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/vue-debug.js"></script>
	<script src="assets/js/axios.min.js"></script>
</head>
<body>
	
	<br><br><br><br>
	<div class="container border" id="pi-controles">
		<div class="row">
			
			<div class="col-md-12 col-lg-12 py-3">
				<h4 class="my-4">Set Mode Of GPIO Pin</h4>
				<form class="form-inline" @submit.prevent="SetPinMode">
				  	<div class="form-group mb-2">
				    	<label for="pinmode-pin">Pin No.</label>
					    <select id="pinmode-pin" name="gpiopin" class="form-control">
					        <option v-for='(pin, key) in GPIOpins' :value='pin' >{{pin}}</option>
					    </select>
				  	</div>
				  	<div class="form-group mx-sm-3 mb-2">
				    	<label for="pinmode-mode">Pin Mode.</label>
					    <select id="pinmode-mode" name="pinmode" class="form-control">
					        <option value="in">IN</option>
					        <option value="out">OUT</option>
					    </select>
				  	</div>
				  	<button type="submit" name="submit" class="btn btn-primary px-3">Set</button>
				</form>
			</div>

			<div class="col-md-12 col-lg-12 py-3">
				<h4 class="my-4">Set Output Of GPIO Pin</h4>
				<form class="form-inline" @submit.prevent="SetPinValue">
				  	<div class="form-group mb-2">
				    	<label for="pinout-pin">Pin No.</label>
					    <select id="pinout-pin" name="gpiopin" class="form-control">
					        <option v-for='(pin, key) in GPIOpins' :value='pin' >{{pin}}</option>
					    </select>
				  	</div>
				  	<div class="form-group mx-sm-3 mb-2">
				    	<label for="pinout-value">Pin Value.</label>
					    <select id="pinout-value" name="pinvalue" class="form-control">
					        <option value="1">ON</option>
					        <option value="0">OFF</option>
					    </select>
				  	</div>
				  	<button type="submit" name="submit" class="btn btn-primary px-3">Set</button>
				</form>
			</div>

		</div>
	</div>

</body>
</html>

<script>
	
	var relations = new Vue({

        el: '#pi-controles',
        data: {
        	GPIOpins: [0,11,22],
        },
        methods: {
        	SetPinMode: function(submitEvent){
        		var form = submitEvent.target.elements;
        		const pin = form.gpiopin.value;
        		const mode = form.pinmode.value;
        		form.submit.disabled = true;
        		axios({
	              	method: 'GET',
	              	url: 'ajax.php',
	              	params: {opr:'setpinmode',pin:pin,mode:mode}
	            })
	            .then((r)=>{
	              	var res = r.data;
	              	if(res.status){
	                	alert(res.msg);
	              	}
	              	else{
	                	alert('Server Error: '+ res.msg);
	              	}
	              	// console.log(res);
	            }).then(()=>{
	            	form.submit.disabled = false;
	            })
        	},
        	SetPinValue: function(submitEvent){
        		var form = submitEvent.target.elements;
        		const pin = form.gpiopin.value;
        		const value = form.pinvalue.value;
        		form.submit.disabled = true;
        		axios({
	              	method: 'GET',
	              	url: 'ajax.php',
	              	params: {opr:'setpinvalue',pin:pin,value:value}
	            })
	            .then((r)=>{
	              	var res = r.data;
	              	if(res.status){
	                	alert(res.msg);
	              	}
	              	else{
	                	alert('Server Error: '+ res.msg);
	              	}
	              	// console.log(res);
	            }).then(()=>{
	            	form.submit.disabled = false;
	            })
        	}
        },
        created: function(){
        	axios({
              	method: 'GET',
              	url: 'ajax.php',
              	params: {opr:'getgpiolist'}
            })
            .then((r)=>{
              	var res = r.data;
              	if(res.status){
                	this.GPIOpins = res.pins;
              	}
              	else{
                	alert('Server Error: '+ res.msg);
              	}
              	// console.log(res);
            })
        }
    })



</script>
