var fs = require('fs'),
	args = require('system').args,
	page = require('webpage').create();

page.content = fs.read(args[1]);

page.viewportSize = {
	width: 1024,
	height: 1024
};

page.paperSize = {
	format: 'A4',
	orientation: 'portrait',
	margin: '0cm'
};

page.onLoadFinished = function (status) {
	document.body.bgColor = 'white';
    page.render(args[1]);
	phantom.exit();
};