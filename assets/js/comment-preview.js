/* global commentPreviewData */

( function ( data ) {
	const previewButton = document.getElementById( 'preview-button' );
	const previewWrapper = document.getElementById( 'preview-wrapper' );
	const template = document.getElementById( 'preview-template' );

	document.getElementById( 'cancel-comment-reply-link' ).addEventListener( 'click', clearPreview );

	// Trigger preview button click.
	previewButton.addEventListener( 'click', () => {

		// Disable the preview button.
		previewButton.disabled = true;

		// Collect the data to pass along for generating a comment preview.
		const commentData = {
			comment: document.getElementById( 'comment' ).value,
			format: document.querySelector( '[name="comment_format"]:checked' ).value,
		};

		// Make the request.
		fetch( data.apiURL + 'preview', {
			method: 'POST',
			headers: {
				Accept: 'application/json, text/plain, */*',
				'Content-Type': 'application/json',
				'X-WP-Nonce': data.nonce, // Required for any authenticated requests.
			},
			body: JSON.stringify( commentData ),
		} )
			.then( response => response.json() )
			.then( data => displayPreview( data ) );

	} );

	/**
	 * Preview template with the response data.
	 *
	 * @param {Object} data API Response data.
	 */
	function displayPreview( data ) {
		const preview = template.content.cloneNode( true );

		// Fill in the pieces.
		preview.querySelector( '.avatar' ).src = data.gravatar;
		preview.querySelector( '.comment-author .fn' ).innerText = data.author;
		preview.querySelector( 'time' ).innerText = data.date;
		preview.querySelector( '.comment-content' ).innerHTML = data.comment;

		// Clear out any previous previews before appending the current one.
		previewWrapper.innerHTML = '';
		previewWrapper.append( preview );

		// Re-enable the preview button.
		previewButton.disabled = false;
	}

	/**
	 * Clear out the preview wrapper when a reply or cancel link is clicked.
	 */
	 function clearPreview() {
		previewWrapper.innerHTML = '';
	}

} )( commentPreviewData );
