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

global $USER;

require_login();

$context = context_user::instance($USER->id);
require_capability('local/mymedia:view', $context);

$PAGE->set_context(context_system::instance());
$header =  fullname($USER) . ": " . get_string('heading_mymedia', 'local_mymedia');

$PAGE->set_url('/local/mymedia/mymedia.php');
$PAGE->set_pagetype('mymedia-index');
$PAGE->set_pagelayout('standard');
$PAGE->set_title($header);
$PAGE->set_heading($header);

$pageclass = 'kaltura-mediagallery-body';
$PAGE->add_body_class($pageclass);

echo $OUTPUT->header();



// Request the launch content with an iframe tag.
$attr = array(
    'href' => 'simple_uploader.php',
	'class' => 'btn btn-secondary',
	'style' => 'float: right; margin-top: -1em; margin-bottom: 0.5em',
    'target' => 'contentframe',
);
echo html_writer::tag('a', 'Trouble Uploading?', $attr);


// Request the launch content with an iframe tag.
$attr = array(
    'href' => 'get_h5p_link.php',
	'class' => 'btn btn-secondary',
	'style' => 'float: right; margin-top: -1em; margin-right: 1em; margin-bottom: 0.5em',
    'target' => 'contentframe',
);
echo html_writer::tag('a', 'URLs for H5P', $attr);

// Request the launch content with an iframe tag.
$attr = array(
    'href' => 'get_zoom_url.php',
	'class' => 'btn btn-secondary',
	'style' => 'float: right; margin-top: -1em; margin-right: 1em; margin-bottom: 0.5em',
    'target' => 'contentframe',
);
echo html_writer::tag('a', 'Import Zoom Recordings', $attr);

$attr = array(
    'href' => 'zoom_license.php',
	'class' => 'btn btn-secondary',
	'style' => 'float: right; margin-top: -1em; margin-right: 1em; margin-bottom: 0.5em',
    'target' => 'contentframe',
);
echo html_writer::tag('a', 'Zoom Licensing', $attr);

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
