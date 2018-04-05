<?php

namespace Ntcm\Ntm\Util;

use Ntcm\Exceptions\ProcessExecutionFailedException;
use Symfony\Component\Process\Process;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class ProcessExecutor {

    /**
     * @var string
     */
    protected $output;

    /**
     * @var integer
     */
    protected $exitCode;

    /**
     * Executes a process.
     *
     * @param string  $command The command to execute.
     * @param integer $timeout
     *
     * @return integer
     * @throws ProcessExecutionFailedException
     */
    public function execute($command, $timeout)
    {
        $process = new Process($command, null, null, null, $timeout);

        $this->setOutput($process->run());
        $this->setExitCode($process->getExitCode());

        if( ! $process->isSuccessful()) {
            throw new ProcessExecutionFailedException(
                sprintf(
                    'Failed to execute "%s"' . PHP_EOL . '%s',
                    $command,
                    $process->getErrorOutput()
                )
            );
        }

        return $process->getExitCode();
    }

    /**
     * @return string
     */
    public function getOutput(): string
    {
        return $this->output;
    }

    /**
     * @param string $output
     */
    public function setOutput(string $output): void
    {
        $this->output = $output;
    }

    /**
     * @return int
     */
    public function getExitCode(): int
    {
        return $this->exitCode;
    }

    /**
     * @param int $exitCode
     */
    public function setExitCode(int $exitCode): void
    {
        $this->exitCode = $exitCode;
    }
}
