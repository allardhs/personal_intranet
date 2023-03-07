<!DOCTYPE html>
<html><head>
	
	<?php
		
		require_once './settings.inc.php' ;
		require_once './helpers.php' ;
		
		echo showHeader( "Bookmarks" );
		echo showHeader_jquery();
		
	?>
	
</head><body>
	
	<?php
		
		echo showBody_navmenu_mainpage(); 
		
		$bookmarks = load_bookmarks_file( $bookmarks_filename );
		echo "<pre>" . $bookmarks_filename . " [" . date( "d F Y H:i:s", filemtime( $bookmarks_filename ) ) . "]</pre>";
		
	?>
	
	<section class='section'>
		
		<div class='container'>
			
			<div class='columns'>
				
				<?php
					
					$top_bookmarks = "";
					$foldered_bookmarks = "";
					
					function displaysubfolder( $bookmark, $level ) {
						return "<li><a href='" . $bookmark['href'] . "'>" . $bookmark->title . "</a></li>";
					}
					
					foreach( $bookmarks as $key_1 => $bookmark_1 ) {
						#echo "<pre>" . var_export( $key, True ) . "</pre>";
						if( $key_1 == "folder" ) {
							
							$foldered_bookmarks .= "
								<div class='column is-one-fifth'>
									<aside class='menu'>
										<p class='menu-label'>
											" . $bookmark_1->title . "
										</p>
										<ul class='menu-list'>
							";
							
							foreach( $bookmark_1 as $key_2 => $bookmark_2 ) {
								if( $key_2 == "folder" ) {
									
									$foldered_bookmarks .= "<li>" . $bookmark_2->title . "<ul>";
									foreach( $bookmark_2 as $key_3 => $bookmark_3 ) {
										if( $key_3 == "folder" ) {
											
											$foldered_bookmarks .= "<li>" . $bookmark_3->title . "<ul>";
											foreach( $bookmark_3 as $key_4 => $bookmark_4 ) {
												if( $key_4 == "folder" ) {
													
													$foldered_bookmarks .= "<li>" . $bookmark_4->title . "<ul>";
													foreach( $bookmark_4 as $key_5 => $bookmark_5 ) {
														if( $key_5 == "folder" ) {
															
															$foldered_bookmarks .= "<li>" . $bookmark_5->title . "<ul>";
															continue;
															$foldered_bookmarks .= "</ul></li>";
															
														} elseif( $key_5 == "bookmark" ) {
															$foldered_bookmarks .= displaysubfolder( $bookmark_5, 2 );
														}
													}
													$foldered_bookmarks .= "</ul></li>";
													
												} elseif( $key_4 == "bookmark" ) {
													$foldered_bookmarks .= displaysubfolder( $bookmark_4, 2 );
												}
											}
											$foldered_bookmarks .= "</ul></li>";
											
										} elseif( $key_3 == "bookmark" ) {
											$foldered_bookmarks .= displaysubfolder( $bookmark_3, 2 );
										}
									}
									$foldered_bookmarks .= "</ul></li>";
									
								} elseif( $key_2 == "bookmark" ) {
									$foldered_bookmarks .= displaysubfolder( $bookmark_2, 2 );
								}
							}
							
							$foldered_bookmarks .= "
										</ul>
									</aside>
								</div>
							";
							
						} elseif( $key_1 == "bookmark" ) {
							$top_bookmarks .= displaysubfolder( $bookmark_1, 1 );
						}
					}
					
				?>
				
				<div class='column'>
					<aside class='menu'>
						<p class='menu-label'>
							Bookmarks Bar
						</p>
						<ul class='menu-list'><?php echo $top_bookmarks; ?></ul>
					</aside>
				</div>
				
				<?php echo $foldered_bookmarks; ?>
				
			</div>
			
		</div>
		
	</section>
	
</body></html>
