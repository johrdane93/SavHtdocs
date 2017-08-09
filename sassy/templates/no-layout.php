<article<?php sassy_post_attributes(array('class' => 'nolayout'))?>>

  <?php if (has_post_thumbnail()):?>
  <div class="entry-thumbnail-wrapper">
    <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute()?>">
      <?php the_post_thumbnail((is_single() ? 'large' : 'medium'), 'class=thumbnail')?>
    </a>
  </div>
  <?php endif?>

  <div class="entry-elements-wrapper">

    <?php if (!in_array(get_post_format(), array('status', 'link'))):?>
    <header class="entry-header">

      <?php if (is_singular()):?>
        <h1 class="entry-header-title">
          <?php the_title()?>
        </h1>
      <?php else:?>
        <h2 class="entry-header-title">
          <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute()?>">
            <?php the_title()?>
          </a>
        </h2>
      <?php endif?>

      <?php if (get_post_type() != 'page'):?>
        <div class="entry-header-meta">
          <time class="entry-header-meta-time" datetime="<?php the_time('c')?>" pubdate="pubdate">
            <?php the_time(get_option('date_format'))?>
          </time>
          <span class="entry-header-meta-comments">
            <?php comments_number('0', '1', '%')?>
          </span>
          <span class="entry-header-meta-author">
            <?php the_author()?>
          </span>
        </div>
      <?php endif?>

    </header>
    <?php endif?>

    <?php if (!post_password_required() && !is_singular() && get_the_excerpt()):?>
    <div class="entry-summary teaser">
      <?php the_excerpt()?>
    </div>
    <?php endif?>

    <?php if (is_singular()):?>
    <div class="entry-content">
      <?php
        the_content();
        sassy_pagination('singular');
      ?>
    </div>
    <?php endif?>

    <?php if (is_singular() && get_post_type() != 'page'):?>
    <footer class="entry-footer">
      <?php if (sassy_is_categorized_blog() && $categories = get_the_terms(get_the_ID(), 'category')):?>
        <div class="entry-footer-categories fa--folder">
          <?php foreach ($categories as $catterm):?>
            <a rel="nofollow" href="<?php echo get_term_link($catterm)?>" title="<?php echo $catterm->name?>" class="taxonomy-term-<?php echo $catterm->term_id?>">
              <?php echo $catterm->name?>
            </a>
          <?php endforeach?>
        </div>
      <?php endif?>
      <?php if (NULL != ($tags = get_the_tag_list(__('Tags: '), ', '))):?>
        <div class="entry-footer-categories entry-footer-tags fa--tags">
          <?php echo $tags?>
        </div>
      <?php endif?>
      <?php if (NULL != ($post_format = get_post_format())):?>
        <div class="entry-footer-categories entry-footer-post-format post-meta-post-format-<?php echo $post_format?>">
          <?php echo $post_format?>
        </div>
      <?php endif?>
    </footer>
    <?php endif?>

  </div>

</article>

<?php if (is_singular()) comments_template(); ?>
