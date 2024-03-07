const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const {resolve} = require("path");

module.exports = {
    ...defaultConfig,
    externals: {
        react: 'React',
        'react-dom': 'ReactDOM',
    },
    output: {
        filename: 'admin.js',
        path: resolve( process.cwd(), 'assets/js' )
    },
};