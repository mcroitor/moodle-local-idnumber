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

namespace local_idnumber;

/**
 * Description of generator
 *
 * @copyright   2021 Mihail Croitor <mcroitor@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class generator {

    public static $QTYPE = [
        'ddwtos' => 'DN',
        'description' => 'DC',
        'essay' => 'ES',
        'match' => 'MT',
        'multianswer' => 'EM',
        'multichoice' => 'MC',
        'shortanswer' => 'SA',
        'numerical' => 'NM',
        'gapselect' => 'GS',
        'truefalse' => 'TF'
    ];
    public static $QTYPE_THIRD_PARTY = 'TP';

    public static $PATTERN = "{uuid}";

    public const GENERATORS = [
        "uuid",
        "count",
        "category",
        "qtype",
        "mark"
    ];

    public static function get_question_idnumber($id) {
        $idnumber = self::$PATTERN;

        foreach(self::GENERATORS as $generator) {
            $idnumber = str_replace("{{$generator}}", self::{$generator}($id), $idnumber);
        }
        if($idnumber === self::$PATTERN) {
            $idnumber = self::uuid($id);
        }
        return $idnumber;
    }

    /**
     * UUID
     */
    public static function uuid($course_id) {
        return \core\uuid::generate();
    }

    /**
     * returns question order number in the parent category
     */
    public static function count($course_id) {
        global $DB;
        $category_id = $DB->get_field("question", "category", ["id" => $course_id]);
        $questions = $DB->get_fieldset_select("question", "id", "category={$category_id}");
        return array_search($course_id, $questions);
    }

    /**
     * returns category order number from question bank
     */
    public static function category($course_id) {
        global $DB;
        $category_id = $DB->get_field("question", "category", ["id" => $course_id]);
        $parent = $DB->get_field("question_categories", "parent", ["id" => $category_id]);
        $categories = $DB->get_fieldset_select("question_categories", "id", "parent={$parent}");
        return array_search($category_id, $categories);
    }
    
    /**
     * returns question type
     */
    public static function qtype($course_id) {
        global $DB;
        $qtype = $DB->get_field("question", "qtype", ["id" => $course_id]);
        return self::$QTYPE[$qtype ?? self::$QTYPE_THIRD_PARTY];
    }
    
    /**
     * returns default question mark
     */
    private static function mark($course_id) {
        global $DB;
        return $DB->get_field("question", "defaultmark", ["id" => $course_id]) ?? 1;
    }

}
