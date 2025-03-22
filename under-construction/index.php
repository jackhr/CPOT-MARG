<?php require_once __DIR__ . '/../includes/head.php'; ?>


<style>
    body {
        background: var(--black);
        color: var(--white);
    }

    #main-container {
        width: 100vw;
        height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 24px;
        text-align: center;
    }

    img {
        max-width: 200px;
        margin-bottom: 48px;
    }

    p {
        line-height: 1.5;
        max-width: 800px;
    }

    #reload {
        background: var(--secondary);
        border: solid 1px transparent;
        padding: 16px;
        border-radius: 8px;
        color: var(--white);
        font-weight: 500;
        font-size: 16px;
        cursor: pointer;
        transition: ease 0.3s all;
        margin-top: 48px;
        width: 300px;
    }

    #reload:hover {
        border-color: var(--white);
    }

    #reload {
        background-color: var(--secondary-darker);
    }
</style>

<body>
    <div id="main-container">
        <img src="/assets/icons/hardhat.avif" alt="Hardhat">
        <h1>Under Construction</h1>
        <p>The site is getting an upgrade! We should be finished soon, We should be finished soon, and will contact you once completed.</p>
        <a href="/" id="reload">Refresh</a>
    </div>
</body>

</html>