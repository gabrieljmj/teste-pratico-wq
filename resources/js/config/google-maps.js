import { getGoogleMapsApiKey } from '../utils';

export default {
    load: {
        key: getGoogleMapsApiKey(),
        libraries: 'places',
    },
    installComponents: true
}
