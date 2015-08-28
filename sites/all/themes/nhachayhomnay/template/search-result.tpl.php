<?php

/**
 * @file
 * Default theme implementation for displaying a single search result.
 *
 * This template renders a single search result and is collected into
 * search-results.tpl.php. This and the parent template are
 * dependent to one another sharing the markup for definition lists.
 *
 * Available variables:
 * - $url: URL of the result.
 * - $title: Title of the result.
 * - $snippet: A small preview of the result. Does not apply to user searches.
 * - $info: String of all the meta information ready for print. Does not apply
 *   to user searches.
 * - $info_split: Contains same data as $info, split into a keyed array.
 * - $module: The machine-readable name of the module (tab) being searched, such
 *   as "node" or "user".
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Default keys within $info_split:
 * - $info_split['type']: Node type (or item type string supplied by module).
 * - $info_split['user']: Author of the node linked to users profile. Depends
 *   on permission.
 * - $info_split['date']: Last update of the node. Short formatted.
 * - $info_split['comment']: Number of comments output as "% comments", %
 *   being the count. Depends on comment.module.
 *
 * Other variables:
 * - $classes_array: Array of HTML class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $title_attributes_array: Array of HTML attributes for the title. It is
 *   flattened into a string within the variable $title_attributes.
 * - $content_attributes_array: Array of HTML attributes for the content. It is
 *   flattened into a string within the variable $content_attributes.
 *
 * Since $info_split is keyed, a direct print of the item is possible.
 * This array does not apply to user searches so it is recommended to check
 * for its existence before printing. The default keys of 'type', 'user' and
 * 'date' always exist for node searches. Modules may provide other data.
 * @code
 *   <?php if (isset($info_split['comment'])): ?>
 *     <span class="info-comment">
 *       <?php print $info_split['comment']; ?>
 *     </span>
 *   <?php endif; ?>
 * @endcode
 *
 * To check for all available data within $info_split, use the code below.
 * @code
 *   <?php print '<pre>'. check_plain(print_r($info_split, 1)) .'</pre>'; ?>
 * @endcode
 *
 * @see template_preprocess()
 * @see template_preprocess_search_result()
 * @see template_process()
 *
 * @ingroup themeable
 */
?>

<?php
$theme_path = drupal_get_path('theme', 'nhachayhomnay');

//$title = ($result['node']->field_file_name['und'][0]['value']);
$node_type = 'Nhạc số';
$dl_nhac = '';
$code = '';
$number = '';
$provider_name = 'nhacso';

$singer_tid = $result['node']->field_singer['und'][0]['tid'];
$singer_term = taxonomy_term_load($singer_tid);
$singer_name = $singer_term->name;

$file = $result['node']->field_file['und'][0]['value'];
$file = str_replace(' ','%20',$file);

$url_dl = 'http://mp3.homnay24h.com/nhacso/'.$file;
if($result['node']->type == 'nhac_cho'){
  $url_dl = '#';
  $node_type = 'Nhạc chờ';
  $provider_tid = $result['node']->field_provider['und'][0]['tid'];
  $provider_term = taxonomy_term_load($provider_tid);
  $provider_name = $provider_term->name;
  $dl_nhac = 'dl_nhac_cho';
  $code = $result['node']->field_code['und'][0]['value'];
  if($provider_tid == 3){$number = '1221'; $code = 'BH '.$code;}//viettel
  if($provider_tid == 4){$number = '9224'; $code = 'CHON '.$code;}//mobifone
  if($provider_tid == 5){$number = '9194'; $code = 'TAI '.$code;}//vinaphone
}
$copyright = 0;
if($result['node']->type == 'nhac_so'){
  $copyright = $result['node']->field_copyright['und'][0]['value'];
  if($copyright == 0){
    $url_dl = '';
    $dl_nhac = 'disable';
  }
}

?>

<div class="node-wrap">
  <div class="item-song pull-left">
    <h3><?php print $result['node']->title;?></h3>
    <div class="info-song">
      <ul>
        <li><span class="i-singer">00</span><span class="t-singer"><?php print $singer_name;?></span></li>
        <?php if($result['node']->type != 'nhac_cho'):?>
          <li><span class="i-type-song">00</span><span class="t-type-song"><?php print $node_type;?></span></li>
        <?php endif;?>
      </ul>
    </div>
  </div>
  <div class="tool-song pull-right">
    <div class="i25 i-small i-listen" data-name="<?php print $result['node']->title;?>"
         data-provider="<?php print $provider_name;?>" data-file="<?php print $file;?>" data-nid="<?php print $result['node']->nid;?>"
         data-singer="<?php print $singer_name;?>" data-type="<?php print $result['node']->type;?>">
      <a title="Nghe thử" class="fn-listen" href="#">Listen</a>
    </div>
    <div class="i25 i-small i-download <?php print $dl_nhac;?>" data-name="<?php print $result['node']->title;?>" data-number="<?php print $number;?>" data-code="<?php print $code;?>">
      <a <?php if($dl_nhac == ''){print 'style="display: block; height: 46px;"';}?>
          title="Download" class="fn-dlsong"
          href="<?php print $url_dl;?>" onmouseover="status=''; return true;" download>Download</a>
    </div>
  </div>
  <div class="clearfix"></div>
</div>



