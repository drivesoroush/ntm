<?php

namespace Ntm\Util;

use Symfony\Component\Process\Process;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class ProcessExecutor {

    /**
     * @param string $command The command to execute.
     *
     * @return integer
     */
    public function execute($command)
    {
        $process = new Process($command);
        $process->run();

        if( ! $process->isSuccessful()) {
            throw new \RuntimeException(sprintf(
                'Failed to execute "%s"' . PHP_EOL . '%s',
                $command,
                $process->getErrorOutput()
            ));
        }

        return $process->getExitCode();
    }
}
