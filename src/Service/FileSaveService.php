<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;

class FileSaveService
{

    private SerializerInterface $serializer;
    private Filesystem $filesystem;


    public function __construct(SerializerInterface $serializer, Filesystem $filesystem)
    {
        $this->serializer = $serializer;
        $this->filesystem = $filesystem;
    }
 
    public function saveAsJson($message): void
    {
        $fileName = md5(uniqid()) . '.json';
        $serializedMessage = $this->serializer->serialize($message, 'json');
        try {
            $this->filesystem->dumpFile('../private/contact/' . $fileName, $serializedMessage);
        }
        catch(IOException $e) {
            //
        }
    }
}
