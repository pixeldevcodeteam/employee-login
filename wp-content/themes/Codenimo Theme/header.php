<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php bloginfo('name'); ?> &raquo; <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
   <meta charset="<?php bloginfo( 'charset' ); ?>">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"> -->
   <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-3I6C59I8FZp0UJqIB4+3IHU6/Qt5t5mLhzLhtHjEDcbqcbJSBL87u3aKdvOlHnO4OgtLJGu9QRri/rHLxR4DZA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dashicons/2.3.0/css/dashicons.min.css" integrity="sha384-..." crossorigin="anonymous">

   <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<aside class="sidebarContainter">
    
    <?php get_sidebar() ?>
</aside>




