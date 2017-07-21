# Flysystem Adapter for Aliyun OSS.

[![Build Status](https://travis-ci.org/RobertYue19900425/aliyun-oss-flysystem.svg?branch=master)](https://travis-ci.org/RobertYue19900425/aliyun-oss-flysystem)
[![Coverage Status](https://coveralls.io/repos/github/RobertYue19900425/aliyun-oss-flysystem/badge.svg?branch=master)](https://coveralls.io/github/RobertYue19900425/aliyun-oss-flysystem?branch=master)

This is a Flysystem adapter for the Aliyun OSS ~1.0.0

## Installation

```bash
composer require moyue/aliyun-oss-flysystem
```

## Runing samples

```
cd vendor/moyue/aliyun-oss-flysystem/
vim samples/Config.php

modify the following config:
 const OSS_ACCESS_ID = '';
 const OSS_ACCESS_KEY = '';
 const OSS_ENDPOINT = '';
 const OSS_TEST_BUCKET = '';

php samples/AliyunOssFlysystem.php
```

## Runing tests

```bash
export OSS_ACCESS_KEY_ID=your id
export OSS_ACCESS_KEY_SECRET=your secret
export OSS_ENDPOINT=your endpoint
export OSS_BUCKET=your bucket
cd vendor/moyue/aliyun-oss-flysystem/
composer install
php vendor/bin/phpunit
```
