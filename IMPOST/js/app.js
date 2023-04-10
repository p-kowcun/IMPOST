window.addEventListener("scroll", () => {
    document.querySelector("nav").classList.toggle("sticky", window.scrollY > 250);
    document.querySelector(".impostor").classList.toggle("active", window.scrollY > window.outerHeight/2);
});
document.querySelector(".impostor").addEventListener("click",()=>{
    window.scrollTo(0,0);
});
