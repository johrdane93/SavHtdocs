<div class="author-bio">
  <div class="avatar-wrapper">
    <?php echo get_avatar( get_the_author_meta('email'), SassySettings::get('avatar_size') ); ?>
  </div>
  <div class="author-info">
    <h3 class="author-title">
      <?php printf(__('Author: %s'), get_the_author_link()) ?>
    </h3>
    <p class="author-description">
      <?php echo wpautop(get_the_author_meta('description'))?>
    </p>
  </div>
</div>
