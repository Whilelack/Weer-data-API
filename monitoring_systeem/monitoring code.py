import datetime
import mysql.connector
import time
import psutil
import shutil

mydb = mysql.connector.connect(
    host="192.168.178.92",
    user="database",
    password="L0c@alAdm!n",
    database="monitoring"
)

servername = "Raspberry 1"

mycursor = mydb.cursor()

ct = datetime.datetime.now()

RAM_raw = psutil.virtual_memory().percent
CPU_raw = psutil.cpu_percent(interval=1)

RAM = "{}%".format(RAM_raw)
CPU = "{}%".format(CPU_raw)

total, used, free = shutil.disk_usage("/")
total = total // (2 ** 30)
used = used // (2 ** 30)
free = free // (2 ** 30)

sql = "INSERT INTO monitoring (server_name, CPU, RAM, Disk_Free, Disk_Used, Disk_Total, Timestamp) VALUES (%s, %s, %s, %s, %s, %s, %s)"
val = (servername, CPU, RAM, free, used, total, "{}".format(ct))
mycursor.execute(sql, val)

mydb.commit()

print(mycursor.rowcount, "record inserted.")
time.sleep(10)
