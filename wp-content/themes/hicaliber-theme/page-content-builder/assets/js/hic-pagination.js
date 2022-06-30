jQuery(document).ready(function($) {
    var HIC_PAGINATION = {
        itemPerPage : 9,
        items : $('.hic-item-list .hic-item, .article-list.paginated .article-item'),
        numberOfItems : 0,
        container : $('.hic-paginate-pagination'),
        hicPagination : $('.hic-pagination-page'),
        pageName : "#page-",
        cssStyle : "light-theme",
        smoothScroll : {
            enable : false,
            scrollTo : '.main-content',
            speed : 500,
            adjustPosition : 80,
            scroll: function () {
                var positionXP = jQuery(this.scrollTo).position().top + jQuery(".off-canvas-wrapper").scrollTop();        
                jQuery("html, body").animate({scrollTop: positionXP - this.adjustPosition},this.speed);
            }
        },
        
        // initialize before creating the page element
        /*
         * How to initialize
         * .init() - will use all the diffault property of this object except changed before calling .create()
         * .init( $('items_selector'), $('container_selector'), $('pagination_selector'), 'pageName', numberOfItemPerPage)
         * .init( 'items_selector', 'container_selector', 'pagination_selector', 'pageName', numberOfItemPerPage)
         * All arguments are optional
         */
        init : function(items, container, pagination, pageName, perPage){
            // Set the jquery object containing all the elements
            if(items) if(items.jquery) this.items = items; // if the item set is already a jquery object
            else if(typeof items == "string") this.items = $(items); // if the items set is a selector
            
            // set the total number of items
            this.numberOfItems = this.items.length;
            
            // Set the jquery container object that holds the pagination
            if(container) if(container.jquery) this.container = container; // if item set is already a jquery object
            else if(typeof container == "string") this.container = $(container); // if the items set is a selector
            
            // Set the jquery object of the pagination
            if(pagination) if(pagination.jquery) this.hicPagination = pagination; // if the item set is already a jquery object
            else if(typeof pagination == "string") this.hicPagination = $(pagination); // if the items set is a selector
            
            if(pageName) this.pageName = pageName;
            
            if(perPage) this.itemPerPage = perPage;
        },
        
        create : function(){
    		if (this.numberOfItems > this.itemPerPage) {
    
    			this.container.css({
    				'visibility': 'visible'
    			});
    
    			// only show the first per_page items initially
    			this.items.slice(this.itemPerPage).hide();
    
                // setup pagination
                this.hicPagination.pagination({
    				items: HIC_PAGINATION.numberOfItems,
    				itemsOnPage: HIC_PAGINATION.itemPerPage,
    				cssStyle: HIC_PAGINATION.cssStyle,
    				hrefTextPrefix: HIC_PAGINATION.pageName,
    				onPageClick: function (pageNumber) { // this is where the magic happens
    				
    				    // if someone click the pagination scroll the page smoothly
    					if(HIC_PAGINATION.smoothScroll.enable) HIC_PAGINATION.smoothScroll.scroll();
    					
    					// someone changed page, hide/show trs appropriately
    					var showFrom = HIC_PAGINATION.itemPerPage * (pageNumber - 1);
    					var showTo = showFrom + HIC_PAGINATION.itemPerPage;
    
    					HIC_PAGINATION.items.hide() // first hide everything, then show for the new page
    						.slice(showFrom, showTo).show();
    				}
    			});
    
    		} else {
    			this.container.css({
    				'visibility': 'hidden'
    			});
    		}
        }
        
    };
    
    //Default Hicaliber Content Pagination
    
    // START CPT Search Filter Element
    // Setup and load the pagination 
    HIC_PAGINATION.init();
    HIC_PAGINATION.itemPerPage = HIC_PAGINATION.container.data('per-page');
    HIC_PAGINATION.smoothScroll.enable = HIC_PAGINATION.container.data('smooth-scroll');
    HIC_PAGINATION.smoothScroll.speed = HIC_PAGINATION.container.data('scroll-speed') * 100;
    HIC_PAGINATION.create();
    // END CTP SFE

});