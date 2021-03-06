#!env php
<?php
declare (strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$mc = new Memcache();

$mc->connect('127.0.0.1', 11211);

$factory = \L\Mutex\Factory::createMemcacheFactory([
    'ttl' => 3,
    'client' => $mc
]);

$lock = $factory->create('hello.lck');
$lock2 = $factory->create('hello.lck');

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
