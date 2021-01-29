import subprocess as task
import re


def SetMasterVol(left_percent,right_percent):
	cmd = 'amixer set Master {}%,{}%'.format(left_percent,right_percent)
	result = task.getoutput(cmd)
	return result


def GetMasterVol():
	cmd = 'amixer get Master | grep "%"'
	result = task.getoutput(cmd)
	
	search = re.search('\[(.*)%\]',result)
	left_percent = search.group(0)[1:-2]
	right_percent = search.group(1)[1:-2]

	return left_percent,right_percent


#GetMasterVol()

SetMasterVol(60,70)

print(GetMasterVol())
