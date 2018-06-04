<?php
require_once __DIR__ . '/Common.php';

use League\Flysystem\Filesystem;
use Aliyun\Flysystem\AliyunOss\Plugins\PutFile;
use Aliyun\Flysystem\AliyunOss\AliyunOssAdapter;

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
Common::println("1.txt exists? " . $isTrue);

// 读oss文件到本地变量
$data = $filesystem->read('1.txt');
Common::println("read content is ". $data);

// 更新oss文件
$filesystem->update('1.txt', '456');
$data = $filesystem->read('1.txt');
Common::println("update content is " . $data);

// 重命名oss文件
$filesystem->rename('1.txt', '2.txt');
$isTrue = $filesystem->has('1.txt');
Common::println("1.txt exists? ". $isTrue);

// 判断oss文件是否存在
$isTrue = $filesystem->has('2.txt');
Common::println("2.txt exists? ". $isTrue);

// 获取oss文件meta
$result = $filesystem->getMetadata('2.txt');
echo "getMetadata result: ";
print_r($result);

// 获取oss文件mine type
$result = $filesystem->getMimetype('2.txt');
Common::println("getMimetype result: ". $result);

// 获取oss文件时间戳
$result = $filesystem->getTimestamp('2.txt');
Common::println("getTimestamp result: ". $result);

// 获取oss文件size
$result = $filesystem->getSize('2.txt');
Common::println("getSize result: ". $result);

// 在oss上创建文件目录
$filesystem->createDir('test');
// 拷贝oss文件
$filesystem->copy('2.txt', 'test/3.txt');

// 按前缀list, true是递归list出所有文件,false只list当前文件夹的文件
$result = $filesystem->listContents('', true);
echo "listContents result: ";
print_r($result);

// 按前缀list, true是递归list出所有文件,false只list当前文件夹的文件
$result = $filesystem->listContents('', true);
echo "listContents result: ";
print_r($result);
?>
