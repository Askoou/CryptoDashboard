                #################################################################
                AJOUTER ET REMPLIR CETTE PARTIE AVANT LES INDICATORS VARIABLE
                #################################################################
                
                #ID connexion SQL
                mydb = mysql.connector.connect(
                  host="",
                  user="",
                  password="",
                  database="cryptobot"
                )
                mycursor = mydb.cursor()
                
                
                
                #################################################################
                AJOUTER CETTE PARTIE DANS LA PARTIE # Sell de votre live_strategy
                #################################################################
                
                #Ajout du log SELL dans la db
                sql = "INSERT INTO orderBook (type, amount, symbol, price) VALUES (%s, %s, %s, %s)"
                val = ("1", coinBalance[coin], symbol, "0")
                mycursor.execute(sql, val)
                mydb.commit()
                
                #################################################################
                AJOUTER CETTE PARTIE DANS LA PARTIE # Buy de votre live_strategy
                ##################################################################
                
                #Ajout du log BUY dans la db
                sql = "INSERT INTO orderBook (type, amount, symbol, price) VALUES (%s, %s, %s, %s)"
                val = ("2", buyAmount, symbol, buyPrice)
                mycursor.execute(sql, val)
                mydb.commit()
