# Level 6

During the year, providers apply additional season costs.

## Instructions

In this level, you are going to essentially override the `yearly_consumption` value provided as input by `data.json`. The steps are as follows:
- Read the value from the input file
- Calculate the values for each season of which it consists of. For example: if the contract starts in August 2017 and ends in August 2019, you will need to compute each season from August 2017 until Spring 2019
- Sum up the season values to obtain the new overall consumption
- This will be the new starting value from which all other operations will occur (i.e. discount, cancellation fee etc...)

Season consumptions are calculated as follows:
- Spring: +1%
- Summer: -1.5%
- Autumn: average of +0.7% with average of previous spring and summer. If spring and/or summer are not present, only consider the +0.7% result
- Winter: no additional cost

Finally, you can make the following assumptions:
- Spring: 1st March - 31st May
- Summer: 1st June - 31st August
- Fall: 1st September - 30th November
- Winter: 1st of December - 28th February

Write code that generates `output.json` from `data.json`
