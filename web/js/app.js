$(window).bind('keydown', function (event) {
	if (event.ctrlKey || event.metaKey) {
		console.log(String.fromCharCode(event.which).toLowerCase());
		switch (String.fromCharCode(event.which).toLowerCase()) {
			case 's':
				if ($('[data-command=\'save\']').length === 1) {
					event.preventDefault();
					$('[data-command=\'save\']').trigger('click');
				}
				break;
			case 'n':
				if ($('[data-command=\'new\']').length === 1) {
					event.preventDefault();
					$('[data-command=\'new\']').trigger('click');
				}
				break;
		}
	}

	if (event.keyCode === 27 && $('[data-command=\'escape\']').length) {
		event.preventDefault();
		$('[data-command=\'escape\']').trigger('click');
	}
});