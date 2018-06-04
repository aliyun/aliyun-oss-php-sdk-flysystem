<?php

if (is_file(__DIR__ . '/../../../aliyuncs/oss-sdk-php/autoload.php')) {
    require_once __DIR__ . '/../../../aliyuncs/oss-sdk-php/autoload.php';
} elseif (is_file(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

use OSS\OssClient;
use OSS\Core\OssException;

/**
 * Class Common
 *
 * 示例程序【Samples/*.php】 的Common类，用于获取OssClient实例和其他公用方法
 */
class Common
{
    /**
     * 根据Config配置，得到一个OssClient实例
     *
     * @return OssClient 一个OssClient实例
     */
    public static function getOssClient()
    {
        try {
            $ossClient = new OssClient(self::getAccessKeyId(), self::getAccessKeySecret(), self::getEndpoint(), false);
        } catch (OssException $e) {
            printf(__FUNCTION__ . "creating OssClient instance: FAILED\n");
            printf($e->getMessage() . "\n");
            return null;
        }
        return $ossClient;
    }

    public static function getAccessKeyId()
    {
        return getenv('OSS_ACCESS_KEY_ID');
    }

    public static function getAccessKeySecret()
    {
        return getenv('OSS_ACCESS_KEY_SECRET');
    }

    public static function getEndpoint()
    {
        return getenv('OSS_ENDPOINT');
    }

    public static function getBucketName()
    {
        return getenv('OSS_BUCKET');
    }

    /**
     * 工具方法，创建一个存储空间，如果发生异常直接exit
     */
    public static function createBucket()
    {
        $ossClient = self::getOssClient();
        if (is_null($ossClient)) exit(1);
        $bucket = self::getBucketName();
        $acl = OssClient::OSS_ACL_TYPE_PUBLIC_READ;
        try {
            $ossClient->createBucket($bucket, $acl);
        } catch (OssException $e) {

            $message = $e->getMessage();
            if (\OSS\Core\OssUtil::startsWith($message, 'http status: 403')) {
                echo "Please Check your AccessKeyId and AccessKeySecret" . "\n";
                exit(0);
            } elseif (strpos($message, "BucketAlreadyExists") !== false) {
                echo "Bucket already exists. Please check whether the bucket belongs to you, or it was visited with correct endpoint. " . "\n";
                exit(0);
            }
            printf(__FUNCTION__ . ": FAILED\n");
            printf($e->getMessage() . "\n");
            return;
        }
        print(__FUNCTION__ . ": OK" . "\n");
    }

    public static function println($message)
    {
        if (!empty($message)) {
            echo strval($message) . "\n";
        }
    }
}

Common::createBucket();
