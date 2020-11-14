# Breakdown of the project

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
Register Page is to log the user into our sql database, so that the user may login. The system will automatically request for the telegram handle so that it may be used to search for the chat_id which is crucial for the notification.

## Main page
- Welcomes the user into main page of the interface.
- The current time and weather is shown as a card there.
- Allow the user to retrieve all the schedule task for the day through telegram through the click of a button
- Calendar View for the month is the default view
- The calender view can be switch to weeks View and Day view for more
- A Nav bar at the side to navigate to the other tabs.
- The event on the calender can be click on to bring up more information of the event through a pop-up
- From the pop-up you can edit or delete the task.

### Purpose
Main Page serve as the main interface of the application. The main page will also serve as the trigger to sent the notification every hour to the phone as long as the notification is on. The main page is meant to show all the scheduled items so that one can reference it. The main page also allows for navigation away to other pages.

## New/Edit Schedule
- Here the User can modify their schedule items
- The user can add new schedule items: EVENT, TASK and UNAVAILABLE

### Purpose
Serve as the gateway between the server and the homepage. EVENT cannot overlapped with another EVENT, but can be overlapped with TASK And UNAVAILABLE.  TASK can overlapped with EVENT, UNAVAILABLE AND TASK. UNAVAILBLE can overlapped with EVENT, UNAVAILABLE AND TASK, it is to serve as a visual guide for the user.

## Work Management
???????????????????

### Purpose
???????????????????????????


## Goal Management
???????????????????


### Purpose
???????????????????????????
