<?php

namespace Rattananen\Webdriver\Tests\Traits;

use Symfony\Component\Process\Process;

trait EnvironmentTrait
{
    public static Process $serverProcess;

    public static string $webhost = 'localhost:8878';

    public static string $tmpTestDir;

    public static function setUpBeforeClass(): void
    {
        if (!isset(static::$serverProcess)) {
            static::$serverProcess = new Process([
                'php',
                '-S',
                static::$webhost,
                '-t',
                __DIR__ . '/../Resources/web'
            ]);

            static::$serverProcess->start();

            if (!static::$serverProcess->isRunning()) {
                throw new \LogicException(static::$serverProcess->getErrorOutput());
            }
        }

        static::$tmpTestDir  = __DIR__ . '/../Resources/web/cap_test';
        if (!is_dir(static::$tmpTestDir)) {
            mkdir(static::$tmpTestDir);
        }
    }

    public static function tearDownAfterClass(): void
    {
        static::$serverProcess->stop();

        //remove tmp folder
        if (is_dir(static::$tmpTestDir)) {
            $it = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator(static::$tmpTestDir, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::CURRENT_AS_FILEINFO),
                \RecursiveIteratorIterator::SELF_FIRST
            );
            foreach ($it as $file) {
                if ($file->isDir()) {
                    rmdir($file->getPathName());
                } else {
                    unlink($file->getPathName());
                }
            }

            rmdir(static::$tmpTestDir);
        }
    }

    public static function getWebBaseUri(): string
    {
        return 'http://' . static::$webhost;
    }

    public static function getBaseTmpDir(): string
    {
        return static::$tmpTestDir;
    }
}
