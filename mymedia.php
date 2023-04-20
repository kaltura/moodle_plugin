
<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * My Media main viewing page.
 *
 * @package    local_mymedia
 * @author     Remote-Learner.net Inc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2014 Remote Learner.net Inc http://www.remote-learner.net
 */


require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
//require_once($CFG->dirroot.'/lib/navigationlib.php');

global $USER, $SITE, $navigation;

require_login();

$context = context_user::instance($USER->id);
require_capability('local/mymedia:view', $context);

$PAGE->set_context(context_system::instance());
$header =  fullname($USER) . ": " . get_string('heading_mymedia', 'local_mymedia');

$PAGE->set_url('/local/mymedia/mymedia.php');
$PAGE->set_pagetype('mymedia-index');
$PAGE->set_pagelayout('report');
$PAGE->set_title($header);
$PAGE->set_heading($header);
$PAGE->requires->css('/local/mymedia/mymedia.css');
$pageclass = 'kaltura-mediagallery-body';
$PAGE->add_body_class($pageclass);

$PAGE->add_body_class($pageclass);

echo $OUTPUT->header();


?>
<div class="secondary-navigation d-print-none">
  <nav class="moremenu navigation observed">
    <ul role="menubar" id ="moremenu" class="nav more-nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link nav_border_bottom" aria-current="page" target="contentframe" href="simple_uploader.php">Trouble uploading?</a>
      </li>
      <li class="nav-item " forceintomoremenu ="true">
        <a class="nav-link nav_border_bottom" target="contentframe" href="get_h5p_link.php">URLs for H5P</a>
      </li>
      <li class="nav-item" forceintomoremenu ="true">
        <?php
        //Quick hack for CCE Community, will need to think how it should work for them
        error_log(print_r($SITE->shortname,TRUE));
        if($SITE->shortname != "CCE Community" && $SITE->shortname != "UR Community"){
        ?>
        <a class="nav-link nav_border_bottom" target="contentframe" href="get_zoom_url.php">Import Zoom Recordings</a>
      <?php
        }
        ?>
      </li>
      <li class="nav-item dropdown moremen">
        <a class="nav-link dropdown-toggle nav_border_bottom" data-toggle="dropdown" href="#" role="button" aria-expanded="false">More</a>
        <ul class="dropdown-menu dropdown-bdr">
        <a class="dropdown-item " target="contentframe" href="get_h5p_link.php">URLs for H5P</a>
        <?php
        //Quick hack for CCE Community, will need to think how it should work for them
        error_log(print_r($SITE->shortname,TRUE));
        if($SITE->shortname != "CCE Community" && $SITE->shortname != "UR Community"){
        ?>
        <a class="dropdown-item" target="contentframe" href="get_zoom_url.php">Import Zoom Recordings</a>
      <?php
        }
        ?>
        </ul>
      </li>

    </ul>
  </nav>
</div>

<script>
  const navLinks = document.querySelectorAll('.nav_border_bottom');

navLinks.forEach(link => {
  link.addEventListener('click', function() {
    // Remove the active class from all other nav-links
    navLinks.forEach(link => {
      link.classList.remove('active');
    });

    // Add the active class to the clicked nav-link
    this.classList.add('active');
  });
});

</script>


<?php
 
// Request the launch content with an iframe tag.
$attr = array(
    'id' => 'contentframe',
    'name' => 'contentframe',
    'height' => '600px',
    'width' => '100%',
    'allowfullscreen' => 'true',
    'src' => 'lti_launch.php',
    'allow' => 'autoplay *; fullscreen *; encrypted-media *; camera *; microphone *;',
);
echo html_writer::tag('iframe', '', $attr);

// Require a YUI module to make the iframe tag be as large as possible.
$params = array(
    'bodyclass' => $pageclass,
    'lastheight' => null,
    'padding' => 15
);
$PAGE->requires->yui_module('moodle-local_kaltura-lticontainer', 'M.local_kaltura.init', array($params), null, true);
$PAGE->requires->js(new moodle_url('/local/kaltura/js/kea_resize.js'));

echo $OUTPUT->footer();
