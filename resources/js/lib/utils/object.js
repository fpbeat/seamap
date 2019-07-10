import StringUtil from './string';
import extend from 'extend';

export default {
    getPath(obj, path, def = null) {
        let pathArray = StringUtil.stringToPath(path);
        let current = obj;
        for (var i = 0; i < pathArray.length; i++) {
            if (!current[pathArray[i]]) {
                return def;
            }

            current = current[pathArray[i]];
        }

        return current;
    },

    pick(keys, obj) {
        return keys.reduce((a, c) => ({...a, [c]: obj[c]}), {});
    },

    merge(...args) {
        return extend(...args);
    },

    map(object, fn) {
        return Object.keys(object).reduce((result, key) => {
            result[key] = fn(object[key]);
            return result;
        }, {});
    }
};
