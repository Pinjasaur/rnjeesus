<?php

function rng($lower, $upper, $times) {

  $values = [];

  for ($i = 0; $i < $times; $i++) {

    $values[] = random_int($lower, $upper);

  }

  $sorted = $values;

  sort($sorted);

  return [
    'values' => $values,
    'statistics' => [
      'minimum' => min($values),
      'maximum' => max($values),
      'mean'    => mean($values),
      'median'  => median($sorted)
    ]
  ];

}

function mean($array) {
  return array_sum($array) / count($array);
}

function median($array) {

  $length = count($array);

  // middle value (if odd)
  // middle - 1 value (if even)
  $mid = floor(($length - 1) / 2);

  // odd number of elements
  if ($length % 2) {

    // just take middle value
    $median = $array[$mid];

  // even number of elements
  } else {

    // average the two middle values
    $low = $array[$mid];
    $high = $array[$mid + 1];
    $median = ($low + $high) / 2;

  }

  return $median;
}
