<?php
    /**
     * The header for our theme.
     *
     * Displays all of the <head> section and everything up till <div id="content">
     *
     * @package Bulma by Milla
     */
    require_once('functions/main.php');
?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="<?php echo DESC; ?>">
        <meta name="author" content="<?php echo AUTHOR; ?>">
        <title><?php echo $title; ?></title>
        <!-- Favicon -->
        <link href="<?php echo SERVER; ?>assets/brand/favicon.ico" rel="icon" type="image/png">
        <!-- Theme CSS -->
        <link type="text/css" href="<?php echo SERVER; ?>assets/style.css" rel="stylesheet">
        <link type="text/css" href="<?php echo SERVER; ?>assets/bulma-pageloader/dist/css/bulma-pageloader.min.css" rel="stylesheet">
        <link type="text/css" href="<?php echo SERVER; ?>assets/bulma-pageloader/src/sass/index.sass" rel="stylesheet">
        <!-- JS -->
        <script src="assets/js/menu.js"></script>
    </head>
    <body>