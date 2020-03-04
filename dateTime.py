# Use the datetime object to create and manipulate date and time
# Resource: https://www.guru99.com/date-time-and-datetime-classes-in-python.html

# Import modules needed from datetime
#import only what you need
from datetime import time
from datetime import date
from datetime import datetime

# Create a main loop so this module can be imported
def main():
	# Create a new date time object that hold the current datetime
	#if you see a dot after, it is an object; datetime is an object
	currentTime = datetime.now()
	
	print(currentTime)
	
	# Print only the time from the datetime object
	print(datetime.time(currentTime))
	
	# Use strftime to print only the year from the datetime object
	#% is string substitution
	print("Current Year: ", currentTime.strftime("%y"))
	
	# Use strftime to print a very human readable date
	print("Current Date: ", currentTime.strftime("%a, %B %d, %Y"))
	


if __name__ == "__main__":
	main()
