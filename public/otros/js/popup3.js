var open = document.getElementById('open'),
	overl = document.getElementById('overl'),
	popu = document.getElementById('popu'),
	close = document.getElementById('close');

 	open.addEventListener('click', function(){
	overl.classList.add('active');
	popu.classList.add('active');
});

 	close.addEventListener('click', function(e){
	e.preventDefault();
	overl.classList.remove('active');
	popu.classList.remove('active');
});
