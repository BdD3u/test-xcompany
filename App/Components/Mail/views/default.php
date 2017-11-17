<?php
/** @var array $res */
?>
<html lang="ru">
<header>
    <meta charset="UTF-8">
</header>
<body>
<h1>Добавлены новые файлы</h1>
<ul>
    <?php foreach ($res as $fileInfo):
        $link = "http://{$_SERVER['SERVER_NAME']}/image/?id={$fileInfo['id']}";
        ?>
        <li>
            <a target="_blank" href="<?= $link; ?>">
                <?= $fileInfo['name_origin']; ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>
