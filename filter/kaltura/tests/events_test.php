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
 * Contains the event tests for the plugin.
 *
 * @package filter_kaltura
 * @copyright 2021 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;

/**
 * Contains the event tests for the plugin.
 *
 * @package filter_kaltura
 * @copyright 2021 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class filter_kaltura_events_testcase extends advanced_testcase {

    /**
     * Tests (media_gallery_viewed)
     */
    public function test_media_gallery_viewed() {
        $this->resetAfterTest();
        $generator = $this->getDataGenerator();
        $user = $generator->create_user();
        $course = $generator->create_course();
        $this->setUser($user);

        $context = context_course::instance($course->id);

        // Create a basic event.
        $event = \local_kalturamediagallery\event\media_gallery_viewed::create([
                'context' => $context,
                'other' => [
                        'coursename' => $course->fullname,
                        'courseid' => $course->id,
                ]]);

        // Check name (generic).
        $this->assertEquals(get_string('eventviewmediagallry', 'local_kalturamediagallery'), $event->get_name());
        $this->assertEquals('The user with id ' . $user->id . ' viewed ' . $course->fullname . ' media gallery in context ' . $context->id
                . ' with courseid ' .  $course->id, $event->get_description());
        $info = $user->id . ':' . $course->fullname . ':' . $context->id . ':' . $course->id;
        $this->assertEquals([$context->id, 'local_kalturamediagallery', 'eventviewmediagallry',
                'local/kalturamediagallery/index.php?courseid=' . $course->id, $info, $context->instanceid], $event->get_legacy_logdata());
    }

}
