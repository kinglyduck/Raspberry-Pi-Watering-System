#!/bin/bash

old_IFS=$IFS
IFS=$'\n'
lines=($(cat configuration.txt)) # array
IFS=$old_IFS

# GPIO pin options will be on lines 2 through 17
# For pin numbers 0 through 15. So...Line 2, which in the array is line 1, is pin 0.
# Loop 1 through 17 for the lines in the array
for ((number=1;number <= 17 ;number++))
{
# Check the line we're for "on"
if [[ ${lines[number]} = *"on"* ]]; then
	# The actual pin number is 1 less than the array number
	pinNumber = number - 1
	#Echo for testing purposes
	echo "Changing pin number " . pinNumber . " to on"
fi
}
exit 0

# Schedule on line 20, number 19 in array
# Watering timing on line 21, number 20 in array

echo ${line[4]} # will echo line number 4 (line numbering start with 0)
echo ${line[@]} # will print all the lines.
echo ${line[#]} # will print the size of the array (the total line numbering)