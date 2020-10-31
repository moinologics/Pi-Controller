import RPi.GPIO as GPIO
import time

GPIO.setmode(GPIO.BOARD)
GPIO.setwarnings(False)

def decimalToBinary(n, l):
	b = bin(n).replace("0b", "")
	if len(b) < l:
		b = ("0"*(l-len(b))) + b
	return b


def format_number(n):
	n = str(n)
	if len(n) < 3:
		n = ((3-len(n)) * "0") + n
	n = [int(x) for x in n]
	return n

def setDigit(di_val,di_num):

	values = [0,0,0]
	
	#removing all segment's main input
	GPIO.output(d,values)

	
	
	#selecting and setting the correct segments
	values[di_num] = 1
	GPIO.output(d,values)
	
	#setting binary value
	digits = [int(x) for x in decimalToBinary(di_val,4)]	#binary int digits in list
	GPIO.output(D,digits[::-1])						#digits in reverse order

	print(digits[::-1],di_num)


def refresh_display(num, freq):
	num = format_number(num)

	print(num)
#	return

	for count in range(int(1/freq)):
		for di_num in range(3):
			time.sleep(freq)
			setDigit(num[2-di_num], di_num)
		







D = [37,35,33,31]
d = [40,38,36]

freq = 1/200

i = 0

GPIO.setup(D,GPIO.OUT)
GPIO.setup(d,GPIO.OUT)

GPIO.output(D,[0,0,0,0])
GPIO.output(d,[1,1,1])



while(True):

	percent = int(open('7-segment-percent-number.txt','r').read())


	refresh_display(percent,freq)
	
	i += 1
	if i > 100:
		i = 0
