import RPi.GPIO as GPIO
import time


GPIO.setmode(GPIO.BOARD)

TRIG = 3
ECHO = 5

i=0

max_distance = 118		#cm
min_distance = 12		#cm

current_distance = max_distance
last_distance = current_distance

file = open("../../7-segment-percent-number.txt", "w")


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
               tank_percent = ( (current_distance-min_distance)/(max_distance-min_distance) ) * 100
               print("percent: ", 100 - int(tank_percent), "%")
               print("current distance: ",current_distance, "cm")
          
       if current_distance>400 and i==1:
          print("place the object....")
          i=0
       time.sleep(2)

except KeyboardInterrupt:
     GPIO.cleanup()