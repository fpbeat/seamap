import L from 'leaflet';
import moment from 'moment';

export default class {

    options = {};
    points = [];

    constructor(group, options = {}) {
        this.options = options;

        this.group = group;
    }

    create(data) {
        this.cleanup();

        this.points = Array.from(data).reduce((accumulator, current) => {
            accumulator.push(L.marker([current.lat, current.lng]).bindTooltip(this.formatTooltip(current)));

            return accumulator;
        }, []);

        this.points.forEach(this.group.addLayer.bind(this.group));
    }

    cleanup() {
        this.points.forEach(point => {
            this.group.removeLayer(point);

            point.remove();
        });
    }

    formatTooltip(point) {
        let datetime = moment(point.datetime),
            components = [];

        if (!!point.datetime && datetime.isValid()) {
            components.push(datetime.format(this.options.dateFormat));
        }

        if (!!point.message) {
            components.push(point.message);
        }

        return components.join("<br><br>");
    }

    get lastpoint() {
        return this.points[this.points.length - 1] || null;
    }
}