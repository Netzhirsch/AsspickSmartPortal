$(document).ready(function () {

    expandAllOnClick();
    collapseAllOnClick();

    $('[class^="level-"]:not(.file)').on('click',function (){

        let id = $(this).data('id');
        $(this).find('i').toggleClass('fa-folder-open').toggleClass('fa-folder');
        updateChildren(id,$(this).find('i').hasClass('fa-folder-open'));

    });
});

function expandAllOnClick() {
    $('#expand-all').click(function () {
        $('table tbody tr').removeClass('hidden closed');
        $('table tbody tr i').addClass('fa-folder-open').removeClass('fa-folder');
    });
}

function collapseAllOnClick() {
    $('#collapse-all').click(function () {
        $('tbody tr').addClass('closed');
        $('tbody tr:not(.level-0)').addClass('hidden');
        $('tbody tr i').addClass('fa-folder').removeClass('fa-folder-open');
    });
}

function updateChildren(id,isVisible) {
    $('[data-parent="'+id+'"]').each(function (){
        let id = $(this).data('id');

        $(this).toggleClass('hidden',!isVisible);

        let nextVisibility = isVisible && $(this).find('i').hasClass('fa-folder-open');

        if (!$(this).hasClass('file'))
            updateChildren(id,nextVisibility);
    })

}
