<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width" />

  <link rel="preconnect" href="https://player.vimeo.com">
  <link rel="preconnect" href="https://i.vimeocdn.com">
  <link rel="preconnect" href="https://f.vimeocdn.com">

  <?php wp_head(); ?>

  <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/fonts/red-hat-text-400.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/fonts/red-hat-text-700.woff2" as="font" type="font/woff2" crossorigin>
  <style>
    @font-face {
      font-family: 'Red Hat Text';
      src: url(<?php echo get_template_directory_uri(); ?>/fonts/red-hat-text-400.woff2) format("woff2");
      font-weight: 400;
      font-display: swap;
    }

    @font-face {
      font-family: 'Red Hat Text';
      src: url(<?php echo get_template_directory_uri(); ?>/fonts/red-hat-text-700.woff2) format("woff2");
      font-weight: 700;
      font-display: swap;
    }
  </style>
</head>

<body <?php body_class(); ?>>
  <div id="wrapper" class="hfeed wrapper">
    <header id="header">
      <div id="branding">
        <div id="site-title">
          <?php if (is_front_page() || is_home() || is_front_page() && is_home()) {
            echo '<h1 class="frontpage_title">';
          } ?>
          <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_html(get_bloginfo('name')); ?>" rel="home"><?php echo esc_html(get_bloginfo('name')); ?></a>
          <?php if (is_front_page() || is_home() || is_front_page() && is_home()) {
            echo '</h1>';
          } ?>
        </div>
      </div>
      <nav id="menu">
        <!-- <div id="search"><?php get_search_form(); ?></div> -->
        <!-- <?php wp_nav_menu(array('theme_location' => 'main-menu')); ?> -->
      </nav>
    </header>
    <div id="container">