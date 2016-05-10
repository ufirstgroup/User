;(function ($, window, document) {
	"use strict";

	$('.navbar-custom-menu .user-header').on('click', function (event) {
		window.location.href = "/"+Asgard.backendUrl+"/user/profile/edit"
	})

})(jQuery, window, document);
