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
 * @package local_mymedia
 * @copyright 2021 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;

/**
 * Contains the event tests for the plugin.
 *
 * @package local_mymedia
 * @copyright 2021 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_mymedia_events_testcase extends advanced_testcase {

    /**
     * Tests (mymedia_viewed)
     */
    public function test_mymedia_viewed() {
        $this->resetAfterTest();
        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);

        $context = context_system::instance();

        // Create a basic event.
        $event = \local_mymedia\event\mymedia_viewed::create([
                'context' => $context,
                'other' => [
                        'page' => get_string('heading_mymedia', 'local_mymedia')
                ]]);

        // Check name (generic).
        $this->assertEquals(get_string('eventviewmymedia', 'local_mymedia'), $event->get_name());
        $this->assertEquals('The user with id ' . $user->id . ' viewed My Media in context 1', $event->get_description());
        $info = $user->id . ':' . get_string('heading_mymedia', 'local_mymedia') . ':' . $context->id;
        $this->assertEquals([$context->id, 'local_mymedia', 'viewmymedia',
                'local/mymedia/mymedia.php', $info, $context->instanceid], $event->get_legacy_logdata());
    }

}
