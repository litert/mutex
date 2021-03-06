#!env php
<?php
declare (strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$lock = \L\Mutex\Factory::createAPCuMutex(
    'hello.lck',
    ['ttl' => 3]
);
$lock2 = \L\Mutex\Factory::createAPCuMutex('hello.lck');

if ($lock->lock()) {

    echo 'Lock1: locked.', PHP_EOL;
}
else {

    echo 'Lock1: failed.', PHP_EOL;
}

if ($lock2->lock()) {

    echo 'Lock2: locked.', PHP_EOL;
}
else {

    echo 'Lock2: failed.', PHP_EOL;
}

$lock->unlock();
$lock2->unlock();

if ($lock2->tryLock()) {

    echo 'Lock2: locked.', PHP_EOL;
}
else {

    echo 'Lock2: failed.', PHP_EOL;
}

$lock2->unlock();
