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
use core_question\local\bank\question_edit_contexts;

/**
 * The questions test class.
 *
 * @package     local_idnumber
 * @category    test
 * @copyright   2021 Mihail Croitor <mcroitor@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_idnumber_questions_testcase extends advanced_testcase
{

    // Write the tests here as public funcions.
    // Please refer to {@link https://docs.moodle.org/dev/PHPUnit} for more details on PHPUnit tests in Moodle.

    public function test_generator_uuid()
    {
        $uuid = \local_idnumber\generator::uuid(1);
        $this->assertNotEmpty($uuid);
        echo $uuid;
    }

    public function test_generator_mark()
    {
        $generator = $this->getDataGenerator();
        $course = $generator->create_course();
        $quiz = $generator->create_module('quiz', ['course' => $course->id]);
        $contexts = new question_edit_contexts(context_module::instance($quiz->cmid));

        $defaultcategory = question_make_default_categories([$contexts->lowest()]);
        $questiongerator = $generator->get_plugin_generator('core_question');

        $question = $questiongerator->create_question(['category' => $defaultcategory->id]);
        $mark = \local_idnumber\generator::mark($question->id);
        $this->assertEquals(1, $mark);
    }

    public function test_generator_category()
    {
        $generator = $this->getDataGenerator();
        $course = $generator->create_course();
        $quiz = $generator->create_module('quiz', ['course' => $course->id]);
        $contexts = new question_edit_contexts(context_module::instance($quiz->cmid));

        $defaultcategory = question_make_default_categories([$contexts->lowest()]);
        $questiongerator = $generator->get_plugin_generator('core_question');

        $question = $questiongerator->create_question(['category' => $defaultcategory->id]);
        $category = \local_idnumber\generator::category($question->id);
        $this->assertEquals(1, $category);
    }

    public function test_generator_number()
    {
        $generator = $this->getDataGenerator();
        $course = $generator->create_course();
        $quiz = $generator->create_module('quiz', ['course' => $course->id]);
        $contexts = new question_edit_contexts(context_module::instance($quiz->cmid));

        $defaultcategory = question_make_default_categories([$contexts->lowest()]);
        $questiongerator = $generator->get_plugin_generator('core_question');

        $questiongerator->create_question(['category' => $defaultcategory->id]);
        $questiongerator->create_question(['category' => $defaultcategory->id]);
        $question = $questiongerator->create_question(['category' => $defaultcategory->id]);
        $number = \local_idnumber\generator::number($question->id);
        $this->assertEquals(3, $number);
    }

    public function test_generator_type()
    {
        $generator = $this->getDataGenerator();
        $course = $generator->create_course();
        $quiz = $generator->create_module('quiz', ['course' => $course->id]);
        $contexts = new question_edit_contexts(context_module::instance($quiz->cmid));

        $defaultcategory = question_make_default_categories([$contexts->lowest()]);
        $questiongerator = $generator->get_plugin_generator('core_question');

        $question = $questiongerator->create_question([
            'category' => $defaultcategory->id,
            'qtype' => 'multichoice'
        ]);
        $type = \local_idnumber\generator::type($question->id);
        $this->assertEquals('multichoice', $type);
    }

    public function test_generator_get_idnumber()
    {
        $generator = $this->getDataGenerator();
        $course = $generator->create_course();
        $quiz = $generator->create_module('quiz', ['course' => $course->id]);
        $contexts = new question_edit_contexts(context_module::instance($quiz->cmid));

        $defaultcategory = question_make_default_categories([$contexts->lowest()]);
        $questiongerator = $generator->get_plugin_generator('core_question');

        $questiongerator->create_question([
            'category' => $defaultcategory->id,
            'qtype' => 'multichoice',
            'defaultmark' => 2
        ]);
        $question = $questiongerator->create_question([
            'category' => $defaultcategory->id,
            'qtype' => 'multichoice',
            'defaultmark' => 2
        ]);
        $template = 'C{category}N{number}T{type}M{mark}';
        $idnumber = \local_idnumber\generator::get_idnumber($question->id, $template);
        $this->assertEquals('C1N2TmM2', $idnumber);
    }
}
