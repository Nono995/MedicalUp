<?php

$settings = [];

$settings['error'] = [
    // MUST be set to false in production.
    // When set to true, it shows error details and throws an ErrorException for notices and warnings.
    'display_error_details' => false,
    'log_errors' => true,
];


return $settings;