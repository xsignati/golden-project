var prefix = "../";
var emOffset = 16;
$(function() {
   loadNews(0);
    $('#text-wrap').scroll(function() {
        if($(this).scrollTop() + $(this).innerHeight() >= ($(this)[0].scrollHeight) - emOffset) {
           var rowStart = $(".date").length;
           loadNews(rowStart);
        }
	}); 
 
	function loadNews(rowStart) {
		$.ajax({
			type: "post",
			url: prefix + "scripts/News.php",
			dataType: "json",
			data: {
				rowStart: rowStart
			},
			success: function(data) {
				   $.each(data, function(index, object) {
						var textDiv = document.createElement("div");
						$(textDiv).attr("id", object['tag']);
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
									if(object['imageLink'] != null){
										$(newsImage).css('background-image', 'url(' + object['imageLink'] + ')');
										$(newsImageWrap).append(newsImage);
									}
								//news content	
								var contentP = document.createElement("p");
								$(contentP).addClass("image-text");
								$(contentP).text(object['text']);
								$(newsWrap).append(contentP);							
				 });   
			},
			error: function(){
				alert('error getting News data!');
			}
		});
	};

});

