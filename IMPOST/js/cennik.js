function updateOutput() {
  var start = document.querySelector("#from").value;
  var end = document.querySelector("#to").value;
      document.querySelector("#cena").innerHTML = document.querySelector("#czas").innerHTML = "";

  let stops = 0;

  if (start && end) { // check if both inputs have a selected value
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      stops = parseInt(this.responseText);
      if(stops > 1)
      {
        document.querySelector("#cena").innerHTML = "Koszt przesyłki to jedyne " + (stops * 3 - 0.01) + "PLN!";
      document.querySelector("#czas").innerHTML = "Twoja paczka będzie na miejscu po upływie " + (stops * 4) + " godzin";
      }


    }
    xhttp.open("POST", "cennik.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("from=" + start + "&to=" + end);
  }
}

document.querySelector("#from").addEventListener("change", updateOutput);
document.querySelector("#to").addEventListener("change", updateOutput);
