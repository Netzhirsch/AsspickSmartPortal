require('../less/tabs.less');
$(function(){
    $('header.tabs .tab').click(function () {
        let tabName = $(this).data('tab');
        if (tabName.length > 0) {
            $(this).siblings('.tab').removeClass('active');
            $(this).addClass('active');
            let tab = $('.content.tab[data-tab="'+tabName+'"]');
            tab.siblings().removeClass('active');
            tab.addClass('active');
        }
    });
});