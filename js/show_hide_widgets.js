$( document ).ready( function () {
	
	$( '.expand_collapse_card' ).click( function (e) {
		var card_image = $(this).parent().find( '.card-image' );
		var card_content = $(this).parent().find( '.card-content' );
		var card_separator = $(this).parent().find( '.card-separator' );
		if ( $(card_image).is( ':visible' ) ) {
			card_image.hide( 'fast', 'swing' );
			card_content.hide( 'fast', 'swing' );
			card_separator.hide( 'fast', 'swing' );
		} else {
			card_image.show('fast', 'swing');
			card_content.show('fast', 'swing');
			card_separator.show('fast', 'swing');
		}
	});
	
	$( '.expand_collapse_title' ).click( function (e) {
		var cards = $(this).parent().find( '.card' );
		if ( $(cards).is( ':visible' ) ) {
			cards.hide( 'fast', 'swing' );
		} else {
			cards.show('fast', 'swing');
		}
	});
	
});
