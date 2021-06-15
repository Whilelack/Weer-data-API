import requests
import mysql.connector
import json
import os
import datetime

mydb = mysql.connector.connect(
       host="192.168.178.92",
       user="database",
       password="L0c@alAdm!n",
       database="weather_data"
     )

dirname = os.path.dirname(__file__)
f = open(dirname + 'config.json')
data = json.load(f)
id = data["id"]
plaats = data["plaats"]
f.close()

ct = datetime.datetime.now()

mycursor = mydb.cursor()
weer_data = requests.get("https://weerlive.nl/api/json-data-10min.php?key=bdb77819ed&locatie={}".format(plaats))
weer_data_json = weer_data.json()['liveweer']
geselecteerde_data = ["plaats", "temp", "samenv", "windr", "windk", "luchtd", "verw", "sup", "sunder", "d0neerslag"]
sql_data = []

for val in weer_data_json:
    for x in geselecteerde_data:
        sql_data.append(val[x])

sql = "INSERT INTO Weather_data (pi_id, plaats, temp, conditie, windrichting, windkracht, luchtdruk, verwachting, zonsopkomst, zonsondergang, neerslag_kans, timestamp) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
val = (id, sql_data[0], sql_data[1], sql_data[2], sql_data[3], sql_data[4], sql_data[5], sql_data[6], sql_data[7], sql_data[8], sql_data[9], ct)
mycursor.execute(sql, val)
mydb.commit()