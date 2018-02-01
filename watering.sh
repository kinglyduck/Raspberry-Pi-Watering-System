#!/bin/bash

old_IFS=$IFS
IFS=$'\n'
lines=($(cat configuration.txt)) # array
IFS=$old_IFS

# GPIO pin options will be on lines 2 through 17
# Since this is in an array, it'll be 1 through 17
# Loop 1 through 15
for ((number=1;number <= 17 ;number++))
{
# Check the line we're on for "on"
if [[ ${lines[number]} = *"on"* ]]; then
	# Do stuff if we find "on", the echo is for testing purposes
	pinNumber = number - 1
	echo "Changing pin number " . pinNumber . " to on"
fi
}
exit 0

# Schedule on line 20, number 19 in array
# Watering timing on line 21, number 20 in array

echo ${line[4]} # will echo line number 4 (line numbering start with 0)
echo ${line[@]} # will print all the lines.
echo ${line[#]} # will print the size of the array (the total line numbering)