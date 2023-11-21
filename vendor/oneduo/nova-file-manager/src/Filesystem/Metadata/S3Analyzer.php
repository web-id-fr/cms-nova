<?php

declare(strict_types=1);

namespace Oneduo\NovaFileManager\Filesystem\Metadata;

use Oneduo\NovaFileManager\Filesystem\Support\GetID3;

class S3Analyzer extends Analyzer
{
    protected function rawAnalyze(string $path): array
    {
        /** @var \Illuminate\Filesystem\AwsS3V3Adapter $filesystem */
        $filesystem = $this->disk;

        $filesystem->getClient()->registerStreamWrapper();

        $bucket = data_get($filesystem->getConfig(), 'bucket');

        return (new GetID3())->analyze(
            filename: sprintf('s3://%s/%s', $bucket, $path),
            fp: $filesystem->readStream($path),
        );
    }
}
