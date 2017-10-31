# Flysystem Adapter for AliCloud OSS

[![Build Status](https://travis-ci.org/aliyun/aliyun-oss-php-sdk-flysystem.svg?branch=master)](https://travis-ci.org/aliyun/aliyun-oss-php-sdk-flysystem)
[![Coverage Status](https://coveralls.io/repos/github/aliyun/aliyun-oss-php-sdk-flysystem/badge.svg?branch=master)](https://coveralls.io/github/aliyun/aliyun-oss-php-sdk-flysystem?branch=master)

This is a Flysystem Adapter for the AliCloud OSS ~1.2.1

## Installation

```bash
composer require aliyuncs/aliyun-oss-flysystem
```

## Running Sample

```
cd vendor/aliyun/aliyun-oss-flysystem/

vim samples/Config.php

modify the following config:
 const OSS_ACCESS_ID = '';
 const OSS_ACCESS_KEY = '';
 const OSS_ENDPOINT = '';
 const OSS_TEST_BUCKET = '';

php samples/AliyunOssFlysystem.php
```

## Running Test

```bash
export OSS_ACCESS_KEY_ID=your id
export OSS_ACCESS_KEY_SECRET=your secret
export OSS_ENDPOINT=your endpoint
export OSS_BUCKET=your bucket

cd vendor/aliyun/aliyun-oss-flysystem/

composer install

php vendor/bin/phpunit
```

## License 
- [MIT](https://github.com/aliyun/aliyun-oss-php-sdk-flysystem/blob/master/LICENSE.md)
