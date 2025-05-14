( () => {
	const api = new mw.Api();

	/**
	 * Click handler for the 'Review link' link.
	 *
	 * @param {Event} e
	 */
	function reviewLinkClickHandler( e ) {
		const $textarea = e.data.$textarea;
		const start = e.data.cursorPosition - e.data.linkWikitext.length,
			end = e.data.cursorPosition,
			// eslint-disable-next-line unicorn/prefer-string-slice
			selectedContent = $textarea.textSelection( 'getContents' )
				.substring( start, end );

		if ( selectedContent !== e.data.linkWikitext ) {
			// Abort if wikitext has changed since the popup was shown.
			return;
		}

		e.preventDefault();
		$textarea.trigger( 'focus' );
		$textarea.textSelection( 'setSelection', { start: start, end: end } );

		// Open the WikiEditor link insertion dialog, double-checking that it still exists (T271457)
		const wikiEditorContext = $textarea.data( 'wikiEditor-context' );
		if (
			wikiEditorContext && $.wikiEditor &&
			$.wikiEditor.modules && $.wikiEditor.modules.dialogs
		) {
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
	 * @param {jQuery} $textarea
	 */
	function showWarning( pageTitle, linkWikitext, cursorPosition, $textarea ) {
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

		$reviewLink.on(
			'click',
			{ $textarea, linkWikitext, cursorPosition, notification },
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
	 * @param {jQuery} $textarea
	 */
	function checkIfDisambig( context, pageTitle, linkWikitext, cursorPosition, $textarea ) {
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
				showWarning( pageTitle, linkWikitext, cursorPosition, $textarea );
			}
		} );
	}

	/**
	 * (Re-)add the keyup listener to the textarea.
	 *
	 * @param {jQuery} $textarea
	 */
	function bindTextareaListener( $textarea ) {
		$textarea.off( 'keyup.disambiguator' ).on( 'keyup.disambiguator', ( e ) => {
			if ( e.key === ']' ) {
				const cursorPosition = $textarea.textSelection( 'getCaretPosition' ),
					context = $textarea.textSelection( 'getContents' )
						.slice( 0, cursorPosition ),
					matches = /.*(\[\[([^[\]|]+)(?:\|.*]]|]]))$/.exec( context );

				if ( matches ) {
					// We always want the last match.
					const pageTitle = matches[ matches.length - 1 ].trim();
					const linkWikitext = matches[ matches.length - 2 ];
					checkIfDisambig( context, pageTitle, linkWikitext, cursorPosition, $textarea );
				}
			}
		} );
	}

	// WikiEditor integration; causes the 'Review link' link to open the link insertion dialog.
	mw.hook( 'wikiEditor.toolbarReady' ).add( ( $wikiEditorTextarea ) => {
		bindTextareaListener( $wikiEditorTextarea );
	} );

	// CodeMirror integration.
	// TODO: Can be removed after CodeMirror 5 is retired.
	mw.hook( 'ext.CodeMirror.toggle' ).add( ( _enabled, _cm, textarea ) => {
		const $textarea = $( textarea );
		bindTextareaListener( $textarea );
	} );

} )();
