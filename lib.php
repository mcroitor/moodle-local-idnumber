<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Code to be executed after the plugin's database scheme has been installed is defined here.
 *
 * @package     local_idnumber
 * @category    upgrade
 * @copyright   2021 Mihail Croitor <mcroitor@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


// Function to extend the course navigation
function local_idnumber_extend_navigation_course($navigation, $course, $context) {
    // Add "idnumber" to the "Question bank" menu
    $questionbank = $navigation->find("questionbank", navigation_node::TYPE_ACTIVITY);
    if ($questionbank) {
        $questionbank->add(
            get_string("idnumber", "local_idnumber"),
            new moodle_url("/local/idnumber/form.php", ["courseid" => $course->id]),
            navigation_node::TYPE_SETTING
        );
    }
}
 
function local_idnumber_generate_idnumbers($course_id) {
    global $DB;
    $template = $DB->get_field("local_idnumber", "template", ["course" => $course_id]);
    // get the question bank

}

