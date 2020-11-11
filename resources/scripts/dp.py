import RPi.GPIO as GPIO
import time

GPIO.setmode(GPIO.BOARD)
GPIO.setwarnings(False)

dp = 29
motor = 32

GPIO.setup(motor, GPIO.IN)
GPIO.setup(dp, GPIO.OUT)

GPIO.output(dp, 0)

while(1):
	if GPIO.input(motor):
 		GPIO.output(dp, 1)
 		time.sleep(1)
 		GPIO.output(dp, 0)
 		time.sleep(1)
	else:
		print("motor not on")
		time.sleep(5)