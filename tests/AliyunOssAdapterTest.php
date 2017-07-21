<?php

namespace Moyue\Flysystem\AliyunOss\Tests;

use OSS\OssClient;
use PHPUnit_Framework_TestCase;
use League\Flysystem\Filesystem;
use Moyue\Flysystem\AliyunOss\Plugins\PutFile;
use Moyue\Flysystem\AliyunOss\AliyunOssAdapter;

class AliyunOssAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \League\Flysystem\Filesystem
     */
    protected $filesystem;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        /*
         * TODO 测试依赖
         */

        $accessId = getenv('OSS_ACCESS_KEY_ID');
        $accessKey = getenv('OSS_ACCESS_KEY_SECRET');
        $endPoint = getenv('OSS_ENDPOINT');
        $bucket = getenv('OSS_BUCKET');

        $client = new OssClient($accessId, $accessKey, $endPoint);
        $adapter = new AliyunOssAdapter($client, $bucket);
			
		$dir = time() . 'aliyun-oss-php-flysystem-test-cases';
        $adapter->setPathPrefix($dir);

        $filesystem = new Filesystem($adapter);
        $filesystem->addPlugin(new PutFile());

        $this->filesystem = $filesystem;
    }

    public function setUp()
    {
		$this->create_dir = time() . "test-create-dir";

		$this->prepare_file = time() . "prepare-file";
        $this->filesystem->write($this->prepare_file, 'xxx');

		$this->rename_file = time() . "rename-file";
        $this->filesystem->write($this->rename_file, 'xxx');

		$this->delete_file = time() . "delete-file";
        $this->filesystem->write($this->delete_file, 'xxx');
	}

	public function tearDown()
	{
        if ($this->filesystem->has($this->prepare_file))
		{
			$this->filesystem->delete($this->prepare_file);
		}
        if ($this->filesystem->has($this->rename_file))
		{
			$this->filesystem->delete($this->rename_file);
		}
        if ($this->filesystem->has($this->delete_file))
		{
			$this->filesystem->delete($this->delete_file);
		}
	}

	/**
	 *
	 */
    public function testPutFile()
    {
        $tmpfile = tempnam(sys_get_temp_dir(), 'OSS');
        file_put_contents($tmpfile, 'put file');

		$dest_file = time() . "test-put-file";
        $this->filesystem->putFile($dest_file, $tmpfile);
        $this->assertSame('put file', $this->filesystem->read($dest_file));

        unlink($tmpfile);
        $this->filesystem->delete($dest_file);
    }

    /**
     * 
     */
    public function testWrite()
    {
		$dest_file = time() . "test-write-file";
        try
		{
			$this->filesystem->write($dest_file, '123');
		} catch (OssException $e) {
	        $this->assertTrue(false);
		}
		try
		{
        	$this->filesystem->delete($dest_file);
		} catch (OssException $e) {
	        $this->assertTrue(false);
		}
    }

    /**
     * 
     */
    public function testWriteStream()
    {
		$dest_file = time() . "test-write-stream";
        $stream = tmpfile();
        fwrite($stream, 'OSS text');
        rewind($stream);

        try
		{
			$this->filesystem->writeStream($dest_file, $stream);
		} catch (OssException $e) {
	        $this->assertTrue(false);
		}

        fclose($stream);
		
        try
		{
			$this->filesystem->delete($dest_file);
		} catch (OssException $e) {
            $this->assertTrue(false);
	    }
    }

    /**
     * 
     */
    public function testUpdate()
    {
        try
		{
			$this->filesystem->update($this->prepare_file, __FUNCTION__);
		} catch (OssException $e) {
            $this->assertTrue(false);
        }
    }
	
	/**
	  *
	  */
    public function testVisibility()
    {
		$acl = 'private';
        try
		{
			$this->filesystem->setVisibility($this->prepare_file, $acl);
		} catch (OssException $e) {
            $this->assertTrue(false);
        }

        try
		{
			$result = $this->filesystem->getVisibility($this->prepare_file);
		} catch (OssException $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals($acl, $result);
		
		$acl = 'public';
        try
		{
			$this->filesystem->setVisibility($this->prepare_file, $acl);
		} catch (OssException $e) {
            $this->assertTrue(false);
        }
        try
		{
			$result = $this->filesystem->getVisibility($this->prepare_file);
		} catch (OssException $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals('public-read', $result);
    }

    /**
     *
     */
    public function testUpdateStream()
    {
        $stream = tmpfile();
        fwrite($stream, 'OSS text2');
        rewind($stream);

        try {
			$this->filesystem->updateStream($this->prepare_file, $stream);
		} catch (OssException $e) {
            $this->assertTrue(false);
        }

        fclose($stream);
    }

    public function testHas()
    {
        $this->assertTrue($this->filesystem->has($this->prepare_file));
        $this->assertFalse($this->filesystem->has($this->prepare_file . "xxx"));
    }

    /**
     *
     */
    public function testCopy()
    {
        try
		{
			$this->filesystem->copy($this->rename_file, 'copy.txt');
		} catch (OssException $e) {
            $this->assertTrue(false);
	    }
        $this->assertTrue($this->filesystem->has('copy.txt'));
        try
		{
			$this->filesystem->delete('copy.txt');
		} catch (OssException $e) {
            $this->assertTrue(false);
	    }
    }

    /**
     * 
     */
    public function testDelete()
    {
        try
		{
			$this->filesystem->delete($this->delete_file);
		} catch (OssException $e) {
            $this->assertTrue(false);
		}
        $this->assertFalse($this->filesystem->has($this->delete_file));
    }

    /**
     *
     */
    public function testRename()
    {
		$file = time() . 'txt';
        $this->filesystem->rename($this->rename_file, $file);
        $this->assertFalse($this->filesystem->has($this->rename_file));
        $this->assertTrue($this->filesystem->has($file));
        $this->filesystem->delete($file);
    }

    /**
     *
     */
    public function testCreateDir()
    {
        try
		{
			$this->filesystem->createDir($this->create_dir);
		} catch (OssException $e) {
            $this->assertTrue(false);
        }
        try
		{
			$this->filesystem->copy($this->prepare_file, $this->create_dir . '/' . $this->prepare_file);
		} catch(OssException $e) {
            $this->assertTrue(false);
		}
    }

    public function testListContents()
    {
        $dir = time() ."listcontents";
        $this->filesystem->createDir($dir);
        
		$this->filesystem->write($dir . '/1.txt', '123');
		$this->filesystem->write($dir . '/2.txt', '123');
		$this->filesystem->write($dir . '/3.txt', '123');
		$this->filesystem->write($dir . '/secondlevel/4.txt', '123');
		 

        $list = $this->filesystem->listContents($dir, true);
        $this->assertEquals(count($list), 4);
 
        $list = $this->filesystem->listContents($dir, false);
        $this->assertEquals(count($list), 0);
       
		$this->filesystem->deleteDir($dir);
	}

    /**
     *
     */
    public function testDeleteDir()
    {
        $this->filesystem->createDir($this->create_dir);
        $this->filesystem->deleteDir($this->create_dir);
        $this->assertFalse($this->filesystem->has($this->create_dir . '/'));
    }

    public function testRead()
    {
        $this->assertInternalType('string', $this->filesystem->read($this->prepare_file));
    }

    public function testReadStream()
    {
        $this->assertInternalType('resource', $this->filesystem->readStream($this->prepare_file));
    }

    public function testGetMetadata()
    {
        $data = $this->filesystem->getMetadata($this->prepare_file);

        $this->assertArrayHasKey('type', $data);
        $this->assertArrayHasKey('dirname', $data);
        $this->assertArrayHasKey('path', $data);
        $this->assertArrayHasKey('timestamp', $data);
        $this->assertArrayHasKey('mimetype', $data);
        $this->assertArrayHasKey('size', $data);
    }

    public function testGetMimetype()
    {
        $this->assertInternalType('string', $this->filesystem->getMimetype($this->prepare_file));
    }

    public function testGetTimestamp()
    {
        $this->assertInternalType('integer', $this->filesystem->getTimestamp($this->prepare_file));
    }

    public function testGetSize()
    {
        $this->assertInternalType('integer', $this->filesystem->getSize($this->prepare_file));
    }
}
