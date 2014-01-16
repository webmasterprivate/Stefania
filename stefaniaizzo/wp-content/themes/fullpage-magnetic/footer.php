<div id="footer">
    <div id="footerNav"><?php wp_nav_menu (array ( 'theme_location' => 'footer-menu') ); ?></div>
    <div class="copyright">&copy; <?php echo get_the_time('Y '); bloginfo('name'); ?></div>
</div>

<?php wp_footer(); ?>
</div>
</body>
</html>
