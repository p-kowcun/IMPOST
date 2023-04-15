const map = document.querySelectorAll("#map area");
const mapinfo = document.querySelectorAll(".mapinfo");
const towndesc = document.querySelectorAll(".towndesc");
const time = document.querySelectorAll(".time");
const city = document.querySelectorAll(".city");
const from = document.querySelectorAll("#from option");
const to = document.querySelectorAll("#to option");
const price = document.querySelector("#cena");
const costtime= document.querySelector("#czas");

let i = 0;
let i2 = 0;
map.forEach((m) => {
  m.addEventListener("click", () => {
    const vowels = "aeiouy";
    const lastLetter = m.title[m.title.length - 1];

    mapinfo[i2].classList.remove("whiteborder");
    towndesc[i2].classList.remove("hidden");
    time[i2].classList.remove("hidden");

    towndesc[i2].innerHTML = i2 === 0 ?
      `Godziny funkcjonowania placówki w mieście nadawczym: <span class='maptitle'>${m.title}</span>` :
      `Godziny funkcjonowania placówki w mieście odbiorczym: <span class='maptitle'>${m.title}</span>`;

    if (vowels.includes(lastLetter)) {
      time[i2].innerHTML = "<span class='header'>Od 8:00 - 18:00</span>";
    } else if (m.title == "Koszalin") {
      time[i2].innerHTML = "<span class='header'>Od 10:00 - 17:00</span>";
    } else if (m.title == "Radom") {
      time[i2].innerHTML = "<span class='header'>Od 5:00 - 17:00</span>";
    } else if (m.title == "Wrocław") {
      time[i2].innerHTML = "<span class='header'>Od 12:00 - 22:00</span>";
    } else if (m.title == "Szczecin") {
      time[i2].innerHTML = "<span class='header'>Czynny 24h</span>";
    } else {
      time[i2].innerHTML = "<span class='header'>Od 6:00 - 16:00</span>";
    }

    i2 = i2 === 0 ? 1 : 0;

    city[i].value = m.title;
    i = i === 0 ? 1 : 0;

    const isSameCity = city[0].value == city[1].value;
    city[1].setCustomValidity(isSameCity ? "Nie możesz wybrac dwóch tych samych miast" : "");
    updateOutput();
  });
});

reset.addEventListener("click", () => {
  i = 0;
  mapinfo.forEach((info) => info.classList.add("whiteborder"));
  towndesc.forEach((desc) => desc.classList.add("hidden"));
  time.forEach((t) => t.classList.add("hidden"));
  price.innerHTML="";
  costtime.innerHTML="";

});

//selects foreaches
from.forEach((f)=>{
  f.addEventListener("click",()=>{
    const vowels = "aeiouy";
    const lastLetter = f.value[f.value.length - 1];

    mapinfo[i2].classList.remove("whiteborder");
    towndesc[i2].classList.remove("hidden");
    time[i2].classList.remove("hidden");

    towndesc[i2].innerHTML = i2 === 1 ?
      `Godziny funkcjonowania placówki w mieście nadawczym: <span class='maptitle'>${f.value}</span>` :
      `Godziny funkcjonowania placówki w mieście odbiorczym: <span class='maptitle'>${f.value}</span>`;

    if (vowels.includes(lastLetter)) {
      time[i2].innerHTML = "<span class='header'>Od 8:00 - 18:00</span>";
    } else if (f.value == "Koszalin") {
      time[i2].innerHTML = "<span class='header'>Od 10:00 - 17:00</span>";
    } else if (f.value == "Radom") {
      time[i2].innerHTML = "<span class='header'>Od 5:00 - 17:00</span>";
    } else if (f.value == "Wrocław") {
      time[i2].innerHTML = "<span class='header'>Od 12:00 - 22:00</span>";
    } else if (f.value == "Szczecin") {
      time[i2].innerHTML = "<span class='header'>Czynny 24h</span>";
    } else {
      time[i2].innerHTML = "<span class='header'>Od 6:00 - 16:00</span>";
    }

    i2 = i2 === 0 ? 1 : 0;

    city[i].value = f.value;
    i = i === 0 ? 1 : 0;

    const isSameCity = city[0].value == city[1].value;
    city[1].setCustomValidity(isSameCity ? "Nie możesz wybrac dwóch tych samych miast" : "");
    updateOutput();
  })
})

to.forEach((t)=>{
  t.addEventListener("click",()=>{
    const vowels = "aeiouy";
    const lastLetter = t.value[t.value.length - 1];

    mapinfo[i2].classList.remove("whiteborder");
    towndesc[i2].classList.remove("hidden");
    time[i2].classList.remove("hidden");

    towndesc[i2].innerHTML = i2 === 1 ?
      `Godziny funkcjonowania placówki w mieście nadawczym: <span class='maptitle'>${t.value}</span>` :
      `Godziny funkcjonowania placówki w mieście odbiorczym: <span class='maptitle'>${t.value}</span>`;

    if (vowels.includes(lastLetter)) {
      time[i2].innerHTML = "<span class='header'>Od 8:00 - 18:00</span>";
    } else if (t.value == "Koszalin") {
      time[i2].innerHTML = "<span class='header'>Od 10:00 - 17:00</span>";
    } else if (t.value == "Radom") {
      time[i2].innerHTML = "<span class='header'>Od 5:00 - 17:00</span>";
    } else if (t.value == "Wrocław") {
      time[i2].innerHTML = "<span class='header'>Od 12:00 - 22:00</span>";
    } else if (t.value == "Szczecin") {
      time[i2].innerHTML = "<span class='header'>Czynny 24h</span>";
    } else {
      time[i2].innerHTML = "<span class='header'>Od 6:00 - 16:00</span>";
    }

    i2 = i2 === 0 ? 1 : 0;

    city[i].value = t.value;
    i = i === 0 ? 1 : 0;

    const isSameCity = city[0].value == city[1].value;
    city[1].setCustomValidity(isSameCity ? "Nie możesz wybrac dwóch tych samych miast" : "");
    updateOutput();
  })
})