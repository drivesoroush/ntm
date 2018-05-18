<?php

namespace Ntcm\Ncm;

use Ntcm\Exceptions\ProcessExecutionFailedException;

trait HelperCommands {

    /**
     * Get running config for this host.
     *
     * @return string
     * @throws ProcessExecutionFailedException
     */
    public function show_running_config()
    {
        // run the backup command...
        // this would populate the filename attribute of this class...
        $this->backup();

        // create the full file path...
        $filePath = tftp_path($this->filename);

        // fetch the content...
        $running = file_get_contents($filePath);

        return $running;
    }
}