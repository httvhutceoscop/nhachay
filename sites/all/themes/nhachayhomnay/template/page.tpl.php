<?php if (theme_get_setting('scrolltop_display')): ?>
<!--<div id="toTop"><span class="glyphicon glyphicon-chevron-up"></span></div>-->
<?php endif; ?>

<?php if ($page['header_top_left'] || $page['header_top_right']) :?>
<!-- #header-top -->

<div class="container">
    <div id="header-top" class="clearfix">
        <!-- #header-top-inside -->
        <div id="header-top-inside" class="clearfix">
            <div class="row">
            
            <?php if ($page['header_top_left']) :?>
            <div class="<?php print $header_top_left_grid_class; ?>">
                <!-- #header-top-left -->
                <div id="header-top-left" class="clearfix">
                    <?php print render($page['header_top_left']); ?>
                </div>
                <!-- EOF:#header-top-left -->
            </div>
            <?php endif; ?>
            
            <?php if ($page['header_top_right']) :?>
            <div class="<?php print $header_top_right_grid_class; ?>">
                <!-- #header-top-right -->
                <div id="header-top-right" class="clearfix">
                    <?php print render($page['header_top_right']); ?>
                </div>
                <!-- EOF:#header-top-right -->
            </div>
            <?php endif; ?>
            
            </div>
        </div>
        <!-- EOF: #header-top-inside -->

    </div>
</div>
<!-- EOF: #header-top -->    
<?php endif; ?>

<!-- header -->
<div class="container">
    <header id="header" role="banner" class="clearfix">
        <!-- #header-inside -->
        <div id="header-inside" class="clearfix">
<!--            <div class="row">-->
                <div class="col-xs-8 header-left">
                    <?php if ($logo):?>
                        <div id="logo">
                            <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home">
                                <!--<img src="<?php /*print $logo; */?>" alt="<?php /*print t('Home'); */?>" />-->
                                <img src="http://nhachay.homnay24h.com/sites/default/files/logo.png" alt="<?php print t('Home'); ?>" />
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php /*if ($site_name):*/?>
                        <!--<div id="site-name">-->
                            <!--<a href="<?php /*print $front_page; */?>" title="<?php /*print t('Home'); */?>"><?php /*print $site_name; */?></a>-->
                        <!--</div>-->
                    <?php /*endif; */?>
                </div>
                <div class="header-right">
                    <div id="search">
                        <input type="text" name="search" placeholder="Tìm bài hát, ca sĩ ..."/>
                        <a id="btn-search" class="i-search" href="#">search</a>
                    </div>
                </div>

                <!--<div class="col-md-12">-->
                    <?php /*if ($site_slogan):*/?>
                        <!--<div id="site-slogan">-->
                            <?php /*print $site_slogan; */?>
                        <!--</div>-->
                    <?php /*endif; */?>
                <!--</div>-->
<!--            </div>-->
        </div>
        <!-- EOF: #header-inside -->
    </header>
    <?php if ($page['header']) :?>
        <?php print render($page['header']); ?>
    <?php endif; ?>
</div>
<!-- EOF: #header -->
<?php
$current_page = drupal_get_path_alias(current_path());
$vt_active = 'active'; $vm_active = ''; $vnp_active = '';
$menu_home = ''; $menu_nhac_cho = '';$menu_nhac_so = '';
$sub_menu = false;
if($is_front){$menu_home = 'active';}
if($current_page == 'nhac-cho-viettel' || $current_page == 'nhac-cho-mobifone' || $current_page == 'nhac-cho-vinaphone'){
    $sub_menu = true;
    $menu_nhac_cho = 'active'; $menu_nhac_so = ''; $menu_home = '';
}
if($current_page == 'nhac-so'){
    $menu_nhac_cho = ''; $menu_nhac_so = 'active'; $menu_home = '';
}
if($current_page == 'nhac-cho-mobifone'){
    $vt_active = ''; $vm_active = 'active'; $vnp_active = '';
}
if($current_page == 'nhac-cho-vinaphone'){
    $vt_active = ''; $vm_active = ''; $vnp_active = 'active';
}
?>
<!-- #main-navigation -->

<div class="container">
    <div id="main-navigation" class="clearfix">
        <!-- #main-navigation-inside -->
        <div id="main-navigation-inside" class="clearfix">
<!--            <div class="row">-->
<!--                <div class="col-md-12">-->
                    <nav role="navigation">
                        <ul class="main-menu menu">
                            <li class="home_menu <?php print $menu_home;?> col-xs-2">
                                <a href="<?php print file_create_url('');?>" class="active">Home</a>
                            </li>
                            <li class="<?php print $menu_nhac_so;?> col-xs-5">
                                <a href="<?php print file_create_url('nhac-so');?>" class="active">Nhạc số</a>
                            </li>
                            <li class="<?php print $menu_nhac_cho;?> col-xs-5">
                                <a href="<?php print file_create_url('nhac-cho-viettel');?>" class="active">Nhạc chờ</a>
                            </li>
                        </ul>
                    </nav>
<!--                </div>-->
<!--            </div>-->
        </div>
        <?php if($sub_menu):?>
            <ul class="sub-menu">
                <li class="<?php print $vt_active;?>"><a href="<?php print file_create_url('nhac-cho-viettel');?>">Viettel</a></li>
                <li class="<?php print $vm_active;?>"><a href="<?php print file_create_url('nhac-cho-mobifone');?>">Mobifone</a></li>
                <li class="<?php print $vnp_active;?>"><a href="<?php print file_create_url('nhac-cho-vinaphone');?>">Vinaphone</a></li>
            </ul>
        <?php endif;?>
        <!-- EOF: #main-navigation-inside -->
    </div>
</div>
<!-- EOF: #main-navigation -->

<?php if ($page['banner']) : ?>
<!-- #banner -->
<div class="container">
    <div id="banner" class="clearfix">
        <!-- #banner-inside -->
        <div id="banner-inside" class="clearfix">
            <div class="row">
                <div class="col-md-12">
                <?php print render($page['banner']); ?>
                </div>
            </div>
        </div>
        <!-- EOF: #banner-inside -->        

    </div>
</div>
<!-- EOF:#banner -->
<?php endif; ?>

<!-- #page -->
<div class="container">
    <div id="page" class="clearfix">
        <!-- #main-content -->
        <div id="main-content">
            <!-- #messages-console -->
            <?php if ($messages):?>
            <div id="messages-console" class="clearfix">
                <div class="row">
                    <div class="col-md-12">
                    <?php print $messages; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <!-- EOF: #messages-console -->
            
            <!--<div class="row">
                <div class="col-md-12">-->
                    <!-- #main -->
                    <div id="main" class="clearfix">

                        <!-- EOF:#content-wrapper -->
                        <div id="content-wrapper">

                            <!-- #tabs -->
                            <?php if ($tabs):?>
                                <div class="tabs">
                                    <?php print render($tabs); ?>
                                </div>
                            <?php endif; ?>
                            <!-- EOF: #tabs -->
                            <?php if($is_front):?>
                                <div class="title-section">
                                    <h3>Bài hát mới</h3>
                                </div>
                            <?php endif;?>

                            <?php //custom nhac so ?>
                            <?php if($current_page == 'nhac-so'):?>
                                <div class="title-section">
                                    <h3>Bài hát mới</h3>
                                </div>

                                <div class="content">
                                    <?php
                                    $html = '';
                                    if(function_exists('getNodeList')){
                                        $nodes = getNodeList('nhac_so',0,10,false);
                                        if(isset($nodes)){
                                            foreach ($nodes as $node){
                                                $node_view_new = node_view($node, 'teaser');
                                                $html .= drupal_render($node_view_new);
                                            }
                                            echo $html;
                                        }
                                    }
                                    ?>
                                </div>

                                <div class="title-section">
                                    <h3>Bài hát nghe nhiều</h3>
                                </div>

                                <div class="content">
                                    <?php
                                    $html = '';
                                    if(function_exists('getNodeList')){
                                        $nodes = getNodeList('nhac_so',0,10,true);
                                        if(isset($nodes)){
                                            foreach ($nodes as $node){
                                                $node_view_new = node_view($node, 'teaser');
                                                $html .= drupal_render($node_view_new);
                                            }
                                            echo $html;
                                        }
                                    }
                                    ?>
                                </div>
                            <?php else:?>
                                <?php print render($page['content']); ?>
                            <?php endif;?>

                            <?php if($is_front):?>
                                <style>
                                    .item-list .pager { display: none; }
                                </style>
                            <?php endif;?>

                        </div>
                        <!-- EOF:#content-wrapper -->

                    </div>
                    <!-- EOF:#main -->
                <!--</div>
            </div>-->

        </div>
    </div>
    <!-- EOF:#main-content -->


</div>
<!-- EOF:#page -->
<div class="container">
    <?php if ($page['footer']):?>
        <?php print render($page['footer']); ?>
    <?php endif; ?>
</div>
