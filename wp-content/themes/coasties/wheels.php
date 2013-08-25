<?php
/**
 * Template Name: Wheels
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 */

get_header(); ?>
	<div class="row">
		<div class="wrapper">
			<nav id="subnav">
				<ul>
					<li><a class="active" href="#all">All</a></li>
					<li><a href="#sets">Wheel sets</a></li>
					<li><a href="#rear">Rear wheels</a></li>
					<li><a href="#deep">Deep Vs</a></li>
				</ul>
			</nav>
		</div>
	</div>

	<div id="sets" class="cat">
		<div class="row">
			<div class="wrapper">
				<h3 class="small-12 small-centered columns center title">Wheel sets</h3>
				<span class="dash-berlin"></span>
						<p class="center sub">The famous Velosteel hub has a elegant high polish finish, and is completely different mechanically than our standard cone clutch hubs.</p>
			</div>
		</div>
		<div class="row listing">
			<div class="wrapper">
				<?php echo do_shortcode('[product_category category="wheel-sets" per_page="12" columns="4" orderby="date" order="desc"]'); ?>
			</div>
		</div>
	</div>

	<div id="rear" class="cat">
		<div class="row">
			<div class="wrapper">
				<h3 class="small-12 small-centered columns center title">Rear Wheels Only</h3>
				<span class="dash-berlin"></span>
						<p class="center sub">The famous Velosteel hub has a elegant high polish finish, and is completely different mechanically than our standard cone clutch hubs.</p>
			</div>
		</div>
		<div class="row listing">
			<div class="wrapper">
				<?php echo do_shortcode('[product_category category="rear-wheels" per_page="12" columns="4" orderby="date" order="desc"]'); ?>
			</div>
		</div>
	</div>

	<div id="deep" class="cat">
		<div class="row">
			<div class="wrapper">
				<h3 class="small-12 small-centered columns center title">Deep Vs</h3>
				<span class="dash-berlin"></span>
						<p class="center sub">The famous Velosteel hub has a elegant high polish finish, and is completely different mechanically than our standard cone clutch hubs.</p>
			</div>
		</div>
		<div class="row listing">
			<div class="wrapper">
				<?php echo do_shortcode('[product_category category="deep-vs" per_page="12" columns="4" orderby="date" order="desc"]'); ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>