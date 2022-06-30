<?php 
//creating custom blocks
add_action('acf/init', 'aipm_acf_init');

function aipm_acf_init() {
	// check function exists
	if( function_exists('acf_register_block') ) {

		acf_register_block(array(
			'name'				=> 'header-banner',
			'title'				=> __('Header Banner'),
			'description'		=> __('Header Banner'),
			'render_callback'	=> 'aipm_acf_module_template_block_render_callback',
			'icon'              => 'superhero',
			'keywords'          => array( 'hero image', 'header', 'banner' ),
			'mode'				=> 'edit',
			'category'			=> 'custom_modules',
			
		));
		acf_register_block(array(
			'name'				=> 'contact-form',
			'title'				=> __('Contact Form'),
			'description'		=> __('Contact form'),
			'render_callback'	=> 'aipm_acf_module_template_block_render_callback',
			'icon'              => 'superhero',
			'keywords'          => array( 'hero image', 'header', 'banner' ),
			'mode'				=> 'edit',
			'category'			=> 'custom_modules',
			
		));
		
		acf_register_block(array(
			'name'				=> 'left-or-right-text-image',
			'title'				=> __('Left or right text image'),
			'description'		=> __('Left or right text image'),
			'render_callback'	=> 'aipm_acf_module_template_block_render_callback',
			'icon'              => 'superhero',
			'keywords'          => array( 'hero image', 'header', 'banner' ),
			'mode'				=> 'edit',
			'category'			=> 'custom_modules',
			
		));
		acf_register_block(array(
			'name'				=> 'list',
			'title'				=> __('
			'),
			'description'		=> __('List'),
			'render_callback'	=> 'aipm_acf_module_template_block_render_callback',
			'icon'              => 'superhero',
			'keywords'          => array( 'hero image', 'header', 'banner' ),
			'mode'				=> 'edit',
			'category'			=> 'custom_modules',
			
		));
		acf_register_block(array(
			'name'				=> 'text-and-image',
			'title'				=> __('Text and image'),
			'description'		=> __('Text and image'),
			'render_callback'	=> 'aipm_acf_module_template_block_render_callback',
			'icon'              => 'superhero',
			'keywords'          => array( 'hero image', 'header', 'banner' ),
			'mode'				=> 'edit',
			'category'			=> 'custom_modules',
			
		));

	}
}

function aipm_acf_module_template_block_render_callback($block, $content = '', $is_preview = false) {
	$slug = str_replace('acf/', '', $block['name']);
	if( file_exists( get_theme_file_path("/template-parts/block/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/template-parts/block/content-{$slug}.php") );
	}

	if ( $is_preview && ! empty( $block['data'] ) ) {
		echo $block['data']['image'];
		return;
   } else {
		if ( $block ) :
			 $template = $block['render_template'];
			 $template = str_replace( '.php', '', $template );
			 get_template_part( '/' . $template );
		endif;
   }
}