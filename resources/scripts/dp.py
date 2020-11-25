import RPi.GPIO as GPIO
import time
import json

GPIO.setmode(GPIO.BOARD)
GPIO.setwarnings(False)

home_data = '../data/home.json'

dp = 29
motor = 32


def log_data(filling):

	with open(home_data,'r') as hfile:
		home = json.load(hfile)
	
	with open(home_data,'w') as hfile:
		home['tank']['filling'] = filling
		hfile.write(json.dumps(home, indent=4))

	print(filling)


GPIO.setup(motor, GPIO.IN)
GPIO.setup(dp, GPIO.OUT)


while(1):
	if GPIO.input(motor):
		log_data(1)
		GPIO.output(dp, 1)
		time.sleep(1)
		GPIO.output(dp, 0)
		time.sleep(1)
	else:
		log_data(0)
		time.sleep(5)