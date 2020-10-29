import argparse
import RPi.GPIO as GPIO

class ParseKwargs(argparse.Action):
    def __call__(self, parser, namespace, values, option_string=None):
        setattr(namespace, self.dest, dict())
        for value in values:
            key, value = value.split('=')
            getattr(namespace, self.dest)[key] = value


def argparser():
	parser = argparse.ArgumentParser()
	parser.add_argument('-k', '--kwargs', nargs='*', action=ParseKwargs)
	args = parser.parse_args()
	if args.kwargs==None:
		return {}
	return args.kwargs


#def setBoardMode(mode):
#	if mode=='BOARD':
#		GPIO.setmode(GPIO.BOARD)
#	elif mode=='BCM':
#		GPIO.setmode(GPIO.BCM)


#def setPinMode(pin, mode):
#	if mode=='IN':
#		GPIO.setup(pin,GPIO.IN)
#	elif mode=='OUT':
#		GPIO.setup(pin,GPIO.OUT)


def setPinOutput(pin, value):
	GPIO.setup(pin,GPIO.OUT)
	if value=='HIGH':
		GPIO.output(pin,GPIO.HIGH)
	elif value=='LOW':
		GPIO.output(pin,GPIO.LOW)


def getPinInput(pin):
	GPIO.setup(pin,GPIO.IN)
	return GPIO.input(pin)


### init ###

GPIO.setwarnings(False)

GPIO.setmode(GPIO.BOARD)

cmdargs = argparser()

error = result = None


######## functionality ########



if 'opr' in cmdargs:

	opr = cmdargs['opr']
	del cmdargs['opr']

	try:
		if 'pin' in cmdargs:
			cmdargs['pin'] = int(cmdargs['pin'])

		result = globals()[opr](**cmdargs) #calling function with args
		
	except Exception as e:
		error = str(e)

else:
	error = 'missing opr'


if error == None:
	print(str({'status': 1, 'msg': result}))
else:
	print(str({'status': 0, 'error': error}))

