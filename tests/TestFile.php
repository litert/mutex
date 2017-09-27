#!env php
<?php
declare (strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$factory = \L\Mutex\Factory::createFileFactory();

$lock = $factory->create('hello.lock');
$lock2 = $factory->create('hello.lock');

if ($lock->lock()) {

    echo 'Lock1: locked.', PHP_EOL;
}
else {

    echo 'Lock1: failed.', PHP_EOL;
}

if ($lock2->tryLock()) {

    echo 'Lock2: locked.', PHP_EOL;
}
else {

    echo 'Lock2: failed.', PHP_EOL;
}

$lock->unlock();

if ($lock2->tryLock()) {

    echo 'Lock2: locked.', PHP_EOL;
}
else {

    echo 'Lock2: failed.', PHP_EOL;
}

$lock2->unlock();
