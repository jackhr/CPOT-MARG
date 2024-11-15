<?php
$current_url = $_SERVER['REQUEST_URI'];
?>

<nav id="desktop-nav">
    <ul>
        <a class="logo-link" href="/">
            <img src="/assets/images/logos/logo-white.png" alt="Logo">
        </a>
        <li>
            <a href="/" class="<?php echo ($current_url == '/') ? 'current' : ''; ?>">Home</a>
        </li>
        <li>
            <a href="/lights" class="<?php echo ($current_url == '/lights') ? 'current' : ''; ?>">Lights</a>
        </li>
        <li>
            <a href="/one-of-a-kind" class="<?php echo ($current_url == '/one-of-a-kind') ? 'current' : ''; ?>">One of a Kind</a>
        </li>
        <li>
            <a href="/about" class="<?php echo ($current_url == '/about') ? 'current' : ''; ?>">Our Story</a>
        </li>
        <li>
            <a href="/contact" class="<?php echo ($current_url == '/contact') ? 'current' : ''; ?>">Contact</a>
        </li>
    </ul>
</nav>

<!-- <nav id="hamburger-nav">

</nav> -->