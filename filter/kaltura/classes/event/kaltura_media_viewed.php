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
 * Kaltura media viewed.
 *
 * @package filter_kaltura
 * @copyright 2021 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace filter_kaltura\event;

defined('MOODLE_INTERNAL') || die();

/**
 * View kaltura media in filter
 *
 * @property-read array $other {
 *      Extra information about event.
 *      - string sourceurl: (required) source media url.
 * }
 *
 * @package filter_kaltura
 * @copyright 2021 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class kaltura_media_viewed extends \core\event\base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('kalturamediaviewed', 'filter_kaltura');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return 'The user with id ' . $this->userid . ' viewed video with source url' . $this->other['sourceurl']
                . 'embed in context ' . $this->contextid;
    }

    protected function validate_data() {
        if (empty($this->other['sourceurl'])) {
            throw new \coding_exception('Missing source url');
        }
    }

    /**
     * Gets data for use when logging to old log table.
     *
     * @return array Data to be passed to the legacy add_to_log function
     */
    public function get_legacy_logdata() {
        $context = $this->get_context();

        $info = $this->userid . ':' . $this->other['sourceurl'] . ':' .
                $this->context->id;
        if (\core_text::strlen($info) > 255) {
            $info = \core_text::substr($info, 0, 255);
        }
        return [$context->id, 'filter_kaltura', 'kalturamediaviewed',
                $this->other['sourceurl'], $info, $context->instanceid];
    }
}
