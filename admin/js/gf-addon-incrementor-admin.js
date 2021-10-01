/**
 * This script removes serveral edit buttons in the 
 * admin edit view for this plugin's field only.
 */
( function ( d ) {
	'use strict';
	window.addEventListener( 'load', onLoad );
	function onLoad () {
		let fields = d.querySelectorAll( '.gf_readonly' );
		for ( const f of fields ) {
			let adminButtons = f.querySelector( '.gfield-admin-icons' );
			if ( !adminButtons ) continue;
			let toRemove = [];
			toRemove.push( adminButtons.querySelector( '.gfield-duplicate' ) );
			//toRemove.push( adminButtons.querySelector( '.gfield-edit' ) );
			toRemove.push( adminButtons.querySelector( '.gfield-delete' ) );
			for ( const button of toRemove ) {
				if ( !button ) continue;
				button.parentElement.removeChild( button );
				//button.style.setProperty('display', 'none');
			}
		}
	}
} )( document );
