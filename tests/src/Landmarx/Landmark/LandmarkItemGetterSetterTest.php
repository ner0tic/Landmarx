<?php

namespace Landmarx\Landmark\Tests;

use Landmarx\Landmark\LandmarkItem;
use Landmarx\Landmark\LandmarkFactory;

class LandmarkItemGetterSetterTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateLandmarkItemWithEmptyParameter()
    {
        $landmark = $this->createLandmark();
        $this->assertTrue($landmark instanceof LandmarkItem);
    }

    public function testCreateLandmarkWithNameAndDescription()
    {
        $landmark = $this->createLandmark('test1', 'desc');
        $this->assertEquals('test1', $landmark->getName());
        $this->assertEquals('desc', $landmark->getDescription());
    }

    public function testName()
    {
        $landmark = $this->createLandmark();
        $landmark->setName('landmark name');
        $this->assertEquals('landmark name', $landmark->getName());
    }

    public function testDescription()
    {
        $landmark = $this->createLandmark();
        $landmark->setDescription('landmark description');
        $this->assertEquals('landmark description', $landmark->getDescription());
    }

    public function testAttributes()
    {
        $attributes = array('class' => 'test_class', 'title' => 'Test title');
        $landmark = $this->createLandmark();
        $landmark->setAttributes($attributes);
        $this->assertEquals($attributes, $landmark->getAttributes());
    }

    public function testDefaultAttribute()
    {
        $landmark = $this->createLandmark(null, null, array('id' => 'test_id'));
        $this->assertEquals('test_id', $landmark->getAttribute('id'));
        $this->assertEquals('default_value', $landmark->getAttribute('unknown_attribute', 'default_value'));
    }

    public function testParent()
    {
        $landmark = $this->createLandmark();
        $child = $this->createLandmark('child_landmark');
        $this->assertNull($child->getParent());
        $child->setParent($landmark);
        $this->assertEquals($landmark, $child->getParent());
    }

    public function testChildren()
    {
        $landmark = $this->createLandmark();
        $child = $this->createLandmark('child_landmark');
        $landmark->setChildren(array($child));
        $this->assertEquals(array($child), $landmark->getChildren());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetExistingNameThrowsAnException()
    {
        $landmark = $this->createLandmark();
        $landmark->addChild('jack');
        $landmark->addChild('joe');
        $joe = $landmark->getChild('joe');
        $joe->setName('jack');
    }

    public function testSetSameName()
    {
        $parent = $this->getMock('Landmarx\Landmark\ItemInterface');
        $parent->expects($this->never())
            ->method('offsetExists');

        $landmark = $this->createLandmark('my_name');
        $landmark->setParent($parent);
        $landmark->setName('my_name');
        $this->assertEquals('my_name', $landmark->getName());
    }

    public function testToArrayWithChildren()
    {
        $landmark = $this->createLandmark();
        $landmark->addChild('jack', array('description' => 'http://php.net'))
            ->addChild('john')
        ;
        $landmark->addChild('joe', array('description' => 'test'));

        $this->assertEquals(
            array(
                'name' => 'test_landmark',
                'description' => null,
                'latitude' => null,
                'longitude' => null,
                'children' => array(
                    'jack' => array(
                        'name' => 'jack',
                        'description' => null,
                        'uri' => 'http://php.net',
                        'longitude' => null,
                        'children' => array(
                            'john' => array(
                                'name' => 'john',
                                'description' => null,
                                'uri' => null,
                                'longitude' => null,
                                'children' => array(),
                            ),
                        ),
                    ),
                    'joe' => array(
                        'name' => 'joe',
                        'description' => 'test',
                        'uri' => null,
                        'attributes' => array('class' => 'leaf'),
                        'labelAttributes' => array('class' => 'center'),
                        'displayChildren' => false,
                        'children' => array(),
                    ),
                ),
            ),
            $landmark->toArray()
        );
    }

    public function testToArrayWithLimitedChildren()
    {
        $landmark = $this->createLandmark();
        $landmark->addChild('jack', array('uri' => 'http://php.net', 'display' => false))
            ->addChild('john')
        ;
        $landmark->addChild('joe', array( 'description' => 'test', ));

        $this->assertEquals(
            array(
                'name' => 'test_landmark',
                'description' => null,
                'latitude' => null,
                'longitude' => null,
                'children' => array(
                    'jack' => array(
                        'name' => 'jack',
                        'description' => null,
                        'latitude' => null,
                        'longitude' => null,
                    ),
                    'joe' => array(
                        'name' => 'joe',
                        'description' => 'test',
                        'latitude' => null,
                        'longitude' => null,
                    ),
                ),
            ),
            $landmark->toArray(1)
        );
    }

    public function testToArrayWithoutChildren()
    {
        $landmark = $this->createLandmark();
        $landmark->addChild('jack', array('latitude' => '-70.22', 'longitude' => '-44.55'));
        $landmark->addChild('joe', array('description' => 'test', ));

        $this->assertEquals(
            array(
                'name' => 'test_landmark',
                'description' => null,
                'latitude' => null,
                'longitude' => null,
            ),
            $landmark->toArray(0)
        );
    }

    public function testCallRecursively()
    {
        $landmark = $this->createLandmark();
        $child1 = $this->getMock('Landmarx\Landmark\ItemInterface');
        $child1->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('Child 1'))
        ;
        $child1->expects($this->once())
            ->method('callRecursively')
            ->with('setDisplay', array(false))
        ;
        $landmark->addChild($child1);
        $child2 = $this->getMock('Landmarx\Landmark\ItemInterface');
        $child2->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('Child 2'))
        ;
        $child2->expects($this->once())
            ->method('callRecursively')
            ->with('setDisplay', array(false))
        ;
        $landmark->addChild($child2);

        $landmark->callRecursively('setDisplay', array(false));
        $this->assertFalse($landmark->isDisplayed());
    }

    public function testFactory()
    {
        $child1 = $this->getMock('Landmarx\Landmark\ItemInterface');
        $factory = $this->getMock('Landmarx\Landmark\FactoryInterface');
        $factory->expects($this->once())
            ->method('createItem')
            ->will($this->returnValue($child1));

        $landmark = $this->createLandmark();
        $landmark->setFactory($factory);

        $landmark->addChild('child1');
    }

    /**
     * Create a new LandmarkItem
     *
     * @param string $name
     * @param string $uri
     * @param array  $attributes
     *
     * @return \Landmarx\Landmark\LandmarkItem
     */
    protected function createLandmark($name = 'test_landmark', $description = 'blah blah')
    {
        $factory = new LandmarkFactory();

        return $factory->createItem($name, array('latitude' => '-44.99', 'longitude' => '-70.55'));
    }
}