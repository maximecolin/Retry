<?php

namespace Retry\Tests;

use Retry;

class RetryTest extends \PHPUnit_Framework_TestCase
{
    public function testRun()
    {
        $mock = $this->getMock('Retry\Tests\Tryable');
        $mock->expects($this->exactly(1))->method('doSomething')->will($this->returnValue('something'));

        $retry = new Retry\Retry(
            function () use ($mock) {
                return $mock->doSomething();
            }
        );

        $this->assertEquals('something', $retry->run(3));
    }

    public function testRetry()
    {
        $mock = $this->getMock('Retry\Tests\Tryable');
        $mock->expects($this->at(0))->method('doSomething')->will($this->throwException(new \Exception()));
        $mock->expects($this->at(1))->method('doSomething')->will($this->returnValue('something'));

        $retry = new Retry\Retry(
            function () use ($mock) {
                return $mock->doSomething();
            }
        );

        $this->assertEquals('something', $retry->run(3));
    }

    public function testException()
    {
        $this->setExpectedException('Retry\Exception', 'Max attempt reached.');

        $mock = $this->getMock('Retry\Tests\Tryable');
        $mock->expects($this->exactly(3))->method('doSomething')->will($this->throwException(new \Exception()));

        $retry = new Retry\Retry(
            function () use ($mock) {
                return $mock->doSomething();
            }
        );

        $retry->run(3);
    }
}
