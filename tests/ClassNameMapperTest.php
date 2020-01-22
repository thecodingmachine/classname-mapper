<?php
namespace Mouf\Composer;


class ClassNameMapperTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPossibleFiles() {
        $mapper = ClassNameMapper::createFromComposerFile(__DIR__.'/Fixtures/test_autoload.json');
        $possibleFiles = $mapper->getPossibleFileNames('Foo\\Bar\\Baz');

        $this->assertEquals([ 'src/Foo/Bar/Baz.php', 'src2/Bar/Baz.php' ], $possibleFiles);

        $possibleFiles = $mapper->getPossibleFileNames('Foo\\Bar');

        $this->assertEquals([ 'src/Foo/Bar.php', 'src2/Bar.php' ], $possibleFiles);

        //From autoloader instead of composer.json
        $mapper = ClassNameMapper::createFromComposerAutoload(__DIR__ . '/Fixtures/test_autoload.php');
        $possibleFiles = $mapper->getPossibleFileNames('Mouf\\Composer\\ClassNameMapper');

        $this->assertEquals([
                'src/ClassNameMapper.php'
            ],
            $possibleFiles
        );
    }

    public function testUseAutoloadDev() {
        $mapper = ClassNameMapper::createFromComposerFile(__DIR__.'/Fixtures/test_autoload.json', null, true);
        $possibleFiles = $mapper->getPossibleFileNames('Foo\\Bar\\Baz');

        $this->assertEquals([ 'src/Foo/Bar/Baz.php', 'tests/Foo/Bar/Baz.php', 'src2/Bar/Baz.php', 'tests2/Bar/Baz.php' ], $possibleFiles);

    }

    public function testGetPossibleFilesFromEmptyPsrAutoload() {
        $mapper = ClassNameMapper::createFromComposerFile(__DIR__.'/Fixtures/empty_autoload.json');
        $possibleFiles = $mapper->getPossibleFileNames('Foo\\Bar');

        $this->assertEquals([ 'src/Foo/Bar.php', 'src2/Foo/Bar.php' ], $possibleFiles);

        $possibleFiles = $mapper->getPossibleFileNames('Foo_Zip\\Bar_Baz');

        $this->assertEquals([ 'src/Foo_Zip/Bar/Baz.php', 'src2/Foo_Zip/Bar_Baz.php' ], $possibleFiles);

    }

    public function testGetManagedNamespaces() {
        $mapper = ClassNameMapper::createFromComposerFile(__DIR__.'/../composer.json');
        $namespaces = $mapper->getManagedNamespaces();

        $this->assertEquals([ 'Mouf\\Composer\\' ], $namespaces);
    }

    public function testGetManagedNamespacesFromEmptyPsrAutoload() {
        $mapper = ClassNameMapper::createFromComposerFile(__DIR__.'/Fixtures/empty_autoload.json');
        $namespaces = $mapper->getManagedNamespaces();

        $this->assertEquals([ '' ], $namespaces);
    }

    public function testEmptyDir() {
        $mapper = ClassNameMapper::createFromComposerFile(__DIR__.'/Fixtures/test_autoload_empty_dir.json', null, true);

        $possibleFiles = $mapper->getPossibleFileNames('Foo\\Bar\\Baz');
        $this->assertEquals([ 'Foo/Bar/Baz.php' ], $possibleFiles);

        $possibleFiles = $mapper->getPossibleFileNames('Bar\\Baz');
        $this->assertEquals([ 'Baz.php' ], $possibleFiles);

        $possibleFiles = $mapper->getPossibleFileNames('Baz\\Bar\\Baz');
        $this->assertEquals([ 'Baz/Bar/Baz.php' ], $possibleFiles);

        $possibleFiles = $mapper->getPossibleFileNames('Wiz\\Bar\\Baz');
        $this->assertEquals([ 'Bar/Baz.php' ], $possibleFiles);

    }

    public function testAutoloadException() {
        $this->expectException(MissingFileException::class);
        $this->expectExceptionMessage('Could not load file "notexist.php"');
        ClassNameMapper::createFromComposerAutoload('notexist.php');
    }
}
