<footer>

    <section id="contact-banner"></section>

    <div class="inner">
        <div>
            <div class="footer-nav">
                <h6>Navigation</h6>
                <ul>
                    <li>
                        <a href="/" class="<?php echo ($current_url == '/') ? 'current' : ''; ?>">Home</a>
                    </li>
                    <li>
                        <a href="/sconces" class="<?php echo ($current_url == '/sconces/') ? 'current' : ''; ?>">Sconces</a>
                    </li>
                    <li>
                        <a href="/one-of-a-kind" class="<?php echo ($current_url == '/one-of-a-kind/') ? 'current' : ''; ?>">One of a Kind</a>
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
            <div class="footer-logo">
                <div>
                    <img src="/assets/images/logos/logo-primary.png" alt="Logo">
                </div>
            </div>
            <div class="footer-contact">
                <h6>Contact</h6>
                <div class="contact-link">
                    <span>Phone:</span>
                    <a href="tel:+1 (268) 123-4567">+1 (268) 123-4567</a>
                </div>
                <div class="contact-link">
                    <span>Email:</span>
                    <a href="mailto:info@<?php echo $domain; ?>">info@<?php echo $domain; ?></a>
                </div>
            </div>
        </div>

        <div id="copyright">© <?php echo date('Y'); ?> <?php echo $company_name; ?>   |   US$ to EC$ Exchange at 2.7</div>
    </div>

</footer>

</body>

</html>