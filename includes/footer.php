<?php
if (($current_url == '/sconces/') || ($current_url == '/sconces/shop.php')) {
    $on_sconce_page = true;
} else {
    $on_sconce_page = false;
}
?>

<footer>

    <section id="contact-banner"></section>

    <div class="inner">
        <div>
            <div class="footer-contact">
                <h6>Contact</h6>
                <div class="contact-link">
                    <span>Phone:</span>
                    <a href="tel:+1 (268) 460-5293">+1 (268) 460-5293</a>
                </div>
                <div class="contact-link">
                    <span>Email:</span>
                    <a href="mailto:info@<?php echo $domain; ?>">info@<?php echo $domain; ?></a>
                </div>
            </div>
            <div class="footer-logo">
                <div>
                    <img src="/assets/images/logos/logo-primary.png" alt="Logo">
                </div>
            </div>
            <div class="footer-nav">
                <h6>Navigation</h6>
                <ul>
                    <li>
                        <a href="/" class="<?php echo ($current_url == '/') ? 'current' : ''; ?>">Home</a>
                    </li>
                    <li>
                        <a href="/sconces" class="<?php echo $on_sconce_page ? 'current' : ''; ?>">Sconces</a>
                    </li>
                    <li>
                        <a href="/portfolios/imogen" class="<?php echo strpos($current_url, '/portfolios/imogen/') !== false ? 'current' : ''; ?>">Imogen</a>
                    </li>
                    <li>
                        <a href="/portfolios/michael" class="<?php echo strpos($current_url, '/portfolios/michael/') !== false ? 'current' : ''; ?>">Michael</a>
                    </li>
                    <li>
                        <a href="/about" class="<?php echo ($current_url == '/about/') ? 'current' : ''; ?>">Our Story</a>
                    </li>
                    <li>
                        <a href="/contact" class="<?php echo ($current_url == '/contact/') ? 'current' : ''; ?>">Contact</a>
                    </li>
                    <li>
                        <a href="/cart" class="<?php echo ($current_url == '/cart/') ? 'current' : ''; ?>">Cart</a>
                    </li>
                </ul>
            </div>
        </div>

        <div id="copyright">© <?php echo date('Y'); ?> <?php echo $company_name; ?>   |   US$ to EC$ Exchange at 2.7</div>
    </div>

</footer>

</body>

</html>