<?php

/**
 * @file
 * Default theme implementation for displaying search results.
 *
 * This template collects each invocation of theme_search_result(). This and
 * the child template are dependent to one another sharing the markup for
 * definition lists.
 *
 * Note that modules may implement their own search type and theme function
 * completely bypassing this template.
 *
 * Available variables:
 * - $search_results: All results as it is rendered through
 *   search-result.tpl.php
 * - $module: The machine-readable name of the module (tab) being searched, such
 *   as "node" or "user".
 *
 *
 * @see template_preprocess_search_results()
 *
 * @ingroup themeable
 */
?>
<?php
  $theme_path = drupal_get_path('theme', 'nhachayhomnay');
?>

<div id="item-wrap" class="wrapper-search">
  <?php if ($search_results): ?>
    <div class="title-bar">
      <h3><?php print t('Kết quả tìm kiếm:');?> <strong><?php print variable_get('key_word_search'); ?></strong></h3>
    </div>
    <div class="search-results <?php print $module; ?>-results">
      <?php print $search_results; ?>
    </div>
    <?php print $pager; ?>
  <?php else : ?>
    <div class="title-bar">
      <h3><?php print t('Kết quả tìm kiếm:');?> <strong><?php print variable_get('key_word_search'); ?></strong></h3>
    </div>
    <div class="not-found">
      Không tìm thấy kết quả phù hợp. Bạn hãy thử lại với từ khóa chính xác hơn.
    </div>
  <?php endif; ?>
</div>

