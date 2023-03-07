<!DOCTYPE html>
<html><head>
	
	<?php
		
		require_once './settings.inc.php' ;
		require_once './helpers.php' ;
		
		echo showHeader( "Home file server" );
		echo showHeader_jquery();
		echo showHeader_fontawesome();
		
		[ $crypto_portfolio, $value_on_exchanges, $presearch_results ] = get_crypto_portfolio_status();
		[ $homeassistant_version, $weather, $conditions_icons ] = get_homeassistant_api_data();
		$sentiment_data = load_sentiment_file();
		$bankrekeningen_portfolio = json_decode( file_get_contents( $bankrekeningen_files_path_file ), true );
		
		// Define overriding values to dynamically override placeholders in INI files
		define( 'WEER_ICON', $conditions_icons[ $weather['today']['condition'] ] );
		define( 'WEER_PIC', "weather_" . $weather['today']['condition'] );
		define( 'WEER_TITLE', "YR.no: <span style='font-style:italic;'>" . $weather['today']['condition'] . "</span>" );
		define( 'WEER_SUBTITLE', show_weather_widget( $conditions_icons, $weather ) );
		
		define( 'HASS_VERSION', $homeassistant_version );
		
		define( 'CRYPTO_PORTFOLIO_BALANCE', "€ " . number_format( $crypto_portfolio[ 'totals'], 2 ) . "<br>Last sync: <i>xxx</i>");
		define( 'PRESEARCH_BALANCE', "₱ " . number_format( $presearch_results[ 'total'], 2 ) . "<br>Last sync: <i>xxx</i>" );
		
		define( 'SENTIMENT_SCORE', "<i>Fear vs. Greed:</i> " . number_format( $sentiment_data[ 'augmentio.ai' ], 0 ) . "% - " . number_format( $sentiment_data[ 'alternative.me' ] * 100, 0 ) . "%" );
		
		define( 'COINBASE_BALANCE', "€ " . number_format( $value_on_exchanges[ 'coinbase'], 2 ) );
		define( 'CRYPTO_COM_BALANCE', "€ " . number_format( $value_on_exchanges[ 'crypto_com'], 2 ) );
		define( 'CRYPTO_COM_WALLET_BALANCE', "€ " . number_format( $value_on_exchanges[ 'crypto_com_wallet'], 2 ) );
		define( 'CRYPTO_COM_EXCHANGE_BALANCE', "€ " . number_format( $value_on_exchanges[ 'crypto_com_exchange'], 2 ) );
		define( 'KRAKEN_BALANCE', "€ " . number_format( $value_on_exchanges[ 'kraken'], 2 ) );
		define( 'BITPANDA_BALANCE', "€ " . number_format( $value_on_exchanges[ 'bitpanda_regular'], 2 ) );
		define( 'BITPANDA_EXCHANGE_BALANCE', "€ " . number_format( $value_on_exchanges[ 'bitpanda'], 2 ) );
		define( 'BINANCE_BALANCE', "€ " . number_format( $value_on_exchanges[ 'binance'], 2 ) );
		define( 'GATE_IO_BALANCE', "€ " . number_format( $value_on_exchanges[ 'gateio'], 2 ) );
		define( 'LYKKE_BALANCE', "€ " . number_format( $value_on_exchanges[ 'lykke'], 2 ) );
		define( 'WHITEBIT_BALANCE', "€ " . number_format( $value_on_exchanges[ 'whitebit'], 2 ) );
		
		define( 'BANK_BALANCE', "€ " . number_format( sum_all_bank_amount(), 2 ) . "<br>Last sync: <i>xxx</i>" );
		define( 'BIEN_BALANCE', "€ " . number_format( sum_bank_amount( "BIEN_SPAREBANK_BIENNOK1" ), 2 ) . " [kr " . number_format( sum_bank_amount( "BIEN_SPAREBANK_BIENNOK1", False ), 2 ) . "]" );
		define( 'ING_BALANCE', "€ " . number_format( sum_bank_amount( "ING_INGBNL2A" ), 2 ) );
		define( 'REVOLUT_BALANCE', "€ " . number_format( sum_bank_amount( "REVOLUT_REVOGB21" ), 2 ) );
		define( 'WISE_BALANCE', "€ " . number_format( sum_bank_amount( "WISE_TRWIGB22" ), 2 ) );
		define( 'PAYPAL_BALANCE', "€ " . number_format( sum_bank_amount( "PAYPAL_PPLXLULL" ), 2 ) );
		define( 'BCV_BALANCE', "€ 0 [₣ 0]" );
		define( 'DEGIRO_NL_BALANCE', "€ xxx" );
		define( 'DEGIRO_NO_BALANCE', "€ xxx" );
		
		define( 'BOOKMARKS_LAST_SYNC', "<i>Last sync: </i>" . date( "d F Y", filemtime( $bookmarks_filename ) ) );
		
		// Load all INI files in directory and parse into array
		$ini_array = array();
		$files = glob( './*.ini') ;
		foreach( $files as $file ) {
			$ini_array[ substr( $file, 2, -4 ) ] = parse_ini_file( $file, true );
		}
		
		// Order elements by order (as defined in INI
		$temp_key_values = array_column( $ini_array, 'order' );
		array_multisort( $temp_key_values, SORT_ASC, $ini_array );
		
	?>
	
	<script src='/js/show_hide_widgets.js'></script>
	<script src='/js/obfuscate_sensitive_data.js'></script>
	
</head><body<?php if( $settings[ 'obfuscate_on_load' ] ) { echo " onload='obfuscate_sensitive_stuff()'"; } ?>>
	
	<div class='bg_image' style='background-image:url(/css/pic_weather_<?php echo $weather['today']['condition']; ?>.png);'></div>
	
	<section class='section'>
		
		<div class='content is-pulled-right' style='position: absolute; right: 20px; z-index: 999;'>
			<button onclick='obfuscate_sensitive_stuff()'>Verberg privé-gegevens...</button>
			<br>
			<a href='https://bulma.io/documentation/' target='_blank'>Documentatie</a>
		</div>
		
		<div class='container'>
			
			<div class='columns'>
				
				<?php
					
					# WALK THROUGH $ini_array LAYER A ("SMART HOME", "CRYPTO", ...) => "TOPIC"
					foreach( $ini_array as $display_topic => $display_topics_details ) {
						
						echo "
						<div class='column ";
						if( count( $ini_array ) < 4 ) { echo "is-one-third"; }
						elseif( count( $ini_array ) == 4 ) { echo "is-one-quarter"; }
						else { echo "is-one-fifth"; }
						echo"'>
							<div class='box title is-4 has-text-centered expand_collapse_title'>
								" . mb_convert_case( $display_topics_details[ 'friendly_name' ], MB_CASE_UPPER, 'UTF-8' ) . "
							</div>
						";
						
						if( is_array( $display_topics_details ) ) {
							
							# WALK THROUGH $ini_array LAYER B ("Weer", "Home Assistant", ...) => "CARD"
							foreach( $display_topics_details as $card_title => $card_contents ) {
								
								echo "<div class='card'>";
								
								if( is_array( $card_contents ) ) {
									
									echo "
										<div class='card-header expand_collapse_card'>
											<div class='card-header-title'>
												" . $card_contents[ 'friendly_name' ] . "
											</div>
											<div class='card-header-icon' style='cursor:initial;'>
												<i class='fa-solid fa-" . ( ( array_key_exists( 'icon', $card_contents ) ) ? $card_contents[ 'icon' ] : "grid-horizontal" ) . "'></i>
											</div>
										</div>
									";
									
									echo "
										<div class='card-image' title='" .  $card_contents[ 'friendly_name' ] . "' style='background-image:url(/css/pic_" . ( ( array_key_exists( 'splash_pic', $card_contents ) ) ? $card_contents[ 'splash_pic' ] : "blank" ) . ".png);'>
										</div>
									";
									
									# WALK THROUGH $ini_array LAYER C ("Yr.no", "HomeWizard Sensoren", "ING", ...) => "ITEM"
									
									#if( array_key_exists( 'items', $card_contents ) ) {
									
									$j = 1;
									
									foreach( $card_contents as $item_title => $item_contents ) {
										
										if( is_array( $item_contents ) ) {
											
											#echo "<pre>";var_dump( $item_contents ); if( $j >= 2 ) { exit; }
											
											echo "
												<div class='card-content'>
													<a href='" . ( ( array_key_exists( 'link', $item_contents ) ) ? $item_contents[ 'link' ] : "#" ) . "'>
														<div class='media'>
															<div class='media-left'>
																<figure class='image is-48x48'>
																	<img src='/css/icon_" . ( ( array_key_exists( 'icon', $item_contents ) ) ? $item_contents[ 'icon' ] : "blank" ) . ".png'>
																</figure>
															</div>
															<div class='media-content'>" . 
																"<p class='title is-6'>" . ( ( array_key_exists( 'title', $item_contents ) ) ? $item_contents[ 'title' ] : $item_title ) . "</p>" .
																( ( array_key_exists( 'subtitle', $item_contents ) ) ? "<p class='subtitle is-6" . ( ( array_key_exists( 'subtitle_obfuscation', $item_contents ) ) ? " obfuscate_me" : "" ) . "'>" . $item_contents[ 'subtitle' ] . "</p>" : "" ) .
															"</div>
														</div>
													</a>
												</div>
											";
											
											if( count( $display_topics_details ) > 1 and $j < count( $display_topics_details ) ) {
												echo "<hr style='margin: 0; height: 1px;' class='card-separator'>";
											}
											$j += 1;
											
										}
										
									}
									
								}
								
								echo "</div>";
								
							}
							
						}
						
						echo "
						</div>
						";
					}
					
				?>
		
			</div>
			
		</div>
		
	</section>
	
</body></html>
