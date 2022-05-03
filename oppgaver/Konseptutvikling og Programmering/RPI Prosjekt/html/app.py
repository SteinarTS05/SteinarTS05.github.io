import time
from bme280 import BME280
import mysql.connector
from ltr559 import LTR559

mydb = mysql.connector.connect(
  host="piasvg.mysql.database.azure.com",
  user="chickentikkamasala",
  password="Kylling0980",
  database="chickentikkamasala"
)
try:
    from smbus2 import SMBus
except ImportError:
    from smbus import SMBus

bus = SMBus(1)
bme280 = BME280(i2c_dev=bus)
ltr559 = LTR559()

temperature1 = round(bme280.get_temperature(),2)
fuktighet1 = round(bme280.get_humidity(),2)
lufttrykk1 = round(bme280.get_pressure(),2)
lys1 = ltr559.get_lux()
print ("Sensorer starter opp!")
print ("Venter 10 sekund!")
time.sleep(10)
while True:
	temperatur = round(bme280.get_temperature(),2)
	fuktighet = round(bme280.get_humidity(),2)
	lufttrykk = round(bme280.get_pressure(),2)
	lys = round(ltr559.get_lux(),2)
	named_tuple = time.localtime() # get struct_time
	time_string = time.strftime("%Y-%m-%d %H:%M:%S", named_tuple)
	cursor = mydb.cursor()
	print (time_string, "///", "temperatur =", temperatur, "ºC", "///", "fuktighet =", fuktighet, "%", "///", "lufttrykk =", lufttrykk, "hPa", "///", "lux =", lys,)
	sql = ("INSERT INTO temperatur_måling (temperatur, klasseromnummer, fuktighet, lufttrykk, lys, timestamp) VALUES (%s, %s, %s, %s, %s, %s)")
	val = (float(temperatur), float("352"), float(fuktighet), float(lufttrykk), float(lys), (time_string))
	cursor.execute(sql, val)
	mydb.commit()
	print ("1 minutt til oppdatering")
	time.sleep(60)



