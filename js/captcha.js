let a= Math.ceil(Math.random()*10);
	let b= Math.ceil(Math.random()*10);
	
	document.getElementById('wysw').innerHTML="<b>"+a+"+"+b+"</b>";

function check_captcha(){

	
	
	let input=document.getElementById('num');
	if(a+b==document.getElementById('num').value)
		input.setCustomValidity("");
	else
	input.setCustomValidity("Wynik jest niepoprawny");
	}
	check_captcha();