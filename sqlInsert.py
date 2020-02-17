# Import mysql.connector library
import mysql.connector

# Open database connection
db = mysql.connector.connect(host="localhost", user="user", passwd="password", db="school")
db.autocommit = True #autocommit to db

# Create a cursor object using cursor() method
cursor = db.cursor()

cur = db.cursor(dictionary=True)

# Define what you want to insert
name = 'Jane'
age = 8
gradeLevel = 5

# Insert data
sql = "INSERT INTO students (name, age, gradeLevel) VALUES ('Jane',8,5)"
# Execute sql query
cur.execute(sql)

# Select everything
sql2 = "SELECT * FROM students"
# Execute second sql query
cur.execute(sql2)

# Print out everything
rows = cur.fetchall() #request all data from rows
for row in rows: #output all data
	print(row)

# Disconnect from server
cur.close()
db.close()
