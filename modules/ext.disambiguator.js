/* global mediaWiki, jQuery */
( ( function ( mw, $ ) {
	var api = new mw.Api(),
		// eslint-disable-next-line no-jquery/no-global-selector
		$textarea = $( '#wpTextbox1' );

	/**
	 * Issue a notification of type 'warn'.
	 *
	 * @param {string} pageTitle
	 * @param {string} linkWikitext
	 * @param {number} cursorPosition
	 */
	function showWarning( pageTitle, linkWikitext, cursorPosition ) {
		// Build the content, which generates as the parsed 'disambiguator-notification-question'
		//   and 'disambiguator-notification-message' messages, followed by the 'Review link'.
		var $reviewLink = $( '<a>' )
				.prop( 'href', new mw.Title( pageTitle ).getUrl() )
				.text( mw.msg( 'disambiguator-review-link' ) )
				.addClass( 'disambiguator-review-link' ),
			$container = $( '<div>' );

		$container.append(
			$( '<p>' ).append(
				mw.message( 'disambiguator-notification-question' ).parse()
			),
			$( '<p>' ).append(
				mw.message( 'disambiguator-notification-summary', [ pageTitle ] ).parse()
			)
		);
		$container.append( $reviewLink );

		// Make links open in a new tab.
		$container.find( 'a' ).prop( 'target', '_blank' );

		// Except for $reviewLink, which should highlight the relevant wikitext in the textarea.
		$reviewLink.on( 'click', function ( e ) {
			var start = cursorPosition - linkWikitext.length,
				end = cursorPosition;

			if ( $textarea.val().substring( start, end ) !== linkWikitext ) {
				// Abort if wikitext has changed since the popup was shown.
				return;
			}

			e.preventDefault();
			$textarea[ 0 ].selectionStart = start;
			$textarea[ 0 ].selectionEnd = end;
			$textarea.trigger( 'focus' );
		} );

		// Issue long notification of type 'warn'.
		mw.notify( $container, {
			autoHideSeconds: 'long',
			type: 'warn'
		} );
	}

	/**
	 * Query the API to determine if the inputted link is to a disambiguation page.
	 * If it is, a warning is displayed to the user.
	 *
	 * @param {string} context
	 * @param {string} pageTitle
	 * @param {string} linkWikitext
	 * @param {number} cursorPosition
	 */
	function checkIfDisambig( context, pageTitle, linkWikitext, cursorPosition ) {
		api.get( {
			action: 'query',
			titles: pageTitle,
			prop: 'pageprops',
			ppprop: 'disambiguation',
			formatversion: 2
		} ).then( function ( resp ) {
			if ( resp.query.pages && resp.query.pages[ 0 ].pageprops &&
				Object.prototype.hasOwnProperty.call( resp.query.pages[ 0 ].pageprops, 'disambiguation' )
			) {
				showWarning( pageTitle, linkWikitext, cursorPosition );
			}
		} );
	}

	$textarea.on( 'keyup.disambiguator', function ( e ) {
		if ( e.key === ']' ) {
			var cursorPosition = $textarea[ 0 ].selectionStart,
				context = $textarea.val().substring( 0, cursorPosition ),
				matches = /.*(\[\[([^[\]|]+)(?:\|.*]]|]]))$/.exec( context ),
				pageTitle, linkWikitext;

			if ( matches ) {
				// We always want the last match.
				pageTitle = matches[ matches.length - 1 ].trim();
				linkWikitext = matches[ matches.length - 2 ];
				checkIfDisambig( context, pageTitle, linkWikitext, cursorPosition );
			}
		}
	} );

} )( mediaWiki, jQuery ) );
