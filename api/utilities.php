<?php

function rng($lower, $upper, $times) {

  $numbers = [];

  for ($i = 0; $i < $times; $i++) {

    $numbers[] = random_int($lower, $upper);

  }

  return [
    'numbers' => $numbers
  ];

}
