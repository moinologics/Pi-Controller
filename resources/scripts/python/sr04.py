from include.base import GPIO,time,set_data,get_data
from include.config import TRIG,ECHO,SR04_SLEEP_TIME


def log_data(percent, distance):

	home = get_data()

	home['tank']['filled_percentage'] = int(percent)
	home['tank']['current_water_distance_cm'] = distance
	
	set_data(home)


i=0

max_distance = 118		#cm
min_distance = 10		#cm

current_distance = max_distance
last_distance = current_distance


GPIO.setup(TRIG,GPIO.OUT)
GPIO.setup(ECHO,GPIO.IN)

GPIO.output(TRIG, False)
print("Calibrating.....")
time.sleep(0.5)

print("Place the object......")



while True:
	try:
		GPIO.output(TRIG, True)
		time.sleep(0.00001)
		GPIO.output(TRIG, False)

		while GPIO.input(ECHO)==0:
			pulse_start = time.time()

		while GPIO.input(ECHO)==1:
			pulse_end = time.time()
		
		pulse_duration = pulse_end - pulse_start

		current_distance = pulse_duration * 17150

		current_distance = round(current_distance, 2)

		if current_distance<=400 and current_distance>=2:
			i=1
			if current_distance != last_distance:
				tank_empty_percent = int( ( (current_distance-min_distance)/(max_distance-min_distance) ) * 100 )
				tank_fill_percent = 100 - tank_empty_percent
				print("percent: ", tank_fill_percent, "%")
				print("current distance: ",current_distance, "cm")
				log_data(tank_fill_percent, current_distance)
     
		if current_distance>400 and i==1:
			print("place the object....")
			i=0
  
		time.sleep(SR04_SLEEP_TIME)
		
	except Exception as e:
		print(str(e))
		#raise e

	except KeyboardInterrupt:
		break
