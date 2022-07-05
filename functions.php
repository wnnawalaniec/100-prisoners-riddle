<?php
declare(strict_types=1);

function open_boxes_randomly(array $boxes, int $number_of_boxes): array
{
    $closed_boxes = $boxes;
    $opened_boxes = [];
    $found_values = [];
    while (count($opened_boxes) < $number_of_boxes) {
        $box_to_open = pick_random_box($closed_boxes);
        $opened_boxes[] = $box_to_open;
        $found_values[] = $closed_boxes[$box_to_open];
        unset($closed_boxes[$box_to_open]);
    }

    return $found_values;
}

function open_boxes_using_loop_theory(array $boxes, int $number_of_boxes, int $first_box = 0): array
{
    $closed_boxes = $boxes;
    $opened_boxes = [];
    $found_values = [];
    while (count($opened_boxes) < $number_of_boxes) {
        $box_to_open = pick_following_box($closed_boxes, empty($found_values) ? $first_box : end($found_values));
        $opened_boxes[] = $box_to_open;
        $found_values[] = $closed_boxes[$box_to_open];
        unset($closed_boxes[$box_to_open]);
    }

    return $found_values;
}

function pick_random_box(array $boxes): int
{
    $boxes = array_keys($boxes);
    return $boxes[rand(0, count($boxes)-1)];
}

function pick_following_box(array $closed_boxes, int $value_from_previous_box): int
{
    if (array_key_exists($value_from_previous_box, $closed_boxes)) {
        return $value_from_previous_box;
    } else {
        return pick_random_box($closed_boxes);
    }
}

function create_boxes(int $number_of_boxes): array
{
    $boxes = range(0, $number_of_boxes-1);
    shuffle($boxes);
    return $boxes;
}

function create_prisoners(int $number_of_prisoners): array
{
    return range(0, $number_of_prisoners-1);
}

function loop(array $array): array
{
    $loop = [];
    $next_element = array_key_first($array);
    while (true) {
        $next_element = $array[$next_element];
        if (in_array($next_element, $loop)) {
            break;
        }
        $loop[] = $next_element;
    }

    return $loop;
}

function loops(array $array, int $from_element = 0): array
{
    $loops = [];
    while (true) {
        $array = array_diff($array, array_merge(...$loops));
        if (empty($array)) {
            break;
        }
        $loops[] = loop($array);
    }
    return $loops;
}