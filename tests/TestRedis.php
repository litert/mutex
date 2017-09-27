#!env php
<?php
declare (strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$mc = new \Redis();

$mc->connect('127.0.0.1', 6379);

$factory = \L\Mutex\Factory::createRedisFactory([
    'ttl' => 3,
    'client' => $mc
]);

$lock = $factory->create('hello.lock');
$lock2 = $factory->create('hello.lock');

if ($lock->lock()) {

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

if ($lock->tryLock()) {

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

$lock->unlock();
