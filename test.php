<?php

function asynchronousCounter(string $name, int $count): \Generator
{
    \BlackfireProbe::addMarker("Start $name");
    for (; $count > 0; --$count) {
        echo "[$name] $count …\n";
        usleep(100000);
        yield;
    }

    echo "[$name] $count !!! Bye\n";
    \BlackfireProbe::addMarker("Stop $name");
}

$counters = [
    asynchronousCounter('A', 10),
    asynchronousCounter('B', 5),
    asynchronousCounter('C', 7),
];

while($counters) {
    foreach ($counters as $id => $counter) {
        if(!$counter->valid()) {
            unset($counters[$id]);
        } else {
            $counter->next();
        }
    }
}
