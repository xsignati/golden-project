$(function() {
   loadResults(0);
    $('#text-wrap').scroll(function() {
      //if($("#loading").css('display') == 'none') {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
           var rowStart = $(".date").length;
           loadResults(rowStart); 
        }
      //}
	}); 
 
function loadResults(rowStart) {
	//$("#loading").show();
    $.ajax({
        type: "post",
		url: "scripts/News.php",
        dataType: "json",
        data: {
            rowStart: rowStart
        },
        success: function(data) {
               $.each(data, function(index, object) {
				    $.each(object, function(key, value) {
					$("#text").append("<p class='"+key+"'>"+value+"</p>");
				});
             });
             //$("#loading").hide();     
        },
		error: function(){
			alert('error!');
		}
    });
};
});