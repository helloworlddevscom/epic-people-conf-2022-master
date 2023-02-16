<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="description" content="<?php echo esc_attr(get_bloginfo('description')); ?>" />
    <title><?php wp_title('&laquo;', true, 'right'); ?></title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1'/>-->
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,500;1,500&family=Work+Sans:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap" rel="stylesheet">    
    <?php wp_head(); ?>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-55278002-10"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-55278002-10');
  </script>

</head>
<body <?php body_class(); ?>>

<header class="header">
  <?php get_template_part('template-part', 'head'); ?>

  <?php get_template_part('template-part', 'topnav'); ?>
</header>
