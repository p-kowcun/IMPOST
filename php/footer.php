<footer>
        <img src="../img/logo_dark.png" alt="logo" class="logo">

        <div class="kontakt">
            <a href="tel:112">+48 5U5 8U5 0W0</a>
            <a href="mailto:kontakt@impost.pl">kontakt@impost.pl</a>
            <a href="opinions.php">Wystaw opinie</a>
        </div>
		
		<p class="copyright">Copyright &copy; ImPost&trade; sp. z.o.o. Wszelkie prawa zastrzeżone.</p>

    </footer>
<div class="impostor"><img src="../img/impost.png" alt="Scroll up"></div>

<div id="cookie-message">
  Nasza strona używa "cookies". Używając jej zezwalasz na to. Możesz kliknąć przycisk "Super!", ale i tak zezwalasz nawet jak nie klikniesz.
  <button id="accept-cookies">Super!</button>
</div>

<script>

// Get the cookie message element
var cookieMessage = document.getElementById("cookie-message");

// Check if the user has already accepted cookies
if (localStorage.getItem("accepted-cookies") === "true") {
  // Hide the cookie message
  cookieMessage.style.display = "none";
} else {
  // Show the cookie message
  cookieMessage.style.display = "flex";
}

// Add an event listener to the accept cookies button
document.getElementById("accept-cookies").addEventListener("click", function() {
  // Set a local storage item to remember that the user accepted cookies
  localStorage.setItem("accepted-cookies", "true");
  // Hide the cookie message
  cookieMessage.style.display = "none";
});
</script>
