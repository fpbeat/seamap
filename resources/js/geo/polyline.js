import L from "leaflet";

export default class {

    options = {};
    polyline = null;

    constructor(group, options = {}) {
        this.options = options;

        this.group = group;
    }

    create(data) {
        this.cleanup();

        let path = Array.from(data).reduce((accumulator, current) => {
            accumulator.push([current.lat, current.lng]);

            return accumulator;
        }, []);

        this.polyline = L.polyline(path, this.options);

        this.group.addLayer(this.polyline);
    }

    cleanup() {
        if (!!this.polyline) {
            this.group.removeLayer(this.polyline);
            this.polyline.remove();
        }
    }
}