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
 * View media gallery
 *
 * @package local_kalturamediagallery
 * @copyright 2021 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_kalturamediagallery\event;

defined('MOODLE_INTERNAL') || die();

/**
 * View my media
 *
 * @property-read array $other {
 *      Extra information about event.
 *      - string coursename: (required) course name.
 *      - int courseid : (required) course id.
 * }
 *
 * @package local_kalturamediagallery
 * @copyright 2021 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class media_gallery_viewed extends \core\event\base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventviewmediagallry', 'local_kalturamediagallery');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return 'The user with id ' . $this->userid . ' viewed ' . $this->other['coursename'] . ' media gallery in context ' . $this->contextid
                . ' with courseid ' .  $this->other['courseid'];
    }

    protected function validate_data() {
        if (empty($this->other['coursename'])) {
            throw new \coding_exception('Missing course name');
        }
        if (empty($this->other['courseid'])) {
            throw new \coding_exception('Missing course id');
        }
    }

    /**
     * Gets data for use when logging to old log table.
     *
     * @return array Data to be passed to the legacy add_to_log function
     */
    public function get_legacy_logdata() {
        $context = $this->get_context();

        $info = $this->userid . ':' . $this->other['coursename'] . ':' .
                $this->context->id . ':' . $this->other['courseid'];
        if (\core_text::strlen($info) > 255) {
            $info = \core_text::substr($info, 0, 255);
        }
        return [$context->id, 'local_kalturamediagallery', 'eventviewmediagallry',
                'local/kalturamediagallery/index.php?courseid=' . $this->other['courseid'], $info, $context->instanceid];
    }
}
