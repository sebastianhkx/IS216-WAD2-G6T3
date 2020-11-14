# IS216-WAD2-G6T3 Project Req

## Problems
Students and workers have a busy schedule and it’s common for people to forget their appointments especially if they have a lot going on. Thus, most of us rely on a calendar app or a scheduling app one way or the other to organize our life. However, they are usually very limited in functionalities and only provide either a productivity aspect or a scheduling aspect.

The features of the app is as indicated below:

## Login page
- Login and Register


## Register page
- Register the user
- No repeat username is allowed
- Telegram Handle is needed
- Steps will be issued for the system to retrieve the username for sending notifications

### Purpose
Register Page is to log the user into our sql database, so that he may login. The system will automatically request for the telegram handle so that it may be used to search for the chat_id which is crucial for the notification.

## Main page
- Welcomes the user into 
- Agenda Overview (List view of tasks for the day + time)
- Calendar View for the day
- When clicking on 'Outdoor' related task, will show popup of weather and location and maybe estimated time from current location?
- Implement Toast notification
- Clicking on certain time on the calendar will lead to schedule form with time & date info prefilled
- Ability to edit certain task by clicking on timeline. It will open a schedule form with prefilled areas.

### Features Needed:

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
