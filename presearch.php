<!DOCTYPE html>
<?php
	ini_set( 'display_errors', 1 );
	ini_set( 'display_startup_errors', 1 );
	error_reporting( E_ALL );
?>

<html><head>
	
	<?php
		require( "../helpers.php" );
		echo showHeader( "Presearch" );
		echo showHeader_jquery();
		echo showHeader_jsonviewer();
	?>
	
	<?php
		
		$file_load = file_get_contents( $presearch_files_path_file );
		$presearch_results = json_decode( $file_load, true );
		#echo '<pre>' . var_export( $presearch_results, true ) . '</pre>';
		
		$handle = fopen( $users_txt_path_file, "r" );
		$users_txt = array();
		while ( ( $data = fgetcsv( $handle ) ) !== FALSE ) {
			if( substr( $data[0], 0, 1 ) == "#" ) { continue; }
			$users_txt[ floatval($data[0]) ][ 'id' ] = $data[0];
			$users_txt[ floatval($data[0]) ][ 'username' ] = $data[1];
			$users_txt[ floatval($data[0]) ][ 'password' ] = $data[2];
			$users_txt[ floatval($data[0]) ][ 'browser_profile' ] = $data[3];
			$users_txt[ floatval($data[0]) ][ 'name' ] = $data[11];
		}
		#echo '<pre>' . var_export( $users_txt, true ) . '</pre>';
		
		foreach( $presearch_results as $results_id => $results_data ) {
			if( !is_int( $results_id ) ) { continue; }
			if( array_key_exists( $results_id, $users_txt ) ) {
				$presearch_results[ $results_id ][ 'username' ] = $users_txt[ $results_id ][ 'username' ];
				$presearch_results[ $results_id ][ 'password' ] = $users_txt[ $results_id ][ 'password' ];
			} else {
				$presearch_results[ $results_id ][ 'username' ] = "(not found)";
				$presearch_results[ $results_id ][ 'password' ] = "(not found)";
			}
		}
		#echo '<pre>' . var_export( $presearch_results, true ) . '</pre>';
		
		function showStatus ( $color, $status, $diff_in_pre, $last_updated ) {
			$today = date('Ymd');
			if( $status == -2 )						{ if( $color == True ) { return "has-background-danger";		} } # if logged out
			elseif( $status == -1 ) {
				if( $today - $last_updated > 0 )	{ if( $color == True ) { return "";								} } # not yet done today
				elseif( $diff_in_pre >= 1.9 )			{ if( $color == True ) { return "has-background-success-light" ;} } # done
				else								{ if( $color == True ) { return "has-background-danger-light";	} } # indicates done but has not yet mined 3 PRE today -> verify
			}
			elseif( $status == 1 )					{ if( $color == True ) { return "has-background-warning-light";	} else { return "<span style='color:red;font-weight:bold;'><center>[ ONGOING ]</center></span>" ; } } # working on currently
			elseif( $status == 0 )					{ if( $color == True ) { return "has-background-warning";	} } # starting work on this one for today
			else 									{ if( $color == True ) { return "has-background-grey-light";	} } # should not occur, but using a clearly different colour to stand out
		}
		function colorLookup( $number ) {
			if( $number == 1 ) { return "is-primary"; }
			elseif( $number > 0.5 ) { return "is-success" ;}
			elseif( $number == 0 ) { return "is-info"; }
			else{ return "is-black"; }
		}
		function checkCVSscorecolor( $number ) {
			if( $number == 100 ) { return "has-text-primary"; }
			elseif( $number >= 70 ) { return "has-text-success" ;}
			elseif( $number >= 50 ) { return "has-text-info"; }
			elseif( $number > 0 ) { return "has-text-danger"; }
			else{ return "has-text-black"; }
		}
		
	?>
	
</head><body>
	
	<?php echo showBody_navmenu_cryptofolio(); ?>
	
	<section class='hero is-link'>
		<div class='hero-body'>
			<p class='subtitle'>
				Total:
			</p>
			<p class='title'>
				PRE <?php echo number_format( array_sum( array_column( $presearch_results, "pre" ) ), 2 ); ?>
			</p>
		</div>
	</section>
	
	<section class='section'>
		<div class='container'>
			<div class='columns'>
				
				<?php
					
					$i = 0;
					foreach( $presearch_results as $results_id => $results_data ) {
						
						#if( $results_id == "total" ) { continue; }
						if( !is_int( $results_id ) ) { continue; }
						
						echo "
							<div class='column is-one-fifth'>
								<div class='card'>
									<div class='card-content " . showStatus( True, intval($results_data[ 'status' ]), floatval($results_data[ 'diff_in_pre' ]), intval($results_data[ 'last_updated' ]) ) . "'>
										<div class='media'>
											<div class='media-left'>
												<div class='has-background-primary has-text-primary-light' style='border-radius:9999px;width:36px;height:36px;text-align:center;padding-top:5px;'>" . $results_id . "</div>
											</div>
											<div class='media-content'>
												<p class='title is-5' style='margin-bottom:0.4rem;'>". str_replace( "@", "<br /><span class='title is-7 has-text-grey'>@", $results_data[ 'username' ] ) . "</span></p>
												<p class='title is-7 has-text-grey-light' style='margin-bottom:0.4rem;'>" . $results_data[ 'password' ] . "</p>
												<p class='title is-7' style='margin-bottom:0.4rem;'>Updated: " . intval($results_data[ 'last_updated' ]) . "</p>
											</div>
										</div>
										<div class='content' title='status: [" . intval($results_data[ 'status' ]) . "], diff_in_pre: [" . number_format( floatval($results_data[ 'diff_in_pre' ]), 2 ) . "]'>
											Δ PRE: " . number_format( 100 * $results_data[ 'diff_in_pre' ] / 3, 1 ) . "%<br /><progress class='progress " . colorLookup( $results_data[ 'diff_in_pre' ] / 3 ) . " is-small' value='" . number_format( $results_data[ 'diff_in_pre' ] / 3, 2 ) . "' max='1'></progress>
										</div>
										<nav class='level'>
											<div class='level-item has-text-centered'>
												<div>
													<p class='heading'>PRE</p>
													<p class='title'>" . number_format( $results_data[ 'pre' ], 1 ) . "</p>
												</div>
											</div>
											<div class='level-item has-text-centered'>
												<div>
													<p class='heading'>CVS</p>
													<p class='title " . checkCVSscorecolor( $results_data[ 'cvs_score' ] ). "'>" . $results_data[ 'cvs_score' ] . "</p>
												</div>
											</div>
										</nav>
										" . showStatus( False, intval($results_data[ 'status' ]), floatval($results_data[ 'diff_in_pre' ]), intval($results_data[ 'last_updated' ]) ) . "
										
									</div>
								</div>
							</div>
						";
						
						$i += 1;
						if( fmod( $i, 5 ) == 0 ) {
							echo "</div><div class='columns'>";
						}
						
					}
					
				?>
				
			</div>
		</div>
	</section>
	
	<div class='column'>
		<pre id='json'></pre>
	</div>
	
	<script>
		var jsonViewer = new JSONViewer();
		document.querySelector('#json').appendChild(jsonViewer.getContainer());
		jsonViewer.showJSON(<?php echo json_encode( $presearch_results ); ?>, -1, -1);
	</script>
	
</body></html>
