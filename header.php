<?php defined('ABSPATH') or die(); ?>
<!DOCTYPE html>
<html <?php \language_attributes(); ?>>
    <head>
        <meta charset="<?php \bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="pingback" href="<?php \bloginfo('pingback_url'); ?>" />

        <?php \wp_head(); ?>
    </head>

    <body <?php \body_class('no-js'); ?> id="pagetop">
        <header>
            <!-- Blog Name & Logo -->
            <div class="top-main-menu">
                <div class="container">
                    <div class="row">
                        <!-- Logo -->
                        <div class="<?php echo \WordPress\Themes\EveOnline\Helper\PostHelper::getHeaderColClasses(); ?> brand clearfix">
                            <?php
                            $options = \get_option('eve_theme_options', \WordPress\Themes\EveOnline\Helper\ThemeHelper::getThemeDefaultOptions());

                            if(!empty($options['name'])) {
                                $eveApi = \WordPress\Themes\EveOnline\Helper\EsiHelper::getInstance();
                                $siteLogo = $eveApi->getEntityLogoByName($options['name'], $options['type']);

                                if($siteLogo !== false) {
                                    ?>
                                    <div class="site-logo float-left">
                                        <a href="<?php echo \esc_url(\home_url()); ?>"><img src="<?php echo $siteLogo; ?>" class="img-responsive" alt="<?php echo \get_bloginfo('name'); ?>"></a>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            <div class="site-title">
                                <span class="site-name"><?php echo \get_bloginfo('name'); ?></span>
                                <span class="site-description"><?php echo \get_bloginfo('description'); ?></span>
                            </div>
                        </div>

                        <!-- Navigation Header -->
                        <div class="col-sm-3 col-md-3 col-sm-12 visible-sm visible-md visible-lg">
                            <div class="top-head-menu">
                                <nav class="navbar navbar-default navbar-headermenu" role="navigation">
                                    <?php
                                    if(\has_nav_menu('header-menu')) {
                                        \wp_nav_menu([
                                            'menu' => '',
                                            'theme_location' => 'header-menu',
                                            'depth' => 1,
                                            'container' => false,
                                            'menu_class' => 'header-menu nav navbar-nav',
                                            'fallback_cb' => '\WordPress\Themes\EveOnline\Addons\BootstrapMenuWalker::fallback',
                                            'walker' => new \WordPress\Themes\EveOnline\Addons\BootstrapMenuWalker
                                        ]);
                                    }
                                    ?>
                                </nav>
                            </div>
                        </div>

                        <!-- Header Widget from Theme options -->
                        <?php
                        if(\WordPress\Themes\EveOnline\Helper\ThemeHelper::hasSidebar('header-widget-area')) {
                            ?>
                            <div class="col-md-3 col-sm-12">
                                <div class="row">
                                    <div class="col-sm-12 header-widget">
                                        <?php
                                        if(\function_exists('\dynamic_sidebar')) {
                                            \dynamic_sidebar('header-widget-area');
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                    <!-- Navigation Main -->
                    <?php
                    if(\has_nav_menu('main-menu') || \has_nav_menu('header-menu')) {
                        ?>
                        <!-- Menu -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="top-main-menu">
                                    <nav class="<?php if(!\has_nav_menu('main-menu')) { echo 'visible-xs ';} ?>navbar navbar-default" role="navigation">
                                        <!-- Brand and toggle get grouped for better mobile display -->
                                        <div class="navbar-header">
                                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                                                <span class="sr-only"><?php \__('Toggle navigation', 'eve-online'); ?></span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                            </button>
                                            <span class="navbar-toggled-title visible-xs float-right"><?php \printf(\__('Menu', 'eve-online')) ?></span>
                                        </div>

                                        <!-- Collect the nav links, forms, and other content for toggling -->
                                        <div class="collapse navbar-collapse navbar-ex1-collapse">
                                            <?php
                                            if(\has_nav_menu('main-menu')) {
                                                \wp_nav_menu([
                                                    'menu' => '',
                                                    'theme_location' => 'main-menu',
                                                    'depth' => 3,
                                                    'container' => false,
                                                    'menu_class' => 'nav navbar-nav main-navigation',
                                                    'fallback_cb' => '\WordPress\Themes\EveOnline\Addons\BootstrapMenuWalker::fallback',
                                                    'walker' => new \WordPress\Themes\EveOnline\Addons\BootstrapMenuWalker
                                                ]);
                                            }

                                            if(\has_nav_menu('header-menu')) {
                                                $additionalMenuClass = null;
                                                if(\has_nav_menu('main-menu')) {
                                                    $additionalMenuClass = ' secondary-mobile-menu';
                                                }

                                                \wp_nav_menu([
                                                    'menu' => '',
                                                    'theme_location' => 'header-menu',
                                                    'depth' => 1,
                                                    'container' => false,
                                                    'menu_class' => 'visible-xs header-menu nav navbar-nav' . $additionalMenuClass,
                                                    'fallback_cb' => '\WordPress\Themes\EveOnline\Addons\BootstrapMenuWalker::fallback',
                                                    'walker' => new \WordPress\Themes\EveOnline\Addons\BootstrapMenuWalker
                                                ]);
                                            }
                                            ?>
                                        </div><!-- /.navbar-collapse -->
                                    </nav>
                                </div><!-- /.top-main-menu -->
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div><!-- /.container -->
            </div><!-- /.top-main-menu -->

            <div class="stage">
                <div class="container">
                    <?php
                    if(\is_single() && \has_post_thumbnail()) {
                        ?>
                        <figure class="post-header-image">
                            <?php
                            if(\function_exists('\fly_get_attachment_image')) {
                                echo \fly_get_attachment_image(\get_post_thumbnail_id(), 'header-image');
                            } else {
                                \the_post_thumbnail('header-image');
                            }
                            ?>
                        </figure>
                        <?php
                    } elseif(\is_category() || \is_tax()) {
                        if(\function_exists('\z_taxonomy_image')) {
                            $headerImage = '';

                            if(\function_exists('\fly_get_attachment_image')) {
                                $headerImage = \fly_get_attachment_image(\z_get_attachment_id_by_url(\z_taxonomy_image_url()), 'header-image');
                            } else {
                                $headerImage = \z_taxonomy_image(null, 'header-image', null, false);
                            }

                            if($headerImage !== '') {
                                ?>
                                <figure class="post-header-image foobar">
                                    <?php echo $headerImage; ?>
                                </figure>
                                <?php
                            }
                        }
                    } else {
                        /**
                         * Render our Slider, if we have one
                         */
                        \do_action('eve_render_header_slider');
                    }
                    ?>
                </div>
            </div>
        </header>
        <!-- End Header. Begin Template Content -->

        <?php
        if((\is_front_page()) && (\is_paged() == false)) {
            if(\WordPress\Themes\EveOnline\Helper\ThemeHelper::hasSidebar('home-column-1') || \WordPress\Themes\EveOnline\Helper\ThemeHelper::hasSidebar('home-column-2') || \WordPress\Themes\EveOnline\Helper\ThemeHelper::hasSidebar('home-column-3') || \WordPress\Themes\EveOnline\Helper\ThemeHelper::hasSidebar('home-column-4')) {
                ?>
                <!--
                // Marketing Stuff / Home Widgets
                -->
                <div class="home-widget-area">
                    <div class="home-widget-wrapper">
                        <div class="row">
                            <div class="container home-widgets">
                                <?php \get_sidebar('home'); ?>
                            </div>
                        </div>
                    </div>
                </div><!--/.row -->
                <?php
            }
        }
        ?>

        <main>
