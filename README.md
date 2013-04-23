Retry
=====

Retry is a micro library to handle retry of a part of code.

How to
------

Retry will try to execute the closure passed in the constructor. If an exception is throwed by the code inside the closure, Retry will try to execute it again till the max attemp is reached. If each attemp failed, Retry throw a new exception.

    $retry = new Retry\Retry(function () { // do something });
    $retry->run(3);

Here the closure will be executed one time.

    $retry = new Retry\Retry(function () { throw new \Exception() });
    $retry->run(3);

Here the closure will be exucute 3 times, then a ``Retry\Exception`` is throw.

Example
-------

    try {

        $result = (new Retry\Retry(function () use ($api) {
            return $api->call('method', ['param' => 'value']);
        }))->run(3);

    } catch (Retry\Exception $e) {

        // Get the original exception
        $e->getPrevious();

    }
