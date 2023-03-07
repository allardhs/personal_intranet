<!DOCTYPE html>
<?php
	ini_set( 'display_errors', 1 );
	ini_set( 'display_startup_errors', 1 );
	error_reporting( E_ALL );
?>

<html><head>
	
	<?php
		require( "../helpers.php" );
		echo showHeader( "Cryptofolio" );
		echo showHeader_jquery();
		echo showHeader_jsonviewer();
		echo showHeader_charter();
		
	?>
	
	<?php
		
		$file_load = file_get_contents( $crypto_portfolio_files_path_file );
		$crypto_portfolio = json_decode( $file_load, true );
		
		function lookup_color( $number ) {
			if ( $number > 10 ) { return "is-primary"; }
			elseif ( $number > 0 ) { return "is-success" ;}
			elseif ( $number == 0 ) { return "is-info"; }
			elseif ( $number < -10 ) { return "is-danger"; }
			elseif ( $number < 0 ) { return "is-warning"; }
			else { return "is-dark"; }
		}
		
		function add_exchanges_subinfo( $coin_data ) {
			$ret = "";
			$cnt = count( $coin_data[ 'on_exchange' ] );
			foreach( $coin_data[ 'on_exchange' ] as $exch => $exch_data ) {
				$ret .= "<div class='column'><div class='box is-size-7' style='padding:0.2rem;'>";
				$ret .= $exch . "<br />" . number_format( $exch_data[ 'balance' ], 2) ;
				$ret .= "</div></div>";
			}
			return $ret;
		}
		
		function add_sparklines( $coin ) {
			
			$ret = "";
			
			$ret .= "labels: [ ";
			$result_dates = array_column( $coin[ 'price_history' ], 0 );
			foreach( $result_dates as $key => $values ) {
				$ret .= "'" . date( "j F Y", $values / 1000 ) . "', ";
			}
			$ret .= " ],";
			
			$ret .= "datasets: [ { data: [ ";
			$result_values = array_column( $coin[ 'price_history' ], 1 );
			foreach( $result_values as $key => $values ) {
				$ret .= floatval($values) . ", ";
			}
			$ret .= " ] } ]";
			
			return $ret;
			
		}
		
		function getBackgoundColorChart( $value ) {
			if( $value < 0 ) { return "#a50e0e"; } else { return "#137333"; }
		}
		function getForegoundColorChart( $value ) {
			if( $value < 0 ) { return "#fce8e6"; } else { return "#e6f4ea"; }
		}
		
	?>
	
</head><body>
	
	<?php echo showBody_navmenu_cryptofolio(); ?>
	
	<section class='hero is-link'>
		<div class='hero-body'>
			<p class='subtitle'>
				Total crypto
			</p>
			<p class='title'>
				€ <?php echo number_format( $crypto_portfolio[ 'totals'], 2 ); ?>
			</p>
		</div>
	</section>
	<section class='section'>
		<div class='container'>
			<div class='columns'>
				
				<?php
					
					$i = 0;
					foreach( $crypto_portfolio[ 'crypto'] as $coin_symbol => $coin_data ) {
						
						echo "
							<div class='column is-one-quarter'>
								<div class='card'>
									<div class='card-content'>
										<div class='media'>
											<div class='media-left'>
												<figure class='image is-48x48'>
													<img src='" . $coin_data[ 'image' ] . "' title='" . $coin_data[ 'name' ] . "'>
												</figure>
											</div>
											<div class='media-content'>
												<p class='title is-5' style='margin-bottom:0.4rem;'>" . $coin_data[ 'name' ] . "</p>
												<p class='title is-7'>
													<span style='font-weight:bold;/* background-color:#4a4a4a; */'>" . number_format( $coin_data[ 'balance' ], 2 ) . "</span> <a href='https://www.coingecko.com/en/coins/" . $coin_data[ 'gecko_id' ] . "' target='_blank'>" . $coin_symbol . "</a> @ 
													€ " . number_format( $coin_data[ 'latest_price' ], 2 ) . "
												</p>
											</div>
										</div>
										<div class='columns'>" . add_exchanges_subinfo( $coin_data ) . "</div>
										<nav class='level'>
											<div class='level-item has-text-centered'>
												<div>
													<p class='heading'>value</p>
													<p class='title'>" . number_format( $coin_data[ 'latest_value' ], 2 ) . "</p>
												<div>
											</div>
										</nav>
										<div class='content'>
											ATH: " . number_format( 100 * $coin_data[ 'latest_price' ] / $coin_data[ 'ath' ], 1 ) . "%<br /><progress class='progress is-primary is-small' value='" . number_format( $coin_data[ 'latest_price' ] / $coin_data[ 'ath' ], 2 ) . "' max='1'></progress><br />
											<div class='field is-grouped is-grouped-multiline'>
											  <div class='control'>
												<div class='tags has-addons'>
												  <span class='tag is-dark'>1 hour</span>
												  <span class='tag " . lookup_color( $coin_data[ 'delta_1h' ] ) . "'>" . number_format( $coin_data[ 'delta_1h' ], 2 ) . "%</span>
												</div>
											  </div>
											  <div class='control'>
												<div class='tags has-addons'>
												  <span class='tag is-dark'>24 hour</span>
												  <span class='tag " . lookup_color( $coin_data[ 'delta_24h' ] ) . "'>" . number_format( $coin_data[ 'delta_24h' ], 2 ) . "%</span>
												</div>
											  </div>
											  <div class='control'>
												<div class='tags has-addons'>
												  <span class='tag is-dark'>7 days</span>
												  <span class='tag " . lookup_color( $coin_data[ 'delta_7d' ] ) . "'>" . number_format( $coin_data[ 'delta_7d' ], 2 ) . "%</span>
												</div>
											  </div>
											  <div class='control'>
												<div class='tags has-addons'>
												  <span class='tag is-dark'>30 days</span>
												  <span class='tag " . lookup_color( $coin_data[ 'delta_30d' ] ) . "'>" . number_format( $coin_data[ 'delta_30d' ], 2 ) . "%</span>
												</div>
											  </div>
											</div>
										</div>
										<canvas id='sparkline_" . str_replace( "-", "_", $coin_data[ 'gecko_id' ] ) . "' width='250' height='75'></canvas>
									</div>
								</div>
							</div>
						";
						
						echo "
							<script>
								const ctx_" . str_replace( "-", "_", $coin_data[ 'gecko_id' ] ) . " = document.getElementById('sparkline_" . str_replace( "-", "_", $coin_data[ 'gecko_id' ] ) . "').getContext('2d');
								const chart_" . str_replace( "-", "_", $coin_data[ 'gecko_id' ] ) . " = new Chart( ctx_" . str_replace( "-", "_", $coin_data[ 'gecko_id' ] ) . ", {
								  type: 'line',
								  data: { " . add_sparklines( $coin_data ) . " },
								  options: {
									responsive: false,
									point: { radius: 0 },
									elements: {
									  line: {
										borderColor: '" . getBackgoundColorChart( floatval($coin_data[ 'delta_7d' ] )) . "',
										backgroundColor: '" . getForegoundColorChart( floatval($coin_data[ 'delta_7d' ] )) . "',
										borderWidth: 1,
										fill: true,
									  },
									  point: { radius: 0 },
									},
									tooltips: { enabled: true, },
									scales: { x: { display: false, }, y: { display: false, }, },
									plugins: { legend: { display: false }, }
								  }
								});
							</script>
						";
						
						$i += 1;
						if( fmod( $i, 4 ) == 0 ) {
							echo "</div><div class='columns'>";
						}
						
					}
					
				?>
				
			</div>
		</div>
	</section>
	
	<pre><?php echo $crypto_portfolio_files_path_file . " [" . date( "d F Y H:i:s", filemtime( $crypto_portfolio_files_path_file ) ) . "]"; ?></pre>
	<pre id='json'></pre>
	<script>
		var jsonViewer = new JSONViewer();
		document.querySelector( '#json' ).appendChild( jsonViewer.getContainer() );
		jsonViewer.showJSON(<?php echo $file_load; ?>, -1, -1);
	</script>
	
</body></html>
