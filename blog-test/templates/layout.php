<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>blog</title>
    <link rel="shortcut icon" href="/image/favicon.png" type="image/png">
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
<header class="header">
    <div class="header__content">
        <a class="header__logo" href="/">
            <div class="header__logo-wrapper">
                <img src="/image/logo.svg" alt="logo">
            </div>
            <span class="header__logo-name">MY BLOG</span>
        </a>
        <p class="header__title">merry christmas</p>
    </div>
</header>
<main>
    <section class="content">
		<?= $messages ?>
		<?= $content ?>
    </section>
</main>
<footer class="footer">
    <p>enjoy reading =)</p>
</footer>
</body>
</html>
