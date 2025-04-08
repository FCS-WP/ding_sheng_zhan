<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/
 */

function farmart_meta_box_scripts( $hook ) {
	if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
		wp_enqueue_script( 'farmart-meta-boxes', get_template_directory_uri() . "/js/backend/meta-boxes.js", array( 'jquery' ), '20181210', true );
	}
}

add_action( 'admin_enqueue_scripts', 'farmart_meta_box_scripts' );

/**
 * Registering meta boxes
 *
 * Using Meta Box plugin: http://www.deluxeblogtips.com/meta-box/
 *
 * @see http://www.deluxeblogtips.com/meta-box/docs/define-meta-boxes
 *
 * @param array $meta_boxes Default meta boxes. By default, there are no meta boxes.
 *
 * @return array All registered meta boxes
 */
function farmart_register_meta_boxes( $meta_boxes ) {

	// Display Settings
	$meta_boxes[] = array(
		'id'       => 'post-layout-settings',
		'title'    => esc_html__( 'Post Layout Settings', 'farmart' ),
		'pages'    => array( 'post' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name'    => esc_html__( 'Layout', 'farmart' ),
				'id'      => 'post_layout_settings',
				'type'    => 'select',
				'std'     => '',
				'options' => array(
					''                => esc_html__( 'Default', 'farmart' ),
					'full-content'    => esc_html__( 'No Sidebar', 'farmart' ),
					'content-sidebar' => esc_html__( 'Right Sidebar', 'farmart' ),
					'sidebar-content' => esc_html__( 'Left Sidebar', 'farmart' ),
				),
				'class'   => 'post-layout',
			),
		),
	);

	// Post format's meta box
	$meta_boxes[] = array(
		'id'       => 'post-format-settings',
		'title'    => esc_html__( 'Format Details', 'farmart' ),
		'pages'    => array( 'post' ),
		'context'  => 'normal',
		'priority' => 'high',
		'autosave' => true,
		'fields'   => array(
			array(
				'name'  => esc_html__( 'Gallery', 'farmart' ),
				'id'    => 'images',
				'type'  => 'image_advanced',
				'class' => 'gallery',
			),
			array(
				'name'  => esc_html__( 'Audio', 'farmart' ),
				'id'    => 'audio',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 2,
				'class' => 'audio',
			),
			array(
				'name'  => esc_html__( 'Video', 'farmart' ),
				'id'    => 'video',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 2,
				'class' => 'video',
			),

			array(
				'name'  => esc_html__( 'Title', 'farmart' ),
				'id'    => 'title',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 1,
				'class' => 'link',
			),

			array(
				'name'  => esc_html__( 'Link', 'farmart' ),
				'id'    => 'url',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 1,
				'class' => 'link',
			),
			array(
				'name'  => esc_html__( 'Text', 'farmart' ),
				'id'    => 'url_text',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 1,
				'class' => 'link',
			),
			array(
				'name'  => esc_html__( 'Description', 'farmart' ),
				'id'    => 'desc',
				'type'  => 'textarea',
				'cols'  => 40,
				'rows'  => 2,
				'class' => 'link',
			),
			array(
				'name'  => esc_html__( 'Quote', 'farmart' ),
				'id'    => 'quote',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 2,
				'class' => 'quote',
			),
			array(
				'name'  => esc_html__( 'Author', 'farmart' ),
				'id'    => 'quote_author',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 1,
				'class' => 'quote',
			),
			array(
				'name'  => esc_html__( 'Author URL', 'farmart' ),
				'id'    => 'author_url',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 1,
				'class' => 'quote',
			),
		),
	);

	// Related Post
	$meta_boxes[] = array(
		'id'       => 'related-posts-settings',
		'title'    => esc_html__( 'Related Posts Setting', 'farmart' ),
		'pages'    => array( 'post' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name' => esc_html__( 'Hide Related Posts', 'farmart' ),
				'id'   => 'hide_related_posts',
				'type' => 'checkbox',
				'std'  => false,
			),
			array(
				'name'  => esc_html__( 'Related Posts Title', 'farmart' ),
				'id'    => 'related_posts_title',
				'type'  => 'text',
				'class' => 'title',
			),
			array(
				'name' => esc_html__( 'Numbers of Related Posts', 'farmart' ),
				'id'   => 'related_posts_numbers',
				'type' => 'number',
				'min'  => 0,
			),
			array(
				'name' => esc_html__( 'Columns of Related Posts', 'farmart' ),
				'id'   => 'related_posts_columns',
				'type' => 'number',
				'min'  => 0,
			),
		),
	);

	// Product Video
	$meta_boxes[] = array(
		'id'       => 'product-videos',
		'title'    => esc_html__( 'Product Video', 'farmart' ),
		'pages'    => array( 'product' ),
		'context'  => 'side',
		'priority' => 'low',
		'fields'   => array(
			array(
				'name' => esc_html__( 'Video URL', 'farmart' ),
				'id'   => 'video_url',
				'type' => 'oembed',
				'std'  => false,
				'desc' => esc_html__( 'Enter URL of Youtube or Vimeo or specific filetypes such as mp4, webm, ogv.', 'farmart' ),
			),
			array(
				'name'             => esc_html__( 'Video Thumbnail', 'farmart' ),
				'id'               => 'video_thumbnail',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'std'              => false,
				'desc'             => esc_html__( 'Add video thumbnail', 'farmart' ),
			),
			array(
				'name'    => esc_html__( 'Video Position', 'farmart' ),
				'id'      => 'video_position',
				'type'    => 'select',
				'options' => array(
					'1' => esc_html__( 'The last product gallery', 'farmart' ),
					'2' => esc_html__( 'The first product gallery', 'farmart' ),
				),
			),
		),
	);

	// Header Content
	$meta_boxes[] = array(
		'id'       => 'header-settings',
		'title'    => esc_html__( 'Header Settings', 'farmart' ),
		'pages'    => array( 'page' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name'    => esc_html__( 'Header Background', 'farmart' ),
				'id'      => 'farmart_header_background',
				'type'    => 'select',
				'options' => array(
					'default'     => esc_html__( 'Default', 'farmart' ),
					'transparent' => esc_html__( 'Transparent', 'farmart' ),
				),
			),
		)
	);

	// Page Header
	$meta_boxes[] = array(
		'id'       => 'page-header-settings',
		'title'    => esc_html__( 'Page Header Settings', 'farmart' ),
		'pages'    => array( 'page' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name'             => esc_html__( 'Hide Page Header', 'farmart' ),
				'id'               => 'hide_page_header',
				'type'             => 'checkbox',
				'std'              => false,
			),
			array(
				'name'    => esc_html__( 'Layout', 'farmart' ),
				'id'      => 'page_header_layout',
				'type'    => 'select',
				'std'     => '',
				'options' => array(
					'' => esc_html__( 'Select Layout', 'farmart' ),
					'1' => esc_html__( 'Layout 1', 'farmart' ),
					'2' => esc_html__( 'Layout 2', 'farmart' ),
				),
				'class'   => 'page-header-layout',
			),
			array(
				'name' => esc_html__( 'Hide Title', 'farmart' ),
				'id'   => 'hide_title',
				'type' => 'checkbox',
				'std'  => false,
				'class'   => 'page-header-hide-title',
			),
			array(
				'name' => esc_html__( 'Hide Breadcrumb', 'farmart' ),
				'id'   => 'hide_breadcrumb',
				'type' => 'checkbox',
				'std'  => false,
				'class'   => 'page-header-hide-breadcrumb',
			),
		)
	);

	// Content Setting
	$meta_boxes[] = array(
		'id'       => 'content-settings',
		'title'    => esc_html__( 'Content Settings', 'farmart' ),
		'pages'    => array( 'page' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name'    => esc_html__( 'Content Width', 'farmart' ),
				'id'      => 'farmart_content_width',
				'type'    => 'select',
				'options' => array(
					''      => esc_html__( 'Normal', 'farmart' ),
					'large' => esc_html__( 'Large', 'farmart' ),
					'full-width' => esc_html__( 'Full Width', 'farmart' ),
				),
			),
			array(
				'name'    => esc_html__( 'Content Top Spacing', 'farmart' ),
				'id'      => 'farmart_content_top_spacing',
				'type'    => 'select',
				'options' => array(
					'default' => esc_html__( 'Default', 'farmart' ),
					'no'      => esc_html__( 'No spacing', 'farmart' ),
					'custom'  => esc_html__( 'Custom', 'farmart' ),
				),
			),
			array(
				'name'       => '&nbsp;',
				'id'         => 'farmart_content_top_padding',
				'class'      => 'custom-spacing hidden',
				'type'       => 'slider',
				'suffix'     => esc_html__( ' px', 'farmart' ),
				'js_options' => array(
					'min' => 0,
					'max' => 300,
				),
				'std'        => '80',
			),
			array(
				'name'    => esc_html__( 'Content Bottom Spacing', 'farmart' ),
				'id'      => 'farmart_content_bottom_spacing',
				'type'    => 'select',
				'options' => array(
					'default' => esc_html__( 'Default', 'farmart' ),
					'no'      => esc_html__( 'No spacing', 'farmart' ),
					'custom'  => esc_html__( 'Custom', 'farmart' ),
				),
			),
			array(
				'name'       => '&nbsp;',
				'id'         => 'farmart_content_bottom_padding',
				'class'      => 'custom-spacing hidden',
				'type'       => 'slider',
				'suffix'     => esc_html__( ' px', 'farmart' ),
				'js_options' => array(
					'min' => 0,
					'max' => 300,
				),
				'std'        => '80',
			),
		)
	);

	return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'farmart_register_meta_boxes' );
