export function generateRoute (route, params) {
    if (!route) return;
    for (const key of Object.keys(params)) {
        route = route.replace(new RegExp(':'+key, 'g'), params[key]);
    }
    return route;
}

export function getRequestError(error) {
    let messages = ['Error al intentar procesar tu petición.'];
    if (error) {
        const response = error.response;
        if (response.status === 422 && response.data) {
            messages = [];
            // if (response.data.message) {
            //     messages = [response.data.message];
            // }
            if (response.data.errors) {
                Object.values(response.data.errors).forEach(errors => {
                    messages = messages.concat(errors);
                });
            }
        }
    }
    return messages.join('<br>');
}
