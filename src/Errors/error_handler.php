<?php 

error_reporting(0);
ini_set('log_errors', 'off');

function CustomExceptionHandler($e) {
  global $logger;
  try {
    $logger->debug($e);
  } catch (\Exception $exc) {
    echo "<p>Logger error.</p>";
  } finally {
    http_response_code(500);
    if (filter_var(ini_get('display_errors'), FILTER_VALIDATE_BOOLEAN)) {
      echo nl2br(htmlentities($e));
    } else {
      echo "<div style='margin:2rem; text-align:center;'>
            <h3>500 Internal Server Error</h3>
            An internal server error has been occurred.<br />
            Please try again later.
            <a href='./'><h3>Back to homepage.</h3></a>
            </div>";
    }
  }
}
set_exception_handler('CustomExceptionHandler');

set_error_handler(function($level, $message, $file = '', $line = 0) {
  global $logger;
  switch ($level) {
    case E_PARSE:
    case E_ERROR:
    case E_CORE_ERROR:
    case E_COMPILE_ERROR:
    case E_USER_ERROR:
    case E_RECOVERABLE_ERROR:
      throw new ErrorException($message, 0, $level, $file, $line);
    default:
      $logger->debug(getErrorTypeByValue($level). " - ". $message);
      $logger->debug(prn_backtrace());
      return false;
  }
});

function prn_backtrace() {
  $str = "Stack trace";
  foreach (debug_backtrace() as $k => $obj) {
    if ($k === 0) continue;   // this function is in top of the stack
    $str .= "\n". json_encode($obj);
  }
  return $str;
}

function getErrorTypeByValue($type) {
  $constants = get_defined_constants(true);
  foreach ($constants['Core'] as $key => $value) { // Each Core constant
    if (preg_match('/^E_/', $key)) {    // Check error constants
      if ($type == $value)
        return "$key";
    }
  }
}

