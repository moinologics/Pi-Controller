from include.base import TM1637,time,get_data
from include.config import CLOCK,DIO


display = TM1637(clk=CLOCK, dio=DIO)


def display_turnoff():
	display.write([0, 0, 0, 0])


def show_clock(time_count_second):
	time_count_second //= 2
	while time_count_second:
		display.show(time.strftime("%I%M"), colon=True)
		time.sleep(1)
		display.show(time.strftime("%I%M"), colon=False)
		time.sleep(1)
		time_count_second -= 1
	display_turnoff()


def show_tank_percent(time_count_second):
	value = str(get_data()['tank']['filled_percentage'])
	value = ("0"*(4-len(value)))+value
	display.show(value,colon=False)
	time.sleep(time_count_second)
	display_turnoff()


def show_temperature(time_count_second):
	value = get_data()['weather']['accuweather']['Temperature']['Metric']['Value']
	display.temperature(round(value))
	time.sleep(time_count_second)
	display_turnoff()


while(1):
	try:
		show_clock(10)
		show_tank_percent(10)
		show_temperature(10)
	except:
		pass


