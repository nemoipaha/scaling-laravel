<?php

namespace App\Http\Responses;

use App\ProfileImage;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class S3FileStream
{
    private $image;
    private $adapter;
    private $client;

    public function __construct(ProfileImage $image)
    {
        $this->image = $image;
        $this->adapter = $this->createAdapter();
        $this->client = $this->adapter->getClient();
    }

    private function createAdapter(): AwsS3Adapter
    {
        return Storage::disk('s3')->getAdapter();
    }

    public function output()
    {
        return $this->headers()
            ->stream();
    }

    private function headers(): self
    {
        $object = $this->client->headObject([
            'Bucket' => $this->adapter->getBucket(),
            'Key' => $this->image->path,
        ]);

        $headers = [
            'Last-Modified' => $object['LastModified'],
            // 'Etag' => $object['ETag'], # We are not currently implementing validation caching
            'Accept-Ranges' => $object['AcceptRanges'],
            'Content-Length' => $object['ContentLength'],
            'Content-Type' => $object['ContentType'],
            'Content-Disposition' => 'attachment; filename=' . basename($this->image->path),
        ];

        foreach($headers as $header => $value) {
            header("{$header}: {$value}");
        }

        return $this;
    }

    private function stream()
    {
        $this->client->registerStreamWrapper();

        $stream = fopen("s3://{$this->adapter->getBucket()}/{$this->image->path}", 'r');

        // Open a stream in read-only mode
        if (! $stream) {
            throw new HttpException(
                'Could not open stream for reading export [' . $this->image->path . ']'
            );
        }

        // Check if the stream has more data to read
        while (! feof($stream)) {
            // Read 1024 bytes from the stream
            echo fread($stream, 1024);
        }

        // Be sure to close the stream resource when you're done with it
        fclose($stream);
    }
}