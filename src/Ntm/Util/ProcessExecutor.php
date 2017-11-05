<?php

namespace Ntcm\Ntm\Util;

use Ntcm\Exceptions\ScanFailedException;
use Symfony\Component\Process\Process;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class ProcessExecutor {

    /**
     * Executes a process.
     *
     * @param string  $command The command to execute.
     * @param integer $timeout
     *
     * @return integer
     * @throws ScanFailedException
     */
    public function execute($command, $timeout)
    {
        $process = new Process($command, null, null, null, $timeout);
        $process->run();

        if( ! $process->isSuccessful()) {
            throw new ScanFailedException(
                sprintf(
                    'Failed to execute "%s"' . PHP_EOL . '%s',
                    $command,
                    $process->getErrorOutput()
                )
            );
        }

        return $process->getExitCode();
    }
}
