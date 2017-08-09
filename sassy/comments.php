<?php

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */

if (!is_singular() || post_password_required()) {
  return;
}

global $sassy_hide_comments_title;

/**
 * Main comments
 */
if (comments_open() || have_comments()):?>
  <div class="entry-comments-wrapper">

    <?php if (empty($sassy_hide_comments_title)):?>
    <div class="entry-comments-title">
      <?php echo get_comments_number_text()?>
    </div>
    <?php endif?>

    <div class="entry-comments" itemprop="UserComments">

      <?php if (have_comments()):?>
        <ol class="commentlist">
          <?php wp_list_comments('avatar_size=' . SassySettings::get('components_comment_avatar_size') . '&echo=1&short_ping=1')?>
        </ol>
        <?php sassy_pagination('comments') ?>
      <?php endif?>

      <?php if (comments_open()):?>
        <?php comment_form()?>
      <?php endif?>

    </div>

  </div>
<?php endif?>
