<?php
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
 * Kaltura my media library script
 *
 * @package    local_mymedia
 * @author     Remote-Learner.net Inc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2014 Remote Learner.net Inc http://www.remote-learner.net
 */

/**
 * This function adds my media links to the navigation block
 * @param global_navigation $navigation a global_navigation object
 * @return void
 */
function local_mymedia_extend_navigation($navigation) {
    global $USER, $CFG;

    if (empty($USER->id)) {
        return;
    }

    $context = context_user::instance($USER->id);

    if (!has_capability('local/mymedia:view', $context, $USER)) {
        return;
    }

    $menuHeaderStr = get_string('nav_mymedia', 'local_mymedia');

    if (strpos($CFG->custommenuitems, $menuHeaderStr) !== false) {
        // My Media is already part of the config, no need to add it again.
        return;
    }

    $myMediaStr = "\n$menuHeaderStr|/local/mymedia/mymedia.php";
    $CFG->custommenuitems .= $myMediaStr;

    $url = new moodle_url('/local/mymedia/mymedia.php');
    $node = navigation_node::create(
        'My Media',
        $url,
        navigation_node::NODETYPE_LEAF,
        'local_mymedia',
        'local_mymedia',
        new pix_icon('icon', 'local_mymedia')
    );
    $navigation->add_node($node);

   
    
    
}
