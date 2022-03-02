/* global mediaWiki, jQuery */
( ( function ( mw, $ ) {
	const api = new mw.Api();
	let wikiEditorContext,
		// eslint-disable-next-line no-jquery/no-global-selector
		$textarea = $( '#wpTextbox1' );

	/**
	 * Click handler for the 'Review link' link.
	 *
	 * @param {Event} e
	 */
	function reviewLinkClickHandler( e ) {
		const start = e.data.cursorPosition - e.data.linkWikitext.length,
			end = e.data.cursorPosition,
			selectedContent = $textarea.textSelection( 'getContents' )
				.substring( start, end );

		if ( selectedContent !== e.data.linkWikitext ) {
			// Abort if wikitext has changed since the popup was shown.
			return;
		}

		e.preventDefault();
		$textarea.trigger( 'focus' );
		$textarea.textSelection( 'setSelection', { start, end } );

		// Open the WikiEditor link insertion dialog, double-checking that it still exists (T271457)
		if ( wikiEditorContext && $.wikiEditor && $.wikiEditor.modules && $.wikiEditor.modules.dialogs ) {
			$.wikiEditor.modules.dialogs.api.openDialog( wikiEditorContext, 'insert-link' );
			e.data.notification.close();
		}
	}

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
		const $reviewLink = $( '<a>' )
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

		// Issue long notification of type 'warn'.
		const notification = mw.notification.notify( $container, {
			autoHideSeconds: 'long',
			type: 'warn',
			classes: 'mw-disambiguator-notification'
		} );

		$reviewLink.bind(
			'click',
			{ linkWikitext, cursorPosition, notification },
			reviewLinkClickHandler
		);
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
		} ).then( ( resp ) => {
			if ( resp.query.pages && resp.query.pages[ 0 ].pageprops &&
				Object.prototype.hasOwnProperty.call( resp.query.pages[ 0 ].pageprops, 'disambiguation' )
			) {
				showWarning( pageTitle, linkWikitext, cursorPosition );
			}
		} );
	}

	/**
	 * (Re-)add the keyup listener to the textarea.
	 */
	function bindTextareaListener() {
		$textarea.off( 'keyup.disambiguator' ).on( 'keyup.disambiguator', ( e ) => {
			if ( e.key === ']' ) {
				const cursorPosition = $textarea.textSelection( 'getCaretPosition' ),
					context = $textarea.textSelection( 'getContents' )
						.substring( 0, cursorPosition ),
					matches = /.*(\[\[([^[\]|]+)(?:\|.*]]|]]))$/.exec( context );
				let pageTitle, linkWikitext;

				if ( matches ) {
					// We always want the last match.
					pageTitle = matches[ matches.length - 1 ].trim();
					linkWikitext = matches[ matches.length - 2 ];
					checkIfDisambig( context, pageTitle, linkWikitext, cursorPosition );
				}
			}
		} );
	}

	// WikiEditor integration; causes the 'Review link' link to open the link insertion dialog.
	mw.hook( 'wikiEditor.toolbarReady' ).add( ( $wikiEditorTextarea ) => {
		wikiEditorContext = $wikiEditorTextarea.data( 'wikiEditor-context' );
	} );

	// CodeMirror integration.
	mw.hook( 'ext.CodeMirror.switch' ).add( ( _enabled, $editor ) => {
		$textarea = $editor;
		bindTextareaListener();
	} );

	bindTextareaListener();
} )( mediaWiki, jQuery ) );
