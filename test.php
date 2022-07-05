<?php
declare(strict_types=1);

require_once "functions.php";

$NUMBER_OF_PRISONERS = 100;
$NUMBER_OF_BOXES = $NUMBER_OF_PRISONERS;
$NUMBER_OF_TEST_RUNS = 1000;
$NUMBER_OF_BOXES_SINGLE_PRISONER_CAN_OPEN = 50;

$prisoners = create_prisoners($NUMBER_OF_PRISONERS);
$wins = 0;
$loops = 0;
$start_time = microtime(true);
for ($test_run = 0; $test_run < $NUMBER_OF_TEST_RUNS; $test_run++) {
    $boxes = create_boxes($NUMBER_OF_BOXES);
    $current_loops = loops($boxes);
    $loops += count($current_loops);
    $prisoners_with_their_number_found = 0;
    foreach ($prisoners as $prisoner) {
        $found_values = open_boxes_using_loop_theory($boxes, $NUMBER_OF_BOXES_SINGLE_PRISONER_CAN_OPEN, $prisoner);

        if (in_array($prisoner, $found_values)) {
            $prisoners_with_their_number_found++;
        }
    }

    if ($prisoners_with_their_number_found === $NUMBER_OF_PRISONERS) {
        $wins++;
    }
}
$delta_time = microtime(true) - $start_time;

printf("Wins rate using loop strategy: %d%%\n", $wins/$NUMBER_OF_TEST_RUNS*100);
printf("Avg. loops in boxes: %f\n", $loops/$NUMBER_OF_TEST_RUNS);
printf("It took: %fs\n",  $delta_time);

$wins = 0;
$start_time = microtime(true);
for ($test_run = 0; $test_run < $NUMBER_OF_TEST_RUNS; $test_run++) {
    $boxes = create_boxes($NUMBER_OF_BOXES);
    $current_loops = loops($boxes);
    $loops += count($current_loops);
    $prisoners_with_their_number_found = 0;
    foreach ($prisoners as $prisoner) {
        $found_values = open_boxes_randomly($boxes, $NUMBER_OF_BOXES_SINGLE_PRISONER_CAN_OPEN);

        if (in_array($prisoner, $found_values)) {
            $prisoners_with_their_number_found++;
        }
    }

    if ($prisoners_with_their_number_found === $NUMBER_OF_PRISONERS) {
        $wins++;
    }
}
$delta_time = microtime(true) - $start_time;

printf("Wins rate using random strategy: %d%%\n", $wins/$NUMBER_OF_TEST_RUNS*100);
printf("It took: %fs\n", $delta_time);