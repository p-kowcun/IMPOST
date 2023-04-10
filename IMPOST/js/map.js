const map = document.querySelectorAll("#map area");
const mapinfo = document.querySelector(".mapinfo");
const towndesc = document.querySelector(".towndesc");
const time = document.querySelector(".time");

map.forEach((m) => {
    const vowels = "aeiouy";
    const lastLetter = m.title[m.title.length - 1];
    m.addEventListener("click", () => {
        mapinfo.classList.remove("whiteborder");
        towndesc.innerHTML = "Godziny funkcjonowania placówki w mieście: <h3>" + m.title + "</h3>";
        if (vowels.includes(lastLetter)) {
            time.innerHTML = "<h4>Od 8:00 - 18:00</h4>";
        } else if (m.title == "Koszalin") {
            time.innerHTML = "<h4>Od 10:00 - 17:00</h4>";
        } else if (m.title == "Radom") {
            time.innerHTML = "<h4>Od 5:00 - 17:00</h4>";
        } else if (m.title == "Wrocław") {
            time.innerHTML = "<h4>Od 12:00 - 23:00</h4>";
        } else if (m.title == "Szczecin") {
            time.innerHTML = "<h4>Czynny 24h</h4>";
        } else {
            time.innerHTML = "<h4>Od 6:00 - 16:00</h4>";
        }


    })
});
