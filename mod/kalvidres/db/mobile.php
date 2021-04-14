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
 * Defines mobile handlers.
 *
 * @package   mod_kalvidres
 * @copyright 2020 Bas Brands <bas@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$addons = [
    'mod_kalvidres' => [ // Plugin identifier.
        'handlers' => [ // Different places where the plugin will display content.
            'viewkaltura' => [ // Handler unique name.
                'displaydata' => [
                    'icon' => $CFG->wwwroot . '/mod/kalvidres/pix/icon.svg',
                    'class' => 'core-course-module-kalvidres-handler',
                ],
                'delegate' => 'CoreCourseModuleDelegate', // Delegate (where to display the link to the plugin).
                'method' => 'mobile_view_activity', // Main function in \mod_kalvides\output\mobile.
            ]
        ],
        'lang' => [ // Language strings that are used in all the handlers.
            ['pluginname', 'kalvidres'],
        ]
    ]
];
