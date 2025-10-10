$(function () {
    const $dropZone = $('#drop-zone');
    const $fileInput = $('#file-input');
    let filesList = [];

    const allowedTypes = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];

    $dropZone.on('click', function (e) {
        if (e.target.id === 'drop-zone' || e.target.tagName === 'P') {
            $fileInput.trigger('click');
        }
    });

    $fileInput.on('change', function (e) {
        handleFiles(e.target.files);
        $fileInput.val('');
    });

    $dropZone.on('dragover', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $dropZone.addClass('hover');
    });

    $dropZone.on('dragleave drop', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $dropZone.removeClass('hover');
    });

    $dropZone.on('drop', function (e) {
        const files = e.originalEvent.dataTransfer.files;
        handleFiles(files);
    });

    function handleFiles(files) {
        $.each(files, function (i, file) {
            if (!isAllowed(file)) {
                alert(`File "${file.name}" is not allowed. Only PDF, Word, or images are accepted.`);
                return;
            }

            filesList.push(file);
            const reader = new FileReader();
            reader.onload = function (e) {
                const $item = $('<div class="file-item"></div>');
                if (file.type.startsWith('image/')) {
                    $item.append(`<img src="${e.target.result}" alt="${file.name}">`);
                } else {
                    $item.append(`<span>📄 ${file.name}</span>`);
                }
                $item.append(`<span class="remove-file">&times;</span>`);
                $item.find('.remove-file').on('click', function (ev) {
                    ev.stopPropagation();
                    const index = filesList.indexOf(file);
                    if (index > -1) filesList.splice(index, 1);
                    $item.remove();
                });

                $dropZone.append($item);
            };

            if (file.type.startsWith('image/')) {
                reader.readAsDataURL(file);
            } else {
                reader.onload();
            }
        });
    }

    function isAllowed(file) {
        return (
            file.type.startsWith('image/') ||
            allowedTypes.includes(file.type)
        );
    }
});