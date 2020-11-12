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
    <title>WorkManagement</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">

    <script src="https://unpkg.com/axios/dist/axios.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/timrjs/latest/timr.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300" rel="stylesheet">
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

        @import url(https://fonts.googleapis.com/css?family=Roboto:100,300);

        @keyframes session-finish {
            0% {
                background: #1b5e20;
            }

            50% {
                background: #388e3c;
            }

            100% {
                background: #1b5e20;
            }
        }

        @keyframes break-finish {
            0% {
                background: #b71c1c;
            }

            50% {
                background: #f44336;
            }

            100% {
                background: #b71c1c;
            }
        }

        body {
            background: #FFFFFF;
            color: #FFFFFF;
            font: 100 16px 'Roboto', sans-serif;
            padding: 0px;
        }

        h1,
        .time,
        .sessionText {
            font-size: 3em;
            color: white;
        }

        h1 {
            padding-top: 20px;
        }

        h4 {
            color: white;

        }

        .workStatus {
            padding-top: 40px;

        }

        .timer-wrapper {
            border: 6px solid #263238;
            border-radius: 50%;
            cursor: pointer;
            height: 300px;
            margin: 45px auto;
            overflow: hidden;
            position: relative;
            transition: all 0.2s linear;
            width: 300px;
        }

        .timer-wrapper.session {
            box-shadow: 2px 0 0 2px #1b5e20, 0 2px 0 2px #1b5e20, -2px 0 0 2px #1b5e20, 0 -2px 0 2px #1b5e20, 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .timer-wrapper.session:hover {
            box-shadow: 2px 0 0 2px #388e3c, 0 2px 0 2px #388e3c, -2px 0 0 2px #388e3c, 0 -2px 0 2px #388e3c, 0 12px 15px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
        }

        .timer-wrapper.break {
            box-shadow: 2px 0 0 2px #b71c1c, 0 2px 0 2px #b71c1c, -2px 0 0 2px #b71c1c, 0 -2px 0 2px #b71c1c, 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .timer-wrapper.break:hover {
            box-shadow: 2px 0 0 2px #f44336, 0 2px 0 2px #f44336, -2px 0 0 2px #f44336, 0 -2px 0 2px #f44336, 0 12px 15px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
        }

        .timer-wrapper .fill {
            bottom: 0;
            content: '';
            left: 0;
            position: absolute;
            right: 0;
            transition: inherit;
            width: inherit;
            z-index: -1;
        }

        .timer-wrapper .fill.session {
            background: #1b5e20;
        }

        .timer-wrapper .fill.session.finish {
            animation: session-finish 0.06s linear 5;
        }

        .timer-wrapper .fill.break {
            background: #b71c1c;
        }

        .timer-wrapper .fill.break.finish {
            animation: break-finish 0.6s linear 5;
        }

        .timer-wrapper .time,
        .timer-wrapper .sessionText {
            bottom: 20%;
            left: 0;
            position: absolute;
            right: 0;

        }

        .timer-wrapper .sessionText {
            top: 20%;
        }

        .change span {
            border: 3px solid;
            border-radius: 50%;
            display: inline-block;
            font-size: 1.5em;
            height: 2em;
            line-height: 2em;
            margin: 10px;
            width: 2em;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        }

        .change.session span {
            border-color: #1b5e20;
        }

        .change.session input {
            width: 18em;
            -webkit-appearance: none;
        }

        .change.session input:focus {
            outline: none;
        }

        .change.session input::-webkit-slider-runnable-track {
            width: 100%;
            height: 8.4px;
            cursor: pointer;
            box-shadow: 1px 1px 1px #000, 0px 0px 1px #0d0d0d;
            background: #388e3c;
            border-radius: 1.3px;
            border: 0.2px solid #010101;
        }

        .change.session input::-webkit-slider-thumb {
            box-shadow: 1px 1px 1px #000, 0px 0px 1px #0d0d0d;
            border: 1px solid #000;
            height: 36px;
            width: 16px;
            border-radius: 3px;
            background: #1b5e20;
            cursor: pointer;
            -webkit-appearance: none;
            margin-top: -14px;
        }

        .change.session input::-moz-range-track {
            width: 100%;
            height: 8.4px;
            cursor: pointer;
            box-shadow: 1px 1px 1px #000, 0px 0px 1px #0d0d0d;
            background: #388e3c;
            border-radius: 1.3px;
            border: 0.2px solid #010101;
        }

        .change.session input::-moz-range-thumb {
            box-shadow: 1px 1px 1px #000, 0px 0px 1px #0d0d0d;
            border: 1px solid #000;
            height: 36px;
            width: 16px;
            border-radius: 3px;
            background: #388e3c;
            cursor: pointer;
        }

        .change.session input::-ms-track {
            width: 100%;
            height: 8.4px;
            cursor: pointer;
            background: transparent;
            border-color: transparent;
            color: transparent;
        }

        .change.session input::-ms-fill-lower {
            background: #50cb4f;
            border: 0.2px solid #010101;
            border-radius: 2.6px;
            box-shadow: 1px 1px 1px #000, 0px 0px 1px #0d0d0d;
        }

        .change.session input::-ms-fill-upper {
            background: #388e3c;
            border: 0.2px solid #010101;
            border-radius: 2.6px;
            box-shadow: 1px 1px 1px #000, 0px 0px 1px #0d0d0d;
        }

        .change.session input::-ms-thumb {
            box-shadow: 1px 1px 1px #000, 0px 0px 1px #0d0d0d;
            border: 1px solid #000;
            height: 36px;
            width: 16px;
            border-radius: 3px;
            background: #388e3c;
            cursor: pointer;
            height: 8.4px;
        }

        .change.break span {
            border-color: #b71c1c;
        }

        .change.break input {
            width: 18em;
            -webkit-appearance: none;
        }

        .change.break input:focus {
            outline: none;
        }

        .change.break input::-webkit-slider-runnable-track {
            width: 100%;
            height: 8.4px;
            cursor: pointer;
            box-shadow: 1px 1px 1px #000, 0px 0px 1px #0d0d0d;
            background: #f44336;
            border-radius: 1.3px;
            border: 0.2px solid #010101;
        }

        .change.break input::-webkit-slider-thumb {
            box-shadow: 1px 1px 1px #000, 0px 0px 1px #0d0d0d;
            border: 1px solid #000;
            height: 36px;
            width: 16px;
            border-radius: 3px;
            background: #b71c1c;
            cursor: pointer;
            -webkit-appearance: none;
            margin-top: -14px;
        }

        .change.break input::-moz-range-track {
            width: 100%;
            height: 8.4px;
            cursor: pointer;
            box-shadow: 1px 1px 1px #000, 0px 0px 1px #0d0d0d;
            background: #f44336;
            border-radius: 1.3px;
            border: 0.2px solid #010101;
        }

        .change.break input::-moz-range-thumb {
            box-shadow: 1px 1px 1px #000, 0px 0px 1px #0d0d0d;
            border: 1px solid #000;
            height: 36px;
            width: 16px;
            border-radius: 3px;
            background: #f44336;
            cursor: pointer;
        }

        .change.break input::-ms-track {
            width: 100%;
            height: 8.4px;
            cursor: pointer;
            background: transparent;
            border-color: transparent;
            color: transparent;
        }

        .change.break input::-ms-fill-lower {
            background: #50cb4f;
            border: 0.2px solid #010101;
            border-radius: 2.6px;
            box-shadow: 1px 1px 1px #000, 0px 0px 1px #0d0d0d;
        }

        .change.break input::-ms-fill-upper {
            background: #f44336;
            border: 0.2px solid #010101;
            border-radius: 2.6px;
            box-shadow: 1px 1px 1px #000, 0px 0px 1px #0d0d0d;
        }

        .change.break input::-ms-thumb {
            box-shadow: 1px 1px 1px #000, 0px 0px 1px #0d0d0d;
            border: 1px solid #000;
            height: 36px;
            width: 16px;
            border-radius: 3px;
            background: #f44336;
            cursor: pointer;
            height: 8.4px;
        }
    </style>
</head>

<body>

    <div id="workApp">
        <v-app style="background: linear-gradient(180deg, rgba(161,196,253,1) 0%, rgba(194,233,251,1) 100%);">
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
                            <v-icon>mdi-home</mdi-home>
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
                    <v-list-item href="model/logout_process.php">
                        <v-list-item-icon>
                            <v-icon>mdi-logout-variant</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-navigation-drawer>

            <v-main style="background: rgba(0,0,0,0.2); text-align:center;">

                <h1>Pomodoro Timer</h1>
                <div class="workStatus">
                    <h4>Now Your Work Status: </h4><label id=label>
                        <h4>{{worktitle}}</h4>
                    </label>
                </div>
                <div class="timer-wrapper" :class="session.toLowerCase()" @click="startStop"><span class="sessionText">{{ this.session }}</span><span class="time">{{ this.time }}</span><span class="fill" :style="{ height: `${fillHeight}%` }" :class="[{ finish: finish }, session.toLowerCase()]"></span></div>
                <div class="change session">
                    <h4>Working Time Setting:</h4><span>{{ sessionTime | zeroPad }}</span><input v-model="sessionTime" type="range" min="1" max="60" />
                </div>
                <div class="change break">
                    <h4>Break Time Setting: </h4><span> {{ breakTime | zeroPad }}</span><input v-model="breakTime" type="range" min="1" max="60" />
                </div>

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
            el: '#workApp',
            vuetify: new Vuetify(),
            data: {
                drawer: true,
                focus: '',
                type: 'month',
                navLink: {
                    logout: "logout.html"
                },

                selectedEvent: {},
                selectedElement: null,
                selectedOpen: false,
                events: [],

                time: '25:00',
                sessionTime: 25,
                breakTime: 5,
                session: 'Session',
                fillHeight: 0,
                finish: false,
                goalDisplay: '',
                worktitle: ''

            },

            mounted() {
                const buzzer = new Audio('https://cpres.herokuapp.com/pomodoro-timer/egg-timer.wav');
                this.timer = Timr(`${this.sessionTime}m`).ticker(({
                    formattedTime,
                    percentDone
                }) => {
                    this.time = formattedTime;
                    this.fillHeight = percentDone;
                }).finish(self => {
                    this.finish = true;
                    buzzer.play(); // Timeout to give finish animation enough time to run.

                    setTimeout(() => {
                        const session = this.session === 'Session' ? 'Break' : 'Session';
                        this.session = session;
                        this.fillHeight = 0, this.finish = false;
                        this.time = self.setStartTime(`${this[`${session.toLowerCase()}Time`]}m`).getFt();
                        self.start();
                    }, 3000);
                });
            },

            watch: {
                sessionTime(newTime) {
                    this.session = 'Session';
                    this.time = this.timer.setStartTime(`${newTime}m`).getFt();
                }
            },

            computed: {
                lgAndUp() {
                    return this.$vuetify.breakpoint.mdAndUp;
                },
                mini() {
                    return !(this.lgAndUp || this.menuOpen);
                },

            },

            filters: {
                zeroPad(v) {
                    return v < 10 ? `0${v}` : v;
                }
            },

            created: function() {

                    loadTask();
                },

            methods: {

                startStop() {
                    !this.timer.isRunning() && !this.finish ? this.timer.start() : this.timer.pause();
                },

                workStatus({
                    name
                }) {
                    this.event = name;
                    navApp.workStatus = name[0];
                },


                viewDay({
                    date
                }) {
                    this.focus = date
                    this.type = 'day'
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

        function loadTask() {
            var currentTime = CurentTime()
            var currentDate = getTodayDate();
            console.log(currentTime);
            $(document).ready(function() {

                $.ajax({
                    url: "./include/read_task_work_management.php",
                    type: "POST",

                    data: {
                        date: currentDate,
                        currentTime: currentTime
                    },

                    cache: false,
                    success: function(dataResult) {

                        var dataResult = JSON.parse(dataResult);
                        navApp.worktitle = dataResult[0].title;

                    }

                });

            });

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

        function statusChange(start, end, status) {
            var sdate = start;
            var sdate = sdate.getTime();
            var edate = end;
            var edate = edate.getTime();
            var time = CurentTime().getTime();
            console.log(time);
            console.log(sdate);
            if ((time >= sdate) && (time <= edate)) {
                document.getElementById(label).innerHTML = status;
            }
        }

        function CurentTime() {
            var now = new Date();

            var year = now.getFullYear();
            var month = now.getMonth() + 1;
            var day = now.getDate();

            var hh = now.getHours();
            var mm = now.getMinutes();

            var clock = year + "-";

            if (month < 10)
                clock += "0";

            clock += month + "-";

            if (day < 10)
                clock += "0";

            clock += day + " ";

            if (hh < 10)
                clock += "0";

            clock += hh + ":";
            if (mm < 10) clock += '0';
            clock += mm;
            return (clock);
        }

        function getTodayDate() {
            var d = new Date();
            var date = d.getDate();
            var month = d.getMonth() + 1; // Since getMonth() returns month from 0-11 not 1-12
            var year = d.getFullYear();

            var dateStr = year + "-" + month + "-" + date;
            return dateStr;
        }
    </script>

</body>

</html>
