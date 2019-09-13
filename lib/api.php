<?php

require_once 'constants.php';
require_once 'utilities.php';

/**
 * Regular expression for matching API request.
 * Entire expression matches the following:
 *   /api/<lower>..<upper>[@<quantity>][/(asc|dsc)]
 *   [1]        [2]           [3]           [4]
 */

// 1. matches /api/
$pattern  = '/^\/api\/';

// 2. matches <lower>..<upper>
$pattern .= '(-?\d+)\.\.(-?\d+)';

// 3. matches [@<quantity>]
$pattern .= '(?:@(-?\d+))?';

// 4. matches [/(asc|dsc)]
$pattern .= '(?:\/([ad]sc))?/';

$request = $_SERVER['REQUEST_URI'];

// Assume it failed
$status = FALSE;
$message = 'The RNG genie has blessed you.';
$data = [];

preg_match($pattern, $request, $match);

$lower = (isset($match[1]) && $match[1] !== '') ? intval($match[1]) : NULL;
$upper = (isset($match[2]) && $match[2] !== '') ? intval($match[2]) : NULL;

// If not set, `quantity` defaults to 1
$quantity = (isset($match[3]) && $match[3] !== '') ? intval($match[3]) : 1;

// If not set, `sort` defaults to NULL
$order = (isset($match[4]) && $match[4] !== '') ? ($match[4]) : NULL;

// Error checking
if (!($lower !== NULL && $upper !== NULL)) {

  $message = 'Needs a lower and upper bound.';

} else if ($lower > $upper) {

  $message = 'Lower bound cannot be greater than upper bound.';

} else if ($lower < BOUNDS_MIN) {

  $message = 'Lower bound cannot be smaller than ' . BOUNDS_MIN . '.';

} else if ($upper > BOUNDS_MAX) {

  $message = 'Upper bound cannot be larger than ' . BOUNDS_MAX . '.';

} else if ($quantity < 1) {

  $message = 'Quantity must be at least 1.';

} else if ($quantity > QUANTITY_MAX) {

  $message = 'Quantity cannot be larger than ' . QUANTITY_MAX . '.';

} else {

  $status = TRUE;
  $data = rng($lower, $upper, $quantity, $order);

}

$response = [
  'status' => $status,
  'message' => $message,
  'data' => $data
];

// Provide callback if it's a JSONP request
$callback = (isset($_GET['callback']) && $_GET['callback'] !== '') ?
  $_GET['callback'] :
  NULL;

// Provide plain-text if ?raw
$raw = (isset($_GET['raw']) && $_GET['raw']) ?
  $_GET['raw'] :
  NULL;

header('Access-Control-Allow-Origin: *');

if ($callback !== NULL) {

  header('Content-Type: application/javascript');
  echo $callback . '(' . json_encode($response) . ');';

} else if ($raw !== NULL) {

  header('Content-Type: text/plain');
  echo ($status) ? implode("\n", $data['values']) : $message;

} else {

  header('Content-Type: application/json');
  echo json_encode($response);

}
