<?php
/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all, or
 *   print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct url of the current node.
 * - $terms: the themed list of taxonomy term links output from theme_links().
 * - $display_submitted: whether submission information should be displayed.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined, e.g. $node->body becomes $body. When needing to access
 * a field's raw values, developers/themers are strongly encouraged to use these
 * variables. Otherwise they will have to explicitly specify the desired field
 * language, e.g. $node->body['en'], thus overriding any language negotiation
 * rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */
?>

<?php
$node_type = 'Nhạc số';
$code = '';
$number = '';
$disable = '';
$provider_name = 'nhacso';
//$dl_nhac = 'dl_nhac_so';
$dl_nhac = '';

$singer_tid = $node->field_singer['und'][0]['tid'];
$singer_term = taxonomy_term_load($singer_tid);
$singer_name = $singer_term->name;

$file = $node->field_file['und'][0]['value'];
$file = str_replace(' ','%20',$file);

$url_dl = 'http://mp3.homnay24h.com/nhacso/'.$file;
$src = $url_dl;
if($node->type == 'nhac_cho'){
    $url_dl = '#';
    $node_type = 'Nhạc chờ';
    $provider_tid = $node->field_provider['und'][0]['tid'];
    $provider_term = taxonomy_term_load($provider_tid);
    $provider_name = $provider_term->name;
    $dl_nhac = 'dl_nhac_cho';
    $code = $node->field_code['und'][0]['value'];
    if($provider_tid == 3){$number = '1221'; $code = 'BH '.$code;}//viettel
    if($provider_tid == 4){$number = '9224'; $code = 'CHON '.$code;}//mobifone
    if($provider_tid == 5){$number = '9194'; $code = 'TAI '.$code;}//vinaphone
    $src = 'http://mp3.homnay24h.com/'.$provider_name.'/'.$file;
}

$copyright = 0;
if($node->type == 'nhac_so'){
    $copyright = $node->field_copyright['und'][0]['value'];
    if($copyright == 0){
        $url_dl = '';
        $dl_nhac = 'disable';
    }
}

?>

<?php //print render($title_prefix); ?>
<?php //print render($title_suffix); ?>

<?php if (!$page): ?>
    <div class="node-wrap">
      <div class="item-song pull-left">
        <h3><?php print $node->title;?></h3>
        <div class="info-song">
          <ul>
            <li><span class="i-singer">00</span><span class="t-singer"><?php print $singer_name;?></span></li>
            <?php if($node->type != 'nhac_cho'):?>
              <li><span class="i-type-song">00</span><span class="t-type-song"><?php print $node_type;?></span></li>
            <?php endif;?>
          </ul>
        </div>
      </div>
      <div class="tool-song pull-right">
        <div class="i25 i-small i-listen" data-name="<?php print $node->title;?>"
            data-provider="<?php print $provider_name;?>" data-file="<?php print $file;?>"
            data-singer="<?php print $singer_name;?>" data-nid="<?php print $node->nid;?>" data-type="<?php print $node->type;?>">
          <a title="Nghe thử" class="fn-listen" href="#">Listen</a>
        </div>
        <div class="i25 i-small i-download <?php print $dl_nhac;?>" data-name="<?php print $node->title;?>"
             data-file="<?php print $file;?>" data-number="<?php print $number;?>" data-code="<?php print $code;?>">
          <a <?php if($dl_nhac == ''){print 'style="display: block; height: 46px;"';}?>
              title="Download" class="fn-dlsong"
              href="<?php print $url_dl;?>" onmouseover="status=''; return true;" download>Download</a>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>

<?php else: ?>
    <div class="container">
        <audio style="display: block" controls="controls" autoplay="autoplay">
            <source src="<?php print $src;?>" type="audio/mpeg">
            Browser is not supported!
        </audio>
    </div>
<?php endif; ?>