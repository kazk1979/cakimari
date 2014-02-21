/*スタイルシートの切り替え*/
$(function(){
$("#jstyle").attr({href:$.cookie('style')});
});
function jstyle(cssurl){
$('#jstyle').attr({href:cssurl});
$.cookie('style',cssurl,{expires:30,path:'/'});
}

/*入力欄のチップス*/
$(document).ready(function() {
	$('form input.Text, form textarea.Text').formtips({
		tippedClass: 'tipped'
	});
});