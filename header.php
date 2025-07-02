<?php
namespace Eclipse\Theme;

defined('ABSPATH') || exit;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
    <div class="container">
        <div class="header-inner">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                <?php if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    bloginfo('name');
                } ?>
            </a>
            <button class="menu-toggle" aria-expanded="false" aria-controls="primary-menu">
                ☰
            </button>
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'menu_id'        => 'primary-menu',
                'container'      => 'nav',
                'container_class'=> 'primary-nav',
            ]);
            ?>
        </div>
    </div>
</header>
