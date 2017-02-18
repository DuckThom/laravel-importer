<?php

return [
    /***********************************************************
     * Importers are used for defining specific import tasks
     * For instance, a ProductImporter could import a file with
     * products into a table.
     ***********************************************************/
    'importers' => [
        'default' => \Luna\Importer\Importers\BaseImporter::class
    ],

    /***********************************************************
     * Runners are used for looping through the file
     * The default is a CSV runner which will loop though
     * CSV files line-by-line. A runner uses an importer to get
     * import specific settings like the model class.
     ***********************************************************/
    'runners' => [
        'default' => \Luna\Importer\Runners\CsvRunner::class
    ]
];