<?php

#################################
### BASE PATH AND KEY FILES
#################################

$base_path = dirname(__FILE__) . DIRECTORY_SEPARATOR;

# crypto portfolio
$crypto_portfolio_files_path_file = $base_path . "portfolios/crypto_portfolio.txt";

# bankrekeningen portfolio
$bankrekeningen_files_path_file = $base_path . "geld/nordigan_accounts_data.txt";

# crypto sentiment
$sentiment_filename = $base_path . "sentiment/current.txt";

# presearch
$presearch_files_path_file = $base_path . "portfolios/scores.txt";
$users_txt_path_file = "/mnt/Syno_scripts/bitcoin/users.txt";

# home assistant
$homeassistant_url = "http://192.168.178.102:8123";
$homeassistant_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJiNTUwYzg4YTNkMTc0YjIzYWYzYTU1ZTE4MjliMDAwYiIsImlhdCI6MTY0OTMzNTgzOSwiZXhwIjoxOTY0Njk1ODM5fQ.iI1TxmHslw_jgTJoBIMhCw0rc9fuITiUoubfmASJ9vE";

# bookmarks
$bookmarks_filename = $base_path . "bookmarks.xbel";

#################################
### DISPLAY HEADER AND FOOTER
#################################

function showHeader( $title = "Home file server" ) {
	
	return "
		<meta charset='utf-8'>
		
		<title>" . $title . "</title>
		<meta name='author' content='Allard Höfelt'>
		<meta name='robots' content='none'>
		
		<link rel='shortcut icon' href='/favicon.png'>
		<link rel='icon' href='/favicon.ico' sizes='any'><!-- 32×32 -->
		<link rel='icon' href='/favicon.png' type='image/png'>
		<!-- https://developer.apple.com/library/archive/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
		<link rel='apple-touch-icon' sizes='180x180' href='/favicon_apple.png'><!-- 180×180 -->
		<link rel='apple-touch-startup-image' href='/favicon_apple.png'>
		<meta name='apple-mobile-web-app-title' content='Home'>
		<meta name='mobile-wep-app-capable' content='yes'>
		<meta name='apple-mobile-web-app-capable' content='yes'>
		<meta name='apple-mobile-web-app-status-bar-style' content='white'>
		
		<meta name='viewport' content='width=device-width, height=device-height, initial-scale=0.75, minimum-scale=0.6, maximum-scale=1.5, user-scalable=yes, viewport-fit=cover'>
		<link rel='manifest' href='/manifest.json'>
		
		<link rel='stylesheet' href='/css/bulma.min.css'>
		<link rel='stylesheet' href='/css/base.css'>
	";
	
}

function showHeader_jquery() {
	return "<script src='/js/jquery-3.6.0.slim.min.js'></script>";
}

function showHeader_fontawesome() {
	return "<script defer src='/css/fontawesome.js'></script>";
}

function showHeader_jsonviewer() {
	return "
		<link rel='stylesheet' href='/css/json-viewer.css'>
		<script src='/js/json-viewer.js'></script>
		<style>
			pre {
				white-space: initial;
				word-break: break-word;
			}
		</style>
	";
}

function showHeader_charter() {
	return "<script src='/js/chart.min.js'></script>";
}

function showHeader_gauge() {
	return "<script src='/js/gauge.js'></script>";
}

function showBody_navmenu_mainpage() {
	
	return "
		
		<script>
			$(document).ready(function() {
			  $('.navbar-burger').click(function() {
				  $('.navbar-burger').toggleClass('is-active');
				  $('.navbar-menu').toggleClass('is-active');
			  });
			});
		</script>
		
		<nav class='navbar' role='navigation' aria-label='main navigation'>
			
			<div class='navbar-brand'>
				
				<a class='navbar-item' href='../'>
					<img src='/favicon.png' width='30' height='30'>
				</a>
				
				<a role='button' class='navbar-burger' aria-label='menu' aria-expanded='false' data-target='navbarBasicExample'>
					<span aria-hidden='true'></span>
					<span aria-hidden='true'></span>
					<span aria-hidden='true'></span>
				</a>
				
			</div>
			
			<div id='navbarBasicExample' class='navbar-menu'>
				<div class='navbar-start'>
					<a class='navbar-item" . (( $_SERVER['REQUEST_URI'] == "/bookmarks.php" ) ? ' has-text-primary' : '') . "' href='bookmarks.php'>
						Bookmarks
					</a>
					<a class='navbar-item" . (( $_SERVER['REQUEST_URI'] == "/webcams.php" ) ? ' has-text-primary' : '') . "' href='webcams.php'>
						Webcams
					</a>
				</div>
			</div>
			
		</nav>
		
	";
	
}

function showBody_navmenu_sentiment() {
	
	return "
		
		<script>
			$(document).ready(function() {
			  $('.navbar-burger').click(function() {
				  $('.navbar-burger').toggleClass('is-active');
				  $('.navbar-menu').toggleClass('is-active');
			  });
			});
		</script>
		
		<nav class='navbar' role='navigation' aria-label='main navigation'>
			
			<div class='navbar-brand'>
				
				<a class='navbar-item' href='../'>
					<img src='/favicon.png' width='30' height='30'>
				</a>
				
				<a role='button' class='navbar-burger' aria-label='menu' aria-expanded='false' data-target='navbarBasicExample'>
					<span aria-hidden='true'></span>
					<span aria-hidden='true'></span>
					<span aria-hidden='true'></span>
				</a>
				
			</div>
			
			<div id='navbarBasicExample' class='navbar-menu'>
				<div class='navbar-start'>
					<a class='navbar-item" . (( $_SERVER['REQUEST_URI'] == "/sentiment/sentiment.php" ) ? ' has-text-primary' : '') . "' href='sentiment.php'>
						Sentiment Monitor
					</a>
					<a class='navbar-item" . (( $_SERVER['REQUEST_URI'] == "/sentiment/s2f.php" ) ? ' has-text-primary' : '') . "' href='s2f.php'>
						S2F model
					</a>
					<a class='navbar-item" . (( $_SERVER['REQUEST_URI'] == "/sentiment/rainbow.php" ) ? ' has-text-primary' : '') . "' href='rainbow.php'>
						Rainbow Charts
					</a>
				</div>
			</div>
			
		</nav>
		
	";
	
}

function showBody_navmenu_cryptofolio() {
	
	return "
		
		<script>
			$(document).ready(function() {
			  $('.navbar-burger').click(function() {
				  $('.navbar-burger').toggleClass('is-active');
				  $('.navbar-menu').toggleClass('is-active');
			  });
			});
		</script>
		
		<nav class='navbar' role='navigation' aria-label='main navigation'>
			
			<div class='navbar-brand'>
				
				<a class='navbar-item' href='../'>
					<img src='/favicon.png' width='30' height='30'>
				</a>
				
				<a role='button' class='navbar-burger' aria-label='menu' aria-expanded='false' data-target='navbarBasicExample'>
					<span aria-hidden='true'></span>
					<span aria-hidden='true'></span>
					<span aria-hidden='true'></span>
				</a>
				
			</div>
			
			<div id='navbarBasicExample' class='navbar-menu'>
				<div class='navbar-start'>
					<a class='navbar-item" . (( $_SERVER['REQUEST_URI'] == "/portfolios/portfolio.php" ) ? ' has-text-primary' : '') . "' href='portfolio.php'>
						Cryptofolio
					</a>
					<a class='navbar-item" . (( $_SERVER['REQUEST_URI'] == "/portfolios/presearch.php" ) ? ' has-text-primary' : '') . "' href='presearch.php'>
						Presearch Tracker
					</a>
				</div>
			</div>
			
		</nav>
		
	";
	
}

function showBody_navmenu_money() {
	
	return "
		
		<script>
			$(document).ready(function() {
			  $('.navbar-burger').click(function() {
				  $('.navbar-burger').toggleClass('is-active');
				  $('.navbar-menu').toggleClass('is-active');
			  });
			});
		</script>
		
		<nav class='navbar' role='navigation' aria-label='main navigation'>
			
			<div class='navbar-brand'>
				
				<a class='navbar-item' href='../'>
					<img src='/favicon.png' width='30' height='30'>
				</a>
				
				<a role='button' class='navbar-burger' aria-label='menu' aria-expanded='false' data-target='navbarBasicExample'>
					<span aria-hidden='true'></span>
					<span aria-hidden='true'></span>
					<span aria-hidden='true'></span>
				</a>
				
			</div>
			
			<div id='navbarBasicExample' class='navbar-menu'>
				<div class='navbar-start'>
					<a class='navbar-item" . (( $_SERVER['REQUEST_URI'] == "/geld/bankrekeningen.php" ) ? ' has-text-primary' : '') . "' href='bankrekeningen.php'>
						Bankrekeningen
					</a>
				</div>
			</div>
			
		</nav>
		
	";
	
}

function showBody_navmenu_home() {
	
	return "
		
		<script>
			$(document).ready(function() {
			  $('.navbar-burger').click(function() {
				  $('.navbar-burger').toggleClass('is-active');
				  $('.navbar-menu').toggleClass('is-active');
			  });
			});
		</script>
		
		<nav class='navbar' role='navigation' aria-label='main navigation'>
			
			<div class='navbar-brand'>
				
				<a class='navbar-item' href='../'>
					<img src='/favicon.png' width='30' height='30'>
				</a>
				
				<a role='button' class='navbar-burger' aria-label='menu' aria-expanded='false' data-target='navbarBasicExample'>
					<span aria-hidden='true'></span>
					<span aria-hidden='true'></span>
					<span aria-hidden='true'></span>
				</a>
				
			</div>
			
			<div id='navbarBasicExample' class='navbar-menu'>
				<div class='navbar-start'>
					<a class='navbar-item" . (( $_SERVER['REQUEST_URI'] == "/home/homewizard.php" ) ? ' has-text-primary' : '') . "' href='homewizard.php'>
						HomeWizard
					</a>
					<a class='navbar-item" . (( $_SERVER['REQUEST_URI'] == "/home/homewizard_sparklines.php" ) ? ' has-text-primary' : '') . "' href='homewizard_sparklines.php'>
						HomeWizard (sparklines)
					</a>
					<a class='navbar-item" . (( $_SERVER['REQUEST_URI'] == "/home/homewizard_graphs.php" ) ? ' has-text-primary' : '') . "' href='homewizard_graphs.php'>
						HomeWizard (graphs)
					</a>
				</div>
			</div>
			
		</nav>
		
	";
	
}

function load_bookmarks_file() {
	
	$xml = simplexml_load_file( $GLOBALS["bookmarks_filename"] ) or die( "Error: Cannot create object" );
	$bookmarks = $xml->folder[0];
	return $bookmarks;
	
}

function load_sentiment_file() {
	
	$sentiment_file_load = file_get_contents( $GLOBALS["sentiment_filename"] );
	return json_decode( $sentiment_file_load, true );
	
}

#################################
### INDEX
#################################

function show_weather_widget( $conditions_icons, $weather ) {
	return "
		<ul class='week-list'>
			<li class='active' title='vandaag'><i class='fa-solid fa-" .  $conditions_icons[ $weather['today']['condition'] ] . "'></i><span class='day-temp'>" .  number_format($weather['today']['temperature'],0,'.','') . "°</span></i><span class='day-day'>" .  date( 'D', strtotime( 'today' ) ) . "</span></li>
			<li title='morgen'><i class='fa-solid fa-" .  $conditions_icons[ $weather['forecast'][0]['condition'] ] . "'></i><span class='day-temp'>" .  number_format($weather['forecast'][0]['temperature'],0,'.','') . "°</span><span class='day-day'>" .  date( 'D', strtotime( '+1 Day' ) ) . "</span></li>
			<li title='overmorgen'><i class='fa-solid fa-" .  $conditions_icons[ $weather['forecast'][1]['condition'] ] . "'></i><span class='day-temp'>" .  number_format($weather['forecast'][1]['temperature'],0,'.','') . "°</span><span class='day-day'>" .  date( 'D', strtotime( '+2 Day' ) ) . "</span></li>
			<li title='vandaag + 3'><i class='fa-solid fa-" .  $conditions_icons[ $weather['forecast'][2]['condition'] ] . "'></i><span class='day-temp'>" .  number_format($weather['forecast'][2]['temperature'],0,'.','') . "°</span><span class='day-day'>" .  date( 'D', strtotime( '+3 Day' ) ) . "</span></li>
			<li title='vandaag + 4'><i class='fa-solid fa-" .  $conditions_icons[ $weather['forecast'][3]['condition'] ] . "'></i><span class='day-temp'>" .  number_format($weather['forecast'][3]['temperature'],0,'.','') . "°</span><span class='day-day'>" .  date( 'D', strtotime( '+4 Day' ) ) . "</span></li>
			<li title='vandaag + 5'><i class='fa-solid fa-" .  $conditions_icons[ $weather['forecast'][4]['condition'] ] . "'></i><span class='day-temp'>" .  number_format($weather['forecast'][4]['temperature'],0,'.','') . "°</span><span class='day-day'>" .  date( 'D', strtotime( '+5 Day' ) ) . "</span></li>
		</ul>
	";
}
function sum_bank_amount( $bankid, $convert_to_eur = True ) {
	$sum = 0;
	foreach( $GLOBALS[ "bankrekeningen_portfolio" ][ $bankid ][ 'accounts' ] as $account_key => $account_data ) {
		if( $convert_to_eur ) {
			$sum += floatval( $account_data[ 'balance' ] ) * floatval( $account_data[ 'currency_to_EUR' ] );
		} else {
			$sum += floatval( $account_data[ 'balance' ] );
		}
	}
	return $sum;
}
function sum_all_bank_amount() {
	$sum = 0;
	foreach( $GLOBALS[ "bankrekeningen_portfolio" ] as $bankid => $bank_data ) {
		foreach( $bank_data[ 'accounts' ] as $account_key => $account_data ) {
			$sum += floatval( $account_data[ 'balance' ] ) * floatval( $account_data[ 'currency_to_EUR' ] );
		}
	}
	return $sum;
}

#################################
### DEBUG
#################################

if( $settings[ 'debug_mode' ] ) {
	ini_set( 'display_errors', 1 );
	ini_set( 'display_startup_errors', 1 );
	error_reporting( E_ALL );
}

function highlight_array( $array, $name = 'var' ) {
	echo "<pre>" . highlight_string( "<?php\n\$$name =\n" . var_export($array, true) . ";\n?>" ) . "</pre>";
}

#################################
### CRYPTO PORTFOLIO STATUS
#################################

function get_crypto_portfolio_status() {
	
	$crypto_portfolio = json_decode( file_get_contents( $GLOBALS["crypto_portfolio_files_path_file"] ), true );

	$presearch_results = json_decode( file_get_contents( $GLOBALS["presearch_files_path_file"] ), true );

	$value_on_exchanges = array(
		'coinbase' => 0, 'coinbasepro' => 0,
		'crypto_com' => 0, 'crypto_com_wallet' => 0, 'crypto_com_exchange' => 0,
		'bitpanda_regular' => 0, 'bitpanda' => 0,
		'kraken' => 0, 'binance' => 0, 'gateio' => 0, 'lykke' => 0, 'whitebit' => 0,
	);
	foreach( $crypto_portfolio[ 'crypto' ] as $coin => $coin_data  ) {
		foreach( $coin_data[ 'on_exchange' ] as $exchange => $value_of_coins_on_exchange ) {
			if( !isset( $value_on_exchanges[ $exchange ] ) ) {
				$value_on_exchanges[ $exchange ] = 0;
			}
			$value_on_exchanges[ $exchange ] += floatval( $value_of_coins_on_exchange[ 'latest_value' ] );
		}
	}
	
	#highlight_array( $value_on_exchanges );
	return array( $crypto_portfolio, $value_on_exchanges, $presearch_results );
	
}

#################################
### HOME ASSISTANT
#################################

function get_homeassistant_api_data() {
	
	function talk_to_api( $url, $token, $post=False ) {
		
		$curl_handler = curl_init( $url );
		
		if ( $post ) {
			$payload = json_encode( array( 'entity_id' => 'media_player.alfa', 'message'   => 'LOREM IPSUM DOLOR', ) );
			curl_setopt( $curl_handler, CURLOPT_POST, 1 );
			curl_setopt( $curl_handler, CURLOPT_POSTFIELDS, $payload );
		}
		
		curl_setopt( $curl_handler, CURLOPT_HTTPHEADER, array( "Authorization: Bearer $token", "Content-Type: application/json" ));
		curl_setopt( $curl_handler, CURLOPT_RETURNTRANSFER, True );
		curl_setopt( $curl_handler, CURLOPT_FOLLOWLOCATION, True );
		curl_setopt( $curl_handler, CURLOPT_SSL_VERIFYHOST, False );
		curl_setopt( $curl_handler, CURLOPT_SSL_VERIFYPEER, False );
		
		$output_array = json_decode( curl_exec( $curl_handler ), True );
		curl_close( $curl_handler );
		
		return $output_array;
		
	}
	
	$homeassistant_version = talk_to_api( $GLOBALS["homeassistant_url"] . "/api/config", $GLOBALS["homeassistant_token"] )[ 'version' ];
	
	$conditions_icons = array(
		'clear_night'		=> 'moon',
		'sunny'				=> 'sun',
		'partlycloudy'		=> 'cloud-sun',
		'cloudy'			=> 'clouds',
		'fog'				=> 'cloud-fog',
		'lightning_rainy'	=> 'cloud-bolt',
		'rainy'				=> 'cloud-drizzle',
		'pouring'			=> 'cloud-showers-heavy',
		'snowy'				=> 'cloud-snow',
		'snowy_rainy'		=> 'cloud-sleet',
		'neutral'			=> 'question'
	);
	
	$weather_array = talk_to_api( $GLOBALS["homeassistant_url"] . "/api/states/weather.met_no_bygdoy", $GLOBALS["homeassistant_token"] );
	$weather = array(
		'today' => array( 'condition' => $weather_array[ 'state' ], 'temperature' => $weather_array[ 'attributes' ][ 'temperature' ] ),
		'forecast' => array(
			0 => array( 'condition' => $weather_array[ 'attributes' ][ 'forecast' ][ 0 ][ 'condition' ], 'temperature' => $weather_array[ 'attributes' ][ 'forecast' ][ 0 ][ 'temperature' ] ),
			1 => array( 'condition' => $weather_array[ 'attributes' ][ 'forecast' ][ 1 ][ 'condition' ], 'temperature' => $weather_array[ 'attributes' ][ 'forecast' ][ 1 ][ 'temperature' ] ),
			2 => array( 'condition' => $weather_array[ 'attributes' ][ 'forecast' ][ 2 ][ 'condition' ], 'temperature' => $weather_array[ 'attributes' ][ 'forecast' ][ 2 ][ 'temperature' ] ),
			3 => array( 'condition' => $weather_array[ 'attributes' ][ 'forecast' ][ 3 ][ 'condition' ], 'temperature' => $weather_array[ 'attributes' ][ 'forecast' ][ 3 ][ 'temperature' ] ),
			4 => array( 'condition' => $weather_array[ 'attributes' ][ 'forecast' ][ 4 ][ 'condition' ], 'temperature' => $weather_array[ 'attributes' ][ 'forecast' ][ 4 ][ 'temperature' ] ),
		)
	);
	
	#echo "<pre>" . var_export( $weather_array, True ) . "</pre>";
	#echo "<pre>" . var_export( $weather, True ) . "</pre>";
	
	return array( $homeassistant_version, $weather, $conditions_icons );
	
}
