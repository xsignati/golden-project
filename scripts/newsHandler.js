$(function() {
   loadResults(0);
    $('#text-wrap').scroll(function() {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
           var rowStart = $(".date").length;
           loadResults(rowStart); 
        }
	}); 
 
function loadResults(rowStart) {
    $.ajax({
        type: "post",
		url: "scripts/News.php",
        dataType: "json",
        data: {
            rowStart: rowStart
        },
        success: function(data) {
               $.each(data, function(index, object) {
				   //alert(object['content']);
					//if(key == "content"){}
					//$("#text").append("<p class='"+key+"'>"+value+"</p>");
					//text div
					var textDiv = document.createElement("div");
					$(textDiv).attr("id", object['type']);
					$(textDiv).addClass("text");
					$('#text-wrap').append(textDiv);
						//date paragraph
						var dateP = document.createElement("p");
						$(dateP).addClass("date");
						$(dateP).text(object['date']);
						$(textDiv).append(dateP);
						//news-image-div
						var newsWrap = document.createElement("div");
						$(newsWrap).addClass("news-wrap");
						$(textDiv).append(newsWrap);
							//title paragraph
							var titleP = document.createElement("p");
							$(titleP).addClass("title");
							$(titleP).text(object['title']);
							$(newsWrap).append(titleP);	
							//news image wrap
							var newsImageWrap = document.createElement("div");
							$(newsImageWrap).addClass("news-image-wrap");
							$(newsWrap).append(newsImageWrap);
								//news image
								var newsImage = document.createElement("div");
								$(newsImage).addClass("news-image");
								if(object['path'] != null){
									$(newsImage).css('background-image', 'url(' + object['path'] + ')');
									$(newsImageWrap).append(newsImage);
								}
							//news content	
							var contentP = document.createElement("p");
							$(contentP).addClass("content");
							$(contentP).text(object['content']);
							$(newsWrap).append(contentP);							
					
					//$("#text-wrap").append("<div class='text'>"+key+"'>"+value+"</p> </div>");
             });
             //$("#loading").hide();     
        },
		error: function(){
			alert('error!');
		}
    });
};
});