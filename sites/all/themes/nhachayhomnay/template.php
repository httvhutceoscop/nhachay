<?php 

/**
 * Page alter.
 */
function nhachayhomnay_page_alter(&$page) {
	$mobileoptimized = array(
		'#type' => 'html_tag',
		'#tag' => 'meta',
		'#attributes' => array(
		'name' =>  'MobileOptimized',
		'content' =>  'width'
		)
	);
	$handheldfriendly = array(
		'#type' => 'html_tag',
		'#tag' => 'meta',
		'#attributes' => array(
		'name' =>  'HandheldFriendly',
		'content' =>  'true'
		)
	);
	$viewport = array(
		'#type' => 'html_tag',
		'#tag' => 'meta',
		'#attributes' => array(
		'name' =>  'viewport',
		'content' =>  'width=device-width, initial-scale=1'
		)
	);
	drupal_add_html_head($mobileoptimized, 'MobileOptimized');
	drupal_add_html_head($handheldfriendly, 'HandheldFriendly');
	drupal_add_html_head($viewport, 'viewport');

	/**
	 *  Hide search form on the results page
	 */
	// This assumes everything being output in the "content" page region.
	// Logged in
	if (!empty($page['content']['system_main']['content']['search_form'])) {
		unset($page['content']['system_main']['content']['search_form']);
	}
	// Not logged in
	if (!empty($page['content']['system_main']['search_form'])) {
		unset($page['content']['system_main']['search_form']);
	}
}

/**
 * Preprocess variables for html.tpl.php
 */
function nhachayhomnay_preprocess_html(&$variables) {
	/**
	 * Add IE8 Support
	 */
	drupal_add_css(path_to_theme() . '/css/ie8.css', array('group' => CSS_THEME, 'browsers' => array('IE' => '(lt IE 9)', '!IE' => FALSE), 'preprocess' => FALSE));
    
	/**
	* Bootstrap CDN
	*/
    
//    if (theme_get_setting('bootstrap_css_cdn', 'nhachayhomnay')) {
//        $cdn = '//maxcdn.bootstrapcdn.com/bootstrap/' . theme_get_setting('bootstrap_css_cdn', 'nhachayhomnay')  . '/css/bootstrap.min.css';
//        drupal_add_css($cdn, array('type' => 'external'));
//    }
    
    /*if (theme_get_setting('bootstrap_js_cdn', 'nhachayhomnay')) {
        $cdn = '//maxcdn.bootstrapcdn.com/bootstrap/' . theme_get_setting('bootstrap_js_cdn', 'nhachayhomnay')  . '/js/bootstrap.min.js';
        drupal_add_js($cdn, array('type' => 'external'));
    }*/
	
	/**
	* Add Javascript for enable/disable scrollTop action
	*/
	if (theme_get_setting('scrolltop_display', 'nhachayhomnay')) {

		drupal_add_js('jQuery(document).ready(function($) { 
		$(window).scroll(function() {
			if($(this).scrollTop() != 0) {
				$("#toTop").fadeIn();	
			} else {
				$("#toTop").fadeOut();
			}
		});
		
		$("#toTop").click(function() {
			$("body,html").animate({scrollTop:0},800);
		});	
		
		});',
		array('type' => 'inline', 'scope' => 'header'));
	}
	//EOF:Javascript
}

/**
 * Override or insert variables into the html template.
 */
function nhachayhomnay_process_html(&$vars) {
	// Hook into color.module
	if (module_exists('color')) {
	_color_html_alter($vars);
	}
}

/**
 * Preprocess variables for page template.
 */
function nhachayhomnay_preprocess_page(&$vars) {
	drupal_add_js(array('nhachayhomnay' => array('root_path' => file_create_url(''))), 'setting');

	drupal_add_css(drupal_get_path('theme','nhachayhomnay').'/css/bootstrap.min.css');
	drupal_add_js(drupal_get_path('theme','nhachayhomnay').'/js/bootstrap.min.js', array('type' => 'file', 'scope' => 'footer'));
	drupal_add_js(drupal_get_path('theme','nhachayhomnay').'/js/min/nhachay.min.js', array('type' => 'file', 'scope' => 'footer'));

	/**
	 * insert variable search box
	 */
//	$search_box = drupal_render(drupal_get_form('search_form'));
//	$vars['search_box'] = $search_box;

	/**
	 * insert variables into page template.
	 */

	if($vars['page']['header_top_left'] && $vars['page']['header_top_right']) { 
		$vars['header_top_left_grid_class'] = 'col-md-8';
		$vars['header_top_right_grid_class'] = 'col-md-4';
	} elseif ($vars['page']['header_top_right'] || $vars['page']['header_top_left']) {
		$vars['header_top_left_grid_class'] = 'col-md-12';
		$vars['header_top_right_grid_class'] = 'col-md-12';		
	}

	/**
	 * Add Javascript
	 */
	/*if($vars['page']['pre_header_first'] || $vars['page']['pre_header_second'] || $vars['page']['pre_header_third']) { 
	drupal_add_js('
	function hidePreHeader(){
	jQuery(".toggle-control").html("<a href=\"javascript:showPreHeader()\"><span class=\"glyphicon glyphicon-plus\"></span></a>");
	jQuery("#pre-header-inside").slideUp("fast");
	}

	function showPreHeader() {
	jQuery(".toggle-control").html("<a href=\"javascript:hidePreHeader()\"><span class=\"glyphicon glyphicon-minus\"></span></a>");
	jQuery("#pre-header-inside").slideDown("fast");
	}
	',
	array('type' => 'inline', 'scope' => 'footer', 'weight' => 3));
	}*/
	//EOF:Javascript
}

/**
 * Override or insert variables into the page template.
 */
function nhachayhomnay_process_page(&$variables) {
  // Hook into color.module.
  if (module_exists('color')) {
    _color_page_alter($variables);
  }
}

/**
 * Preprocess variables for block.tpl.php
 */
function nhachayhomnay_preprocess_block(&$variables) {
	$variables['classes_array'][]='clearfix';
}

/**
 * Override theme_breadrumb().
 *
 * Print breadcrumbs as a list, with separators.
 */
function nhachayhomnay_breadcrumb($variables) {
	$breadcrumb = $variables['breadcrumb'];

	if (!empty($breadcrumb)) {
		$breadcrumb[] = drupal_get_title();
		$breadcrumbs = '<ol class="breadcrumb">';

		$count = count($breadcrumb) - 1;
		foreach ($breadcrumb as $key => $value) {
		$breadcrumbs .= '<li>' . $value . '</li>';
		}
		$breadcrumbs .= '</ol>';

		return $breadcrumbs;
	}
}

/**
 * Search block form alter.
 */
/*function nhachayhomnay_form_alter(&$form, &$form_state, $form_id) {
	if ($form_id == 'search_block_form') {
	    unset($form['search_block_form']['#title']);
	    $form['search_block_form']['#title_display'] = 'invisible';
		$form_default = t('Search this website...');
	    $form['search_block_form']['#default_value'] = $form_default;

		$form['actions']['submit']['#attributes']['value'][] = '';

	 	$form['search_block_form']['#attributes'] = array('onblur' => "if (this.value == '') {this.value = '{$form_default}';}", 'onfocus' => "if (this.value == '{$form_default}') {this.value = '';}" );
	}
}*/

function nhachayhomnay_form_alter(&$form, &$form_state, $form_id)
{
	if ($form_id == 'search_form') {
		variable_set('key_word_search', $form['basic']['keys']['#default_value']);
//		if ($form['advanced']['#title'] != "Advanced search") array_push($form['#attributes']['class'], 'no_show');
	}
}

/**
 * Implementation of HOOK_pager().
 * $variables: An associative array containing:
 *  tags: An array of labels for the controls in the pager.
 *  element: An optional integer to distinguish between multiple pagers on one page.
 *  parameters: An associative array of query string parameters to append to the pager links.
 *  quantity: The number of pages in the list.
 */
function nhachayhomnay_pager($variables) {
	$tags = $variables['tags'];
	$element = $variables['element'];
	$parameters = $variables['parameters'];
	$quantity = $variables['quantity'];
	global $pager_page_array, $pager_total,$user;

	if($quantity >= 3) {$quantity = 3;}

	$li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('‹ Previous')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
	$li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('Next ›')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));

	// Calculate various markers within this pager piece:
	// Middle is used to "center" pages around the current page.
	$pager_middle = ceil($quantity / 2);
	// current is the page we are currently paged to
	$pager_current = $pager_page_array[$element] + 1;
	// first is the first page listed by this pager piece (re quantity)
	$pager_first = $pager_current - $pager_middle + 1;
	// last is the last page listed by this pager piece (re quantity)
	$pager_last = $pager_current + $quantity - $pager_middle;
	// max is the maximum page number
	$pager_max = $pager_total[$element];
	// End of marker calculations.

	// Prepare for generation loop.
	$i = $pager_first;
	if ($pager_last > $pager_max) {
		// Adjust "center" if at end of query.
		$i = $i + ($pager_max - $pager_last);
		$pager_last = $pager_max;
	}
	if ($i <= 0) {
		// Adjust "center" if at start of query.
		$pager_last = $pager_last + (1 - $i);
		$i = 1;
	}

	if ($pager_total[$element] > 1) {

		// PREVIOUS
		if ($li_previous) {
			$items[] = array(
				'class' => array('pager-previous'),
				'data' => $li_previous,
			);
		}

		// When there is more than one page, create the pager list.
		if ($i != $pager_max) {
			/*if ($i > 1) {
				$items[] = array(
					'class' => array('pager-ellipsis'),
					'data' => '…',
				);
			}*/
			// Now generate the actual pager piece.
			for (; $i <= $pager_last && $i <= $pager_max; $i++) {
				if ($i < $pager_current) {
					$items[] = array(
						'class' => array('pager-item'),
						'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
					);
				}
				if ($i == $pager_current) {
					$items[] = array(
						'class' => array('pager-current'),
						'data' => $i,
					);
				}
				if ($i > $pager_current) {
					$items[] = array(
						'class' => array('pager-item'),
						'data' => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
					);
				}
			}
			/*if ($i < $pager_max) {
				$items[] = array(
					'class' => array('pager-ellipsis'),
					'data' => '…',
				);
			}*/
		}

		// NEXT
		if ($li_next) {
			$items[] = array(
				'class' => array('pager-next'),
				'data' => $li_next,
			);
		}

		// OUTPUT
		return '<h2 class="element-invisible">' . t('Pages') . '</h2>' . theme('item_list', array(
			'items' => $items,
			'attributes' => array('class' => array('pager')),
		));
	}
}