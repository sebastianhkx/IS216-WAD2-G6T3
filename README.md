# IS216-WAD2-G6T3 Project Req
 
## Main page
### Features Needed:
- Agenda Overview (List view of tasks for the day + time)
- Each listed task/reminder comes with a checkbox, when checked, it's completed.
- Calendar View for the day
- When clicking on 'Outdoor' related task, will show popup of weather and location and maybe estimated time from current location?
- Implement Toast notification
- Clicking on certain time on the calendar will lead to schedule form with time & date info prefilled
- Ability to edit certain task by clicking on timeline. It will open a schedule form with prefilled areas.

## Schedule Page/Modal
### Features Needed:
- Three Categories (Event + Task/Reminder + Unavailable)
- Data Needed for Event:
	- Time, Date, Location, 'Importance Tag', Description, "Completed?" Tag (to signal if task complete, won't be on form)
- Data Needed for Task/Reminder & Unavailable
	- Time, Date, Description, 'Repeatable? (Weekly/Daily/Weekends/Weekdays)'
- Ability to show locations on GMaps and Weather
- Maybe provide reviews to certain areas like restaurants/malls and average timetaken from current location to reach there?

## Work Management
### Features Needed:
- Pomodoro Timers (Take overall time taken for task, divide evenly, with 5 minutes break in between. So if task is 2 hours, It will be 120 minutes/20 minutes = 6)
- When2Meet (Ability to sync the breaktimes of 2 people and more and display common break times)
- Notification (Telegram?) + Toast Notification (OneSignal?)

## Sign-In Page
### Features Needed:
- I think SSO and/ internal. For SSO, no pass needed, for internal, record password
- Data Needed:
	- UserID, Username, UserPass (if Internal), ifSSO check

## Sign-on page
### Features Needed:
- just sign on fields (user + pass) and/ Google SSO
