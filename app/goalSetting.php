<?php

session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.html");
    return;
}

$id = $_SESSION['userid'];
$username = $_SESSION['username'];

if (isset($_GET['itemid']) && isset($_GET['taskType'])) {
    $itemid = $_GET['itemid'];
    $taskType = $_GET['taskType'];
    $title = $_GET['title'];
    $startTime = $_GET['startTime'];
    $endTime = $_GET['endTime'];
    $location = $_GET['location'];
    $date = $_GET['date'];
    $repeatable = $_GET['repeatable'];
}

?>

<!DOCTYPE html>
<html>
<!-- THINGS TO VALIDATE: Check if there's an EXACT overlapping time!!!-->
<!-- ANother thing to validate: Make sure the date isn't backdated! -->

<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

    <style>
        body {
            background: linear-gradient(90deg, #00d2ff 0%, #3a47d5 100%);
        }

        .center-element {
            text-align: "center";
        }

        a:hover {
            text-decoration: none;
        }

        @keyframes fade {

            0%,
            100% {
                opacity: 0
            }

            50% {
                opacity: 1
            }
        }
    </style>

</head>


<body>
    <div class="">

        <div id="app">
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
                        <v-list-item href="include/logout_process.php">
                            <v-list-item-icon>
                                <v-icon>mdi-logout-variant</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Logout</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-navigation-drawer>

                <v-main>
                    <v-container style="text-align:center; padding-top:10%; padding-left: 100px; padding-right:100px">
                        <v-card class="overflow-hidden" color="rgb(0, 0, 0, 0.5)" dark>
                            <!-- this following are text message -->
                            <v-alert v-model="submitErrorAlert" border="left" close-text="Close Alert" color="pink darken-1" dark dismissible>
                                {{errorSubmitMessage}}
                            </v-alert>
                            <v-alert v-model="successAlert" border="left" close-text="Close Alert" color="green darken-1" dark dismissible>
                                {{successMessage}}
                            </v-alert>
                            <!-- end of text message -->
                            <v-list-item two-line>
                                <v-list-item-content>
                                    <v-list-item-title class="headline" style="text-align:center; margin-top: 20px">
                                        Set your goal for the day
                                    </v-list-item-title>
                                    <v-list-item-subtitle style="text-align:center;">Set your goal for the day. Work towards it. Don't stress too much.</v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                            <v-form ref="form">
                                <v-textarea outlined v-model="goal" :rules="fieldRules" style="text-align:center; margin-left: 100px; margin-right:100px" label="Set your Goal" value="" placeholder="Keep it short, but concise with measurable goals"></v-textarea>

                                <!-- if user is adding new stuff into the database -->
                                <div v-if="formatType=='new'">
                                    <v-btn cols="12" md="12" color="success" @click='eValidateSubmit' :disabled="!scheduleForm" block>Add Goal
                                </div>
                                <!-- if user is editing existing stuff -->
                                <div v-else style="padding-left: 10%; padding-right: 10%">
                                    <v-row>
                                        <v-col cols="12" md="6">
                                            <v-btn cols="12" md="12" color="success" @click='eValidateEdit' :disabled="!scheduleForm" block>Edit Goal
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-btn cols="12" md="12" color="success" @click='eValidateDelete' :disabled="!scheduleForm" block>Delete Goal
                                        </v-col>
                                    </v-row>
                                </div>
                            </v-form>
                        </v-card>
                    </v-container>
                </v-main>
            </v-app>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTxz9GlBwJNiU8IlL_IcQQmGqJSmlnV50">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script>
        var FormApp = new Vue({
                el: '#app',
                vuetify: new Vuetify(),
                data: {
                    scheduleForm: true,
                    fieldRules: [v => !!v || 'This field is required'],
                    submitErrorAlert: false,
                    successAlert: false,
                    errorSubmitMessage: '',
                    successMessage: '',
                    formatType: 'new',
                    goalDisplay: '',
                    goal: '',
                    goalID: '' //only used if existing
                },
                computed: {
                    lgAndUp() {
                        return this.$vuetify.breakpoint.mdAndUp;
                    },
                    mini() {
                        return !(this.lgAndUp || this.menuOpen);
                    },
                },
                created: function() {
                    //We want to check if the thing exist.
                    checkExist();
                },
                methods: {
                    eValidateSubmit() {
                        if (this.$refs.form.validate() == true) {
                            submitForm();
                        };
                    },
                    eValidateEdit() {
                        if (this.$refs.form.validate() == true) {
                            editForm();
                        };
                    },
                    eValidateDelete() {
                        if (this.$refs.form.validate() == true) {
                            deleteForm();
                        };
                    },
                }
            }

        );

        //add into new day

        function submitForm() {
            var currentDate = getTodayDate();

            $(document).ready(function() {

                var date = currentDate;
                var formatType = "add";
                var goal = FormApp.goal;

                // User_Id to be modified

                var user_id = '<?php echo $id; ?>';

                $.ajax({
                    url: "./include/process_goal.php",
                    type: "POST",
                    data: {
                        date: date,
                        goal: goal,
                        user_id: user_id,
                        type: formatType
                    },

                    cache: false,
                    success: function(dataResult) {

                        var dataResult = JSON.parse(dataResult);

                        if (dataResult.statusCode == 200) {
                            console.log("something is right");
                            FormApp.successMessage = "Entry successfully updated!";
                            FormApp.successAlert = true;
                            window.location.href = 'index.php';

                        } else if (dataResult.statusCode == 201) {
                            console.log("something is wrong");
                            FormApp.errorSubmitMessage = "Error occured! The page returned 201 Status Code!";
                            FormApp.submitErrorAlert = true;
                        }

                    }

                });

            });

        }

        //edit today's goal
        function editForm() {
            var currentDate = getTodayDate();

            $(document).ready(function() {

                var date = currentDate;
                var formatType = "edit";
                var goal = FormApp.goal;
                var goal_id = FormApp.goalID;

                // User_Id to be modified

                var user_id = '<?php echo $id; ?>';

                $.ajax({
                    url: "./include/process_goal.php",
                    type: "POST",
                    data: {
                        date: date,
                        goal: goal,
                        goal_id: goal_id,
                        type: formatType
                    },

                    cache: false,
                    success: function(dataResult) {

                        var dataResult = JSON.parse(dataResult);

                        if (dataResult.statusCode == 200) {
                            FormApp.successMessage = "Entry successfully updated!";
                            FormApp.successAlert = true;
                            FormApp.goalDisplay = FormApp.goal;

                        } else if (dataResult.statusCode == 201) {
                            FormApp.errorSubmitMessage = "Update failed! The page returned 201 Status Code!";
                            FormApp.submitErrorAlert = true;
                        }

                    }

                });

            });

        }

        //Delete
        function deleteForm() {
            var currentDate = getTodayDate();

            $(document).ready(function() {

                var date = currentDate;
                var formatType = "delete";
                var goal_id = FormApp.goalID;

                // User_Id to be modified

                var user_id = '<?php echo $id; ?>';

                $.ajax({
                    url: "./include/process_goal.php",
                    type: "POST",
                    data: {
                        goal_id: goal_id,
                        type: formatType
                    },

                    cache: false,
                    success: function(dataResult) {

                        var dataResult = JSON.parse(dataResult);

                        if (dataResult.statusCode == 200) {
                            FormApp.successMessage = "Goal deleted!";
                            FormApp.successAlert = true;
                            location.reload();

                        } else if (dataResult.statusCode == 201) {
                            FormApp.errorSubmitMessage = "Deletion failed! The page returned 201 Status Code!";
                            FormApp.submitErrorAlert = true;
                        }

                    }

                });

            });

        }

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
                        FormApp.formatType = "existing";
                        FormApp.goal = dataResult[0].description;
                        FormApp.goalID = dataResult[0].goal_id;
                        FormApp.goalDisplay = dataResult[0].description;
                    } else {
                        FormApp.goalDisplay = "You haven't set your goal!";
                    }

                }

            });

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