function flickrBadge(optionsParam)
{
  var options =
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
  if(optionsParam)
  {
    for (var property in optionsParam)
      options[property] = optionsParam[property];
  }

  var width = options.cols * options.size + ((options.cols - 1) * options.border);
  var height = options.rows * options.size + ((options.rows - 1) * options.border);
  var params =
  [
    'host='+options.host,
    'cols='+options.cols,
    'rows='+options.rows,
    'wh='+options.size,
    'swapInterv='+options.swapInterval,
    'loadInterv='+options.loadInterval,
    'transition='+options.transition,
    'nsid='+options.userId,
    'scope=0',
    'favorites=0',
    'tags='+options.tags,
    'tag_mode=all',
    'group_id=',
    'text=',
    'set_id=',
    'context=',
    'magisterLudi='+options.magisterLudi,
    'auth_token='
  ];
  var url = options.host + '/apps/badge/flashbadge.swf?' + params.join('&');
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
