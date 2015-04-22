// JavaScript Document
$(document).ready(function () {
	$("#search").keypress(function (event) {
		if (event.keyCode == 13) {//按下enter按鍵後
		  $("#search_btn").trigger("click");
		}
	});
});


function search(){
   var keywordvalue = document.getElementById('search').value;
   location.href="index.php?keyword="+keywordvalue;
}