<?php

require_once 'constants.php';

header('Content-Type: application/json');

/**
 * Matches API request in the pattern:
 *   /api/<lower>..<upper>[@<times>]
 */
$pattern = '/^\/api\/(\-?\d+)\.\.(\-?\d+)(?:@(\d+))?/';
$request = $_SERVER['REQUEST_URI'];

$status = TRUE;
$message = 'The RNG genie has blessed you.';
$data = [];

preg_match($pattern, $request, $match);

$lower = (isset($match[1])) ? $match[1] : NULL;
$upper = (isset($match[2])) ? $match[2] : NULL;

// If not set, `times` defaults to 1
$times = (isset($match[3])) ? $match[3] : 1;

// Error checking
if (!($lower && $upper)) {

  $status = FALSE;
  $message = 'Needs a lower and upper bound.';

} else if ($lower > $upper) {

  $status = FALSE;
  $message = 'Lower bounds cannot be greater than upper bounds.';

} else if ($lower < PHP_INT_MIN) {

  $status = FALSE;
  $message = 'Lower bound too low.';

} else if ($upper > PHP_INT_MAX) {

  $status = FALSE;
  $message = 'Upper bound too high.';

} else if ($times > TIMES_MAX) {

  $status = FALSE;
  $message = 'Times cannot be larger than ' . TIMES_MAX . '.';

} else {

  for ($i = 0; $i < $times; $i++) {

    $data[] = random_int($lower, $upper);

  }

}

$response = [
  'status' => $status,
  'message' => $message,
  'data' => $data
];

// Provide callback if it's a JSONP request
$callback = (isset($_REQUEST['callback']) && $_REQUEST['callback'] !== '') ?
  $_REQUEST['callback'] :
  NULL;

if ($callback !== NULL) {

  echo($callback . '(' . json_encode($response) . ');');

} else {

  echo json_encode($response);

}
