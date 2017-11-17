document.addEventListener('DOMContentLoaded', function () {

    function PhotoUploader() {
        this.obForm = null;
        this.obBtnAddField = null;
        this.config = {
            // id формы
            "formId": "upload_photos",
            // class кнопки "Добавить поле"
            "classBtnAdd": "add_fieldset"
        };

        /**
         * Вешает событие onclick на .fake_input_file
         */
        this.refreshFakeInutsFiles = function () {
            var _self = this;
            var btnUploadFile = _self.obForm.getElementsByClassName('btn_file_upload');

            for (var i = 0; i < btnUploadFile.length; i++) {
                // установка события на .fake_input_file
                btnUploadFile[i].onclick = function (e) {
                    var btnUploadFile = this;
                    var originInput = this.closest('.wr_input_file').querySelector('input[type="file"]');
                    originInput.value = null;
                    // при открытии окна выбора файла срабатывает change
                    originInput.addEventListener('change', function () {
                        if (this.value) {
                            btnUploadFile.innerText = this.value;
                        }
                    });
                    originInput.click();
                    return false;
                }
            }
        };

        /**
         * Добавляет новые поля.
         */
        this.addFileField = function () {
            var _self = this;
            var fieldsets = this.obForm.getElementsByTagName('fieldset');

            if (fieldsets.length) {
                var lastField = fieldsets[fieldsets.length - 1];
                var newField = lastField.cloneNode(true);

                var legend = newField.querySelector('legend');
                var textField = newField.querySelector('input[type="text"]');
                var fileField = newField.querySelector('input[type="file"]');
                var btn = newField.querySelector('.btn_file_upload');

                if (!(textField !== null && fileField !== null && legend !== null && btn !== null)) {
                    throw new Error('Ошибка при клонировании fieldset.')
                }

                // Подготовить параметры..
                legend.innerText = 'Фотография ' + (fieldsets.length + 1);
                textField.value = null;
                fileField.value = null;
                textField.setAttribute('name', 'file[' + fieldsets.length + '][name]');
                fileField.setAttribute('name', 'file[' + fieldsets.length + '][file]');
                btn.innerText = 'Прикрепите файл';

                // Вставка
                if (this.obForm.lastChild === lastField) {
                    this.obForm.appendChild(newField);
                } else {
                    this.obForm.insertBefore(newField, lastField.nextSibling);
                }
                _self.refreshFakeInutsFiles();
            }
        };

        this.send = function (e) {
            var _self = this;
            var formData = new FormData(this.obForm);
            var request = new XMLHttpRequest();
            request.open('POST', this.obForm.action);
            request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            request.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var container = _self.obForm.closest('.wr_main_content');
                    if (container && this.response) {
                        container.innerHTML = this.response;
                        _self.init(); // обновить все.
                        document.querySelector('.preloader').style.display = 'none';
                    }

                }
            };
            request.send(formData);
            e.preventDefault();
        };

        this.init = function () {
            // Запуск.
            try {
                var _self = this;
                this.obForm = document.getElementById(this.config.formId);
                this.obBtnAddField = this.obForm.querySelector('.add_fieldset');
                this.obBtnAddField.addEventListener('click', function () {
                    _self.addFileField();
                });
                this.obForm.addEventListener('submit', function(e) {
                    document.querySelector('.preloader').style.display = 'block';
                    _self.send(e);
                });

                this.refreshFakeInutsFiles();
            } catch (exception) {
                console.log(exception.message);
            }
        };
    }

    (new PhotoUploader()).init();

});