<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$student = \App\Models\Student::where('email', 'shivansh2915@gmail.com')->first();
if ($student) {
    $student->accommodation = 'PG / Flat';
    $student->save();
    echo "Updated shivansh2915@gmail.com to PG / Flat\n";
} else {
    echo "Student not found\n";
}
