import React from 'react';

/**
 * To display loader
 *
 * @param {boolean} loading Option to enable loader.
 * @return Element
 */
const Loader = ( { loading } ) => {
	return (
		<div
			className={ 'wpdw-loader' + ( true === loading ? ' loading' : '' ) }
		>
			<span className="wpdw-loader-span"></span>
		</div>
	);
};
export default Loader;
