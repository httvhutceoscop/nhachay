<?php

/**
 * @file
 * Default theme implementation to display a block.
 *
 * Available variables:
 * - $block->subject: Block title.
 * - $content: Block content.
 * - $block->module: Module that generated the block.
 * - $block->delta: An ID for the block, unique within each module.
 * - $block->region: The block region embedding the current block.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - block: The current template type, i.e., "theming hook".
 *   - block-[module]: The module generating the block. For example, the user
 *     module is responsible for handling the default user navigation block. In
 *     that case the class would be 'block-user'.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Helper variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $block_zebra: Outputs 'odd' and 'even' dependent on each block region.
 * - $zebra: Same output as $block_zebra but independent of any block region.
 * - $block_id: Counter dependent on each block region.
 * - $id: Same output as $block_id but independent of any block region.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 * - $block_html_id: A valid HTML ID and guaranteed unique.
 *
 * @see template_preprocess()
 * @see template_preprocess_block()
 * @see template_process()
 *
 * @ingroup themeable
 */
?>
<?php
$module = drupal_get_path('module','');
$theme = drupal_get_path('theme','nhachayhomnay');
?>
<div id="<?php print $block_html_id; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>


  <div id="footer" class="clearfix">
<!--    <div class="row">-->
<!--      <div class="col-md-12">-->
        <ul>
          <li><a href="http://xoso.homnay24h.com" title="trực tiếp xổ số hôm nay"><h3>Xổ số</h3></a></li>
          <li><a href="http://tuvi.homnay24h.com" title="tử vi trọn đời"><h3>Tử vi</h3></a></li>
          <li><a href="http://nhaccho.homnay24h.com" title="nhạc chờ hot 2015"><h3>Nhạc chờ</h3></a></li>
          <li><a href="http://stargame.vn" title="game hay"><h3>Games</h3></a></li>
        </ul>
<!--      </div>-->
<!--    </div>-->
  </div>

<!--  <div class="row">-->
<!--    <div class="col-md-12">-->
      <div id="play-section">
        <div class="progress_bar">
          <span class="remain-time pull-left">00:00</span>
          <div id="progress" class="text-center pull-left" style="width:80%;">
            <div id="load_progress"></div>
            <div id="play_progress"></div>
          </div>
          <span class="total-time pull-right">00:00</span>
        </div>
        <div class="clearfix"></div>
        <div class="play-wrapper">
          <div class="i-music icon"></div>
          <div class="music-info pull-left">
            <p class="music-name"></p>
            <p class="singer-name"></p>
          </div>
          <div class="i-large-play icon">
            <audio id="audioId">
              <source id="sourceId" src="" type="audio/mpeg">
              Your browser does not support the audio element.
            </audio>
          </div>
        </div>
      </div>
<!--    </div>-->
<!--  </div>-->
</div>
