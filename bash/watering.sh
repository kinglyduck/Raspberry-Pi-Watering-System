#!/bin/bash

# ** W A R N I N G ** W A R N I N G **
# THIS WILL LOOP UNTIL IT IS TURNED OFF
# ** W A R N I N G ** W A R N I N G **
while true 
do
	# If a file "stop" exists in the temp directory, end the program.
	# This would be the "hard stop" for the program, to end it permanently
	if [ -e /tmp/stop ] ; then
		echo "Stop file found, ending the program"
		exit 0
	fi

	# Each loop, cat the config file to check for changes
	old_IFS=$IFS
	IFS=$'\n'
	LINES=($(cat configuration.txt)) # array
	IFS=$old_IFS

	# Testing echo statement
	echo ${LINES[4]} # will echo line number 4 (line numbering start with 0)

	# Default value for the sleep timing
	# This value gives a loop time of 1.5 minutes (86.4 seconds )
	WATERSLEEP = 0.001
	# Schedule on line 20, number 19 in array, get the value after the "="
	WATERSLEEP = ${LINES[19]} | cut -d "=" -f2
	# Echo for testing
	echo "We will be sleeping for " . $WATERSLEEP . "days."
	# So for the sleep timing, assuming the input is in days, that has to be converted to seconds
	WATERSLEEP = $WATERSLEEP * 86400

	# Watering timing on line 21, number 20 in array, get the value after the "="
	WATERTIMING = ${LINES[20]} | cut -d "=" -f2
	# Echo out the result of above line to check
	echo "Checking against " . $WATERTIMING 
	# Switch statement for light // medium // heavy
	# Timing values (for the duration of water flow) might need to be tweaked?
	case $WATERTIMING in
		Light )
			TIMING = 1
			;;
		Medium )
			TIMING = 2
			;;
		Heavy )
			TIMING = 3
			;;
	esac

	# Change to check for a "stop" line in text file -- Coming Soon
	# If the line in config is "on" then do the watering stuff
	# This would be the "soft stop", as it will continue to loop, it will just skip the watering until turned back on
	if [ -f /tmp/stop ] ; then
		# GPIO pin options will be on lines 2 through 17
		# For pin numbers 0 through 15. So...Line 2, which in the array is line 1, is pin 0.
		# Loop 1 through 17 for the lines in the array
		for ((NUMBER=1;NUMBER <= 17;NUMBER++)) {
			# Check the line we're for "on"
			# Echo for testing
			echo "Checking line number " . $NUMBER
			if [[ ${LINES[NUMBER]} = *"on"* ]]; then
				# The actual pin number is 1 less than the array number
				PINNUMBER = $NUMBER - 1

				# Testing echo
				echo "Changing pin number " . $PINNUMBER . " to on"

				# Set pin mode to Out
				gpio -g mode $PINNUMBER out

				#Write value of 1 to turn the pin on
				gpio -g write $PINNUMBER 1

				# Timing control, so how long the water will flow
				sleep $TIMING

				#write value of 0 to turn the pin off
				gpio -g write $PINNUMBER 0
			fi
		}
	fi

	# Wait for the timing/schedule
	sleep $WATERSLEEP
	
done
