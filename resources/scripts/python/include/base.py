from . import config
import RPi.GPIO as GPIO
import requests as http
from tm1637 import TM1637
import time
import json


GPIO.setmode(GPIO.BOARD)
GPIO.setwarnings(False)


def get_data():
	with open(config.HOME_DATA_PATH,'r') as hfile:
		home = json.load(hfile)
	return home


def set_data(home):
	with open(config.HOME_DATA_PATH,'w') as hfile:
		hfile.write(json.dumps(home, indent=4))

