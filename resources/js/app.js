import {GenericUtil} from './lib/utils';

import L from 'leaflet'
import axios from 'axios';

import geoPoints from './geo/point';
import geoPolyline from './geo/polyline';

import '../styles/app.less';

export default class {
    options = {
        tiles: [
            {
                url: '//{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                options: {
                    maxZoom: 18
                }
            },
            {
                url: '//tiles.openseamap.org/seamark/{z}/{x}/{y}.png',
                options: {
                    maxZoom: 18
                }
            }
        ],

        map: {
            center: [60.23729700, 31.60128600],
            zoom: 10,

            minZoom: 2,
            maxZoom: 18
        },

        point: {
            dateFormat: 'DD.MM.YYYY HH:mm',
            icon: {}
        },

        polyline: {
            color: 'red',
            weight: 2
        },

        updateInterval: 2,
        centering: 'bounds' // lastpoint
    };

    constructor(element, options = {}) {
        try {
            this.container = document.querySelector(element);

            if (GenericUtil.isEmpty(this.container)) {
                throw new Error('Passed invalid container element');
            }

            GenericUtil.setOptions(this, options);

            this.bootstrap();
        } catch (e) {
            ('console' in window) && console.error(`leafTracker fatal error: ${e.message}`);
        }
    }

    bootstrap() {
        this.buildMap();

        this.layerGroup = L.featureGroup([]).addTo(this.map);

        this.points = new geoPoints(this.layerGroup, this.options.point);
        this.polyline = new geoPolyline(this.layerGroup, this.options.polyline);

        this.setInitialData();
        this.setCenter();

        if (!!this.options.updateInterval && this.options.updateInterval >= 1) {
            setInterval(this.reload.bind(this), this.options.updateInterval * 1000);
        }
    }

    setInitialData() {
        this.hashes = this.options.initial.hashes;

        this.points.create(this.options.initial.data.points);
        this.polyline.create(this.options.initial.data.polyline);
    }

    buildMap() {
        this.map = L.map(this.container, this.options.map);

        this.options.tiles.forEach(tile => L.tileLayer(tile.url, tile.options || {}).addTo(this.map));
    }

    reload() {
        axios.post(this.options.dataUrl, {
            data: this.hashes
        }).then(response => {
            if (response.data) {
                this.update(response.data.data);

                if (!!response.data.hashes) {
                    this.hashes = response.data.hashes;
                }
            }
        }).catch(error => {
            throw new Error(error);
        });
    }

    update(data) {
        if (!!data.points) {
            this.points.create(data.points || []);
        }

        if (!!data.polyline) {
            this.polyline.create(data.polyline || []);
        }

        if (!!data.points || !!data.polyline) {
            this.setCenter();
        }
    }

    setCenter() {
        switch (this.options.centering) {
            case 'bounds':
                let bounds = this.layerGroup.getBounds();

                if (bounds.isValid()) {
                    this.map.fitBounds(this.layerGroup.getBounds(), {
                        animate: false
                    });
                }

                break;
            case 'lastpoint':
                if (this.points.lastpoint !== null) {
                    this.map.flyTo(this.points.lastpoint.getLatLng());
                }
                break;
        }
    }
}