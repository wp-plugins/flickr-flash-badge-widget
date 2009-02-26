<?php
/*
Plugin Name: Flickr Badge Widget
Description: Display your Flickr photos with the Flickr Badge
Author: Erik Rasmussen
Version: 1.1
Author URI: http://www.erik-rasmussen.com/blog/2006/09/14/flash-flickr-badge-widget-for-wordpress/

Copyright 2006  Erik Rasmussen (email : rasmussenerik@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
define('FBW_UPDATE_INTERVAL', 120);  // seconds

function flickr_badge_widget_init() {
	if ( !function_exists('register_sidebar_widget') )
		return;

	function flickr_badge_widget($args) {
		extract($args);

		$options = get_option('flickr_badge_widget');
		$fbw_title = $options['fbw_title'];
		$fbw_flickr_id = $options['fbw_flickr_id'];
		$fbw_tags = $options['fbw_tags'];
		$fbw_rows = $options['fbw_rows'];
		$fbw_cols = $options['fbw_cols'];
		$fbw_size = $options['fbw_size'];
		$fbw_transition = $options['fbw_transition'];

    $magisterLudi = $options['fbw_magisterLudi'];

    $lastUpdate = $options['fbw_last_update'];
    $now = time();
    if($lastUpdate + FBW_UPDATE_INTERVAL < $now || is_null($magisterLudi))
    {
      $magisterLudi = get_magisterLudi();
      $options['fbw_magisterLudi'] = $magisterLudi;
      $options['fbw_last_update'] = $now;
      echo '<!-- updated magisterLudi! -->';
			update_option('flickr_badge_widget', $options);
    }
    else
      echo '<!-- seconds since magisterLudi update: ' . ($now - $lastUpdate) . ' -->';

		echo $before_widget . $before_title . $fbw_title . $after_title;
		$url_parts = parse_url(get_bloginfo('home'));
		echo '<div style="margin-top:5px;margin-bottom:5px;text-align:left;"><!-- Author: Erik Rasmussen http://www.erik-rasmussen.com/blog/2006/09/14/flash-flickr-badge-widget-for-wordpress/ -->';
		output_fbw($fbw_flickr_id,$fbw_tags,$fbw_rows,$fbw_cols,$fbw_size,$fbw_transition,$magisterLudi);
		echo '<br/><small>By <a href="http://www.erik-rasmussen.com/blog/2006/09/14/flash-flickr-badge-widget-for-wordpress/">Erik Rasmussen</a></small></div>';
		echo $after_widget;
	}

	function flickr_badge_widget_control() {
		$options = get_option('flickr_badge_widget');
		if ( !is_array($options) )
			$options = array('fbw_title'=>'Flickr' ,'fbw_flickr_id'=>'','fbw_tags'=>'','fbw_rows'=>'4','fbw_cols'=>'3','fbw_size'=>37,'fbw_transition'=>'BTS');
		if ( $_POST['fbw-submit'] ) {
			$options['fbw_title'] = strip_tags(stripslashes($_POST['fbw_title']));
			$options['fbw_flickr_id'] = strip_tags(stripslashes($_POST['fbw_flickr_id']));
			$options['fbw_tags'] = $_POST['fbw_tags'];
			$rows = (int) $_POST['fbw_rows']; 
            		if ( $number > 10) $number = 10; 
            		if ( $number < 1)  $number = 1; 
            		$options['fbw_rows'] = $rows; 
			$cols = (int) $_POST['fbw_cols']; 
            		if ( $number > 10) $number = 10; 
            		if ( $number < 1)  $number = 1; 
            		$options['fbw_cols'] = $cols; 
			$size = (int) $_POST['fbw_size']; 
            		if ( $number > 60) $number = 60; 
            		if ( $number < 30)  $number = 30; 
            		$options['fbw_size'] = $size; 
			$options['fbw_transition'] = $_POST['fbw_transition'];
			update_option('flickr_badge_widget', $options);
		}

		$fbw_title = htmlspecialchars($options['fbw_title'], ENT_QUOTES);
		$fbw_flickr_id = htmlspecialchars($options['fbw_flickr_id'], ENT_QUOTES);
		$fbw_tags = $options['fbw_tags']; 
		$rows = $options['fbw_rows']; 
		$cols = $options['fbw_cols']; 
		$size = $options['fbw_size']; 
		$transition = $options['fbw_transition']; 
		
    ?>
    <style type="text/css">
      .fbw-row {
        clear:both;
      }
      .fbw-row label {
        width:200px;
        text-align:right;
        float:left;
        padding-top:7px;
      }
      .fbw-row input {
        width:150px;
        float:left;
        margin-left:15px;
      }
      .fbw-row select {
        float:left;
        margin-left:15px;
      }
    </style>
    <?php
		echo '<div class="fbw-row"><label for="fbw-title">Title:</label> <input id="fbw-title" name="fbw_title" type="text" value="'.$fbw_title.'" /></div>';
		echo '<div class="fbw-row"><label for="fbw-flickr_id">Flickr ID*:</label> <input id="fbw-flickr_id" name="fbw_flickr_id" type="text" value="'.$fbw_flickr_id.'" /></div>';
		echo '<div class="fbw-row"><label for="fbw-tags">Tags:</label> <input id="fbw-tags" name="fbw_tags" type="text" value="'.$fbw_tags.'" /></div>';
?><div class="fbw-row"><label for="fbw-rows">Number of rows:</label> <select id="fbw_rows" name="fbw_rows" value="<?php echo $rows; ?>"><?php for ( $i = 1; $i <= 10; ++$i ) echo "<option value='$i' ".($rows==$i ? "selected='selected'" : '').">$i</option>"; ?></select></div>
<div class="fbw-row"><label for="fbw-cols">Number of columns:</label> <select id="fbw_cols" name="fbw_cols" value="<?php echo $cols; ?>"><?php for ( $i = 1; $i <= 10; ++$i ) echo "<option value='$i' ".($cols==$i ? "selected='selected'" : '').">$i</option>"; ?></select></div>
<div class="fbw-row"><label for="fbw-size">Size of thumbnail squares:</label> <select id="fbw_size" name="fbw_size" value="<?php echo $size; ?>"><?php for ( $i = 30; $i <= 60; ++$i ) echo "<option value='$i' ".($size==$i ? "selected='selected'" : '').">$i</option>"; ?></select></div>
<div class="fbw-row"><label for="fbw-transition">Transition:</label> <select id="fbw_transition" name="fbw_transition" value="<?php echo $transition; ?>"><?php echo "<option value='BTS' ".($transition=='BTS' ? "selected='selected'" : '').">Big Then Small</option><option value='FAD' ".($transition=='FAD' ? "selected='selected'" : '').">Fade</option>"; ?></select></div><?php
		echo '<input type="hidden" id="fbw-submit" name="fbw-submit" value="1" />';
		echo '<div class="fbw-row" style="text-align:center;padding-top:15px;">*Your Flickr ID should be the value in your URL when you are viewing your Flickr photos.  (e.g. 23585397@N00)<br/><br/>By <a href="http://www.erik-rasmussen.com/blog/2006/09/14/flash-flickr-badge-widget-for-wordpress/">Erik Rasmussen</a></div>';
	}
	
	register_sidebar_widget('Flickr Badge', 'flickr_badge_widget');
	register_widget_control('Flickr Badge', 'flickr_badge_widget_control', 400, 300);
}

function output_fbw($fbw_flickr_id,$fbw_tags,$fbw_rows,$fbw_cols,$fbw_size,$fbw_transition,$magisterLudi) {
  echo '<script type="text/javascript" src="' . get_settings('siteurl') . '/wp-content/plugins/flickr-flash-badge-widget/flickr-badge.js"></script>';
  ?>
  <script type="text/javascript">
    <?php
      echo "flickrBadge({userId:'".$fbw_flickr_id."',rows:$fbw_rows,cols:$fbw_cols,size:$fbw_size,transition:'".($fbw_transition=='BTS' ? "bigThenSmall" : "fade")."',tags:'".$fbw_tags."',magisterLudi:'".$magisterLudi."'});";
    ?>
  </script>
  <?php
}
require( ABSPATH . WPINC . '/class-snoopy.php');
function get_magisterLudi()
{
  $client = new Snoopy();
  $client->agent = 'WordPress/' . $wp_version;
  $client->read_timeout = 2;
  $client->use_gzip = true;
  @$client->fetch('http://www.flickr.com/apps/badge/badge_iframe.gne');
  if($client->status >= 200 && $client->status < 300)
  {
    if(preg_match("/(magisterLudi=)(\S+)(';)/", $client->results, $matches))
    {
      return $matches[2];
    }
    else
    {
      echo 'Failed to parse badge info from Flickr\n';
    }
  }
  else
  {
    echo 'Failed to fetch badge info from Flickr.\n';
  }
}
add_action('plugins_loaded', 'flickr_badge_widget_init');
?>
