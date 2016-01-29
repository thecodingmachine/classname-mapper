<?php
namespace Mouf\Composer;


class ClassNameMapperTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPossibleFiles() {
        $mapper = ClassNameMapper::createFromComposerFile(__DIR__.'/../composer.json');
        $possibleFiles = $mapper->getPossibleFileNames('Mouf\\Composer\\Foo\\Bar');

        $this->assertEquals([ 'src/Foo/Bar.php' ], $possibleFiles);
    }

    public function testGetManagedNamespaces() {
        $mapper = ClassNameMapper::createFromComposerFile(__DIR__.'/../composer.json');
        $namespaces = $mapper->getManagedNamespaces();

        $this->assertEquals([ 'Mouf\\Composer\\' ], $namespaces);
    }

}
