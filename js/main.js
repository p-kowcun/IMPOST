const slider=document.querySelector(".sliderange");
const boxborder=document.querySelector(".boxborder");
const boxspace=document.querySelector(".boxspace");
const header=document.querySelector(".slider .header");
const boxpercentage=document.querySelector(".boxpercentage");

boxborder.style.width=slider.value+"px";
boxborder.style.height=slider.value+"px";
slider.oninput=function(){
    boxborder.style.width=this.value+"px";
    boxborder.style.height=this.value+"px";
    console.log(this.value)
    if(this.value==140)
    {
        boxspace.innerHTML="";
        boxpercentage.innerHTML="";
        header.innerHTML="Przesuń suwak i zobacz, jakie znaczenie ma to, jak pakujesz!";
    }
    else if(this.value>143&&this.value<170)
    {
        boxspace.innerHTML="Pusta przestrzeń paczki";
        boxpercentage.innerHTML=parseInt(((this.value)-142))+"%";
        header.innerHTML="Idealne dopasowanie! Oszczędzasz miejsce i środowisko!";
    }
    else if(this.value>171&&this.value<190)
    {
        boxspace.innerHTML="Pusta przestrzeń paczki";
        boxpercentage.innerHTML=parseInt(((this.value)-142))+"%";
        header.innerHTML="Pomyśl nad mniejszym kartonem ilość wytwarzanych spalin rośnie!";
    }
    else if(this.value>191&&this.value<226)
    {
        boxspace.innerHTML="Pusta przestrzeń paczki";
        boxpercentage.innerHTML=parseInt(((this.value)-142))+"%";
        header.innerHTML="To już przestaje być EKO…";
    }
    else if(this.value>227)
    {
        boxspace.innerHTML="Pusta przestrzeń paczki";
        boxpercentage.innerHTML=parseInt(((this.value)-142))+"%";
        header.innerHTML="Generujesz niepotrzebny CO2, zmień karton!";
    }
}