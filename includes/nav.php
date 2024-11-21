<?php
$current_url = $_SERVER['REQUEST_URI'];
?>

<nav id="desktop-nav">
    <ul>
        <a class="logo-link" href="/">
            <img src="/assets/images/logos/logo-primary.png" alt="Logo">
        </a>
        <li>
            <a href="/" class="<?php echo ($current_url == '/') ? 'current' : ''; ?>">Home</a>
        </li>
        <li>
            <a href="/lights" class="<?php echo ($current_url == '/lights/') ? 'current' : ''; ?>">Lights</a>
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
            <a href="/cart" class="<?php echo ($current_url == '/contact/') ? 'current' : ''; ?>">
                <svg title="Cart" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="8" cy="21" r="1" />
                    <circle cx="19" cy="21" r="1" />
                    <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                </svg>
            </a>
        </li>
    </ul>
</nav>

<!-- <nav id="hamburger-nav">

</nav> -->