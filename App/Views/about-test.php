<section class="std_container">
    <p align="center" style="margin-bottom: 0.21cm; line-height: 150%; page-break-after: avoid"><a name="_GoBack"></a>
        <font face="Times New Roman, serif"><font size="4" style="font-size: 16pt"><b>ТЕСТОВОЕ
                    ЗАДАНИЕ</b></font></font></p>
    <p align="center" style="margin-bottom: 0.21cm; line-height: 150%; page-break-after: avoid">
        <font face="Times New Roman, serif"><font size="4" style="font-size: 14pt"><b>(на
                    должность Web-программиста)</b></font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><br/>

    </p>
    <p style="margin-bottom: 0.21cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                                  style="font-size: 12pt"><b>ОСНОВНОЕ
                    ТРЕБОВАНИЕ:</b></font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                               style="font-size: 12pt">Сделать
                веб-страницу с формой для загрузки
                картинок на сервер и скрипт, загружающий
                картинки с этой формы.</font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><br/>

    </p>
    <p style="margin-bottom: 0.21cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                                  style="font-size: 12pt"><b>КЛИЕНТСКАЯ
                    ЧАСТЬ</b></font></font><font face="Times New Roman, serif"><font size="3"
                                                                                     style="font-size: 12pt">:</font></font>
    </p>
    <p style="margin-bottom: 0cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                               style="font-size: 12pt">-
                посетитель самостоятельно может выбрать
                количество картинок, которые он может
                загрузить за одну отправку формы
                (возможность добавления полей ввода на
                JavaScript)</font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                               style="font-size: 12pt">-
                каждый файл имеет обязательное текстовое
                поле &quot;название&quot; (не забываем, что
                поля добавляются посетителем)</font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                               style="font-size: 12pt">-
                после загрузки файлов, страница
                дополняется таблицей с уже загруженными
                файлами, с информацией о размере каждого
                на диске, маленькой картинкой 100х100 и с
                ссылкой на большой файл</font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                               style="font-size: 12pt">-
                отправка файлов и вывод результата в
                таблицу происходит без перезагрузки
                страницы</font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                               style="font-size: 12pt">-
                крайне приветствуется приятный внешний
                вид (простые стили без обилия CSS)</font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><br/>

    </p>
    <p style="margin-bottom: 0.21cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                                  style="font-size: 12pt"><b>СЕРВЕРНАЯ
                    ЧАСТЬ:</b></font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                               style="font-size: 12pt">-
                скрипт записывает файлы в папку на
                сервере</font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                               style="font-size: 12pt">-
                делает запись в базе данных MySQL с
                информацией о каждом файле (название,
                имя файла на диске и др.)</font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                               style="font-size: 12pt">-
                если какой-либо файл имеет размер больше
                500х500 точек, то скрипт уменьшает эту
                картинку и записывает на диск уменьшенную</font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                               style="font-size: 12pt">-
                скрипт отправляет администратору e-mail
                уведомление о том, что загружены новые
                картинки с ссылкой на их просмотр</font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><a name="__DdeLink__143_1941534206"></a>
        <font face="Times New Roman, serif"><font size="3" style="font-size: 12pt">-
                таблицы в БД должны сами создаваться
                при первом запуске</font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                               style="font-size: 12pt">-
                продумать как следить за уникальностью
                имен файлов</font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><br/>

    </p>
    <p style="margin-bottom: 0.21cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                                  style="font-size: 12pt"><b>ТАКЖЕ
                    НЕОБХОДИМО:</b></font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                               style="font-size: 12pt">-
                продумать и сделать защиту от
                злоумышленников, кратко описать от чего
                она защищает и как работает</font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                               style="font-size: 12pt">-
                продумать и сделать сообщения об ошибках,
                в случае неудачной загрузки картинок</font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><br/>

    </p>
    <p style="margin-bottom: 0.21cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                                  style="font-size: 12pt"><b>ВАЖНО:</b></font></font>
    </p>
    <p style="margin-bottom: 0cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                               style="font-size: 12pt">-
                не использовать сторонние библиотеки
                – все коды должны быть написаны вами
                от и до</font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                               style="font-size: 12pt">-
                кодировка win (русские символы должны
                корректно обрабатываться)</font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><a name="__DdeLink__160_1607778959"></a><a
                name="__DdeLink__145_1941534206"></a>
        <font face="Times New Roman, serif"><font size="3" style="font-size: 12pt">-
                скрипт должен запускаться по любому
                пути – в корне, в подпапке и т.д.</font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                               style="font-size: 12pt"><b>-
                    максимально подробные комменты
                    приветствуются</b></font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                               style="font-size: 12pt"><b>-
                    проведите тест формы на разных картинках
                    и в разных браузерах</b></font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><br/>

    </p>
    <p style="margin-bottom: 0cm; line-height: 100%"><br/>

    </p>
    <p style="margin-bottom: 0cm; line-height: 100%"><font face="Times New Roman, serif"><font size="3"
                                                                                               style="font-size: 12pt">Если
                что-то не будет получаться или покажется
                вам сложноватым, то можете это пропустить.
                Нам просто нужно посмотреть, как вы
                справитесь с этой задачей. Исходники
                отправьте в zip архиве на e-mail: </font></font><font color="#004dbb"><font
                    face="Times New Roman, serif"><font size="3" style="font-size: 12pt"><u><b><span
                                    style="background: #fafafa">hr@xcompany_test.ru</span></b></u></font></font></font><font
                face="Times New Roman, serif"><font size="3" style="font-size: 12pt">
            </font></font><font face="Times New Roman, serif"><font size="3" style="font-size: 12pt"><span
                        style="background: #fafafa">(копия
на </span></font></font><font color="#004dbb"><font face="Times New Roman, serif"><font size="3"
                                                                                        style="font-size: 12pt"><u><b><span
                                    style="background: #fafafa">minsk@xcompany_test.ru</span></b></u></font></font></font><font
                face="Times New Roman, serif"><font size="3" style="font-size: 12pt"><span style="background: #fafafa">
и </span></font></font><font color="#004dbb"><font face="Times New Roman, serif"><font size="3" style="font-size: 12pt"><u><b>info@xcompany_test.ru</b></u></font></font></font><font
                face="Times New Roman, serif"><font size="3" style="font-size: 12pt">).
                А ещё можете выложить на какой-нибудь
                бесплатный хостинг, чтобы можно было
                сразу протестить.</font></font></p>
    <p style="margin-bottom: 0cm; line-height: 100%"><br/>

    </p>
</section>