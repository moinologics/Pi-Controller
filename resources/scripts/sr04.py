import RPi.GPIO as GPIO
import time

data_dir = '../data/'

def log_percent(percent):
	f = open(data_dir+'7-segment-percent-number.txt', 'w')
	f.write(str(percent))
	f.close()

GPIO.setmode(GPIO.BOARD)
GPIO.setwarnings(False)

TRIG = 16
ECHO = 18

i=0
sleep_time = 10

max_distance = 118		#cm
min_distance = 12		#cm

current_distance = max_distance
last_distance = current_distance


GPIO.setup(TRIG,GPIO.OUT)
GPIO.setup(ECHO,GPIO.IN)

GPIO.output(TRIG, False)
print("Calibrating.....")
time.sleep(0.5)

print("Place the object......")



try:
    while True:
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
               log_percent(tank_fill_percent)
               print("percent: ", tank_fill_percent, "%")
               print("current distance: ",current_distance, "cm")
          
       if current_distance>400 and i==1:
          print("place the object....")
          i=0
       
       time.sleep(sleep_time)

except KeyboardInterrupt:
     GPIO.cleanup()
