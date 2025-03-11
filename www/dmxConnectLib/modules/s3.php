<?php

namespace modules;

if (file_exists(__DIR__ . '/../aws/aws-autoloader.php')) {
    require(__DIR__ . '/../aws/aws-autoloader.php');
}

use \lib\core\Module;
use \lib\core\Path;
use \lib\core\FileSystem;
use \lib\db\Connection;
use \lib\db\SqlBuilder;
use \Aws\S3\S3Client;

class s3 extends Module
{
    public function provider($options, $name) {
        $pos = stripos($options->endpoint, '.amazonaws');
        $region = isset($options->region) ? $options->region : 'us-east-1';

        if ($pos) {
            $region = substr($options->endpoint, 3, $pos - 3);
        }

        $this->app->s3[$name] = new \Aws\S3\S3Client([
            'version' => 'latest',
            'region' => $region,
            'endpoint' => 'https://' . $options->endpoint,
            'credentials' => [
                'key' => $options->accessKeyId,
                'secret' => $options->secretAccessKey
            ]
        ]);

        return $this->app->s3[$name];
    }

    private function getClient($name) {
        if (isset($this->app->s3[$name])) {
            return $this->app->s3[$name];
        }

        $path = realpath($this->app->get('ACTIONS_URL', BASE_URL . '/../dmxConnect/modules/s3/' . $name . '.php'));
		if (FileSystem::exists($path)) {
            require(FileSystem::encode($path));
            $data = json_decode($exports);
            return $this->provider($this->app->parseObject($data->options), $name);
		}
		
		throw new \Exception('S3 Client "' . $name . '" not found.');
    }

    public function createBucket($options) {
        option_require($options, 'provider');
        option_require($options, 'bucket');
        option_default($options, 'acl', NULL);

        $options = $this->app->parseObject($options);

        $s3 = $this->getClient($options->provider);

        $result =  $s3->createBucket(array(
            'Bucket' => $options->bucket,
            'ACL' => $options->acl
        ));

        $s3->waitUntil('BucketExists', array(
            'Bucket' => $options->bucket
        ));

        return $result->toArray();
    }

    public function listBuckets($options) {
        option_require($options, 'provider');

        $options = $this->app->parseObject($options);

        $s3 = $this->getClient($options->provider);

        $data = $s3->listBuckets()->toArray();

        foreach ($data['Buckets'] as &$bucket) {
            $bucket['CreationDate'] = (string)$bucket['CreationDate'];
        }

        return $data;
    }

    public function deleteBucket($options) {
        option_require($options, 'provider');
        option_require($options, 'bucket');

        $options = $this->app->parseObject($options);

        $s3 = $this->getClient($options->provider);

        return $s3->deleteBucket(array(
            'Bucket' => $options->bucket
        ))->toArray();
    }

    public function listFiles($options) {
        option_require($options, 'provider');
        option_require($options, 'bucket');
        option_default($options, 'maxKeys', 1000);
        option_default($options, 'prefix', NULL);
        option_default($options, 'continuationToken', NULL);
        option_default($options, 'startAfter', NULL);

        $options = $this->app->parseObject($options);

        $s3 = $this->getClient($options->provider);

        $data = $s3->listObjectsV2([
            'Bucket' => $options->bucket,
            'MaxKeys' => $options->maxKeys,
            'Prefix' => $options->prefix,
            'ContinuationToken' => $options->continuationToken,
            'StartAfter' => $options->startAfter
        ])->toArray();

        foreach ($data['Contents'] as &$content) {
            $content['LastModified'] = (string)$content['LastModified'];
        }

        return $data;
    }

    public function putFile($options) {
        option_require($options, 'provider');
        option_require($options, 'bucket');
        option_require($options, 'key');
        option_require($options, 'path');
        option_default($options, 'contentType', NULL);
        option_default($options, 'contentDisposition', NULL);
        option_default($options, 'acl', NULL);

        $options = $this->app->parseObject($options);

        $s3 = $this->getClient($options->provider);

        $path = Path::toSystemPath($options->path);

        $result = $s3->putObject(array(
            'Bucket' => $options->bucket,
            'Key' => $options->key,
            'ContentType' => $options->contentType != NULL ? $options->contentType : mime_content_type($path),
            'ContentDisposition' => $options->contentDisposition,
            'Body' => fopen($path, 'rb'),
            'ACL' => $options->acl
        ));

        $s3->waitUntil('ObjectExists', array(
            'Bucket' => $options->bucket,
            'Key' => $options->key
        ));

        return $result->toArray();
    }

    public function getFile($options) {
        option_require($options, 'provider');
        option_require($options, 'bucket');
        option_require($options, 'key');
        option_require($options, 'path');
        option_default($options, 'stripKeyPath', FALSE);

        $options = $this->app->parseObject($options);

        $s3 = $this->getClient($options->provider);

        $path = Path::toSystemPath($options->path);
        $file = $options->key;

        if ($options->stripKeyPath) {
            $file = basename($file);
        }

        $data = $s3->getObject([
            'Bucket' => $options->bucket,
            'Key' => $options->key,
            'SaveAs' => $path . '/' . $file
        ]);

        return;
    }

    public function deleteFile($options) {
        option_require($options, 'provider');
        option_require($options, 'bucket');
        option_require($options, 'key');

        $options = $this->app->parseObject($options);

        $s3 = $this->getClient($options->provider);

        return $s3->deleteObject(array(
            'Bucket' => $options->bucket,
            'Key' => $options->key
        ))->toArray();
    }

    public function downloadFile($options) {
        option_require($options, 'provider');
        option_require($options, 'bucket');
        option_require($options, 'key');

        $options = $this->app->parseObject($options);

        $s3 = $this->getClient($options->provider);

        if (!$s3->doesObjectExist($options->bucket, $options->key)) {
            $this->app->response->end(404);
        }

        $result = $s3->getObject([
            'Bucket' => $options->bucket,
            'Key' => $options->key
        ]);

        header('Content-Type: ' . $result['ContentType']);
        header('Content-Disposition: attachment; filename="' . basename($options->key) . '"');
        header('Content-Length: ' . $result['ContentLength']);

        exit($result['Body']);
    }

    public function signDownloadUrl($options) {
        option_require($options, 'provider');
        option_require($options, 'bucket');
        option_require($options, 'key');
        option_default($options, 'expires', 300);

        $options = $this->app->parseObject($options);

        $s3 = $this->getClient($options->provider);

        $cmd = $s3->getCommand('GetObject', array(
            'Bucket' => $options->bucket,
            'Key' => $options->key
        ));

        $request = $s3->createPresignedRequest($cmd, '+' . $options->expires . ' seconds');

        return (string)$request->getUri();
    }

    public function signUploadUrl($options) {
        option_require($options, 'provider');
        option_require($options, 'bucket');
        option_require($options, 'key');
        option_default($options, 'expires', 300);
        option_default($options, 'acl', NULL);

        $options = $this->app->parseObject($options);

        $s3 = $this->getClient($options->provider);

        $cmd = $s3->getCommand('PutObject', array(
            'Bucket' => $options->bucket,
            'Key' => $options->key,
            'ACL' => $options->acl
        ));

        $request = $s3->createPresignedRequest($cmd, '+' . $options->expires . ' seconds');

        return (string)$request->getUri();
    }
}