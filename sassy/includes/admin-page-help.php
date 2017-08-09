<?php

/**
 * Sassy help screen functions
 */


/**
 * Condition helps
 */
function sassy_help_conditions() {

$help_html = __("
Format: <condition>[=<arg>] ... <condition>[=<arg>]

All conditions have AND logic, which means
``cond1 cond2 cond3`` will be evaluted as
(bool)cond1 AND (bool)cond2 AND (bool)cond3

Supporting OR logics per global scope in example
``cond1 cond2 cond3 OR condA condB condC``
which will be evaluted as:
(
  (bool)cond1 AND (bool)cond2 AND (bool)cond2)
   OR
  (bool)condA AND (bool)condB AND (bool)condC)
)

Supported condition tags:

post_type=<post_type[,post_type...]>
  validate if current request is from post or archive from given post type

post_format=<post_format[,post_format..]>
  validate if current post is in post format, if not the whole rule return false.

taxonomy:<taxonomy_name>[=<term[,<term2>]>]
  validate if current request is from post or archive in given taxonomy and if given then term

get:<GET param name>[=<value>]
  check if there is GET parameter

url=news*
  check if current URL matches news* pattern

Other supported condition tags:
  comments_open, pings_open, is_home, is_front_page, is_singular, is_archive, is_search, is_paged, is_date, is_year, is_month, is_day, is_404, is_attachment, is_user_logged_in, is_rtl, in_the_loop, is_main_query, has_excerpt, has_post_thumbnail, is_sticky, is_odd, is_even

Also inverting is supported with ! prefix:
  Example: !is_404

Example for rule that handle if current request is singular post view and it has post thumbnail: is_singular has_post_thumbnail
", 'sassy');

echo wpautop(wptexturize(htmlspecialchars($help_html)));

}