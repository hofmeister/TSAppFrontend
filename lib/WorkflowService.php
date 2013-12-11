<?php

class WorkflowService extends RestService {

    function __construct() {
        parent::__construct('http://localhost:8898/tradeshift-workflow/rest');
    }
}