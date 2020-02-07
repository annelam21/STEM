# Import mysql.connector library
import mysql.connector

# Open database connection
db = mysql.connector.connect(host="localhost", user="user", passwd="password", db="school")

# Create a cursor object using cursor() method
cursor = db.cursor()

cur = db.cursor(dictionary=True)

# Update statement
sql = "UPDATE students SET age=7, gradeLevel=2 WHERE name='Tommette' "

# Execute sql statement
cur.execute(sql)

# Disconnect from server
cur.close()
db.close()

