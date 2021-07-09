new Vue({
    el: "#card-app",
    data: {
        errors: [],
        logs: [],
    },
    methods: {
        async ajax(url, method = 'post', body = {}) {
            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'accept': 'application/json',
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
                    },
                    body: body,
                });

                this.errors.length = 0;
                this.logs.length = 0;

                if (response.ok) {
                    const data = await response.json();

                    return data;
                }

                this.errors.push(`Error, status: ${response.status}`);
            } catch (error) {
                console.log(error);
                this.errors.push(`Error, ${error}`);
            }
        },
        async getSettings() {

        },
        async deleteSetting(url, id, title) {

        },
        async storeSetting() {

        },
        getRoute(url, id) {

        },
    },
    mounted: function () {
        this.getSettings();
    },
})
