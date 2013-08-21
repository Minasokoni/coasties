<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 */
?>

	<?php #get_sidebar( 'footer' ); ?>

<footer id="main">
	<div class="wrapper">
		<div class="footer-block links">
			<h3>About Coasties</h3>
			<a href="#">About us</a>
			<a href="#">Coaster brakes</a>
			<a href="#">Testimonials</a>
		</div>
		<div class="footer-block links">
			<h3>Customer Info</h3>
			<a href="#">How-to</a>
			<a href="#">Shipping &amp; Returns</a>
			<a href="#">Contact Us</a>
		</div>
		<div class="footer-block last">
			<h3>Ride with us</h3>
			<p>Subscribe to our newsletter</p>
			<form action="">
				<label>
					<input type="text" placeholder="Your email" />
					<input type="submit" value="Sign Up" class="btn" />
				</label>
			</form>
			<a class="social facebook" href="#"><i class="icon-facebook"></i></a>
			<a class="social twitter" href="#"><i class="icon-twitter"></i></a>
			<a class="social pinterest" href="#"><i class="icon-pinterest"></i></a>
			<a class="social instagram" href="#"><i class="icon-instagram"></i></a>
		</div>
		<div class="copyright center">2013 &copy; Coasties | Site by <a href="#">Naimsheriff</a> &amp; <a href="#">Robert Barnwell</a></div>
	</div>
</footer>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/vendor/jquery.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/vendor/plugins/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/main.js"></script>
<?php wp_footer(); ?>

</body>
</html>