<?php
// Define the log file in the same directory as the script
define('ERROR_LOG_FILE', 'error.log');

// Custom error handler
function customErrorHandler($errno, $errstr, $errfile, $errline)
{
    $timestamp = time(); // Epoch time
    $humanTime = date('Y-m-d H:i:s', $timestamp); // Human-readable time
    $errorMessage = "[$timestamp][$humanTime] Error [$errno]: $errstr in $errfile on line $errline\n";

    // Write error to the custom log file
    file_put_contents(ERROR_LOG_FILE, $errorMessage, FILE_APPEND);

    // Prevent PHP's default error handler
    return true;
}

// Custom exception handler
function customExceptionHandler($exception)
{
    $timestamp = time(); // Epoch time
    $humanTime = date('Y-m-d H:i:s', $timestamp); // Human-readable time
    $exceptionMessage = "[$timestamp][$humanTime] Uncaught Exception: {$exception->getMessage()} in {$exception->getFile()} on line {$exception->getLine()}\n";

    // Write exception to the custom log file
    file_put_contents(ERROR_LOG_FILE, $exceptionMessage, FILE_APPEND);
}

// Shutdown handler for fatal errors
function shutdownHandler()
{
    $error = error_get_last();
    if ($error && ($error['type'] === E_ERROR || $error['type'] === E_CORE_ERROR || $error['type'] === E_COMPILE_ERROR || $error['type'] === E_PARSE)) {
        $timestamp = time(); // Epoch time
        $humanTime = date('Y-m-d H:i:s', $timestamp); // Human-readable time
        $fatalErrorMessage = "[$timestamp][$humanTime] Fatal Error: {$error['message']} in {$error['file']} on line {$error['line']}\n";

        // Write fatal error to the custom log file
        file_put_contents(ERROR_LOG_FILE, $fatalErrorMessage, FILE_APPEND);
    }
}

// Set error, exception, and shutdown handlers
set_error_handler("customErrorHandler");
set_exception_handler("customExceptionHandler");
register_shutdown_function("shutdownHandler");

// Set error reporting level
error_reporting(E_ALL);
ini_set('display_errors', 1); // Do not display errors (production-ready)
ini_set('log_errors', 1);    // Disable default PHP error logging


