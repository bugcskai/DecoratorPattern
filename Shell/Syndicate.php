<?php

namespace CliApp\Shell;

require ('../Base.php');

use CliApp\Model\Implentations\Iconic;
use CliApp\Model\Implentations\IconicLite;

Class Syndicate {
    private $is_cli = 0;

    private $iconic;

    public function __construct(
        Iconic $iconic,
        IconicLite $iconicLite
    )
    {
        if (PHP_SAPI == "cli") {
            $this->is_cli = 1;
        }

        $this->iconic = $iconic;
        $this->iconicLite = $iconicLite;
        $this->interpretCommand();
    }

    /**
     * @return [type]
     */
    protected function interpretCommand(){
        if (!$this->is_cli)
        {
            exit("Terminating cause not called from console");
        }

        $args = getopt("t:p::", ["type::","pages::"]);
        if (!count($args))
        {
            exit("No arguments provided
            \nUsage example 'php Syndicate.php -t verbose'
            \nPlease use -t verbose|debug or --type=verbose|debug to display decorated results
            \nUse -p<page> to decorate a certain page
            ");
        }

        $argument = ($args["t"]) ? $args["t"]: $args["type"];
        $argument_p = (int) ($args["p"] ?? $args["pages"] ?? 1);

        switch($argument)
        {            
            case "debug":
                if(is_int($argument_p))
                {
                    $this->iconicLite->setPage($argument_p);
                }
                $result = $this->iconicLite->processApi();
            break;
            
            case "verbose": default:
                if(is_int($argument_p))
                {
                    $this->iconic->setPage($argument_p);
                }
                $result = $this->iconic->processApi();
            break;
        } 

        print_r(json_encode($result));
        
    }
}

new Syndicate(
    new Iconic(), 
    new IconicLite()
);