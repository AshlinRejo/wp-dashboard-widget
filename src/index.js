import ReactDOM from 'react-dom/client';
import App from './App';

const container = document.getElementById( 'wpdw-graph-widget' );
if ( 'undefined' !== typeof container && null !== container ) {
	const root = ReactDOM.createRoot( container );
	root.render( <App /> );
}
