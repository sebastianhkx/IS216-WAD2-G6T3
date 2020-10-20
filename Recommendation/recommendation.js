




function weather(loc, date, time){  

  var loc = document.getElementById("location").value;
  var time = "15:00:00";
  var date = "2020-10-20";

  
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
      if (this.readyState == 4) {
          if (this.status == 200) {
              var obj = JSON.parse( this.responseText );

              console.log(obj);

              var weat_list = obj.list;

              console.log(weat_list);

              for (let i = 0; i < weat_list.length; i++) {
                var weather = weat_list[i];
                var time_text = weather.dt_txt;
                var weather_desc = weather.weather[0].description
                
                var time_array = time_text.split(" ");

                if (time_array[1] == time && time_array[0] == date) {

                  document.getElementById("weather").innerText = 
                    weather_desc;
                }


                
              }

          } else {
              alert("Place not found");
          }               
      }

    };
 
  
  // xhr.onreadystatechange

  var gotoURL = "http://api.openweathermap.org/data/2.5/forecast?appid=31de0a7caddc553707023c32a93d4764&q=" + loc ; 
  xhr.open("GET", gotoURL, true);
  xhr.send();


}





