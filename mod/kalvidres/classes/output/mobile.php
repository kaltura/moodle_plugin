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
 * Kaltura local library of functions.
 *
 * @package    local_kaltura
 * @author     Remote-Learner.net Inc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2014 Remote Learner.net Inc http://www.remote-learner.net
 */

namespace mod_kalvidres\output;
defined('MOODLE_INTERNAL') || die();

require_once("$CFG->dirroot/lib/externallib.php");
require_once("$CFG->dirroot/local/kaltura/locallib.php");

class mobile {

    public static function mobile_view_activity($args) {
        global $DB, $OUTPUT;

        $args = (object) $args;

        $cmid = $args->cmid;

        // Capabilities check.
        $cm = get_coursemodule_from_id('kalvidres', $cmid);
        $context = \context_module::instance($cm->id);
        require_login($cm->course, false, $cm, true, true);
        require_capability('mod/kalvidres:view', $context);
        $course = get_course($cm->course);

        // Set some variables we are going to be using.
        $kalvidres = $DB->get_record('kalvidres', ['id' => $cm->instance], '*', MUST_EXIST);
        $kalvidres->name = format_string($kalvidres->name);
        list($kalvidres->intro, $kalvidres->introformat) = external_format_text($kalvidres->intro,
                $kalvidres->introformat, $context->id, 'mod_kalvidres', 'intro');

        $token = required_param('wstoken', PARAM_RAW);

        // Update log and set completion.
        $event = \mod_kalvidres\event\video_resource_viewed::create(array(
                'objectid' => $kalvidres->id,
                'context' => $context
        ));
        $event->trigger();
        $completion = new \completion_info($course);
        $completion->set_module_viewed($cm);

        $ltiparams = [
            'courseid' => $cm->course,
            'cmid' => $cm->id,
            'height' => $kalvidres->height,
            'width' => $kalvidres->width,
            'withblocks' => 0,
            // Force to known default player (will be swapped to configured url in mobile_launch).
            'source' => 'https://' . KALTURA_URI_TOKEN . '/browseandembed/index/media/entryid/' . $kalvidres->entry_id,
            'token' => $token,
        ];
        $ltiurl = new \moodle_url('/mod/kalvidres/mobile_launch.php', $ltiparams);

        $data = [
            'kalvidres' => $kalvidres,
            'iframe' => self::display_iframe($ltiurl->out(false)),
            'cmid' => $cm->id,
        ];

        return [
            'templates'  => [
                [
                    'id' => 'main',
                    'html' => $OUTPUT->render_from_template('mod_kalvidres/mobile_view_activity', $data),
                ],
            ],
            'javascript' => '',
            'otherdata' => '',
        ];

    }

    /**
     * This function displays the iframe markup.
     * @param string $url iframe src url
     * @return string HTML markup.
     */
    public static function display_iframe($url) {
        $attr = [
            'id' => 'contentframe',
            'class' => 'kaltura-player-iframe',
            'src' => $url,
            'allowfullscreen' => 'true',
            'allow' => 'autoplay *; fullscreen *; encrypted-media *; camera *; microphone *;',
            'style' => 'left:0; top:0; position:absolute; border:none; width:100%; height:100%;',
        ];

        $iframe = \html_writer::tag('iframe', '', $attr);
        $iframecontainer = \html_writer::tag('div', $iframe, array(
            'class' => 'kaltura-player-container'
        ));

        return $iframecontainer;
    }
}
