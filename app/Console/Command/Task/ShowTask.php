<?php

class ShowTask extends Shell {

    var $uses = array('User');


    function execute($params)
    {
        //echo "hello";

        $users = $this->User->find("all");

        $this->out("------Users-----\n");

        $this->out("ID\tNAME");

        foreach($users as $user)
        {
            $this->out($user['User']['id']."\t".$user['User']['name']);

        }

       // $this->out($users['User']['id'][0]);

        //echo $this->params."\n";

    }



}