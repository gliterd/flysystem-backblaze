<?php

use ChrisWhite\B2\Client;
use Mhetreramesh\Flysystem\BackblazeAdapter as Backblaze;
use \ChrisWhite\B2\File;
use \League\Flysystem\Config;

class BackblazeAdapterTests extends PHPUnit_Framework_TestCase
{
    public function backblazeProvider()
    {
        $mock = $this->prophesize('ChrisWhite\B2\Client');
        return [
            [new Backblaze($mock->reveal(), 'my_bucket'), $mock],
        ];
    }

    /**
     * @dataProvider  backblazeProvider
     */
    public function testHas($adapter, $mock)
    {
        $mock->fileExists(["BucketName" => "my_bucket", "FileName" => "something"])->willReturn(true);
        $result = $adapter->has('something');
        $this->assertTrue($result);
    }

    /**
     * @dataProvider  backblazeProvider
     */
    public function testWrite($adapter, $mock)
    {
        $mock->upload(["BucketName" => "my_bucket", "FileName" => "something", "Body" => "contents"])->willReturn(new File('something','','','',''), false);
        $result = $adapter->write('something', 'contents', new Config());
        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('type', $result);
        $this->assertEquals('file', $result['type']);
    }

    /**
     * @dataProvider  backblazeProvider
     */
    public function testWriteStream($adapter, $mock)
    {
        $mock->upload(["BucketName" => "my_bucket", "FileName" => "something", "Body" => "contents"])->willReturn(new File('something','','','',''), false);
        $result = $adapter->writeStream('something', 'contents', new Config());
        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('type', $result);
        $this->assertEquals('file', $result['type']);
    }

    /**
     * @dataProvider  backblazeProvider
     */
    public function testUpdate($adapter, $mock)
    {
        $mock->upload(["BucketName" => "my_bucket", "FileName" => "something", "Body" => "contents"])->willReturn(new File('something','','','',''), false);
        $result = $adapter->update('something', 'contents', new Config());
        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('type', $result);
        $this->assertEquals('file', $result['type']);
    }

    /**
     * @dataProvider  backblazeProvider
     */
    public function testUpdateStream($adapter, $mock)
    {
        $mock->upload(["BucketName" => "my_bucket", "FileName" => "something", "Body" => "contents"])->willReturn(new File('something','','','',''), false);
        $result = $adapter->updateStream('something', 'contents', new Config());
        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('type', $result);
        $this->assertEquals('file', $result['type']);
    }
}