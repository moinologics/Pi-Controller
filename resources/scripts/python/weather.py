from include.base import http,json,time,get_data,set_data
from include.config import ACCU_REQ_TIME

loc = '3110618' #for sainthal,uttar pradesh india


base_url = 'http://dataservice.accuweather.com'
key = 'nxw72toGHVIr9loXwk9SEKGfCl5UtMq6'


url = '{}/currentconditions/v1/{}?apikey={}'.format(base_url,loc,key)


while (1):
	try:
		current_time = round(time.time())
		home = get_data()
		previous_req_time = home['weather']['accuweather']['EpochTime']
	
		if previous_req_time+(ACCU_REQ_TIME*60) < current_time:
			r = http.get(url)
			if(r.status_code == 200):
				resp = r.json()[0]
				resp['EpochTime'] = current_time
				home['weather']['accuweather'] = resp
				set_data(home)
			else:
				print('Error, status code: ' + r.status_code)
	except:
		pass



