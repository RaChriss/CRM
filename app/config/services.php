<?php

use app\models\AlimentationModel;
use app\models\AnimalModel;
use app\models\GeneraliserModel;
use app\models\GestionModel;
use app\models\ReinitialisationModel;
use app\models\UploadModel;
use app\models\ActionModel;
use app\models\ReactionModel;
use app\models\StatsModel;
use flight\Engine;
use flight\database\PdoWrapper;
use flight\debug\database\PdoQueryCapture;
use Tracy\Debugger;

/** 
 * @var array $config This comes from the returned array at the bottom of the config.php file
 * @var Engine $app
 */

// uncomment the following line for MySQL
 $dsn = 'mysql:host=' . $config['database']['host'] . ';dbname=' . $config['database']['dbname'] . ';charset=utf8mb4';

// uncomment the following line for SQLite
// $dsn = 'sqlite:' . $config['database']['file_path'];

// Uncomment the below lines if you want to add a Flight::db() service
// In development, you'll want the class that captures the queries for you. In production, not so much.
 $pdoClass = Debugger::$showBar === true ? PdoQueryCapture::class : PdoWrapper::class;
 $app->register('bdd', $pdoClass, [ $dsn, $config['database']['user'] ?? null, $config['database']['password'] ?? null ]);

// Got google oauth stuff? You could register that here
// $app->register('google_oauth', Google_Client::class, [ $config['google_oauth'] ]);

// Redis? This is where you'd set that up
// $app->register('redis', Redis::class, [ $config['redis']['host'], $config['redis']['port'] ]);



Flight::map('generaliserModel', function () {
    return new GeneraliserModel(Flight::bdd());
});

Flight::map('actionModel', function () {
    return new ActionModel(Flight::bdd());
});

Flight::map('reactionModel', function () {
    return new ReactionModel(Flight::bdd());
});


Flight::map('statsModel', function () {
    return new StatsModel(Flight::bdd());
});
