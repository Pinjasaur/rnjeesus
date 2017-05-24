<?php

function rng($lower, $upper, $times, $sort) {

  $values = [];

  for ($i = 0; $i < $times; $i++) {

    $values[] = random_int($lower, $upper);

  }

  $sorted = $values;

  if ($sort === 'asc') {

    sort($sorted);

  } else {

    rsort($sorted);

  }

  return [
    'values' => ($sort !== NULL) ? $sorted : $values,
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

  // Middle value (if odd)
  // Middle - 1 value (if even)
  $mid = floor(($length - 1) / 2);

  // Odd number of elements
  if ($length % 2) {

    // Just take middle value
    $median = $array[$mid];

  // Even number of elements
  } else {

    // Average the two middle values
    $low = $array[$mid];
    $high = $array[$mid + 1];
    $median = ($low + $high) / 2;

  }

  return $median;

}
