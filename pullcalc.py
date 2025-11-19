def pulls(priority, priority_filled,goal_percentage):
     import math
     # Credit Google: calculate time to solve PCR
     from datetime import datetime
     
     # Define the start and end times as strings
     start_time_str = "07:00:00" # time the store opens
     end = datetime.now()
     end_time_str = end.strftime("%H:%M:%S")
     
     # Define the format of the time strings
     FMT = '%H:%M:%S'
     
     # Convert the time strings to datetime objects
     start_time = datetime.strptime(start_time_str, FMT)
     end_time = datetime.strptime(end_time_str, FMT)
     
     # Calculate the difference between the two times
     time_difference = end_time - start_time
     
     # Get the total seconds from the timedelta object
     hours = (time_difference.total_seconds())/3600

     # PCR = Priority Creation Rate: number of priorities/hr since store open
     pcr = (priority + priority_filled)/hours 
     pull_rate = 42.8333 # Number of items the user can pull in 1 hour
     d = pcr/pull_rate
     results = (goal_percentage * (priority + priority_filled)) - priority_filled
     results_buffer = results/(1-goal_percentage*d)
  # ToDo: add if statement for if buffer is less than required or more than total
     return math.ceil(results), math.ceil(results_buffer)

a = 149
b = 217
c =.71
    
x, y = pulls(a,b,c)
print(x, y)
