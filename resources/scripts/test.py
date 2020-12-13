import RPi.GPIO as GPIO
import time


GPIO.setmode(GPIO.BOARD)
GPIO.setwarnings(False)


TRIG = 15
ECHO = 13


GPIO.setup(TRIG,GPIO.OUT)
GPIO.setup(ECHO,GPIO.IN)

GPIO.output(TRIG, True)

while 1:
	print(GPIO.input(ECHO))
	time.sleep(1)
