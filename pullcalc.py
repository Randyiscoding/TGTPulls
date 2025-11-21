import math
from datetime import datetime # Credit Google: calculate time to solve PCR

def main():
    # Main function to control program flow
    # Script Sandbox area (For testing and/or actual use)
    a = 50  # Priorities
    b = 50  # Priorities Filled Already
    c = .71  # The Goal you're Trying To reach


    x, y, z = pulls(a, b, c)
    print(x, y, z)


def pulls(priority, priority_filled,goal_percentage):
     #TODO add safety windows so calculations are usable after store hours

     # Define the start and end times as strings
     start_time_str = "07:00:00" # time the store opens
     close_time_str = "22:00:00" # time the store closes
     end = datetime.now()
     end_time_str = end.strftime("%H:%M:%S")
     
     # Define the format of the time strings
     FMT = '%H:%M:%S'
     
     # Convert the time strings to datetime objects
     start_time = datetime.strptime(start_time_str, FMT)
     end_time = datetime.strptime(end_time_str, FMT)
     close_time = datetime.strptime(close_time_str, FMT)
     
     # Calculate the difference between the two times
     time_difference = end_time - start_time
     close_time_difference = close_time - end_time
     hoo = close_time - start_time #HOO = hours of Operation, should be 16
     
     # Get the total seconds from the timedelta object
     hours = (time_difference.total_seconds())/3600
     close_hours = (close_time_difference.total_seconds())/3600
     operation = (hoo.total_seconds())/3600


     # OPCR = number of priorities/hr since store open
     opcr = (priority + priority_filled)/hours
     x = hours/operation
     pull_strength = 1 # adjust bell curve

     # Priority Creation Rate:
     pcr = ((priority+priority_filled) + (opcr*close_hours)) - (priority_filled+priority) * (x * (1 - x)) * pull_strength
     pull_rate = 53.7887 # Number of items the user can pull in 1 hour
     # above is based on puling 28 items in 31Mins, 13secs, 56ms
     d = pcr/pull_rate
     results = (goal_percentage * (priority + priority_filled)) - priority_filled
     results_buffer = results/(1-goal_percentage*d)

     # Staffing Recomendation
     ptdpci = (priority+priority_filled) + (pcr*close_hours) # calculates the Projected Total number of DPCI's to pull
     staffrec = math.ceil((goal_percentage * ptdpci)/(pull_rate*close_hours)) #number of people reccomended to be pulling

     # Results
     if results_buffer < results:
          return math.ceil(results), 0, staffrec
     elif results_buffer > priority+priority_filled: #Fixed bad math here
          return math.ceil(results), priority+priority_filled, staffrec
     else:
          return math.ceil(results), math.ceil(results_buffer), staffrec


if __name__ == "__main__":
    main()