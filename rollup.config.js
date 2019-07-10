const { PRODUCTION } = process.env;
const path = require('path');

import resolve from 'rollup-plugin-node-resolve';
import alias from 'rollup-plugin-alias';
import babel from 'rollup-plugin-babel';
import commonjs from 'rollup-plugin-commonjs';
import less from 'rollup-plugin-less';

import { uglify } from 'rollup-plugin-uglify';

export default {
    input: './resources/js/app.js',

    output: {
        file: './public/js/app.js',
        name: 'leafTracker',
        format: 'iife',
    },
    plugins: [
        resolve({
            browser: true
        }),
        commonjs({
            include: 'node_modules/**',
        }),
        alias({
            '~': path.resolve(__dirname, './resources/js/')
        }),
        babel({
            exclude: ['node_modules/**']
        }),
        less({
            output: './public/css/app.css',
            option: {
                paths: [
                    path.resolve(__dirname, 'node_modules'),
                ]
            }
        }),

        (PRODUCTION && uglify())
    ]
};