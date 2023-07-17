<?php
//php server2.php start
    use Workerman\Worker;
    use Workerman\Lib\Timer;
    require_once __DIR__ . '/vendor/autoload.php';
 

    $num_players = 0;
    function generateRandomNumberJsonMessage($maxRandNum) {
		$time = date('h:i:s');
		$num=rand(0, intval($maxRandNum));  
		 
		$obj = new stdClass();
		$obj->msg = "The server time is: {$time}";
		$obj->num = $GLOBALS['num_players'];
		return json_encode($obj);
	}

    // SSL context.
    $context = [
        'ssl' => [
            'local_cert'  => '/home/xmatuskam3/webte_fei_stuba_sk.pem',
            'local_pk'    => '/home/xmatuskam3/webte.fei.stuba.sk.key',
            'verify_peer' => false,
        ]
    ];
    
    // Create A Worker and Listens 9000 port, use Websocket protocol
    $ws_worker = new Worker("websocket://0.0.0.0:9000", $context);
    
    // Enable SSL. WebSocket+SSL means that Secure WebSocket (wss://). 
    // The similar approaches for Https etc.
    $ws_worker->transport = 'ssl';
 
    // 4 processes
    $ws_worker->count = 4;
    
    // Add a Timer to Every worker process when the worker process start
    $ws_worker->onWorkerStart = function($ws_worker)
    {   $GLOBALS['userdata']=0;    
        // Timer every 5 seconds
        Timer::add(2, function()use($ws_worker)
        {          
          // Iterate over connections and send the time          
          foreach($ws_worker->connections as $connection)
            {
                $connection->send(generateRandomNumberJsonMessage($GLOBALS['userdata']));
            }            
        });
    
 
    // Emitted when new connection come
    $ws_worker->onConnect = function($connection)
    {
        // Emitted when websocket handshake done
        //$GLOBALS['num_players'];

        $GLOBALS['num_players'] = $GLOBALS['num_players'] + 1;
        $connection->onWebSocketConnect = function($connection)
        {
            echo "New connection ". $GLOBALS['num_players'] ."\n";
        };
    };
 
    $ws_worker->onMessage = function($connection, $data)
    {
        $GLOBALS['userdata']=$data;
        // Send hello $data
        $connection->send(generateRandomNumberJsonMessage($data));
        echo "New connection ". $GLOBALS['num_players'] ."\n";
    };
 
    // Emitted when connection closed
    $ws_worker->onClose = function($connection)
    {
        echo "Connection closed";
    };
}; 
    // Run worker
    Worker::runAll();
    
    
?>