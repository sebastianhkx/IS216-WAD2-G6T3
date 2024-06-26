<?php

session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.html");
    return;
}

$id = $_SESSION['userid'];
$chat_id = $_SESSION['chat_id'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>

<html>

<head>
    <title>Recommendation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">

    <script src="https://unpkg.com/axios/dist/axios.js"></script>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <style>
        .box {

            border: 1px black solid;
            height: 100%;


        }

        .v-card {
            display: flex !important;
            flex-direction: column;
        }


        a:hover {
            text-decoration: none;
        }

        #to_do_list {

            height: 100%;
            padding-top: 20px;


        }
    </style>
</head>

<body>

    <div id="mainApp">
        <v-app style="background: linear-gradient(180deg, #7474BF 0%, #348AC7 100%);">
            <v-navigation-drawer permanent app dark style="background: rgba(0,0,0,0.2);" :mini-variant="mini">
                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title class="title">
                            Welcome back <?php echo $_SESSION['username'] ?>!
                        </v-list-item-title>
                        <v-list-item-subtitle>
                            {{goalDisplay}}
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>

                <v-divider></v-divider>

                <v-list nav dense>
                    <v-list-item link href="index.php">
                        <v-list-item-icon>
                            <v-icon>mdi-home
                            </v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Home</v-list-item-title>
                    </v-list-item>
                    <v-list-item link href="GoalSetting.php">
                        <v-list-item-icon>
                            <v-icon>mdi-flag</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Set a Goal!</v-list-item-title>
                    </v-list-item>
                    <v-list-item link href="Work_Management.php">
                        <v-list-item-icon>
                            <v-icon>mdi-folder</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Work Management</v-list-item-title>
                    </v-list-item>
                    <v-list-item link href="ScheduleVue.php">
                        <v-list-item-icon>
                            <v-icon>mdi-calendar</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Scheduler</v-list-item-title>
                    </v-list-item>
                    <v-list-item href="include/logout_process.php">
                        <v-list-item-icon>
                            <v-icon>mdi-logout-variant</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-navigation-drawer>

            <v-main>
                <!-- send all events and task for the day??? -->
                <v-fab-transition>
                    <v-btn color="pink" @click="cfmRetrieveScheduleDiag = true" dark fixed bottom right fab>
                        <v-icon>mdi-arrow-down-bold-box</v-icon>
                    </v-btn>
                </v-fab-transition>
                <!-- Alert confirmation when object is deleted!! -->
                <v-dialog v-model="deleteCfmDialog" max-width="280">
                    <v-card>
                        <v-card-title class="headline">
                            Result:
                        </v-card-title>
                        <v-card-text>{{deleteCfmDialogMsg}}</v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="green darken-1" text @click="reloadWindow">
                                Confirm
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>

                <!-- Prompts for confirmation dialog to get schedule -->
                <v-dialog v-model="cfmRetrieveScheduleDiag" max-width="280">
                    <v-card>
                        <v-card-title class="headline">
                            Retrieve Schedule:
                        </v-card-title>
                        <v-card-text>Would you like to retrieve your entire schedule for the day on telegram?</v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="green darken-1" text @click="giveSchedule">
                                Retrieve
                            </v-btn>
                            <v-btn color="green darken-1" text @click="cfmRetrieveScheduleDiag = false">
                                Don't retrieve
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>

                <v-dialog v-model="progressLoadScheduleDiag" persistent max-width="480">
                    <v-card>
                        <v-card-title class="headline">
                            Retrieving schedule...
                        </v-card-title>
                        <v-card-text>
                            <v-progress-linear indeterminate color="green"></v-progress-linear>
                        </v-card-text>
                    </v-card>
                </v-dialog>


                <!-- retrieved dialog done! -->
                <v-dialog v-model="retrievedScheduleDiag" max-width="280">
                    <v-card>
                        <v-card-title class="headline">
                            Retrieval operation complete!
                        </v-card-title>
                        <v-card-text>{{retrievedScheduleDiagMsg}}</v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="green darken-1" text @click="retrievedScheduleDiag = false">
                                Dismiss
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>


                <!-- goal setting -->
                <v-card color="rgba(0,0,0,0.4)" dark>
                    <v-card-title>
                        <v-icon>mdi-flag</v-icon>
                        Today's Goal:
                    </v-card-title>
                    <v-card-text color="white" class="headline">{{goalDisplay}}</v-card-text>
                    <v-card-actions>
                        <v-btn v-if="goalDisplay=='No goal yet! Set one now!'" text href="goalSetting.php">
                            Modify Goal
                        </v-btn>
                    </v-card-actions>
                </v-card>

                <!-- Introduction part -->
                <v-row>
                    <v-col cols="12" md="6">
                        <v-card max-width="500" style="margin:20px" color="rgb(0, 0, 0, 0.4)" dark>
                            <v-list-item two-line>
                                <v-list-item-content>
                                    <v-list-item-title class="headline">
                                        Welcome <?php echo $_SESSION['username'] ?>!
                                    </v-list-item-title>
                                    <v-list-item-subtitle>{{dailyReport}}, {{weatherReport}}</v-list-item-subtitle>

                                </v-list-item-content>
                            </v-list-item>

                            <v-card-text>
                                <v-row>
                                    <v-col class="display-2" cols="6">
                                        {{tempReport}}&deg;C
                                    </v-col>
                                    <v-col class="display-2" cols="3">
                                        <v-img v-bind:src="weatherImage" width="92" height="92"></v-img>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-col>
                    <v-col cols="12" md="6">
                        <!-- Agenda part -->
                        <v-card color="rgb(0, 0, 0, 0.4)" dark style="margin-right:20px">
                            <v-card-title class="">
                                <p class="ml-2">
                                    Your Agenda for Today:
                                </p>
                            </v-card-title>
                            </v-img>
                            <v-card-text>
                                <v-row>
                                    <v-col cols="12" md="6">
                                        <div class="font-weight-bold ml-8 mb-2">
                                            Task for today:
                                        </div>
                                        <v-timeline max-height="10" align-top dense style="padding: 10px; height:100px; overflow: auto;">
                                            <v-timeline-item v-for="agenda in agendas_tasks" small color="green">
                                                <div>
                                                    <div class="font-weight-normal">
                                                        <strong>{{ agenda.startTime }}</strong>
                                                    </div>
                                                    <div>{{ agenda.name }}</div>
                                                </div>
                                            </v-timeline-item>

                                        </v-timeline>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <div class="font-weight-bold ml-8 mb-2">
                                            Events for today:
                                        </div>
                                        <v-timeline max-height="10" align-top dense style="height:100px; overflow: auto;">
                                            <v-timeline-item v-for="agenda in agendas_events" small color="red">
                                                <div>
                                                    <div class="font-weight-normal">
                                                        <strong>{{ agenda.startTime }}</strong>
                                                    </div>
                                                    <div>{{ agenda.name }}</div>
                                                </div>
                                            </v-timeline-item>
                                        </v-timeline>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
                <!-- Calendar part -->
                <v-row style="margin:10px">
                    <v-col>
                        <v-sheet height="128" elevation="3">
                            <v-toolbar flat>
                                <v-icon large style="padding-right: 10px">mdi-calendar</v-icon>
                                <h2>Calendar</h2>
                            </v-toolbar>
                            <v-toolbar flat>
                                <v-btn outlined class="mr-4" color="grey darken-2" dark @click="setToday">
                                    Today
                                </v-btn>
                                <v-btn fab text small color="grey darken-2" @click="prev">
                                    <v-icon small>
                                        mdi-chevron-left
                                    </v-icon>
                                </v-btn>
                                <v-btn fab text small color="grey darken-2" @click="next">
                                    <v-icon small>
                                        mdi-chevron-right
                                    </v-icon>
                                </v-btn>
                                <v-toolbar-title v-if="$refs.calendar">
                                    {{ $refs.calendar.title }}
                                </v-toolbar-title>
                                <v-spacer></v-spacer>
                                <v-menu bottom right>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn outlined color="grey darken-2" v-bind="attrs" v-on="on">
                                            <span>{{ typeToLabel[type] }}</span>
                                            <v-icon right>
                                                mdi-menu-down
                                            </v-icon>
                                        </v-btn>
                                    </template>
                                    <v-list>
                                        <v-list-item @click="type = 'day'">
                                            <v-list-item-title>Day</v-list-item-title>
                                        </v-list-item>
                                        <v-list-item @click="type = 'week'">
                                            <v-list-item-title>Week</v-list-item-title>
                                        </v-list-item>
                                        <v-list-item @click="type = 'month'">
                                            <v-list-item-title>Month</v-list-item-title>
                                        </v-list-item>
                                        <v-list-item @click="type = '4day'">
                                            <v-list-item-title>4 days</v-list-item-title>
                                        </v-list-item>
                                    </v-list>
                                </v-menu>
                            </v-toolbar>
                        </v-sheet>
                        <v-sheet height="700">
                            <v-calendar ref="calendar" first-time="06:00" v-model="focus" color="primary" :events="events" :event-color="getEventColor" :type="type" @click:event="showEvent" @click:more="viewDay" @click:date="viewDay"></v-calendar>
                            <v-menu v-model="selectedOpen" :close-on-content-click="false" :activator="selectedElement" offset-x>
                                <v-card color="grey lighten-4" min-width="350px" flat>
                                    <v-toolbar :color="selectedEvent.color" dark>
                                        <v-btn @click="editFunction" icon>
                                            <v-icon>mdi-pencil</v-icon>
                                        </v-btn>
                                        <v-toolbar-title v-html="selectedEvent.name"></v-toolbar-title>
                                        <v-spacer></v-spacer>
                                        <!-- model area -->
                                        <v-dialog v-model="deleteDialog" persistent max-width="280">
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-btn icon @click="deleteDialog = true">
                                                    <v-icon>mdi-trash-can</v-icon>
                                                </v-btn>
                                            </template>
                                            <v-card>
                                                <v-card-title class="headline">
                                                    Warning:
                                                </v-card-title>
                                                <v-card-text>Are you sure you want to delete: {{selectedEvent.name}}</v-card-text>
                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn color="green darken-1" text @click="deleteObject">
                                                        Delete
                                                    </v-btn>
                                                    <v-btn color="green darken-1" text @click="deleteDialog = false">
                                                        Don't delete
                                                    </v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>
                                    </v-toolbar>
                                    <v-card-text>
                                        <span v-if="selectedEvent.taskType=='event'"><b>Location: {{selectedEvent.location}}</b></span><br>
                                        <span v-html="selectedEvent.details"></span>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-btn text color="secondary" @click="selectedOpen = false">
                                            Cancel
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-menu>
                        </v-sheet>
                    </v-col>
                </v-row>
            </v-main>

        </v-app>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <script>
        var navApp = new Vue({
            el: '#mainApp',
            vuetify: new Vuetify(),
            data: {
                drawer: true,
                goalDisplay: '',
                goalCheck: false, // Check if a goal exist
                dailyReport: '',
                weatherReport: '',
                weatherImage: '',
                tempReport: '',
                focus: '',
                type: 'month',
                deleteDialog: false,
                deleteCfmDialog: false,
                deleteCfmDialogMsg: '',
                userId: '',
                navLink: {
                    logout: "logout.html"
                },
                colorType: ['grey lighten-2', 'pink lighten-4', 'blue lighten-5'],
                typeToLabel: {
                    month: 'Month',
                    week: 'Week',
                    day: 'Day',
                    '4day': '4 Days',
                },
                selectedEvent: {},
                selectedElement: null,
                selectedOpen: false,
                events: [],
                agendas_events: [],
                agendas_tasks: [],
                cfmRetrieveScheduleDiag: false,
                retrievedScheduleDiag: false,
                retrievedScheduleDiagMsg: '',
                progressLoadScheduleDiag: false,
            },
            created: function() {
                //var startDate = new Date("Nov 2 2020 08:00:00");
                //var endDate = new Date("Nov 2 2020 15:00:00")
                //var startDate2 = new Date("Nov 7 2020 08:00:00");
                //var endDate2 = new Date("Nov 7 2020 15:00:00")
                setInterval(this.weatherReturn, 100);
                this.notifyTrigger();
                setInterval(this.notifyTrigger, 300000);
                callWeather();
                this.updateEvents();
            },
            computed: {
                lgAndUp() {
                    return this.$vuetify.breakpoint.mdAndUp;
                },
                mini() {
                    return !(this.lgAndUp || this.menuOpen);
                },

            },
            methods: {
                reloadWindow: function() {
                    location.reload();
                    return false;
                },
                updateEvents: function() {

                    loadEvent();
                    loadTask();
                    loadUnavailable();
                    checkExist();

                },
                weatherReturn: function() {
                    var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                    var todayDate = new Date();
                    var dayName = days[todayDate.getDay()];
                    var todayTime = todayDate.toLocaleTimeString();
                    this.dailyReport = dayName + ", " + todayTime;
                },
                editFunction: function() {
                    var user_id = '<?php $_SESSION['userid'] ?>';
                    var taskType = this.selectedEvent.taskType;
                    var title = this.selectedEvent.name;
                    var date = this.selectedEvent.rawDate;
                    var startTime = this.selectedEvent.rawStartTime;
                    var endTime = this.selectedEvent.rawEndTime;
                    var itemid;
                    var location;
                    var repeatable = this.selectedEvent.repeatable;
                    var description = this.selectedEvent.details;


                    if (taskType == "event") {
                        itemid = this.selectedEvent.id;
                        var location = this.selectedEvent.location;
                    } else if (taskType == "task") {
                        itemid = this.selectedEvent.id;
                    } else {
                        itemid = this.selectedEvent.id;
                    }

                    window.location.href = "ScheduleEdit.php?itemid=" + itemid + "&taskType=" + taskType + "&title=" + title + "&date=" + date + "&startTime=" + startTime + "&endTime=" + endTime + "&description=" + description + "&location=" + location + "&repeatable=" + repeatable;
                },
                deleteObject: function() {
                    var id = navApp.selectedEvent.id;
                    var taskType = navApp.selectedEvent.taskType;
                    navApp.deleteDialog = false;

                    $.ajax({
                        url: "./include/delete_eventTask.php",
                        type: "POST",
                        data: {
                            id: id,
                            taskType: taskType
                        },

                        cache: false,
                        success: function(dataResult) {

                            var dataResult = JSON.parse(dataResult);

                            if (dataResult.statusCode == 200) {

                                navApp.deleteCfmDialog = true;
                                navApp.deleteCfmDialogMsg = "Object successfully deleted!";
                                navApp.events.splice(navApp.events.findIndex(v => v.id === id), 1);

                            } else if (dataResult.statusCode == 201) {
                                navApp.deleteCfmDialog = true;
                                navApp.deleteCfmDialogMsg = "Database returned 201 status code!";
                            }

                        }

                    });
                },
                giveSchedule: function() {
                    //Prompt for check!
                    navApp.cfmRetrieveScheduleDiag = false;
                    //Bring up the loading screen
                    navApp.progressLoadScheduleDiag = true
                    $.ajax({
                        url: "./include/button_function.php", // retrieve the entire schedule
                        type: "POST",
                        data: {

                        },

                        cache: false,
                        success: function(dataResult) {

                            //Do success only
                            navApp.progressLoadScheduleDiag = false;
                            navApp.retrievedScheduleDiag = true;
                            navApp.retrievedScheduleDiagMsg = 'Your schedule has been loaded into telegram!';
                        }

                    });
                },
                notifyTrigger: function() {
                    runNotification();
                },
                viewDay({
                    date
                }) {
                    this.focus = date
                    this.type = 'day'
                },
                getEventColor(event) {
                    return event.color
                },
                setToday() {
                    this.focus = ''
                },
                prev() {
                    this.$refs.calendar.prev()
                },
                next() {
                    this.$refs.calendar.next()
                },
                showEvent({
                    nativeEvent,
                    event
                }) {
                    const open = () => {
                        this.selectedEvent = event
                        this.selectedElement = nativeEvent.target
                        setTimeout(() => {
                            this.selectedOpen = true
                        }, 10)
                    }

                    if (this.selectedOpen) {
                        this.selectedOpen = false
                        setTimeout(open, 10)
                    } else {
                        open()
                    }

                    nativeEvent.stopPropagation()
                },
            }
        });

        function loadEvent() {
            var loadReq = new XMLHttpRequest();
            const fixedToday = new Date();
            loadReq.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    response = JSON.parse(this.responseText);
                    for (i = 0; i < response.length; i++) {
                        navApp.events.push({
                            name: response[i].title,
                            start: new Date(response[i].date + " " + response[i].start_time),
                            end: new Date(response[i].date + " " + response[i].end_time),
                            rawDate: response[i].date,
                            rawStartTime: response[i].start_time,
                            rawEndTime: response[i].end_time,
                            location: response[i].location,
                            color: "red lighten-2",
                            timed: true,
                            details: response[i].description,
                            id: response[i].event_id,
                            taskType: "event",
                        })

                        //Throw into agenda as well if it matches today's date.
                        if (fixedToday.toDateString() === new Date(response[i].date).toDateString()) {
                            navApp.agendas_events.push({
                                name: response[i].title,
                                startTime: response[i].start_time,
                                endTime: response[i].end_time,
                                location: response[i].location,
                                details: response[i].description
                            })
                        }
                    }

                    //Sort and filter time event and convert (For agenda view)

                    function filterTime(event) {
                        return Number(event.startTime.split(":").join("")) > Number(fixedToday.toLocaleTimeString("en-GB").split(":").join(""));
                    }

                    function convertToAmPm(event) {
                        var timeString = event.startTime;
                        var H = +timeString.substr(0, 2);
                        var h = H % 12 || 12;
                        var ampm = (H < 12 || H === 24) ? " AM" : " PM";
                        event.startTime = h + timeString.substr(2, 3) + ampm;
                    }

                    navApp.agendas_events.sort(function(a, b) {
                        return Number(a.startTime.split(":").join("")) - Number(b.startTime.split(":").join(""));
                    });
                    navApp.agendas_events = navApp.agendas_events.filter(filterTime);
                    navApp.agendas_events.map(convertToAmPm);
                }
            };
            loadReq.open("POST", "include/read_event_user.php", true);
            loadReq.setRequestHeader('Accept', 'application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8');
            loadReq.setRequestHeader('Content-Type', 'application/json');
            loadReq.send();
        }

        function loadTask() {
            var loadReq = new XMLHttpRequest();
            const fixedToday = new Date();
            loadReq.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    response = JSON.parse(this.responseText);

                    for (i = 0; i < response.length; i++) {

                        //console.log(response[i]);
                        //If non-repeat

                        if (response[i].repeatable == "Non Repeat") {
                            navApp.events.push({
                                name: response[i].title,
                                start: new Date(response[i].date + " " + response[i].start_time),
                                end: new Date(response[i].date + " " + response[i].end_time),
                                rawDate: response[i].date,
                                rawStartTime: response[i].start_time,
                                rawEndTime: response[i].end_time,
                                color: "brown lighten-2",
                                timed: true,
                                details: response[i].description,
                                repeatable: response[i].repeatable,
                                id: response[i].task_id,
                                taskType: "task",
                            })

                            ///Throw into the agenda if date matches
                            if (fixedToday.toDateString() === new Date(response[i].date).toDateString()) {
                                navApp.agendas_tasks.push({
                                    name: response[i].title,
                                    startTime: response[i].start_time,
                                    endTime: response[i].end_time,
                                    details: response[i].description
                                })
                            }

                        } else if (response[i].repeatable == "Weekday") {
                            //if weekday
                            //We only accept 1-5 for 1 month ahead
                            const weekday = [1, 2, 3, 4, 5];
                            var todayDate = new Date(); // References today's date, but will change
                            todayDate.setDate(todayDate.getDate() - 1);
                            var todayDateStr = getCorrectDate(todayDate);
                            var currentDateStart = new Date(todayDateStr + " " + response[i].start_time);
                            var currentDateEnd = new Date(todayDateStr + " " + response[i].end_time);

                            for (j = 0; j < 72; j++) {
                                //check if day is a weekday

                                var weStartDate = dateChange(currentDateStart, response[i].start_time, 1);
                                var weEndDate = dateChange(currentDateEnd, response[i].end_time, 1);


                                var chosenDay = new Date(weStartDate).getDay();
                                var chosenDate = new Date(weStartDate);

                                if (weekday.indexOf(chosenDay) !== -1) {

                                    var eventObj = {
                                        name: response[i].title,
                                        start: new Date(weStartDate),
                                        end: new Date(weEndDate),
                                        rawDate: response[i].date,
                                        rawStartTime: response[i].start_time,
                                        rawEndTime: response[i].end_time,
                                        color: "green lighten-2",
                                        timed: true,
                                        details: response[i].description,
                                        repeatable: response[i].repeatable,
                                        id: response[i].task_id,
                                        taskType: "task",
                                    }
                                    navApp.events.push(eventObj);

                                    //If date matches today, then add into agenda!!
                                    if (chosenDate.toDateString() === fixedToday.toDateString()) {
                                        navApp.agendas_tasks.push({
                                            name: response[i].title,
                                            startTime: response[i].start_time,
                                            endTime: response[i].end_time,
                                            details: response[i].description
                                        })
                                    }
                                }
                                //If day is weekend, skip by two days.
                                if (chosenDay == 5) {
                                    currentDateStart.setDate(currentDateStart.getDate() + 2);
                                    currentDateEnd.setDate(currentDateEnd.getDate() + 2);
                                } else {
                                    currentDateStart.setDate(currentDateStart.getDate() + 1);
                                    currentDateEnd.setDate(currentDateEnd.getDate() + 1);
                                }
                            }


                        } else if (response[i].repeatable == "Weekend") {
                            //If repeat weekend (Time not considered)
                            //We only accept 1-5 for 1 month ahead
                            const weekend = [0, 6];
                            var todayDate = new Date();
                            var todayDateStr = getCorrectDate(todayDate);
                            var currentDateStart = new Date(getCorrectDate(todayDate) + " " + response[i].start_time);
                            var currentDateEnd = new Date(getCorrectDate(todayDate) + " " + response[i].end_time);

                            for (j = 0; j < 36; j++) {
                                var chosenDay = currentDateStart.getDay();
                                var weStart = currentDateStart;
                                var weEnd = currentDateEnd;
                                //check if day is a weekend

                                if (weekend.indexOf(chosenDay) !== -1) {
                                    navApp.events.push({
                                        name: response[i].title,
                                        start: new Date(weStart),
                                        end: new Date(weEnd),
                                        rawDate: response[i].date,
                                        rawStartTime: response[i].start_time,
                                        rawEndTime: response[i].end_time,
                                        color: "blue lighten-2",
                                        timed: true,
                                        details: response[i].description,
                                        repeatable: response[i].repeatable,
                                        id: response[i].task_id,
                                        taskType: "task",
                                    })

                                    //If match today's date, add!
                                    if (weStart.toDateString() === fixedToday.toDateString()) {
                                        navApp.agendas_tasks.push({
                                            name: response[i].title,
                                            startTime: response[i].start_time,
                                            endTime: response[i].end_time,
                                            details: response[i].description
                                        })
                                    }
                                }
                                //If DAY is saturday, ADD 1 to sunday. 
                                //Else add 6 ONLY after it has determined it's a weekend SUNDAY.
                                if (chosenDay == 0) {
                                    currentDateStart.setDate(currentDateStart.getDate() + 6);
                                    currentDateEnd.setDate(currentDateEnd.getDate() + 6);
                                } else {
                                    currentDateStart.setDate(currentDateStart.getDate() + 1);
                                    currentDateEnd.setDate(currentDateEnd.getDate() + 1);
                                }

                            }


                        } else if (response[i].repeatable == "Repeat Weekly") {
                            // If repeat every week


                            //Take the particular date and loop
                            var currentDateStart = new Date(response[i].date + " " + response[i].start_time);
                            var currentDateEnd = new Date(response[i].date + " " + response[i].end_time);

                            //Recalibrate the correct day of the current week to match day in reference to set date.
                            //IF date set is TODAY or in the past, recalibrate above
                            //OR ELSE, if date set is in the future, start from only future!!
                            const fixedToday = new Date();
                            var todayDate = new Date();
                            var todayDay = new Date().getDay(); // mon
                            var chosenDay = currentDateStart.getDay(); //tue

                            //if date is in the future, do not change!!
                            if (currentDateStart > todayDate) {
                                var dateModStart = new Date(response[i].date + " " + response[i].start_time);
                                var dateModEnd = new Date(response[i].date + " " + response[i].end_time);
                            } else {
                                //Set date to match current weeks day
                                //if date is in the past, then change!!
                                todayDate.setDate(todayDate.getDate() - (todayDay - chosenDay));


                                var dateString = getCorrectDate(todayDate);

                                var dateModStart = new Date(dateString + " " + response[i].start_time);
                                var dateModEnd = new Date(dateString + " " + response[i].end_time);
                            }


                            for (j = 0; j < 24; j++) {

                                //check if day matches the week
                                navApp.events.push({
                                    name: response[i].title,
                                    start: new Date(dateModStart),
                                    end: new Date(dateModEnd),
                                    rawDate: response[i].date,
                                    rawStartTime: response[i].start_time,
                                    rawEndTime: response[i].end_time,
                                    color: "purple lighten-2",
                                    timed: true,
                                    details: response[i].description,
                                    repeatable: response[i].repeatable,
                                    id: response[i].task_id,
                                    taskType: "task",
                                })

                                //If match today's date, add!
                                if (dateModStart.toDateString() === fixedToday.toDateString()) {
                                    navApp.agendas_tasks.push({
                                        name: response[i].title,
                                        startTime: response[i].start_time,
                                        endTime: response[i].end_time,
                                        location: response[i].location,
                                        details: response[i].description
                                    })
                                }

                                //push date by 7
                                dateModStart.setDate(dateModStart.getDate() + 7);
                                dateModEnd.setDate(dateModEnd.getDate() + 7);

                            }

                        }
                    }
                    //sort and filter the task
                    function filterTime(event) {
                        return Number(event.startTime.split(":").join("")) > Number(fixedToday.toLocaleTimeString("en-GB").split(":").join(""));
                    }

                    function convertToAmPm(event) {
                        var timeString = event.startTime;
                        var H = +timeString.substr(0, 2);
                        var h = H % 12 || 12;
                        var ampm = (H < 12 || H === 24) ? " AM" : " PM";
                        return event.startTime = h + timeString.substr(2, 3) + ampm;
                    }

                    navApp.agendas_tasks.sort(function(a, b) {
                        return Number(a.startTime.split(":").join("")) - Number(b.startTime.split(":").join(""));
                    });
                    navApp.agendas_tasks = navApp.agendas_tasks.filter(filterTime);
                    navApp.agendas_tasks.map(convertToAmPm);
                }
            };
            loadReq.open("POST", "include/read_task_user.php", true);
            loadReq.setRequestHeader('Accept', 'application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8');
            loadReq.setRequestHeader('Content-Type', 'application/json');
            loadReq.send();
        }

        function loadUnavailable() {
            var loadReq = new XMLHttpRequest();
            loadReq.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    response = JSON.parse(this.responseText);

                    for (i = 0; i < response.length; i++) {

                        //console.log(response[i]);
                        //If non-repeat
                        if (response[i].repeatable == "Non Repeat") {
                            navApp.events.push({
                                name: response[i].title,
                                start: new Date(response[i].date + " " + response[i].start_time),
                                end: new Date(response[i].date + " " + response[i].end_time),
                                rawDate: response[i].date,
                                rawStartTime: response[i].start_time,
                                rawEndTime: response[i].end_time,
                                color: "grey",
                                timed: true,
                                details: response[i].description,
                                repeatable: response[i].repeatable,
                                id: response[i].unavailable_id,
                                taskType: "unavailable",
                            })

                        } else if (response[i].repeatable == "Weekday") {
                            //if weekday
                            //We only accept 1-5 for 1 month ahead
                            const weekday = [1, 2, 3, 4, 5];
                            var todayDate = new Date()
                            todayDate.setDate(todayDate.getDate() - 1);
                            var todayDateStr = getCorrectDate(todayDate);
                            var currentDateStart = new Date(todayDateStr + " " + response[i].start_time);
                            var currentDateEnd = new Date(todayDateStr + " " + response[i].end_time);

                            for (j = 0; j < 72; j++) {
                                //check if day is a weekday

                                var weStartDate = dateChange(currentDateStart, response[i].start_time, 1);
                                var weEndDate = dateChange(currentDateEnd, response[i].end_time, 1);


                                var chosenDay = new Date(weStartDate).getDay();

                                if (weekday.indexOf(chosenDay) !== -1) {

                                    var eventObj = {
                                        name: response[i].title,
                                        start: new Date(weStartDate),
                                        end: new Date(weEndDate),
                                        rawDate: response[i].date,
                                        rawStartTime: response[i].start_time,
                                        rawEndTime: response[i].end_time,
                                        color: "grey",
                                        timed: true,
                                        details: response[i].description,
                                        repeatable: response[i].repeatable,
                                        id: response[i].unavailable_id,
                                        taskType: "unavailable",
                                    }
                                    navApp.events.push(eventObj);
                                }
                                //If day is weekend, skip by two days.
                                if (chosenDay == 5) {
                                    currentDateStart.setDate(currentDateStart.getDate() + 2);
                                    currentDateEnd.setDate(currentDateEnd.getDate() + 2);
                                } else {
                                    currentDateStart.setDate(currentDateStart.getDate() + 1);
                                    currentDateEnd.setDate(currentDateEnd.getDate() + 1);
                                }
                            }


                        } else if (response[i].repeatable == "Weekend") {
                            //If repeat weekend (Time not considered)
                            //We only accept 1-5 for 1 month ahead
                            const weekend = [0, 6];
                            var todayDate = new Date();
                            var todayDateStr = getCorrectDate(todayDate);
                            var currentDateStart = new Date(getCorrectDate(todayDate) + " " + response[i].start_time);
                            var currentDateEnd = new Date(getCorrectDate(todayDate) + " " + response[i].end_time);

                            for (j = 0; j < 36; j++) {
                                var chosenDay = currentDateStart.getDay();
                                let weStart = currentDateStart;
                                let weEnd = currentDateEnd;
                                //check if day is a weekend

                                if (weekend.indexOf(chosenDay) !== -1) {
                                    firstFile = true;
                                    navApp.events.push({
                                        name: response[i].title,
                                        start: new Date(weStart),
                                        end: new Date(weEnd),
                                        rawDate: response[i].date,
                                        rawStartTime: response[i].start_time,
                                        rawEndTime: response[i].end_time,
                                        color: "grey",
                                        timed: true,
                                        details: response[i].description,
                                        repeatable: response[i].repeatable,
                                        id: response[i].unavailable_id,
                                        taskType: "unavailable",
                                    })
                                }
                                //If DAY is saturday, ADD 1 to sunday. 
                                //Else add 6 ONLY after it has determined it's a weekend SUNDAY.
                                if (chosenDay == 0) {
                                    currentDateStart.setDate(currentDateStart.getDate() + 6);
                                    currentDateEnd.setDate(currentDateEnd.getDate() + 6);
                                } else {
                                    currentDateStart.setDate(currentDateStart.getDate() + 1);
                                    currentDateEnd.setDate(currentDateEnd.getDate() + 1);
                                }

                            }


                        } else if (response[i].repeatable == "Repeat Weekly") {
                            // If repeat every week


                            //Take the particular date and loop
                            var currentDateStart = new Date(response[i].date + " " + response[i].start_time);
                            var currentDateEnd = new Date(response[i].date + " " + response[i].end_time);

                            //Recalibrate the correct day of the current week to match day in reference to set date.
                            //IF date set is TODAY or in the past, recalibrate above
                            //OR ELSE, if date set is in the future, start from only future!!

                            var todayDate = new Date()
                            var todayDay = new Date().getDay();
                            var chosenDay = currentDateStart.getDay();

                            //if date is in the future, do not change!!

                            if (currentDateStart > todayDate) {
                                var dateModStart = new Date(response[i].date + " " + response[i].start_time);
                                var dateModEnd = new Date(response[i].date + " " + response[i].end_time);
                            } else {
                                //Set date to match current weeks day
                                //if date is in the past, then change!!
                                todayDate.setDate(todayDate.getDate() - (todayDay - chosenDay));


                                var dateString = getCorrectDate(todayDate);

                                var dateModStart = new Date(dateString + " " + response[i].start_time);
                                var dateModEnd = new Date(dateString + " " + response[i].end_time);
                            }

                            for (j = 0; j < 24; j++) {

                                //check if day is a weekend
                                navApp.events.push({
                                    name: response[i].title,
                                    start: new Date(dateModStart),
                                    end: new Date(dateModEnd),
                                    rawDate: response[i].date,
                                    rawStartTime: response[i].start_time,
                                    rawEndTime: response[i].end_time,
                                    color: "grey",
                                    timed: true,
                                    details: response[i].description,
                                    repeatable: response[i].repeatable,
                                    id: response[i].unavailable_id,
                                    taskType: "unavailable",
                                })

                                //push date by 7
                                dateModStart.setDate(dateModStart.getDate() + 7);
                                dateModEnd.setDate(dateModEnd.getDate() + 7);

                            }

                        }

                    }
                }
            };
            loadReq.open("POST", "include/read_unavailable_user.php", true);
            loadReq.setRequestHeader('Accept', 'application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8');
            loadReq.setRequestHeader('Content-Type', 'application/json');
            loadReq.send();
        }

        function callWeather() {

            //Determine if geolocation is supported. 
            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                } else {
                    //not supported by this browser!
                    alert("Browser does not support geolocation!");
                }
            }

            //GET LOCATION

            function showPosition(position) {

                //Get location
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;

                //Call weather

                const api_key_weather = "c9a2c0a5914d4558bdb5432970854635";
                var currentDate = new Date();

                var loadRequest = new XMLHttpRequest();
                loadRequest.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        response = JSON.parse(this.responseText);
                        var weather = response.current.weather[0].main;
                        var weather_icon = response.current.weather[0].icon;
                        var weather_details = response.current.weather[0].details;
                        var temp = response.current.temp;


                        navApp.weatherImage = "http://openweathermap.org/img/wn/" + weather_icon + "@2x.png"
                        navApp.weatherReport = weather;
                        navApp.tempReport = temp;

                    }
                }
                loadRequest.open("GET", "https://api.openweathermap.org/data/2.5/onecall?lat=" + lat + "&lon=" + lng + "&units=metric" + "&appid=" + api_key_weather, true);
                loadRequest.send();
                //event.preventDefault();

            }
            getLocation();
        }

        //This is for trigger AJAX!
        function runNotification() {
            //Calls for event check
            $.ajax({
                url: "./include/cron.php",
                type: "POST",
                data: {

                },

                cache: false,
                success: function(dataResult) {

                    //Nothing happens, just to run AJAX to call notifications!

                }

            });

            //Calls for task check
            $.ajax({
                url: "./include/cron_task.php",
                type: "POST",
                data: {

                },

                cache: false,
                success: function(dataResult) {

                    //Nothing happens, just to run AJAX to call notifications!

                }

            });
        }

        //This is for adding goals!
        function checkExist() {
            var currentDate = getTodayDate();
            var formatType = "read";
            var user_id = '<?php echo $id; ?>';

            $.ajax({
                url: "./include/process_goal.php",
                type: "POST",
                data: {
                    type: formatType,
                    date: currentDate,
                    user_id: user_id
                },

                cache: false,
                success: function(dataResult) {

                    var dataResult = JSON.parse(dataResult);

                    if (dataResult.length > 0) {
                        //content exists!!
                        navApp.goalDisplay = dataResult[0].description;
                        navApp.goalCheck = true;
                    } else {
                        navApp.goalDisplay = "No goal yet! Set one now!";
                        navApp.goalCheck = false;
                    }

                }

            });

        }


        function getCorrectDate(d) {
            var date = d.getDate();
            var month = d.getMonth() + 1; // Since getMonth() returns month from 0-11 not 1-12
            var year = d.getFullYear();

            var dateStr = year + "-" + month + "-" + date;
            return dateStr;
        }

        function getTodayDate() {
            var d = new Date();
            var date = d.getDate();
            var month = d.getMonth() + 1; // Since getMonth() returns month from 0-11 not 1-12
            var year = d.getFullYear();

            var dateStr = year + "-" + month + "-" + date;
            return dateStr;
        }

        function dateChange(dObject, time, count) {

            var newDate = new Date(dObject);
            newDate.setDate(newDate.getDate() + count);

            var date = newDate.getDate();
            var month = newDate.getMonth() + 1;
            var year = newDate.getFullYear();
            var retDate = year + "-" + month + "-" + date + " " + time;
            //console.log(retDate);
            return retDate;
        }
    </script>

</body>

</html>
