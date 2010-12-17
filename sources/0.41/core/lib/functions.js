function dateNow() {
	var now = new Date();
	var y = now.getFullYear();
	var m = now.getMonth();
	var d = now.getDate();
	var h = now.getHours();
	var i = now.getMinutes();	
	if(i <= 9){i = '0'+i;}
	if(h <= 9){h = '0'+h;}
	if(d <= 9){d = '0'+d;}
	m = m+1;
	if(m <= 9){m = '0'+m;}
	document.getElementsByName('day')['0'].value = d;
	document.getElementsByName('time')['0'].value = h+":"+i;
	document.getElementsByName('month')['0'].value = m;
	document.getElementsByName('year')['0'].value = y;
}
function openPopup(fichier,nom,width,height) {
	var popup = window.open(unescape(fichier) , nom, "directories=no, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=yes, width="+width+" , height="+height);
	if(popup) {
		popup.focus();
	} else {
		alert('Ouverture de la fenêtre bloquée par un anti-popup!');
	}
	return;
}
function AddText(where, Text) { 
	var obj = document.getElementsByName(where)['0'];
	obj.focus();
	if(document.selection && document.selection.createRange) {  // Internet Explorer
		sel = document.selection.createRange();
		if(sel.parentElement() == obj)  sel.text = Text;
	}
	else if(obj != "undefined") { // Firefox
		var longueur = parseInt(obj.textLength);
		var selStart = obj.selectionStart;
		var selEnd = obj.selectionEnd;
		obj.value = obj.value.substring(0,selStart) + Text + obj.value.substring(selEnd,longueur);
	}
	else obj.value += Text;
	obj.focus();
}
function insimg(where, src) {
	AddText(where, '<img src="'+src+'" alt="" />');
}
function insdoc(where, src, title) {
	AddText(where, '<a href="./?telechargement/'+src+'">'+title+'</a>');
}
