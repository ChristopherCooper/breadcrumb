<?php

class TranslatorTest extends PHPUnit_Framework_TestCase
{

    /** @var \Noherczeg\Breadcrumb\Translator */
    private $tran = null;

    /**
     * Setup the test enviroment
     */
    public function setUp ()
    {
        $this->tran = new Noherczeg\Breadcrumb\Translator;
    }

    /**
     * Teardown the test enviroment
     */
    public function tearDown ()
    {
        $this->tran = null;
    }

    /**
     * Test instance of $this->segment
     * @test
     */
    public function testInstanceOf ()
    {
        $this->assertInstanceOf('Noherczeg\Breadcrumb\Translator', $this->tran);
    }

    /**
     * Test provide file not found thrown as exception
     *
     * @expectedException \Noherczeg\Breadcrumb\FileNotFoundException
     */
    public function testFileNotFoundException ()
    {
        $this->tran->loadFile(2);
        $this->tran->loadFile();
        $this->tran->loadFile(true);
        $this->tran->loadFile('asd');
    }

    /**
     * Test provide invalid argument thrown as exception
     *
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArg ()
    {
        $this->tran->loadDictionary(1.23);
        $this->tran->loadDictionary(array('yo' => 'for sure'));
        $this->tran->loadDictionary(true);

        $this->tran->translate(34);
        $this->tran->translate(array('yo' => 'for sure'));
    }

    /**
     * Test if the dictionary is loaded properly
     *
     * @test
     */
    public function testCreation ()
    {
        $newInstance = new Noherczeg\Breadcrumb\Translator('en');
        $this->assertTrue(is_array($newInstance->dump()));

        $newInstance2 = new Noherczeg\Breadcrumb\Translator();
        $this->assertTrue(is_array($newInstance2->dump()));

        $newInstance3 = new Noherczeg\Breadcrumb\Translator(array('shold_translate' => 'to_this', 'this' => 'as_well'));
        $this->assertTrue(is_array($newInstance3->dump()));

    }

    /**
     * @test
     */
    public function testCustomDictionary ()
    {
        $newInstance = new Noherczeg\Breadcrumb\Translator(array('key' => 'trans', 'another' => 'as well'));
        $pairs = $newInstance->dump();
        $this->assertArrayHasKey('key', $pairs);
        $this->assertArrayHasKey('another', $pairs);
        $this->assertCount(2, $pairs);
        $this->assertEquals('trans', $pairs['key']);
        $this->assertEquals('as well', $pairs['another']);
    }
    
    public function testGeneric ()
    {
        $this->tran->loadDictionary();
    }
}