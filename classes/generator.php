<?php

namespace local_idnumber;

use core_question\category_manager;

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

    public const SINGLE_CHOICE = 's';
    public const MULTIPLE_CHOICE = 'm';
    public const SHORT_ANSWER = 'a';
    public const NUMERICAL = 'n';
    public const ESSAY = 'e';
    public const TRUE_FALSE = 't';
    public const MATCHING = 'h';
    public const CLOZE = 'c';

    public const QUESTION_TYPES = [
        'Single choice' => self::SINGLE_CHOICE,
        'Multiple choice' => self::MULTIPLE_CHOICE,
        'Short answer' => self::SHORT_ANSWER,
        'Numerical' => self::NUMERICAL,
        'Essay' => self::ESSAY,
        'True/False' => self::TRUE_FALSE,
        'Matching' => self::MATCHING,
        'Cloze' => self::CLOZE,
    ];

    /**
     * Generate a UUID for the question.
     *
     * @param int $question_id The ID of the question.
     * @return string The generated UUID.
     */
    public static function uuid(int $question_id): string {
        return \core\uuid::generate();
    }

    /**
     * return order number of parent category
     * @param int $question_id The ID of the question
     * @return int The category order number
     */
    public static function category(int $question_id): int {
        global $DB;
        $category_id = $DB->get_field("question", "category", ["id" => $question_id]);
        $parent_id = $DB->get_field("question_category", "parent", ["id" => $category_id]);
        $categories = $DB->get_fieldset("question_category", "id", ["parent" => $parent_id]);
        return array_search($category_id, $categories) + 1;
    }

    /**
     * return question order number
     * @param int $question_id The ID of the question
     * @return int the question order number
     */
    public static function number(int $question_id): int {
        global $DB;
        $category_id = $DB->get_field("question", "category", ["id" => $question_id]);
        $questions = $DB->get_fieldset("question", "id", ["category" => $category_id]);
        return array_search($category_id, $questions) + 1;
    }

    /**
     * return question type
     * @param int $question_id The ID of the question
     * @return string question type
     */
    public static function type(int $question_id): string {
        global $DB;
    
        $question = $DB->get_record('question', ['id' => $question_id], 'qtype');
        if ($question) {
            return self::QUESTION_TYPES[$question->qtype];
        }
    
        return '';
    }

    /**
     * return question mark
     * @param int $question_id The ID of the question
     * @return string question point
     */
    public static function mark(int $question_id): string {
        global $DB;
        $mark = $DB->get_field("question", "defaultmark", ["id" => $question_id]);
        return $mark;
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
