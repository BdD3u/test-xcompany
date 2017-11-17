<?php
/** @var Core\PageRenderer $pr */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?= $pr->title; ?></title>
    <link href="/css/?file=main" rel="stylesheet" type="text/css"/>
    <script src="/js/?file=main"></script>
</head>
<body>

<!-- content section -->
<div class="wr_fix_footer">
    <!-- head section -->
    <header class="main">
        <a href="/" class="logo">test-xcompany_test</a>
        <ul class="menu">
            <li>
                <a href="/">Главная</a>
            </li>
            <li>
                <a href="/about-test">Читать ТЗ</a>
            </li>
        </ul>
    </header>
    <!-- end head section -->
    <div class="wr_main_content">
        <?= $pr->content; ?>
    </div>
</div>
<!-- end content section -->

<!-- footer section -->
<footer class="main">
</footer>
<!-- end footer section -->
<div class="preloader"></div>
</body>
</html>