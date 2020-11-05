<?php

session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.html");
    return;
}

$id = $_SESSION['userid'];
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
        <v-app style="background: linear-gradient(90deg, #00d2ff 0%, #3a47d5 100%);">
            <v-navigation-drawer permanent app dark style="background: linear-gradient(90deg, #00d2ff 0%, #3a47d5 100%);" :mini-variant="mini">
                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title class="title">
                            Welcome back <?php echo $_SESSION['username'] ?>!
                        </v-list-item-title>
                        <v-list-item-subtitle>
                            subtext
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>

                <v-divider></v-divider>

                <v-list nav dense>
                    <v-list-item link>
                        <v-list-item-icon>
                            <v-icon>mdi-folder</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Work Management</v-list-item-title>
                    </v-list-item>
                    <v-list-item link href="ScheduleVue.php">
                        <v-list-item-icon>
                            <v-icon>mdi-account-multiple</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Scheduler</v-list-item-title>
                    </v-list-item>
                    <v-list-item href="include/logout_process.php">
                        <v-list-item-icon>
                            <v-icon>mdi-star</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-navigation-drawer>

            <v-main>
                <!-- Introduction part -->
                <v-card max-width="400" style="margin:20px" color="rgb(0, 0, 0, 0.2)" dark>
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="headline">
                                Welcome! name!
                            </v-list-item-title>
                            <v-list-item-subtitle>{{weatherReport}}, Mostly sunny</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>

                    <v-card-text>
                        <v-row>
                            <v-col class="display-3" cols="6">
                                23&deg;C
                            </v-col>
                            <v-col cols="6">
                                <v-img src="https://cdn.vuetifyjs.com/images/cards/sun.png" alt="Sunny image" width="92"></v-img>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
                <!-- Calendar part -->
                <v-row style="margin:10px">
                    <v-col>
                        <v-sheet height="64">
                            <v-toolbar flat>
                                <v-btn outlined class="mr-4" color="grey darken-2" @click="setToday">
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
                        <v-sheet height="500">
                            <v-calendar ref="calendar" v-model="focus" color="primary" :events="events" :event-color="getEventColor" :type="type" @click:event="showEvent" @click:more="viewDay" @click:date="viewDay"></v-calendar>
                            <v-menu v-model="selectedOpen" :close-on-content-click="false" :activator="selectedElement" offset-x>
                                <v-card color="grey lighten-4" min-width="350px" flat>
                                    <v-toolbar :color="selectedEvent.color" dark>
                                        <v-btn icon>
                                            <v-icon>mdi-pencil</v-icon>
                                        </v-btn>
                                        <v-toolbar-title v-html="selectedEvent.name"></v-toolbar-title>
                                        <v-spacer></v-spacer>
                                        <v-btn icon>
                                            <v-icon>mdi-heart</v-icon>
                                        </v-btn>
                                        <v-btn icon>
                                            <v-icon>mdi-dots-vertical</v-icon>
                                        </v-btn>
                                    </v-toolbar>
                                    <v-card-text>
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
                weatherReport: '',
                focus: '',
                type: 'month',
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

            },
            created: function() {
                var startDate = new Date("Nov 2 2020 08:00:00");
                var endDate = new Date("Nov 2 2020 15:00:00")
                var startDate2 = new Date("Nov 7 2020 08:00:00");
                var endDate2 = new Date("Nov 7 2020 15:00:00")
                setInterval(this.weatherReturn, 100);
                this.updateEvents()
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
                updateEvents: function() {

                    loadEvent();
                    loadTask();

                    console.log(this.events);



                },
                weatherReturn: function() {
                    var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                    var todayDate = new Date();
                    var dayName = days[todayDate.getDay()];
                    var todayTime = todayDate.toLocaleTimeString();
                    this.weatherReport = dayName + ", " + todayTime;
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
        })

        function loadEvent() {
            var loadReq = new XMLHttpRequest();
            loadReq.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    response = JSON.parse(this.responseText);
                    for (i = 0; i < response.length; i++) {
                        navApp.events.push({
                            name: response[i].title,
                            start: new Date(response[i].date + " " + response[i].start_time),
                            end: new Date(response[i].date + " " + response[i].end_time),
                            color: "red lighten-2",
                            timed: true,
                            details: response[i].description + " " + response[i].location,
                        })
                    }
                }
            };
            loadReq.open("GET", "include/read_event.php", true);
            loadReq.send();
        }

        function loadTask() {
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
                                color: "green lighten-2",
                                timed: true,
                                details: response[i].description,
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

                            for (j = 0; j < 365; j++) {
                                //check if day is a weekday

                                var weStartDate = dateChange(currentDateStart, response[i].start_time, 1);
                                var weEndDate = dateChange(currentDateEnd, response[i].end_time, 1);


                                var chosenDay = new Date(weStartDate).getDay();

                                if (weekday.indexOf(chosenDay) !== -1) {

                                    var eventObj = {
                                        name: response[i].title,
                                        start: new Date(weStartDate),
                                        end: new Date(weEndDate),
                                        color: "green lighten-2",
                                        timed: true,
                                        details: response[i].description,
                                    }
                                    navApp.events.push(eventObj);
                                }
                                //push date by 1
                                currentDateStart.setDate(currentDateStart.getDate() + 1);
                                currentDateEnd.setDate(currentDateEnd.getDate() + 1);
                            }


                        } else if (response[i].repeatable == "Weekend") {
                            //If repeat weekend (Time not considered)
                            //We only accept 1-5 for 1 month ahead
                            const weekend = [0, 6];
                            var todayDate = new Date();
                            var todayDateStr = getCorrectDate(todayDate);
                            var currentDateStart = new Date(getCorrectDate(todayDate) + " " + response[i].start_time);
                            var currentDateEnd = new Date(getCorrectDate(todayDate) + " " + response[i].end_time);

                            for (j = 0; j < 99; j++) {
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
                                        color: "blue lighten-2",
                                        timed: true,
                                        details: response[i].description,
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

                            //Reset day to Sunday
                            todayDate.setDate(todayDate.getDate() - todayDay);
                            console.log(todayDate);
                            todayDay = 0;

                            while (todayDay != chosenDay){
                                todayDate.setDate(todayDate.getDate() + 1);
                                todayDate.setDate(todayDate.getDate() + 1);
                                todayDay += 1
                            }

                            for (j = 0; j < 54; j++) {

                                //check if day is a weekend
                                navApp.events.push({
                                    name: response[i].title,
                                    start: new Date(currentDateStart),
                                    end: new Date(currentDateEnd),
                                    color: "purple lighten-2",
                                    timed: true,
                                    details: response[i].description,
                                })

                                //push date by 7
                                currentDateStart.setDate(currentDateStart.getDate() + 7);
                                currentDateEnd.setDate(currentDateEnd.getDate() + 7);

                            }

                        }

                    }
                }
            };
            loadReq.open("GET", "include/read_task.php", true);
            loadReq.send();
        }


        function getCorrectDate(d) {
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
