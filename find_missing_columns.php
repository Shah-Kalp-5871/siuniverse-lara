<?php
$models = ['App\Models\Inquiry', 'App\Models\Stay', 'App\Models\Student', 'App\Models\Community', 'App\Models\User', 'App\Models\Admin'];
foreach($models as $model) {
    if(!class_exists($model)) continue;
    $instance = new $model;
    $table = $instance->getTable();
    $dbColumns = Schema::getColumnListing($table);
    $fillable = $instance->getFillable();
    $dbColumns = array_diff($dbColumns, ['id', 'created_at', 'updated_at', 'password', 'remember_token', 'email_verified_at']);
    $missingFillable = array_diff($dbColumns, $fillable);
    if (!empty($missingFillable)) {
        echo "Model '$model' (table '$table') has columns missing in \$fillable: " . implode(', ', $missingFillable) . PHP_EOL;
    }
}
