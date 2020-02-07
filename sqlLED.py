# Imports
import pymysql
import RPi.GPIO as GPIO
import time

# GPIO settings
GPIO.setmode(GPIO.BCM) 
GPIO.setwarnings(False) 
GPIO.setup(21,GPIO.OUT) 

# Store string for comparison later
offdata = "((1,),)"

# Create a loop that will constantly check the database
print("Loop starting...") 
while 0 == 0:
	# Open database connection
    db = pymysql.connect(host="localhost", user="root", passwd="guzzo", db="gpioControl")

	# Create a cursor object using cursor() method
    cur = db.cursor()

	# Select desired value from table
    sql = "SELECT toggleOne FROM led"

    # Execute sql statement
    cur.execute(sql)
    
    # Retrieve data from the sql statement
    rows = cur.fetchall() 
    
    # Show us our sql statement
    print(rows)
    
    r = str(rows) # Stringify sql statement to compare with our offdata string
    
    # Compare output data to turn on and off light
    if r == offdata: #check our data to turn off light
        print("LED off") 
        GPIO.output(21,GPIO.LOW) #turn off led
        time.sleep(1) #add a delay to not DDOS the database
    else:
        print("LED on") 
        GPIO.output(21,GPIO.HIGH) #turn on led
        time.sleep(1) 

	# Disconnect from server
    cur.close()
    db.close()
