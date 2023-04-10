const map = document.querySelectorAll("#map area");
const mapinfo = document.querySelectorAll(".mapinfo");
const towndesc = document.querySelectorAll(".towndesc");
const time = document.querySelectorAll(".time");
const city = document.querySelectorAll(".city");
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
});
