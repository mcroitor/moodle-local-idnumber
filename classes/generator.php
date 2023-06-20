<?php

namespace local_idnumber;

class generator {
    /**
     * available patterns
     */
    public const UUID = "uuid";
    public const CATEGORY = "cat";
    public const NUMBER = "nr";
    public const TYPE = "type";
    public const POINT = "point";

    public const PATTERNS = [
        self::UUID => "uuid",
        self::CATEGORY => "category",
        self::NUMBER => "number",
        self::TYPE => "type",
        self::POINT => "point",
    ];

    /**
     * Generate a UUID for the question.
     *
     * @param int $question_id The ID of the question.
     * @return string The generated UUID.
     */
    public static function uuid($question_id) {
        return \core\uuid::generate();
    }

    /**
     * return order number of parent category
     * @param int $question_id The ID of the question
     * @return int The category order number
     */
    public static function category($question_id) {
        // TODO: implement this
        return 1;
    }

    /**
     * return question order number
     * @param int $question_id The ID of the question
     * @return int the question order number
     */
    public static function number($question_id) {
        // TODO: implement this
        return 1;
    }

    /**
     * return question type
     * @param int $question_id The ID of the question
     * @return string question type
     */
    public static function type($question_id) {
        global $DB;
    
        $question = $DB->get_record('question', ['id' => $question_id], 'qtype');
        if ($question) {
            return $question->qtype;
        }
    
        return '';
    }

    /**
     * return question point
     * @param int $question_id The ID of the question
     * @return string question point
     */
    public static function point($question_id) {
        // TODO: implement this
        return 1;
    }

    public static function get_idnumber($question_id, $template) {
        $idnumber = $template;
        foreach(self::PATTERNS as $pattern => $method) {
            $idnumber = str_replace("[{$pattern}]", self::{$method}($question_id), $idnumber);
        }
        if($idnumber === $template) {
            $idnumber = self::uuid($question_id);
        }
        return $idnumber;
    }
}
