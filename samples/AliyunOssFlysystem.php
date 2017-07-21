<?php
require_once __DIR__ . '/Common.php';

if (is_file(__DIR__ . '/../../../autoload.php')) {
    require_once __DIR__ . '/../../../autoload.php';
}
require_once __DIR__ . '/Config.php';

use OSS\OssClient;
use OSS\Core\OssException;
use League\Flysystem\Filesystem;
use Moyue\Flysystem\AliyunOss\Plugins\PutFile;
use Moyue\Flysystem\AliyunOss\AliyunOssAdapter;

$bucket = Common::getBucketName();
$ossClient = Common::getOssClient();
if (is_null($ossClient)) exit(1);
//*******************************简单使用***************************************************************
$adapter = new AliyunOssAdapter($ossClient, $bucket);
$filesystem = new Filesystem($adapter);
$filesystem->addPlugin(new PutFile());


$adapter->deleteDir('aliyuncs-flysystem-samples');
$adapter->setPathPrefix('aliyuncs-flysystem-samples');

// 写字符串到oss文件
$filesystem->write('1.txt', '123');

// 判断oss文件是否存在
$isTrue = $filesystem->has('1.txt');
Common::println("1.txt is exsit ?" . $isTrue);

// 读oss文件到本地变量
$data = $filesystem->read('1.txt');
Common::println("read content is". $data);

// 更新oss文件
$filesystem->update('1.txt', '456');
$data = $filesystem->read('1.txt');
Common::println("update content is" . $data);

// 重命名oss文件
$filesystem->rename('1.txt', '2.txt');
$isTrue = $filesystem->has('1.txt');
Common::println("1.txt is exsit ? ". $isTrue);

// 判断oss文件是否存在
$isTrue = $filesystem->has('2.txt');
Common::println("2.txt is exsit ? ". $isTrue);

// 获取oss文件meta
$result = $filesystem->getMetadata('2.txt');
echo "getMetadata result: ";
print_r($result);

// 获取oss文件mine type
$result = $filesystem->getMimetype('2.txt');
Common::println("getMimetype result:". $result);

// 获取oss文件时间戳
$result = $filesystem->getTimestamp('2.txt');
Common::println("getTimestamp result:". $result);

// 获取oss文件size
$result = $filesystem->getSize('2.txt');
Common::println("getSize result:". $result);

// 在oss上创建文件目录
$filesystem->createDir('test');
// 拷贝oss文件
$filesystem->copy('2.txt', 'test/3.txt');

//
$result = $filesystem->listContents('', true);
echo "listContents result: ";
print_r($result);
?>
