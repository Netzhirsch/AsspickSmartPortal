require("../../node_modules/dropzone/dist/min/dropzone.min.css");
require('../../node_modules/dropzone/dist/dropzone.js');
Dropzone.autoDiscover = false;
Dropzone.options.myAwesomeDropzone = false;

$(document).ready(function () {
    let dropzone = $('.dropzone');
    let url = dropzone.data('src');
    let acceptedFiles = dropzone.data('acceptedFiles');
    let maxFiles = dropzone.data('maxFiles');
    let newUid = false;
    dropzone.dropzone({
        url: url,
        maxFiles:maxFiles,
        acceptedFiles:acceptedFiles,
        addRemoveLinks:true,
        dictDefaultMessage: 'Bilder hier reinziehen oder hier klicken',
        dictRemoveFile: '<span class="btn red löschen">Löschen</span>',
        init: function () {
            this.on("success", function (response, uid) {
                if (!newUid) {
                    url = url + '/' + uid.uid;
                    this.options.url = url;
                    $("input[id$='tmpFolder']").val(uid.uid);
                }
                newUid = true;
            })
        }
    });
})