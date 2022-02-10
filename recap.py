import os
import sys
sys.path.append(os.path.dirname(sys.argv[0])+'/..')
from utilities.spot_ftx import SpotFtx
from utilities.conf_loader import ConfLoader
import json
import mysql.connector
from datetime import datetime
import time

host =""
user =""
password =""
db = ""

now = datetime.now()
date = now.strftime("%Y-%m-%d")

with open(os.path.dirname(sys.argv[0])+'/../config/config.json', 'r') as fconfig:
    configJson = json.load(fconfig)
    config = ConfLoader(configJson)

ftx = SpotFtx(
    apiKey=config.strategies.alligatorfg20.apiKey,
    secret=config.strategies.alligatorfg20.secret,
    subAccountName=config.strategies.alligatorfg20.subAccountName
)

coinBalance = ftx.get_all_balance()
coinInUsd = ftx.get_all_balance_in_usd()
usdBalance = coinBalance['USD']
del coinBalance['USD']
del coinInUsd['USD']
totalBalanceInUsd = usdBalance + sum(coinInUsd.values())



baseDeDonnees = mysql.connector.connect(host=host,user=user,password=password, database=db)
curseur = baseDeDonnees.cursor()
curseur.execute("INSERT INTO afg20 (date, wallet) VALUES (%s, %s)", (date, totalBalanceInUsd))
baseDeDonnees.commit()
baseDeDonnees.close()
