#!/bin/bash

# ** W A R N I N G ** W A R N I N G **
# THIS WILL LOOP UNTIL IT IS TURNED OFF
# ** W A R N I N G ** W A R N I N G **
while true 
do
	# cat the config file each loop to check for changes
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
	waterTiming = ${line[20]} | cut -d "=" -f2
	# Switch statement for light // medium // heavy
	# Timing values (for the duration of water flow) might need to be tweaked?
	case $waterTiming in
		light)
			timing = 1
			;;
		medium)
			timing = 2
			;;
		heavy)
			timing = 3
			;;
	esac

	# If a file "stop" exists in the temp directory, end the program.
	# This would be the "hard stop" for the program, to end it permanently
	if [ -f /tmp/stop ] ; then
		exit 0
	fi

	# Change to check for a "stop" line in text file -- Coming Soon
	# If the line in config is "on" then do the watering stuff
	# This would be the "soft stop", as it will continue to loop, it just waits until the watering is turned on.
	if [ -f /tmp/stop ] ; then
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
	fi

	# Wait for the timing/schedule
	sleep $waterSleep
	
done
