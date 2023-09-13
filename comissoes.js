	

	function calcular(){


	var porce;
	var novo;
	var result
	var bonus = 500;
	
		porce = prompt("Quanto você vendeu?: ");
		if (porce<1000){
			// alert("Você recebe 20%: " + (porce/100)*20+' R$');
			result = document.getElementById('resultado');
			result.innerHTML = "Você recebe 20%: " + (porce/100)*20+' R$';

					}
		if (porce>=1000 && porce<1500){
			// alert("Voce recebe 25%: " + (porce/100)*25+' R$');
			result = document.getElementById('resultado');
			result.innerHTML = "Voce recebe 25%: " + (porce/100)*25+' R$';
			
		}
		if (porce>=1500 && porce<4000){
			// alert("Voce recebe 36%: " + (porce/100)*36+' R$');
			result = document.getElementById('resultado');
			result.innerHTML = "Voce recebe 36%: " + (porce/100)*36+' R$';
			
		}
			if (porce>=4000 && porce<10000){
			// alert("Voce recebe 42%: " + (porce/100)*42+' R$');
			result = document.getElementById('resultado');
			result.innerHTML = "Voce recebe 42%: " + (porce/100)*42+' R$';
			
		}
		if (porce>=10000){
			novo = (porce/100)*42;
			// alert("Você recebe 42% mais um bonus de 500: " + (novo + bonus)+' R$');
			result = document.getElementById('resultado');
			result.innerHTML = "Você recebe 42% mais um bonus de 500: " + (novo + bonus)+' R$';

		}

	}

	function limpar(){
		window.location.reload(true);
	}