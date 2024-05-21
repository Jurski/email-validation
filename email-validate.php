<?php

echo "Validate an email..." . PHP_EOL;

$emailInput = trim(strtolower(readline("Enter email to validate eg (test@xyz.com): ")));

if ($emailInput === "") {
    echo "Empty input detected, please enter an email" . PHP_EOL;
    exit;
}

$url = "https://api.emailvalidation.io/v1/info?apikey=$key&email=$emailInput";

try {

    $response = file_get_contents($url);

    if ($response === false) {
        throw new Exception("Network error or invalid input");
    }

    $emailData = json_decode($response);

    if ($emailData === null) {
        throw new Exception("Error parsing email data");
    }

    if (isset($emailData->state) && $emailData->state === "deliverable") {
        echo "Email $emailInput is a valid one!";
    } else if (isset($emailData->state) && $emailData->state === "undeliverable") {
        echo "Email $emailInput is not a valid one!";
    } else {
        echo "Couldnt determine email validity";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}