<?php
extract($params);
/** @var App\Models\PhotoModel[] $photos */
/** @var array $uploadPhotos */
?>
<section class="std_container">
    <h1>Загрузка фотографий</h1>
    <!-- photo uploder -->
    <form id="upload_photos" method="post" enctype="multipart/form-data" action="">
        <?php if(isset($uploadPhotos['errors']) && $uploadPhotos['errors']): ?>
        <div class="errors">
            <?php foreach ($uploadPhotos['errors'] as $error): ?>
                <p><?= $error; ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <fieldset>
            <legend>Фотография 1</legend>
            <input type="text" name="file[0][name]" placeholder="Название"/>
            <div class="wr_input_file">
                <input type="file" name="file[0][file]" placeholder="Прикрипите файл"/>
                <div class="btn_file_upload">Прикрепите файл</div>
            </div>
        </fieldset>
        <input style="margin: 20px 0px;" type="text" placeholder="<?= $captcha['question']; ?>" name="captcha" />
        <div class="submit_group">
            <input class="add_fieldset" type="button" value="Добавить поле"/>
            <input type="submit" value="Отправить"/>
        </div>
    </form>
    <!-- end photo uploader -->
    <?php if (isset($photos) && is_array($photos)): ?>
        <ul class="photo_list ">
            <?php foreach ($photos as $photo):
                $uploadDir = \Core\Application::instance()->getConfig()->get('uploadDir');
                $path = $uploadDir . '/' .$photo->name;
                $size = is_file($path) ? round(filesize($path)/1024) : false; // в общем-то это для представления.
                $urlPrev = '/image/preview/?id=' . $photo->id;
                $url = '/image/?id=' . $photo->id;
                ?>
                <li>
                    <a class="photo" style="background-image: url('<?= $urlPrev; ?>')" href="<?= $url; ?>" target="_blank" title="<?= $photo->title; ?>">
                        <span class="size"><?= $size; ?>кб</span>
                        <span title="<?= $photo->name_origin; ?>" class="name_origin"><?= $photo->name_origin; ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <? endif; ?>
</section>