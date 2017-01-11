$(document).ready(function(){
	var changed = 0;
    $(".button").click(function(){
		if(changed == 0){
			$("#id-father").css("z-index", "1").css("left","4em").css("top","2em");
			$("#id-mother-wrap").css("z-index", "2").css("left","0").css("top","0");
			changed++;
		}
		else{
			$("#id-father").css("z-index", "2").css("z-index", "2").css("left","0").css("top","0");
			$("#id-mother-wrap").css("z-index", "1").css("left","4em").css("top","2em");
			changed--;
		}
    });
});