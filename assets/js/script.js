jQuery(document).ready(function($){
	jQuery( 'ul.products li.wif-if-gallery a:first-child' ).hover( function() {
		jQuery( this ).children( '.wp-post-image' ).removeClass( 'fadeInDown' ).addClass( 'animated fadeOutUp' );
		jQuery( this ).children( '.secondary-image' ).removeClass( 'fadeOutUp' ).addClass( 'animated fadeInDown' );
	}, function() {
		jQuery( this ).children( '.wp-post-image' ).removeClass( 'fadeOutUp' ).addClass( 'fadeInDown' );
		jQuery( this ).children( '.secondary-image' ).removeClass( 'fadeInDown' ).addClass( 'fadeOutUp' );
	});
});