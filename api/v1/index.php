<?php

header('Content-Type: application/json');

require_once '../constants.php';
require_once '../utilities.php';

/**
 * Regular expression for matching API request.
 * Entire expression matches the following:
 *   /api/v<x>/<lower>..<upper>[@<times>][/(asc|dsc)]
 *      [1]          [2]          [3]         [4]
 */

// 1. matches /api/v<x>/
$pattern  = '/^\/api\/v\d\/';

// 2. matches <lower>..<upper>
$pattern .= '(-?\d+)\.\.(-?\d+)';

// 3. matches [@<times>]
$pattern .= '(?:@(-?\d+))?';

// 4. matches [/(asc|dsc)]
$pattern .= '(?:\/([ad]sc))?/';

$request = $_SERVER['REQUEST_URI'];

$status = TRUE;
$message = 'The RNG genie has blessed you.';
$data = [];

preg_match($pattern, $request, $match);

$lower = (isset($match[1]) && $match[1] !== '') ? intval($match[1]) : NULL;
$upper = (isset($match[2]) && $match[2] !== '') ? intval($match[2]) : NULL;

// If not set, `times` defaults to 1
$times = (isset($match[3]) && $match[3] !== '') ? intval($match[3]) : 1;

// if not set, `sort` defaults to NULL
$sort =  (isset($match[4]) && $match[4] !== '') ?       ($match[4]) : NULL;

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

  $data = rng($lower, $upper, $times, $sort);

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
