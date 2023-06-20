<?php

namespace local_uuid;

class generator {
    /**
     * Generate a UUID for the question.
     *
     * @param int $questionid The ID of the question.
     * @return string The generated UUID.
     */
    public static function uuid($questionid) {
        return uniqid();
    }
}