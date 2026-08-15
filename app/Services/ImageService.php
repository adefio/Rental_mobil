<?php

namespace App\Services;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    private const CAR_MAX_WIDTH = 1600;

    private const CAR_QUALITY = 95;

    private const PROFILE_MAX_SIZE = 500;

    private const PROFILE_QUALITY = 95;

    public function processCarImage(UploadedFile $file, ?string $disk = null, string $dir = 'mobil'): string
    {
        $disk = $this->resolveDisk($disk);

        $info = @getimagesize($file->getRealPath());

        if ($info === false) {
            return $file->store($dir, $disk);
        }

        if ($info[0] <= self::CAR_MAX_WIDTH) {
            return $file->store($dir, $disk);
        }

        $image = $this->decode($file, $info['mime']);

        if ($image === null) {
            return $file->store($dir, $disk);
        }

        $image = $this->applyOrientation($image, $info['mime'], $file);

        $w = imagesx($image);
        $h = imagesy($image);

        $nw = self::CAR_MAX_WIDTH;
        $nh = (int) round($h * self::CAR_MAX_WIDTH / $w);

        $resized = imagecreatetruecolor($nw, $nh);
        $this->prepareTransparency($resized, $info['mime']);

        imagecopyresampled($resized, $image, 0, 0, 0, 0, $nw, $nh, $w, $h);
        imagedestroy($image);

        $temp = $this->writeTemp($resized, $info['mime'], self::CAR_QUALITY);

        return $this->storeTemp($resized, $temp, $disk, $dir);
    }

    public function processPaymentProof(UploadedFile $file, ?string $disk = null, string $dir = 'bukti'): string
    {
        $disk = $this->resolveDisk($disk);

        $info = @getimagesize($file->getRealPath());

        if ($info === false || $info[0] <= self::CAR_MAX_WIDTH) {
            return $file->store($dir, $disk);
        }

        $image = $this->decode($file, $info['mime']);

        if ($image === null) {
            return $file->store($dir, $disk);
        }

        $image = $this->applyOrientation($image, $info['mime'], $file);

        $w = imagesx($image);
        $h = imagesy($image);
        $nw = self::CAR_MAX_WIDTH;
        $nh = (int) round($h * self::CAR_MAX_WIDTH / $w);

        $resized = imagecreatetruecolor($nw, $nh);
        $this->prepareTransparency($resized, $info['mime']);

        imagecopyresampled($resized, $image, 0, 0, 0, 0, $nw, $nh, $w, $h);
        imagedestroy($image);

        $temp = $this->writeTemp($resized, $info['mime'], self::CAR_QUALITY);

        return $this->storeTemp($resized, $temp, $disk, $dir);
    }

    public function processProfileImage(UploadedFile $file, ?string $disk = null, string $dir = 'profil'): string
    {
        $disk = $this->resolveDisk($disk);

        $info = @getimagesize($file->getRealPath());

        if ($info === false) {
            return $file->store($dir, $disk);
        }

        $image = $this->decode($file, $info['mime']);

        if ($image === null) {
            return $file->store($dir, $disk);
        }

        $image = $this->applyOrientation($image, $info['mime'], $file);

        $w = imagesx($image);
        $h = imagesy($image);
        $mime = $info['mime'];

        $square = min($w, $h);
        $cropX = (int) (($w - $square) / 2);
        $cropY = (int) (($h - $square) / 2);

        $cropped = imagecreatetruecolor($square, $square);
        $this->prepareTransparency($cropped, $mime);

        imagecopy($cropped, $image, 0, 0, $cropX, $cropY, $square, $square);
        imagedestroy($image);

        if ($square > self::PROFILE_MAX_SIZE) {
            $target = self::PROFILE_MAX_SIZE;
            $resized = imagecreatetruecolor($target, $target);
            $this->prepareTransparency($resized, $mime);

            imagecopyresampled($resized, $cropped, 0, 0, 0, 0, $target, $target, $square, $square);
            imagedestroy($cropped);
            $cropped = $resized;
        }

        $temp = $this->writeTemp($cropped, $mime, self::PROFILE_QUALITY);

        return $this->storeTemp($cropped, $temp, $disk, $dir);
    }

    private function resolveDisk(?string $disk): string
    {
        return $disk ?? config('filesystems.storage_disk');
    }

    private function decode(UploadedFile $file, string $mime): ?\GdImage
    {
        return match ($mime) {
            'image/jpeg' => @imagecreatefromjpeg($file->getRealPath()),
            'image/png' => @imagecreatefrompng($file->getRealPath()),
            'image/webp' => @imagecreatefromwebp($file->getRealPath()),
            default => null,
        };
    }

    private function prepareTransparency(\GdImage $image, string $mime): void
    {
        if ($mime === 'image/png' || $mime === 'image/webp') {
            imagealphablending($image, false);
            imagesavealpha($image, true);
        }
    }

    private function applyOrientation(\GdImage $image, string $mime, UploadedFile $file): \GdImage
    {
        if ($mime !== 'image/jpeg' || ! function_exists('exif_read_data')) {
            return $image;
        }

        $exif = @exif_read_data($file->getRealPath());
        $orientation = (int) ($exif['Orientation'] ?? 1);

        $angle = match ($orientation) {
            3 => 180,
            6 => -90,
            8 => 90,
            default => null,
        };

        if ($angle === null) {
            return $image;
        }

        $rotated = imagerotate($image, $angle, 0);

        if ($rotated === false) {
            return $image;
        }

        imagedestroy($image);

        return $rotated;
    }

    private function writeTemp(\GdImage $image, string $mime, int $quality): string
    {
        $ext = match ($mime) {
            'image/png' => 'png',
            'image/webp' => 'webp',
            default => 'jpg',
        };

        $temp = tempnam(sys_get_temp_dir(), 'img').'.'.$ext;

        match ($mime) {
            'image/png' => imagepng($image, $temp, 6),
            'image/webp' => imagewebp($image, $temp, $quality),
            default => imagejpeg($image, $temp, $quality),
        };

        return $temp;
    }

    private function storeTemp(\GdImage $image, string $temp, string $disk, string $dir): string
    {
        imagedestroy($image);

        $stored = Storage::disk($disk)->putFile($dir, new File($temp));

        @unlink($temp);

        return $stored;
    }
}
