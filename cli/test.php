<?php

define ("CLI_SCRIPT", true);

include __DIR__ . "/../../../config.php";

$id = $argv[1] ?? 177;

\local_idnumber\generator::$PATTERN = "T{category}C{count}P{mark}";

echo "uuid: " . \local_idnumber\generator::uuid($id) . PHP_EOL;
echo "uniqid: " . \local_idnumber\generator::uniqid($id) . PHP_EOL;
echo "count: " . \local_idnumber\generator::count($id) . PHP_EOL;
echo "category: " . \local_idnumber\generator::category($id) . PHP_EOL;
echo "qtype: " . \local_idnumber\generator::qtype($id) . PHP_EOL;
echo "mark: " . (int)\local_idnumber\generator::mark($id) . PHP_EOL;

echo "pattern: " . \local_idnumber\generator::get_question_idnumber($id) . PHP_EOL;