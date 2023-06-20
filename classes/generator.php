<?php

namespace local_idnumber;

class generator {
    /**
     * Generate a UUID for the question.
     *
     * @param int $question_id The ID of the question.
     * @return string The generated UUID.
     */
    public static function uuid($question_id) {
        return \core\uuid::generate();
    }
}
