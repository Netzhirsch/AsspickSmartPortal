require("../../node_modules/dropzone/dist/min/dropzone.min.css");
require('../../node_modules/dropzone/dist/dropzone.js');
Dropzone.autoDiscover = false;
Dropzone.options.myAwesomeDropzone = false;

$(document).ready(function () {
    let dropzone = $('.dropzone');
    let url = dropzone.data('src');
    let acceptedFiles = dropzone.data('accepted-files');
    let maxFiles = dropzone.data('maxFiles');
    let dictDefaultMessage = dropzone.data('dict-default-message');
    let newUid = false;
    let dropzoneFiles = $('#dropzone-files li');
    dropzone.dropzone({
        url: url,
        maxFiles:maxFiles,
        acceptedFiles:acceptedFiles,
        parallelUploads:1,
        addRemoveLinks:true,
        dictDefaultMessage: dictDefaultMessage,
        dictRemoveFile: '<span class="btn red löschen">Löschen</span>',
        init: function () {
            this.on("success", function (response, uid) {
                if (!newUid) {
                    url = url + '/' + uid.uid;
                    this.options.url = url;
                    $("input[id$='tmpFolder']").val(uid.uid);
                }
                newUid = true;
            });
            this.on("removedfile", function(file) {
                if (file.status === "server") {
                    dropzoneFiles.each(function (){
                        if ($(this).data('name') === file.name) {
                            $(this).find('input').val($(this).data('file-id'));
                        }
                    });
                }
            });
        }
    });

    if ($('#myAwesomeDropzone').length > 0) {
        let myAwesomeDropzone = Dropzone.forElement("#myAwesomeDropzone");
        dropzoneFiles.each(function (){
            let existingFiles =
                {
                    name: $(this).data('name'),
                    size: $(this).data('size'),
                    type: 'image/*',
                    status: 'server',
                    accepted: true,

                };

            myAwesomeDropzone.emit("addedfile", existingFiles);
            myAwesomeDropzone.emit("complete", existingFiles);
            myAwesomeDropzone.files.push(existingFiles);
            myAwesomeDropzone._updateMaxFilesReachedClass();
            myAwesomeDropzone.emit("thumbnail", existingFiles, $(this).data('thumbnail'));
        });
    }
})