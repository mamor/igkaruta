<?php namespace My\Core;

/**
 * Class UtilTest
 */
class UtilTest extends \TestCase
{
	/**
	 * test for fileGetContents()
	 *
	 * @test
	 */
	public function testFileGetContents()
	{
		$file = app_path('tests/files/test.txt');

		$actual = (new Util)->fileGetContents($file);
		$expect = file_get_contents($file);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * test for filePutContents()
	 *
	 * @test
	 */
	public function testFilePutContents()
	{
		$file = app_path('tests/files/tmp');

		\File::delete($file);
		(new Util)->filePutContents($file, 'test');

		$actual = 'test';
		$expect = file_get_contents($file);
		$this->assertEquals($expect, $actual);

		\File::delete($file);
	}
}
