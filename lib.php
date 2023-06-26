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
    $url = new \moodle_url('/course/modedit.php', ['add' => 'question', 'course' => $course->id]);
    $navigation->add(get_string('idnumber', 'local_idnumber'), $url, navigation_node::TYPE_CUSTOM, null, 'idnumber');
}
 
function local_idnumber_generate_idnumber_for_question($id) {
    global $DB;
    $idnumber = \local_idnumber\generator::get_question_idnumber($id);
    $DB->set_field("question", "idnumber", $idnumber, ["id" => $id]);
}


function local_idnumber_generate_missing_idnumbers() {
    global $DB;
    $ids = $DB->get_fieldset_select("question", "id", "idnumber IS NULL");
    foreach($ids as $question_id){
        local_idnumber_generate_idnumber_for_question($question_id);
    }
}
