jQuery(function($){
    // ---------------- JS Generic Loadmore --------------------- //
	var article_list = $(".article-list.load-more-list");
	var article_list_item = article_list.find('.article-item');
	var article_per_page = article_list.attr('data-per-page');
	var article_load_more_button = $(".article-list.load-more-list + .row .load-more-button.button");

    article_list_item.css('display', 'none');
	article_list_item.slice(0, article_per_page).show();
	if($(".article-list.load-more-list .article-item:hidden").length <= 0){
		article_load_more_button.css('display', 'none');
	}

	article_load_more_button.on('click', function (e) {
		e.preventDefault();
		var article_hidden_items = $(".article-list.load-more-list .article-item:hidden");
		
		article_hidden_items.slice(0, article_per_page).slideDown();
		if (article_hidden_items.length <= article_per_page) {
			$(this).attr('display', 'none');
		}
		if($(".article-list.load-more-list .article-item:hidden").length <= 0){
			article_load_more_button.css('display', 'none');
		}
		$('body,html').animate({
			scrollTop: $(this).offset().top
		}, 1500);
	});

	var list = $(".hic-item-list.load-more-list");
	var list_item = list.find('.hic-item');
	var per_page = list.attr('data-per-page');
	var load_more_button = $(".hic-item-list.load-more-list + .row .load-more-button.button");

    list_item.css('display', 'none');
	list_item.slice(0, per_page).show();

	if($(".hic-item-list.load-more-list .hic-item:hidden").length <= 0){
		load_more_button.css('display', 'none');
	}

	load_more_button.on('click', function (e) {
		e.preventDefault();
		var hidden_items = $(".hic-item-list.load-more-list .hic-item:hidden");
		
		hidden_items.slice(0, per_page).slideDown();
		if (hidden_items.length <= per_page) {
			$(this).attr('display', 'none');
		}
		if($(".hic-item-list.load-more-list .hic-item:hidden").length <= 0){
			load_more_button.css('display', 'none');
		}
		$('body,html').animate({
			scrollTop: $(this).offset().top
		}, 1500);
	});
});