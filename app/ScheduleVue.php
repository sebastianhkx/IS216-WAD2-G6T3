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
<!-- THINGS TO VALIDATE: Check if there's an EXACT overlapping time!!!-->
<!-- ENSURE THE DESCRIPTION HAS A CHARACTER LIMIT OF 200 -->
<!-- ENSURE DOUBLE QUOTES ARE NOT ALLOWED! -->

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
          <v-card class="overflow-hidden" color="rgb(0, 0, 0, 0.3)" dark>
            <v-toolbar flat color="rgb(0, 0, 0, 0.5)">
              <!-- <v-toolbar flat color="light-blue accent-2"> -->
              <v-icon>mdi-account</v-icon>
              <v-toolbar-title class="font-weight-light">
                Schedule Form
              </v-toolbar-title>
              <v-spacer></v-spacer>
            </v-toolbar>
            <v-form ref="form" lazy-validation v-model="scheduleForm">
              <v-container>
                <!-- General alert message start -->
                <v-alert v-model="submitErrorAlert" border="left" close-text="Close Alert" color="pink darken-1" dark dismissible>
                  {{errorSubmitMessage}}
                </v-alert>
                <v-alert v-model="successAlert" border="left" close-text="Close Alert" color="green darken-1" dark dismissible>
                  {{successMessage}}
                </v-alert>
                <!-- Error alert messages -->
                <v-alert v-model="locEmptalert" border="left" close-text="Close Alert" color="pink darken-1" dark dismissible>
                  Location field is empty!
                </v-alert>
                <v-alert border="top" color="red lighten-2" icon="exclamation-thick" v-if="locationReturn == 'failure'" dark>
                  Your search did not return any results. Response Code: {{ResponseCode}}, {{errorType}}.
                </v-alert>
                <!-- End of Error alert messages -->
                <!-- General alert message end -->
                <v-text-field v-model="titleName" label="Title" :rules="fieldRules" required clearable></v-text-field>
                <v-btn-toggle v-model="taskType" mandatory>
                  <v-btn>
                    Event
                  </v-btn>
                  <v-btn @click="removeMap">
                    Task/Reminder
                  </v-btn>
                  <v-btn @click="removeMap">
                    Unavailable
                  </v-btn>
                </v-btn-toggle>

              </v-container>
              <v-container v-if="taskType == '0'">
                <v-row>
                  <v-col cols="12" md="6">
                    <v-text-field v-model="eDateInput" type="date" label="Date" :rules="fieldRules" required>
                    </v-text-field>
                  </v-col>
                  <v-col cols="12" md="3">
                    <v-text-field v-model="estartTimeInput" type="time" label="Start Time" :rules="fieldRules" required>
                    </v-text-field>
                  </v-col>
                  <v-col cols="12" md="3">
                    <v-text-field v-model="eEndTimeInput" type="time" label="End Time" :rules="fieldRules" required>
                    </v-text-field>
                  </v-col>
                </v-row>

                <v-row>
                  <v-col cols="12" md="8">
                    <v-text-field v-model="eLocation" label="Location:" :rules="fieldRules" required clearable>
                    </v-text-field>
                  </v-col>
                  <v-col cols="12" md="4">
                    <v-btn onClick="returnPlaces()">Search for Location</v-btn>
                  </v-col>
                  <v-col cols="12">
                    <v-textarea v-model="eDescription" :counter="200" :rules="descRules" label="Description:" placeholder="Add your description here!">
                    </v-textarea>
                  </v-col>
                </v-row>

                <v-btn cols="12" md="12" color="success" block @click='eValidateSubmit' :disabled="!scheduleForm">Submit
                </v-btn>

                <!-- This container displays the all locations chosen -->

                <v-container v-if="locationReturn == 'success'">
                  <h5>Where are you going?</h5><br>
                  <v-simple-table dark transition="slide-x-transition">
                    <template v-slot:default>
                      <thead>
                        <tr>
                          <th class="text-left">
                            Name
                          </th>
                          <th class="text-left">
                            Address
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="item in locationObject" :key="item.name">
                          <td>{{ item.name }}</td>
                          <td>{{ item.address }}</td>
                          <!--  <td>{{ item.lat }}</td>
                          <td>{{ item.lng }}</td>
                          <td>{{ item.id }}</td> -->
                          <td>
                            <v-btn color="warning" dark @click="getArea(item.name, item.lat, item.lng, item.id)">
                              This is the place!
                            </v-btn>
                          </td>
                        </tr>
                      </tbody>
                    </template>
                  </v-simple-table>

                </v-container>
                <!-- End of container displays the all locations chosen -->

                <!-- This container displays the recommended module -->
                <v-container>
                  <!-- v-if="displayRecommended" -->
                  <div v-if="displayRecommended">
                    <h3>Location Selected: {{selectLocation}}</h3>
                  </div>
                  <v-row>
                    <v-col cols="12" md="6">
                      <!-- Contains image areas -->
                      <div id="map_canvas" v-bind:style="mapStyle"></div>
                    </v-col>
                    <v-col cols="12" md="6" v-if="displayRecommended">
                      <v-container>
                        <v-card class="mx-auto" max-width="400" style="background: rgba(0,0,0,0.2);">
                          <v-list-item two-line>
                            <v-list-item-content>
                              <v-list-item-title class="headline">
                                Weather & Time
                              </v-list-item-title>
                            </v-list-item-content>
                          </v-list-item>

                          <v-card-text>
                            <v-row align="center">

                              <!-- Display Info on selected area -->
                              <v-col class="display-3" cols="6"><img class="text-xs-center" v-bind:src="recWeatherImg" style="width:100px; height:100px;">
                              </v-col>
                              <v-col cols="6">
                                <h5 class="text-xs-center">{{recWeather}}</h5> <br>
                            </v-row>

                            <h5>Time Taken: {{recTimeTaken}}</h5>
                            <v-row align="center">
                              <img class="text-xs-center" src="img/car.png"> <br>
                            </v-row>
                            <v-btn align="center" class="text-xs-center" @click="callTime">Check Time</v-btn>
                            <v-checkbox v-model="autoTimeModifyCheck" label="Would you like to automatically modify the start time to accomodate travel time?" value="true"></v-checkbox>
                          </v-card-text>

                        </v-card>
                    </v-col>
                </v-container>
                </v-row>
              </v-container>
              <!-- End of recommended module-->


              </v-container>

              <!-- Task/Reminder/Unavailable -->

              <v-container v-if="taskType == '1' || taskType == '2'">
                <v-row>
                  <v-col cols="12" md="3">
                    <v-text-field v-model="tDateInput" type="date" label="Date" required :rules="fieldRules"></v-text-field>
                  </v-col>

                  <v-col cols="12" md="3">
                    <v-select :items="['Non Repeat', 'Weekday', 'Weekend', 'Repeat Weekly']" label="Repeatable:" v-model="tRepeatable" :rules="fieldRules" required> </v-select>
                  </v-col>

                  <v-col cols="12" md="3">
                    <v-text-field v-model="tStartTimeInput" type="time" label="Start Time" :rules="fieldRules" required></v-text-field>
                  </v-col>
                  <v-col cols="12" md="3">
                    <v-text-field v-model="tEndTimeInput" type="time" label="End Time" :rules="fieldRules" required></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-textarea v-model="tDescription" :counter="200" :rules="descRules" label="Description:" placeholder="Add your description here!">
                    </v-textarea>
                  </v-col>
                  <v-btn cols="12" md="12" color="success" block @click='eValidateSubmit' :disabled="!scheduleForm">Submit
                </v-row>

              </v-container>

            </v-form>
          </v-card>
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
          scheduleForm: false,
          taskType: ["Event", "Reminder/Task", "Unavailable"],
          taskType: '0',
          titleName: '',
          eDateInput: '',
          estartTimeInput: '',
          eEndTimeInput: '',
          eDescription: '',
          fieldRules: [v => !!v || 'This field is required'],
          checkTime: [v => !!v || 'End time must be greater than start time'],
          descRules: [v => v.length <= 200 || 'Description must be less than 200 characters'],
          locationReturn: "none",
          eLocation: '',
          locImg: '',
          locationObject: [],
          locEmptalert: false,
          ResponseCode: 200,
          errorType: '',
          displayRecommended: false,
          mapStyle: '',
          selectLocation: '',
          recLocation: '',
          recWeather: '',
          recWeatherImg: '',
          recTimeTaken: '',
          recCoordinates: '',
          tDateInput: '',
          tStartTimeInput: '',
          tEndTimeInput: '',
          tDescription: '',
          tRepeatable: 'Non Repeat',
          submitErrorAlert: false,
          errorSubmitMessage: '',
          successAlert: false,
          successMessage: '',
          autoTimeModifyCheck: 'false',
          goalDisplay: ''
        },
        computed: {
          mini() {
            return !(this.lgAndUp || this.menuOpen);
          },
          lgAndUp() {
            return this.$vuetify.breakpoint.mdAndUp;
          },
        },
        created: function() {
          checkExist();
        },
        methods: {
          getDate: function() {
            var dateObj = new Date();
            var month = dateObj.getMonth() + 1; //months from 1-12
            var day = dateObj.getDate() - 1;
            var year = dateObj.getFullYear();
            var newDate = year + "-" + month + "-" + day;
            return newDate
          },
          removeMap: function() {
            this.displayRecommended = false;
            this.mapStyle = "width:0px; height:0px"
          },
          getArea(name, lat, lng, id) {
            callRecommendedModule(name, lat, lng, id);
          },
          callTime: function() {
            getTime();
          },
          eValidateSubmit() {
            if (this.$refs.form.validate() == true) {
              submitForm();
            };
          },
        }
      }

    );

    function loadEdit() {

    }


    function returnPlaces() {
      var location = FormApp.eLocation;
      const client_id = "VXUI3SSKXSUGY0X2V1RCQDVQ12YBGV3V4F2TY3K51T00Z3FA";
      const client_secret = "GMGE02JZ0FXRX5ND42RWYKBVQZUZWLWPZQ1SVR12GLXIW52T";
      //Clear every other element!
      FormApp.displayRecommended = false;
      FormApp.locationReturn = false;
      document.getElementById("map_canvas").innerHTML = "";
      FormApp.mapStyle = ""

      if (location.length == 0) {
        FormApp.locEmptalert = true;
      } else {
        FormApp.locEmptalert = false;
        const locationObject = [];
        var loadRequest = new XMLHttpRequest();
        loadRequest.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);

            if (response.meta.code != 200) {
              FormApp.locationReturn = "failure";
              FormApp.ResponseCode = response.meta.code;
              FormApp.errorType = response.meta.errorType;

            } else {
              for (i = 0; i < response.response.venues.length; i++) {
                //var obj = {};
                //obj["name"] = response.candidates[i].name;
                //obj["address"] = response.candidates[i].name;
                var id = response.response.venues[i].id;
                var lat = response.response.venues[i].location.lat;
                var lng = response.response.venues[i].location.lng;
                var formatted_address = response.response.venues[i].location.address + " (" + response.response.venues[i].location.crossStreet + ")"
                locationObject.push({
                  name: response.response.venues[i].name,
                  address: formatted_address,
                  lat: lat,
                  lng: lng,
                  id: id
                });
              }
              FormApp.locationObject = locationObject;
              FormApp.locationReturn = "success";
            }
          }
        }
        loadRequest.open("GET", "https://api.foursquare.com/v2/venues/search?client_id=" + client_id + "&client_secret=" + client_secret + "&near=Singapore&query=" + location + "&limit=5&v=20201026", true);
        loadRequest.send();
        event.preventDefault();
      }
    }

    function callRecommendedModule(name, lat, lng, id) {

      FormApp.displayRecommended = true;
      FormApp.locationReturn = 'none';
      FormApp.selectLocation = name;
      console.log(id);
      FormApp.recCoordinates = {
        lat: lat,
        lng: lng
      };
      callWeather(lat, lng, id);

    }

    function callWeather(lat, lng, id) {
      const api_key_weather = "c9a2c0a5914d4558bdb5432970854635";
      var currentDate = new Date();
      var selectedDate = new Date(FormApp.eDateInput);
      var diffTime = Math.abs(selectedDate - currentDate);
      var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

      if (diffDays > 7 || diffDays < 0) {
        FormApp.recWeather = "Weather cannot be estimated.";
        loadMap(lat, lng);
      } else {

        var loadRequest = new XMLHttpRequest();
        loadRequest.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            response = JSON.parse(this.responseText);
            var weather = response.daily[diffDays - 1].weather[0].main;
            var weather_icon = response.daily[diffDays - 1].weather[0].icon;
            var weather_details = response.daily[diffDays - 1].weather[0].details;

            FormApp.recWeatherImg = "http://openweathermap.org/img/wn/" + weather_icon + "@2x.png"
            FormApp.recWeather = weather;
            FormApp.recLocation = {
              lat: lat,
              lng: lng
            };
            //Change map!
            loadMap(lat, lng);

          }
        }
        loadRequest.open("GET", "https://api.openweathermap.org/data/2.5/onecall?lat=" + lat + "&lon=" + lng + "&exclude=current,hourly,minutely&appid=" + api_key_weather, true);
        loadRequest.send();
        event.preventDefault();
      }
    }

    function loadMap(lat, lng) {

      FormApp.mapStyle = "width:100%; height:500px;"
      var locale = {
        lat: lat,
        lng: lng
      };
      var map = new google.maps.Map(
        document.getElementById('map_canvas'), {
          zoom: 20,
          center: locale
        });
      var marker = new google.maps.Marker({
        position: locale,
        map: map
      });
    }

    //Calls openrouteservice to get information

    function getTime() {

      //timing
      var time_restricted = '';

      //get location
      function getLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(usePosition);
        } else {
          //not supported by this browser!
          alert("Browser does not support geolocation!");
        }
      }

      //Call the openrouteapi!
      function usePosition(position) {
        var currentLat = position.coords.latitude;
        var currentLng = position.coords.longitude;
        var travelLat = FormApp.recCoordinates.lat;
        var travelLng = FormApp.recCoordinates.lng;

        console.log(currentLat + " " + currentLng + " " + travelLat + " " + travelLng);


        var loadRequest = new XMLHttpRequest();
        loadRequest.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            response = JSON.parse(this.responseText);
            var distanceMatrix = response.durations;
            var totalTime = 0;

            //console.log(distanceMatrix);

            for (distanceArr of distanceMatrix) {
              console.log(distanceArr[1]);
              totalTime += Number(distanceArr[0]);
              totalTime += Number(distanceArr[1]);
            }
            console.log(totalTime / 2);
            FormApp.recTimeTaken = new Date((totalTime / 2) * 1000).toISOString().substr(11, 8);
            var date2 = new Date((totalTime / 2) * 1000).toISOString().substr(11, 8);

            console.log(FormApp.estartTimeInput);
            console.log(date2);

            if (FormApp.estartTimeInput !== "") {
              if (FormApp.autoTimeModifyCheck == "true") {


                var date1 = FormApp.estartTimeInput + ":00";
                console.log(date1);
                var date1_array = date1.split(":");
                var h1 = date1_array[0] * 3600 * 1000;
                var m1 = date1_array[1] * 60 * 1000;
                var s1 = date1_array[2] * 1000;

                var d1 = new Date(h1 + m1 + s1);

                var date2_array = date2.split(":");
                var h2 = date2_array[0] * 3600 * 1000;
                var m2 = date2_array[1] * 60 * 1000;
                var s2 = date2_array[2] * 1000;

                var d2 = new Date(h2 + m2 + s2);

                var d3 = new Date(d1 - d2 - 27000000);

                var new_time = d3.toTimeString();
                var new_time = new_time.slice(0, 5);
                console.log(new_time);

                FormApp.estartTimeInput = new_time;

                FormApp.successMessage = "The timing has been changed for you";
                FormApp.successAlert = true;

              } else {
                FormApp.errorSubmitMessage = "There is no change in your current timing";
                FormApp.submitErrorAlert = true;
              }
            } else {

            }

          }
        }
        loadRequest.open("POST", "https://api.openrouteservice.org/v2/matrix/driving-car", true);
        loadRequest.setRequestHeader('Accept', 'application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8');
        loadRequest.setRequestHeader('Content-Type', 'application/json');
        loadRequest.setRequestHeader('Authorization', '5b3ce3597851110001cf62486288a428d94d441192557d6833ffe438');
        var body = {
          locations: [
            [currentLng, currentLat],
            [travelLng, travelLat]
          ]
        };
        loadRequest.send(JSON.stringify(body));
      }

      getLocation();

      return time_restricted;

    }

    function submitForm() {


      var taskType = '';
      FormApp.submitErrorAlert = false;
      FormApp.successAlert = false;
      FormApp.errorSubmitMessage = "";
      FormApp.successMessage = "";

      if (FormApp.taskType == '0') {
        taskType = 'Event';
        //Validate Timer events
        if (validateTimer(FormApp.estartTimeInput, FormApp.eEndTimeInput) == false) {
          FormApp.submitErrorAlert = true;
          FormApp.errorSubmitMessage = "The End Time cannot be earlier or same as start time! Please change it!";
        } else if (FormApp.selectLocation == "") {
          FormApp.submitErrorAlert = true;
          FormApp.errorSubmitMessage = "Please select a location before proceeding!";
        } else {
          //Success condition, run through the final ajax function

          var date = FormApp.eDateInput;
          var description = FormApp.eDescription;
          var end_time = FormApp.eEndTimeInput;
          var location = FormApp.selectLocation;
          var start_time = FormApp.estartTimeInput;
          var title = FormApp.titleName;

          //User_ID
          var user_id = '<?php echo $id; ?>';

          // 0 == False, 1 == True
          var completed = 0;


          $(document).ready(function() {

            $.ajax({
              url: "./include/read_event_time.php",
              type: "POST",
              data: {
                date: date,
                end_time: end_time,
                start_time: start_time,
                user_id: user_id
              },

              cache: false,
              success: function(dataResult) {

                var dataResult = JSON.parse(dataResult);

                if (dataResult.counter > 0) {

                  alert("There is a clash with another schedule of yours");

                } else {

                  $.ajax({
                    url: "./include/add_event.php",
                    type: "POST",
                    data: {
                      date: date,
                      description: description,
                      end_time: end_time,
                      start_time: start_time,
                      location: location,
                      title: title,
                      user_id: user_id
                    },

                    cache: false,
                    success: function(dataResult) {

                      var dataResult = JSON.parse(dataResult);

                      if (dataResult.statusCode == 200) {

                        FormApp.successMessage = "Data Successfully added!";
                        FormApp.successAlert = true;

                      } else if (dataResult.statusCode == 201) {
                        FormApp.errorSubmitMessage = "Error occured! The page returned 201 Status Code!";
                        FormApp.submitErrorAlert = true;
                      }

                    }

                  });

                }

              }


            });

          });
        }

      } else {

        //Validate Task Type
        if (FormApp.taskType == '1') {
          taskType = "Task";
        } else {
          taskType = 'Unavailable';
        }
        //Validate Timer
        if (validateTimer(FormApp.tStartTimeInput, FormApp.tEndTimeInput) == false) {
          FormApp.submitErrorAlert = true;
          FormApp.errorSubmitMessage = "The End Time cannot be earlier or same as start time! Please change it!";
        } else {
          //Success condition, run through the final ajax function

          if (FormApp.taskType == '1') {

            var date = FormApp.tDateInput;
            var description = FormApp.tDescription;
            var end_time = FormApp.tEndTimeInput;
            var repeatable = FormApp.tRepeatable;
            var start_time = FormApp.tStartTimeInput;
            var title = FormApp.titleName;

            // userid take from session id!!
            var user_id = '<?php echo $id; ?>';

            $(document).ready(function() {

              $.ajax({
                url: "./include/add_task.php",
                type: "POST",

                data: {
                  date: date,
                  description: description,
                  end_time: end_time,
                  start_time: start_time,
                  repeatable: repeatable,
                  title: title,
                  user_id: user_id
                },

                cache: false,
                success: function(dataResult) {

                  var dataResult = JSON.parse(dataResult);

                  if (dataResult.statusCode == 200) {

                    FormApp.successMessage = "Data Successfully added!";
                    FormApp.successAlert = true;

                  } else if (dataResult.statusCode == 201) {
                    FormApp.errorSubmitMessage = "Error occured! The page returned 201 Status Code!";
                    FormApp.submitErrorAlert = true;
                  }

                }

              });

            });

          } else {

            var date = FormApp.tDateInput;
            var description = FormApp.tDescription;
            var end_time = FormApp.tEndTimeInput;
            var repeatable = FormApp.tRepeatable;
            var start_time = FormApp.tStartTimeInput;
            var title = FormApp.titleName;
            // userid take from session id!!

            var user_id = '<?php echo $id; ?>';

            $(document).ready(function() {

              $.ajax({
                url: "./include/add_unavailable.php",
                type: "POST",

                data: {
                  date: date,
                  description: description,
                  end_time: end_time,
                  start_time: start_time,
                  repeatable: repeatable,
                  title: title,
                  user_id: user_id
                },

                cache: false,
                success: function(dataResult) {

                  var dataResult = JSON.parse(dataResult);

                  if (dataResult.statusCode == 200) {

                    FormApp.successMessage = "Data Successfully added!";
                    FormApp.successAlert = true;

                  } else if (dataResult.statusCode == 201) {
                    FormApp.errorSubmitMessage = "Error occured! The page returned 201 Status Code!";
                    FormApp.submitErrorAlert = true;
                  }

                }

              });

            });

          }

        }
      }


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
            FormApp.goalDisplay = dataResult[0].description;
          } else {
            FormApp.goalDisplay = "No goal yet! Set one now!";
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

    function validateTimer(start, end) {
      var startTime = Number(start.split(":").join(""));
      var endTime = Number(end.split(":").join(""));
      if (endTime - startTime <= 0) {
        return false;
      } else {
        return true;
      }
    }
  </script>



</body>

</html>
