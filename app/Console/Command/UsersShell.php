<?php

class UsersShell extends Shell{

    var $tasks = array('Show');


    function startup()
    {

    }

    function main() {

        $this->Show->execute();

    }

}