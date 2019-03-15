<?php
	/**
	 * The header for our admin pages.
	 *
	 * Displays all of the brand menu and user section
	 *
	 * @package Bulma by Milla
	 */
	include('header.php');
	session_start();
?>
<section class="hero is-info is-medium">
    <div class="container has-text-centered">
        <?php echo $Load->HeroMenu(); ?>
    </div>
</section>
<section class="section">
    <div class="container">