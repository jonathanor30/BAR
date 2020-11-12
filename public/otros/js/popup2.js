var abrir = document.getElementById('abrir'),
	over = document.getElementById('over'),
	pop = document.getElementById('pop'),
	cerrar = document.getElementById('cerrar');

abrir.addEventListener('click', function(){
	over.classList.add('active');
	pop.classList.add('active');
});

cerrar.addEventListener('click', function(e){
	e.preventDefault();
	over.classList.remove('active');
	pop.classList.remove('active');
});
