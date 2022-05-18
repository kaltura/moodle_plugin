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
 * @package   local_kalturamediagallery
 * @copyright 2022 Luca Bösch, BFH Bern University of Applied Sciences luca.boesch@bfh.ch
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_kalturamediagallery\output;
use local_invitation\helper\date_time as datetime;
use local_invitation\helper\util as util;
use local_invitation\globals as gl;

/**
 * A class to manipulate the moodle navigation.
 *
 * @copyright 2022 Luca Bösch, BFH Bern University of Applied Sciences luca.boesch@bfh.ch
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class navigation extends \plugin_renderer_base {
    /**
     * Create a new navigation node
     *
     * @return \navigation_node|null The navigation node
     */
    public static function create_navigation_node() {
        $PAGE = gl::page();
        $COURSE = gl::course();
        $DB = gl::db();

        if ($COURSE->id == SITEID) {
            return null;
        }

        if (!util::is_active()) {
            return null;
        }

        $context = \context_course::instance($COURSE->id);
        // Are we really on the course page or maybe in an activity page?
        if ($PAGE->context->id !== $context->id) {
            // If the course has no sections the activity page might be the course page.
                        if (course_format_uses_sections($COURSE->format)) {
                return null;
            }
        }

        if (!has_capability('local/kalturamediagallery:view', $context)) {
            return null;
        }

        if (!is_enrolled($context, null, '', true)) {
            if (!is_viewing($context)) {
                if (!is_siteadmin()) {
                    return null;
                }
            }
        }

        $newnode = \navigation_node::create(
            get_string('nav_mediagallery', 'local_kalturamediagallery'),
            new \moodle_url('/local/kalturamediagallery/index.php', array('courseid' => $COURSE->id)),
            \global_navigation::TYPE_ROOTNODE,
            null,
            null,
            new pix_icon('media-gallery', '', 'local_kalturamediagallery'))
        );

        return $newnode;
    }
}
