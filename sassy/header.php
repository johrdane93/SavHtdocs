<?php

if (defined('DOING_AJAX')) {
  return;
}

/**
 * Because need to ensure that Layout related stylesheets
 * are placed on header.
 *
 * TODO need to found better way
 */
ob_start();

?><!DOCTYPE html>
<html <?php language_attributes(); sassy_html_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset')?>" />
  <meta name="viewport" content="width=device-width, user-scalable=no" />
  <meta name="MobileOptimized" content="height" />
  <meta name="HandheldFriendly" content="true" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <link rel="profile" href="http://gmpg.org/xfn/11" />
  <link rel="pingback" href="<?php bloginfo('pingback_url')?>" />
  <?php wp_head()?>
  <!--[if lte IE 8]>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js"></script>
  <![endif]-->
</head>
<body <?php body_class()?>>

<?php do_action('sassy_before_layout'); ?>

<?php
ob_start();