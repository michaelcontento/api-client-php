<?php

/**
 * @covers Adcloud_Response_Collection
 * @covers Adcloud_Response_Interface
 */
class Adcloud_Response_CollectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param int $status
     * @param array $result
     * @param array $metadata
     * @return Adcloud_Response_Collection
     */
    private function getCollection($status = null, array $result = null, 
        array $metadata = null)
    {
        if ($status === null) {
            $status = 200;
        }

        if ($result === null) {
            $result = array();
        }

        $defaultMetadata = array();
        if ($metadata === null) {
            $metadata = $defaultMetadata;
        } else {
            $metadata = array_merge($metadata, $defaultMetadata);
        }

        return new Adcloud_Response_Collection($status, $result, $metadata);
    }

    public function testGetStatusCode()
    {
        $collection = $this->getCollection(200);
        $this->assertEquals(200, $collection->getStatusCode());
    }

    public function testGetResult()
    {
        $result = array(
            array('foo' => 'bar'), 
            array('bar' => 'foo')
        );

        $collection = $this->getCollection(200, $result);
        $result = $collection->getResult();

        $this->assertTrue(is_array($result));
        $this->assertEquals(2, count($result));
        $this->assertTrue($result[0] instanceof Adcloud_Response_Record);
        $this->assertTrue($result[1] instanceof Adcloud_Response_Record);
    }

    public function testImplementsResponseInterface()
    {
        $collection = $this->getCollection();
        $interfaces = class_implements($collection);
        $this->assertContains('Adcloud_Response_Interface', $interfaces);
    }

    public function testExceptionIfResultIsNotAnArray()
    {
        $this->setExpectedException('InvalidArgumentException');
        new Adcloud_Response_Collection(200, '', array());
    }

    public function testAccessMetaData()
    {
        $metadata = array(
            'some' => 'string',
            'integer' => 42
        );
        $collection = $this->getCollection(null, null, $metadata);

        $this->assertEquals($metadata, $collection->getMetadata()); 
    }
}
