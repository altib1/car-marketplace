<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;

class FileUploader
{
    private const ALLOWED_MIMES = ['image/jpeg', 'image/png', 'image/webp'];
    private const MAX_FILE_SIZE = 20971520; // 20MB
    private const THUMB_SIZES = [
        'small' => [320, 240],
        'medium' => [640, 480],
        'large' => [1024, 768]
    ];

    // Define valid upload contexts
    private const VALID_CONTEXTS = [
        'publications',
        'shop',
    ];

    private $imagine;

    public function __construct(
        private string $baseUploadDirectory,
        private SluggerInterface $slugger,
    ) {
        $this->imagine = new Imagine();
    }

    public function upload(UploadedFile $file, string $context, bool $createThumbnails = true): array 
    {
        // Validate context and file
        if (!in_array($context, self::VALID_CONTEXTS)) {
            throw new FileException('Invalid upload context');
        }
        $this->validateFile($file);
    
        // Setup filenames and paths
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = sprintf('%s-%s.jpg', $safeFilename, uniqid());
        $contextDirectory = $this->getContextDirectory($context);
        
        try {
            // Create temp directory if it doesn't exist
            $tempDir = $contextDirectory . '/temp';
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }
    
            // Move uploaded file to secure temp location
            $tempFile = $tempDir . '/' . $fileName;
            if (!copy($file->getPathname(), $tempFile)) {
                throw new FileException('Failed to copy uploaded file to temp location');
            }

            // Load image from temp location
            $image = $this->imagine->open($tempFile);
            
            $urls = [];
    
            // Generate thumbnails
            if ($createThumbnails) {
                foreach (self::THUMB_SIZES as $size => [$width, $height]) {
                    $thumbPath = sprintf('%s/thumbs/%s/%s', $contextDirectory, $size, $fileName);
                    $this->ensureDirectoriesExist(dirname($thumbPath));
                    
                    $box = $this->calculateDimensions($image->getSize(), $width, $height);
                    $image->copy()
                         ->resize($box)
                         ->save($thumbPath, [
                             'jpeg_quality' => 75,
                             'strip' => true
                         ]);
                         
                    $urls[$size] = sprintf('/uploads/%s/thumbs/%s/%s', $context, $size, $fileName);
                }
            }
    
            // Save original
            $originalPath = sprintf('%s/original/%s', $contextDirectory, $fileName);
            $this->ensureDirectoriesExist(dirname($originalPath));
            $image->save($originalPath, [
                'jpeg_quality' => 85,
                'strip' => true
            ]);
    
            $urls['original'] = sprintf('/uploads/%s/original/%s', $context, $fileName);
    
            // Cleanup temp file
            if (file_exists($tempFile)) {
                unlink($tempFile);
            }
    
            return [
                'filename' => $fileName,
                'context' => $context,
                'urls' => $urls
            ];
    
        } catch (\Exception $e) {
            // Cleanup on error
            if (isset($tempFile) && file_exists($tempFile)) {
                unlink($tempFile);
            }
            throw new FileException('Failed to process and upload file: ' . $e->getMessage());
        }
    }
    

    private function getContextDirectory(string $context): string
    {
        return sprintf('%s/%s', $this->baseUploadDirectory, $context);
    }

    private function validateFile(UploadedFile $file): void
    {
        if (!in_array($file->getMimeType(), self::ALLOWED_MIMES)) {
            throw new FileException('Invalid file type. Allowed types: JPG, PNG, WebP');
        }

        if ($file->getSize() > self::MAX_FILE_SIZE) {
            throw new FileException('File too large. Maximum size: 20MB');
        }

            // Check extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
            throw new FileException('Invalid file extension. Allowed: ' . implode(', ',  ['jpg', 'jpeg', 'png', 'webp']));
        }
    
        // Check mime type
        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, self::ALLOWED_MIMES)) {
            throw new FileException('Invalid file type. Allowed: ' . implode(', ', self::ALLOWED_MIMES));
        }
    
        // Check file size
        if ($file->getSize() > self::MAX_FILE_SIZE) {
            throw new FileException('File too large. Maximum size: 20MB');
        }
    
        // Verify temp file
        if (!is_uploaded_file($file->getPathname())) {
            throw new FileException('Invalid upload file');
        }
    }

    private function ensureDirectoriesExist(string $contextDirectory): void
    {
        // Define required paths
        $paths = [
            sprintf('%s/temp', $contextDirectory),
            sprintf('%s/original', $contextDirectory),
            sprintf('%s/thumbs', $contextDirectory),
        ];
    
        // Add thumbnail size directories
        foreach (array_keys(self::THUMB_SIZES) as $size) {
            $paths[] = sprintf('%s/thumbs/%s', $contextDirectory, $size);
        }
    
        // Create directories if they don't exist
        foreach ($paths as $path) {
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
        }
    }

    private function calculateDimensions($originalSize, $maxWidth, $maxHeight): Box
    {
        $width = $originalSize->getWidth();
        $height = $originalSize->getHeight();
        
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        
        if ($ratio > 1) {
            return new Box($width, $height);
        }
        
        return new Box(
            (int) ($width * $ratio),
            (int) ($height * $ratio)
        );
    }

    public function delete(string $filename, string $context): void
    {
        if (!in_array($context, self::VALID_CONTEXTS)) {
            throw new FileException('Invalid context for deletion');
        }

        $contextDirectory = $this->getContextDirectory($context);

        try {
            // Delete thumbnails
            foreach (array_keys(self::THUMB_SIZES) as $size) {
                $thumbPath = sprintf('%s/thumbs/%s/%s', 
                    $contextDirectory,
                    $size,
                    $filename
                );
                if (file_exists($thumbPath)) {
                    unlink($thumbPath);
                }
            }

            // Delete original
            $originalPath = sprintf('%s/original/%s', $contextDirectory, $filename);
            if (file_exists($originalPath)) {
                unlink($originalPath);
            }
        } catch (\Exception $e) {
            throw new FileException('Failed to delete file: ' . $e->getMessage());
        }
    }
}