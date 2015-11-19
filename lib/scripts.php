<?php

function s2_scripts() {
  // Load Gulp generated main stylesheet
  wp_enqueue_style('s2', get_template_directory_uri() . '/assets/build/css/main.css', false, null);

  // Load critical head js
  wp_enqueue_script('modernizr', get_template_directory_uri() . '/assets/build/js/modernizr-2.7.0.min.js', array(), null, false);
  wp_enqueue_script('picturefill', get_template_directory_uri() . '/assets/build/js/picturefill.min.js', array(), null, false);
  wp_enqueue_script('respond', get_template_directory_uri() . '/assets/build/js/respond.min.js', array(), null, false);

  // Load vendor and custom js
  wp_enqueue_script('s2_vendor_js', get_template_directory_uri() . '/assets/build/js/vendor.js', array('jquery'), null, true);
  wp_enqueue_script('s2_custom_js', get_template_directory_uri() . '/assets/build/js/custom.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 's2_scripts', 100);
