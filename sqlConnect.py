# Import mysql.connector library
import mysql.connector

# Open database connection
db = mysql.connector.connect(host="localhost", user="user", passwd="password", db="school")

# Create a cursor object using cursor() method
cursor = db.cursor()

cur = db.cursor(dictionary=True)

# Select everything
sql = "SELECT * FROM students"

# Execute sql statement
cur.execute(sql)

rows = cur.fetchall() #request all data from rows
for row in rows: #output all data
	print(row)

# Disconnect from server
cur.close()
db.close()
