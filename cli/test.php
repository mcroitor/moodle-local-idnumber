<?php

define ("CLI_SCRIPT", true);

include __DIR__ . "/../../../config.php";

$id = $argv[1] ?? 177;

$template = "T[cat]C[nr]P[point]";

echo "uuid: " . \local_idnumber\generator::uuid($id) . PHP_EOL;
echo "count: " . \local_idnumber\generator::number($id) . PHP_EOL;
echo "category: " . \local_idnumber\generator::category($id) . PHP_EOL;
echo "qtype: " . \local_idnumber\generator::type($id) . PHP_EOL;
echo "mark: " . \local_idnumber\generator::point($id) . PHP_EOL;

echo "pattern: " . \local_idnumber\generator::get_idnumber($id, $template) . PHP_EOL;