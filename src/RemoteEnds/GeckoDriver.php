<?php

namespace Rattananen\Webdriver\RemoteEnds;

use Rattananen\Webdriver\RemoteEndInterface;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

/** 
 * @final 
 */
class GeckoDriver implements RemoteEndInterface
{
    private bool $stopped = true;

    private Process $process;

    public function __construct(?string $path = null, array $args = [])
    {
        if (!class_exists(Process::class)) {
            throw new \LogicException("Package symfony/process is required for GeckoDriver remote end.");
        }

        $path = $path ?? (new ExecutableFinder())->find('geckodriver');

        if (!isset($path)) {
            throw new \LogicException("Geckodriver executable was not found.");
        }

        $this->process = new Process([$path] + $args);
    }

    public function __destruct()
    {
        if ($this->stopped) {
            return;
        }
        $this->stop();
    }

    public function start(): void
    {
        $this->process->start();
        usleep(80000);// should have better way to block util process is ready
        if (!$this->process->isRunning()) {
            throw new \LogicException(sprintf("Can't start Geckodriver. stderr: %s", $this->process->getErrorOutput()));
        }

        $this->stopped = false;
    }

    public function stop(): void
    {
        $this->process->stop();
        $this->stopped = true;
    }
}
