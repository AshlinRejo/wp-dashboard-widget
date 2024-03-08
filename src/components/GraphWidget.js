import React, { useEffect, useState } from 'react';
import axios from 'axios';
import Loader from './Loader';
import {
	LineChart,
	Line,
	XAxis,
	YAxis,
	CartesianGrid,
	Tooltip,
	Legend,
} from 'recharts';

/* global wPDWA */

/**
 * To display Chart
 *
 * @return Element
 */
const GraphWidget = () => {
	const [ loading, setLoading ] = useState( true );
	const [ lastXdays, setLastXdays ] = useState( '7-days' );
	const [ analytics, setAnalytics ] = useState( [] );

	/**
	 * Get graph data from DB
	 */
	function getGraphData() {
		axios
			.get( wPDWA._rest_url + 'chart', {
				params: {
					_ajax_nonce: wPDWA._ajax_nonce,
					last: lastXdays,
				},
			} )
			.then( function ( response ) {
				if ( true === response.data.success ) {
					setAnalytics( response.data.data );
				}
			} )
			.finally( function () {
				setLoading( false );
			} );
	}

	useEffect( () => {
		getGraphData();
	}, [ lastXdays ] );

	return (
		<>
			<div className="wpdw-graph-widget-header">
				<h3 className="wp-heading-inline">{ wPDWA.title_text }</h3>
				<select
					className="wpdw-graph-widget-selectbox"
					name="wpdw_graph_widget_selectbox"
					onChange={ ( event ) => {
						setLastXdays( event.target.value );
					} }
				>
					<option value="7-days">
						{ wPDWA.selectbox_option_7_days }
					</option>
					<option value="15-days">
						{ wPDWA.selectbox_option_15_days }
					</option>
					<option value="1-month">
						{ wPDWA.selectbox_option_1_month }
					</option>
				</select>
			</div>
			<div className="wpdw-graph-container">
				<Loader loading={ loading }></Loader>
				<LineChart
					width={ 500 }
					height={ 300 }
					data={ analytics }
					margin={ {
						top: 5,
						right: 30,
						left: 20,
						bottom: 5,
					} }
				>
					<CartesianGrid strokeDasharray="3 3" />
					<XAxis dataKey="title" />
					<YAxis />
					<Tooltip />
					<Legend />
					<Line
						type="monotone"
						dataKey="pv"
						stroke="#8884d8"
						activeDot={ { r: 8 } }
					/>
					<Line type="monotone" dataKey="uv" stroke="#82ca9d" />
				</LineChart>
			</div>
		</>
	);
};
export default GraphWidget;
