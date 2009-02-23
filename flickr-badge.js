var FlickrBadge = Class.create();
FlickrBadge.prototype =
{
	initialize: function(options)
	{
		this.options =
	  {
		  host: 'http://www.flickr.com',
		  userId: '',             // flickr user id
		  swapInterval: 3,        // time (in seconds) between picture changes
		  loadInterval: 120,      // time (in seconds) between checks for new pictures
		  transition: 'fade',     // options are 'bigThenSmall' or anything else to cause a fade-in effect
      tags: '',               // any tags to restrict which photos are shown
		  cols: 4,                // number of columns
		  rows: 5,                // number of rows
		  size: 55,               // dimensions of each square picture
		  border: 1               // border between pictures
	  };
		if(options)
			Object.extend(this.options, options);

		var width = this.options.cols * this.options.size + ((this.options.cols - 1) * this.options.border);
		var height = this.options.rows * this.options.size + ((this.options.rows - 1) * this.options.border);
		var params =
		{
			host: this.options.host,
			cols: this.options.cols,
			rows: this.options.rows,
			wh: this.options.size,
			swapInterv: this.options.swapInterval,
			loadInterv: this.options.loadInterval,
			transition: this.options.transition,
			nsid: this.options.userId,
			scope: 0,
			favorites: 0,
			tags: this.options.tags,
			tag_mode: 'all',
			group_id: '',
			text: '',
			set_id: '',
			context: '',
			magisterLudi: this.options.magisterLudi,
			auth_token: ''
		};
		var url = this.options.host + '/apps/badge/flashbadge.swf?' + $H(params).toQueryString();
		var html = '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" ' +
		           'codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" '+
		           'WIDTH="' + width + '" HEIGHT="' + height + '" id="flickrBadge" ALIGN="">'+
		           '<PARAM NAME="movie" VALUE="' + url + '"/>'+
		           '<PARAM NAME="quality" VALUE="high"/>'+
		           '<EMBED src="' + url + '" quality="high" WIDTH="' + width + '" '+
		           'HEIGHT="' + height + '" NAME="flickrBadge" ALIGN="" TYPE="application/x-shockwave-flash" '+
		           'PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED></OBJECT>';
		document.write(html);
	}
}
