function loadIndexContent() {
    $.ajax({
        type: "post",
		url: "scripts/News.php",
        dataType: "json",
        data: {
        },
        success: function(data) {
               $.each(data, function(index, object) {
					if(object['content'] != 'null'){
						$(object['type']).text(object['content']);
					}
					if(objet['path' != 'null'){
						$(object['type']).css('background-image', 'url(' + object['path'] + ')');
					}
             });    
        },
		error: function(){
			alert('error!');
		}
    });
};
});