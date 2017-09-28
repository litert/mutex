#!env php
<?php
declare (strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$factory = \L\Mutex\Factory::createRedisFactory([
    'ttl' => 3,
    'client' => (function() {
        $client = new \Redis();

        $client->connect('127.0.0.1', 6379);

        return $client;
    })()
]);

$lock1 = $factory->create('hello.lck');
$lock2 = $factory->create('hello.lck');

if ($lock1->lock()) {

    echo 'Lock1: locked.', PHP_EOL;
}
else {

    echo 'Lock1: failed.', PHP_EOL;
}

if ($lock2->lock()) {

    $lock2->unlock();
    echo 'Lock2: locked.', PHP_EOL;
}
else {

    echo 'Lock2: failed.', PHP_EOL;
}

if ($lock1->tryLock()) {

    echo 'Lock1: locked.', PHP_EOL;
}
else {

    echo 'Lock1: failed.', PHP_EOL;
}

if ($lock2->tryLock()) {

    echo 'Lock2: locked.', PHP_EOL;
    $lock2->unlock();
}
else {

    echo 'Lock2: failed.', PHP_EOL;
}

$lock1->unlock();
