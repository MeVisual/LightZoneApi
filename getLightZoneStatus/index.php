<?php
	// api json返回服务器状态
	use xPaw\MinecraftPing;
	use xPaw\MinecraftPingException;

	// Edit this ->
	define( 'MQ_SERVER_ADDR', 'localhost' );
	define( 'MQ_SERVER_PORT', 25565 );
	define( 'MQ_TIMEOUT', 1 );
	// Edit this <-

	// 实现
	require __DIR__ . '/src/MinecraftPing.php';
	require __DIR__ . '/src/MinecraftPingException.php';
	
	$Timer = MicroTime( true );

	$Info = false;
	$Query = null;

	try
	{
		$Query = new MinecraftPing( MQ_SERVER_ADDR, MQ_SERVER_PORT, MQ_TIMEOUT );

		$Info = $Query->Query( );
	}
	catch( MinecraftPingException $e )
	{
		$Exception = $e;
	}

	$Timer = Number_Format( MicroTime( true ) - $Timer, 4, '.', '' );

	// 输出
	if( $Query !== null )
	{
		echo json_encode(array(
			'status' => 'success',
			'online' => $Info['players']['online'],
			'max' => $Info['players']['max'],
			'version' => $Info['version']['name'],
			'latency' => $Timer
		));
	}
	else
	{
		echo json_encode(array(
			'status' => 'error',
			'error' => $Exception->getMessage()
		));
	}
?>