<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$students = \App\Models\Student::all()->toArray();
$communities = \App\Models\Community::all()->toArray();

file_put_contents('tmp_data_dump.json', json_encode([
    'students' => $students,
    'communities' => $communities
], JSON_PRETTY_PRINT));
echo "Dump complete\n";
