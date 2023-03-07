function obfuscate_sensitive_stuff() {
	var x = document.getElementsByClassName( 'obfuscate_me' );
	for( let index = 0; index < x.length; ++index ) {
		const y = x[index];
		if( y.style.color === 'transparent' ) {
			y.style.removeProperty('background-color');
			y.style.removeProperty('color');
		} else {
			y.style.backgroundColor = '#00000090';
			y.style.color = 'transparent';
		}
	}
}
