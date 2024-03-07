import React from 'react';

/* global wPDWA */

/**
 * App main file.
 *
 * @return Element
 */
const App = () => {
	return (
		<div className="wpdw-graph-widget-container">
			<h1 className="wp-heading-inline">
				{ wPDWA.title_text }
			</h1>
		</div>
	);
};
export default App;
