<?php

require_once '../constants.php';

require_once '../utilities.php';

header('Content-Type: application/json');

/**
 * Matches API request in the pattern:
 *   /api/v<x>/<lower>..<upper>[@<times>]
 */
$pattern = '/^\/api\/v\d\/(-?\d+)\.\.(-?\d+)(?:@(-?\d+))?/';
$request = $_SERVER['REQUEST_URI'];

$status = TRUE;
$message = 'The RNG genie has blessed you.';
$data = [];

preg_match($pattern, $request, $match);

$lower = (isset($match[1]) && $match[1] !== '') ? intval($match[1]) : NULL;
$upper = (isset($match[2]) && $match[2] !== '') ? intval($match[2]) : NULL;

// If not set, `times` defaults to 1
$times = (isset($match[3]) && $match[3] !== '') ? intval($match[3]) : 1;

// Error checking
if (!($lower && $upper)) {

  $status = FALSE;
  $message = 'Needs a lower and upper bound.';

} else if ($lower > $upper) {

  $status = FALSE;
  $message = 'Lower bound cannot be greater than upper bound.';

} else if ($lower < BOUNDS_MIN) {

  $status = FALSE;
  $message = 'Lower cannot be smaller than ' . BOUNDS_MIN . '.';

} else if ($upper > BOUNDS_MAX) {

  $status = FALSE;
  $message = 'Lower cannot be larger than ' . BOUNDS_MAX . '.';

} else if ($times < 1) {

  $status = FALSE;
  $message = 'Times must be at least 1.';

} else if ($times > TIMES_MAX) {

  $status = FALSE;
  $message = 'Times cannot be larger than ' . TIMES_MAX . '.';

} else {

  $data = rng($lower, $upper, $times);

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

  echo $callback . '(' . json_encode($response) . ');';

} else {

  echo json_encode($response);

}
