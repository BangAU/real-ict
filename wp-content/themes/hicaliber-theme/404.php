<?php
/**
 * The template for displaying 404 (page not found) pages.
 *
 * For more info: https://codex.wordpress.org/Creating_an_Error_404_Page
 */

get_header(); ?>

<?php 

    $page_options = get_field('opt_404_page', 'options'); 

    $error_content = $page_options['description'];
    $error_title = $page_options['page_title']; 
    $img = $page_options['banner_image'];
    if(!$img) $img = get_field('subpage_hero_img', 'options');
?>

    <section class="hero page-banner full-screen-banner text-center">
			
	   <div class="hero-main">                
                   <div class="bg-image" style="background-image: url(<?php _e($img); ?>)">
                        <div class="hero-bg-overlay" style="background-color:rgba(10,0,0,0.5);"></div>
                    </div>
                    <div class="grid-container">
                        <div class="grid-x grid-padding-x">
                            <div class="cell cell-message">
                              <div class="hero-banner-message">
                                    <h1><?php 
            			                if($error_content) : echo $error_title; 
            			                else : _e( 'Epic 404 - Article Not Found', 'jointswp' );
            			                endif;
            			            ?></h1>
            						<p><?php 
            						    if($error_content) : echo $error_content;
            						    else : ?>The article you were looking for was not found, Go home by clicking <a href="<?php echo home_url(); ?>">here</a>!<?php
            						    endif;
            						?></p>
                                </div>
                            </div>
                        </div>        
                    </div>
                </div>
    </section>
<?php get_footer(); ?>