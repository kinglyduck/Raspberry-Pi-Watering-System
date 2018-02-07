#!/bin/bash

old_IFS=$IFS
IFS=$'\n'
lines=($(cat configuration.txt)) # array
IFS=$old_IFS

echo ${line[4]} # will echo line number 4 (line numbering start with 0)

# Schedule on line 20, number 19 in array, get the value after the "="
waterSleep = ${line[19]} | cut -d "=" -f2
# So for the sleep timing, assuming the input is in days, that has to be converted to seconds
waterSleep = $waterSleep * 86400

# Watering timing on line 21, number 20 in array, get the value after the "="
waterTiming = ${line[19]} | cut -d "=" -f2
# TO DO
# CODE FOR WATERING TIMING GOES HERE
#
#
#
#
#

while true 
do
	# If a file "stop" exists in the temp directory, end the program.
	if [ -f /tmp/stop ] ; then
		exit
	fi
	# GPIO pin options will be on lines 2 through 17
	# For pin numbers 0 through 15. So...Line 2, which in the array is line 1, is pin 0.
	# Loop 1 through 17 for the lines in the array
	for ((number=1;number <= 17 ;number++)) {
		# Check the line we're for "on"
		if [[ ${lines[number]} = *"on"* ]]; then
			# The actual pin number is 1 less than the array number
			pinNumber = number - 1
			#Echo for testing purposes
			echo "Changing pin number " . pinNumber . " to on"
			# Set pin mode to Out
			gpio -g mode $pinNumber out
			#Write value of 1 to turn the pin on
			gpio -g write $pinNumber 1
			# Timing control, so how long the water will flow
			sleep $timing
			#write value of 0 to turn the pin off
			gpio -g write $pinNumber 0
		fi
	}

	exit 0

	# Wait for the timing/schedule
	sleep $waterSleep

done