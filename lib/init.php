<?php

// Basic setup: language, menus, post types
// -----------------------------------------------------------------------------

function s2_setup() {
  // Make theme available for translation
  load_theme_textdomain('square-two', get_template_directory() . '/lang');

  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus(array(
    'primary_navigation' => __('Primary Navigation', 'square-two')
  ));

  // Add post thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
  // http://codex.wordpress.org/Function_Reference/add_image_size
  add_theme_support('post-thumbnails');

  // Add post formats
  // http://codex.wordpress.org/Post_Formats
  add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

  // Add HTML5 markup for captions
  // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

  // Use main stylesheet for visual editor -- uncomment to turn on
  // https://codex.wordpress.org/Function_Reference/add_editor_style
  // add_editor_style('path/to/css');
}
add_action('after_setup_theme', 's2_setup');

// Add sidebars
// -----------------------------------------------------------------------------

function s2_widgets_init() {
  register_sidebar(array(
    'name'          => __('Primary', 'square-two'),
    'id'            => 'sidebar-primary',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>',
  ));

  register_sidebar(array(
    'name'          => __('Footer', 'square-two'),
    'id'            => 'sidebar-footer',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>',
  ));
}
add_action('widgets_init', 's2_widgets_init');

// Determine which pages will NOT display the sidebar
function s2_display_sidebar() {
  static $display;
  isset($display) || $display = !in_array(true, [
    // The sidebar will NOT be displayed if ANY of the following return true.
    // @link https://codex.wordpress.org/Conditional_Tags
    is_404(),
    is_front_page(),
    is_page_template('template-custom.php'),
  ]);
  return apply_filters('s2_display_sidebar', $display);
}

// Initialize other options
// -----------------------------------------------------------------------------

require_once('scripts.php');
require_once('nav.php');
require_once('cleanup.php');

