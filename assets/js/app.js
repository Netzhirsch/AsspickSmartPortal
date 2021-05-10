import './../less/global.less';
import './../less/messages.less';

import './tabs.js';
//import '@fortawesome/fontawesome-pro/js/all';
import '@fortawesome/fontawesome-pro/css/all.min.css';

$('#topbar .toggle-nav').click(function() {
	$('#mobile-navigation').addClass('visible');
});
$('#mobile-navigation .close').click(function() {
	$('#mobile-navigation').removeClass('visible');
});