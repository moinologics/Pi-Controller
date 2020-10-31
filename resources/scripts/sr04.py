import RPi.GPIO as GPIO
import time


GPIO.setmode(GPIO.BOARD)

TRIG = 3
ECHO = 5
i=0

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

       distance = pulse_duration * 17150

       distance = round(distance, 2)
  
       if distance<=400 and distance>=2:
          print("distance:",distance,"cm")
          i=1
          
       if distance>400 and i==1:
          print("place the object....")
          i=0
       time.sleep(2)

except KeyboardInterrupt:
     GPIO.cleanup()