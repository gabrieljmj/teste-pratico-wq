function getMetaTagContent(name) {
    return document.querySelector(`meta[name="${name}"]`).getAttribute('content');
}

export function getDataFromInput(selector) {
    const input = document.querySelector(selector);

    return input ? JSON.parse(input.value) : {};
}

export function getRoutes() {
    return JSON.parse(getMetaTagContent('routes'));
}

export function getBaseUrl() {
    return getMetaTagContent('app_url');
}

export function getGoogleMapsApiKey() {
    return getMetaTagContent('google_maps_api_key');
}

export function allPropertiesNotNull(object, properties) {
    return properties.length === properties.filter(property => object[property]).length;
}

export function getCsrfToken() {
    return getMetaTagContent('csrf_token');
}

export function getFirstPositionFromGoogleMapsResults(results) {
    return {
        lat: results[0].geometry.location.lat(),
        lng: results[0].geometry.location.lng()
    };
}
