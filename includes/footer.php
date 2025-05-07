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
                    <span>Whatsapp:</span>
                    <a target="_blank" href="https://wa.me/12687704061?text=Hello!%20I’m%20currently%20browsing%20your%20website%20and%20I’m%20interested%20in%20learning%20more%20about%20your%20products%2Fservices.%20Could%20you%20please%20provide%20additional%20information%20about...">+1 (268) 770-4061</a>
                </div>
                <div class="contact-link">
                    <span>Email:</span>
                    <a href="mailto:info@<?php echo $domain; ?>?subject=Inquiry%20about%20Products%2FServices&body=Hello!%20I’m%20currently%20browsing%20your%20website%20and%20I’m%20interested%20in%20learning%20more%20about%20your%20products%2Fservices.%20Could%20you%20please%20provide%20additional%20information%20about...">info@<?php echo $domain; ?></a>
                </div>
                <div class="social-icons">
                    <div class="contact-link">
                        <a target="_blank" href="https://wa.me/12687704061?text=Hello!%20I’m%20currently%20browsing%20your%20website%20and%20I’m%20interested%20in%20learning%20more%20about%20your%20products%2Fservices.%20Could%20you%20please%20provide%20additional%20information%20about...">
                            <img src="/assets/icons/whatsapp.png" alt="Whatsapp Icon">
                        </a>
                    </div>
                    <div class="contact-link">
                        <a href="https://www.facebook.com/MargrieHunt" target="_blank">
                            <img src="/assets/icons/facebook.png" alt="Facebook Icon">
                        </a>
                    </div>
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