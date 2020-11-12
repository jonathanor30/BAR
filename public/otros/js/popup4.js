var opp = document.getElementById('opp'),
	ovlg = document.getElementById('ovlg'),
	popp = document.getElementById('popp'),
	clair = document.getElementById('clair');

 	oppp.addEventListener('click', function(){
	ovlg.classList.add('active');
	popp.classList.add('active');
});

 	clair.addEventListener('click', function(e){
	e.preventDefault();
	ovlg.classList.remove('active');
	popp.classList.remove('active');
});
