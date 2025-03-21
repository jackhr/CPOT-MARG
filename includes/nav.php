<?php
$current_url = $_SERVER['REQUEST_URI'];
if (($current_url == '/sconces/') || ($current_url == '/sconces/shop.php')) {
    $on_sconce_page = true;
} else {
    $on_sconce_page = false;
}
?>

<nav id="desktop-nav">
    <a class="logo-link" href="/">
        <img src="/assets/images/logos/logo-primary.png" alt="Logo">
    </a>
    <ul>
        <a class="logo-link" href="/">
            <img src="/assets/images/logos/logo-primary.png" alt="Logo">
        </a>
        <li>
            <a href="/" class="<?php echo ($current_url == '/') ? 'current' : ''; ?>">Home</a>
        </li>
        <li>
            <a href="/sconces" class="<?php echo $on_sconce_page ? 'current' : ''; ?>">Sconces</a>
        </li>
        <li>
            <a href="#" class="<?php echo strpos($current_url, '/portfolios/') !== false ? 'current' : ''; ?>">Portfolios</a>
            <ul class="subnav">
                <li>
                    <a href="/portfolios/imogen/" class="<?php echo ($current_url == '/portfolios/imogen/') ? 'current' : ''; ?>">Imogen</a>
                </li>
                <li>
                    <a href="/portfolios/michael/" class="<?php echo ($current_url == '/portfolios/michael/') ? 'current' : ''; ?>">Michael</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="/shop" class="<?php echo ($current_url == '/shop/') ? 'current' : ''; ?>">Shop</a>
        </li>
        <li>
            <a href="/about" class="<?php echo ($current_url == '/about/') ? 'current' : ''; ?>">Our Story</a>
        </li>
        <li>
            <a href="/contact" class="<?php echo ($current_url == '/contact/') ? 'current' : ''; ?>">Contact</a>
        </li>
        <li>
            <a href="/cart" class="<?php echo ($current_url == '/cart/') ? 'current' : ''; ?>">
                <div class="cart-count"></div>
                <svg title="Cart" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="8" cy="21" r="1" />
                    <circle cx="19" cy="21" r="1" />
                    <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                </svg>
            </a>
        </li>
    </ul>
    <div id="hamburger-btn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <line x1="4" x2="20" y1="12" y2="12" />
            <line x1="4" x2="20" y1="6" y2="6" />
            <line x1="4" x2="20" y1="18" y2="18" />
        </svg>
    </div>
</nav>

<nav id="hamburger-nav">
    <ul class="main-nav">
        <div class="close-nav">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18" />
                <path d="m6 6 12 12" />
            </svg>
        </div>
        <a class="logo-link" href="/">
            <img src="/assets/images/logos/logo-primary.png" alt="Logo">
        </a>
        <li>
            <a href="/" class="<?php echo ($current_url == '/') ? 'current' : ''; ?>">Home</a>
        </li>
        <li>
            <a href="/sconces" class="<?php echo $on_sconce_page ? 'current' : ''; ?>">Sconces</a>
        </li>
        <li>
            <a href="/portfolios" class="<?php echo strpos($current_url, '/portfolios/') !== false ? 'current' : ''; ?>">Portfolios</a>
        </li>
        <li>
            <a href="/shop" class="<?php echo ($current_url == '/shop/') ? 'current' : ''; ?>">Shop</a>
        </li>
        <li>
            <a href="/about" class="<?php echo ($current_url == '/about/') ? 'current' : ''; ?>">Our Story</a>
        </li>
        <li>
            <a href="/contact" class="<?php echo ($current_url == '/contact/') ? 'current' : ''; ?>">Contact</a>
        </li>
        <li>
            <a href="/cart" class="<?php echo ($current_url == '/cart/') ? 'current' : ''; ?>">
                <div class="cart-count"></div>
                <svg title="Cart" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="8" cy="21" r="1" />
                    <circle cx="19" cy="21" r="1" />
                    <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                </svg>
            </a>
        </li>
    </ul>
    <ul class="portfolio-nav">
        <div id="back-nav">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
        </div>
        <div class="close-nav">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18" />
                <path d="m6 6 12 12" />
            </svg>
        </div>
        <a class="logo-link" href="/">
            <img src="/assets/images/logos/logo-primary.png" alt="Logo">
        </a>
        <li>
            <a href="/portfolios/imogen/" class="<?php echo ($current_url == '/portfolios/imogen/') ? 'current' : ''; ?>">Imogen</a>
        </li>
        <li>
            <a href="/portfolios/michael/" class="<?php echo ($current_url == '/portfolios/michael/') ? 'current' : ''; ?>">Michael</a>
        </li>
    </ul>
</nav>