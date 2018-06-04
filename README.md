# Flysystem Adapter for AliCloud OSS

[![Build Status](https://travis-ci.org/aliyun/aliyun-oss-php-sdk-flysystem.svg?branch=master)](https://travis-ci.org/aliyun/aliyun-oss-php-sdk-flysystem)
[![Coverage Status](https://coveralls.io/repos/github/aliyun/aliyun-oss-php-sdk-flysystem/badge.svg?branch=master)](https://coveralls.io/github/aliyun/aliyun-oss-php-sdk-flysystem?branch=master)

This is a Flysystem Adapter for the AliCloud OSS ^2.2.1

## Installation

```bash
composer require aliyuncs/aliyun-oss-flysystem
```

## Environment variables (oss.env)
Samples and unit tests depend on environment variables for OSS configuration.
```
cp oss.env-example oss.env
vim oss.env

# edit environment variables, e.g.:
export OSS_ACCESS_KEY_ID=your id
export OSS_ACCESS_KEY_SECRET=your secret
export OSS_ENDPOINT=your endpoint
export OSS_BUCKET=your bucket

Write and save (:wq).
```

## Running Sample

```
source oss.env

cd vendor/aliyun/aliyun-oss-flysystem/

php samples/AliyunOssFlysystem.php
```

## Running Test

```bash
source oss.env

cd vendor/aliyun/aliyun-oss-flysystem/

composer install

php vendor/bin/phpunit
```

## License 
- [MIT](https://github.com/aliyun/aliyun-oss-php-sdk-flysystem/blob/master/LICENSE.md)
