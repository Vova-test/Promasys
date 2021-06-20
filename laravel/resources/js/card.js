new Vue({
    el: "#card-app",
    data: {
        credentialSets: [],
        credentialSet: {
            id: '',
            name: '',
            credentials: '',
        },
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

                if (response.ok || response.status == 422) {
                    const data = await response.json();

                    return data;
                }

                this.errors.push(`Error, status: ${response.status}`);
            } catch (error) {
                console.log(error);
                this.errors.push(`Error, ${error}`);
            }
        },
        async getCredentialSets() {
            const url = document.getElementById("card-app").getAttribute("data-url");

            const result = await this.ajax(url);

            this.credentialSets = result.credentialSets;
        },
        async deleteSet(url, id, name) {
            url = this.getRoute(url, id);

            const result = await this.ajax(url, 'delete');

            if (result.deleted) {
                await this.getCredentialSets();

                this.logs.push(`Credentials name:"${name}" was deleted!`);

            } else {
                this.errors.push(`Credentials name:"${name}" was not defind!`);
            }
        },
        async storeSet() {
            const method = 'post';

            const formData = new FormData();
            formData.append('name', this.credentialSet.name);
            formData.append('credentials', this.credentialSet.credentials);
            formData.append('projectId', this.credentialSet.projectId);

            const result = await this.ajax(this.credentialSet.url, method, formData);

            if (result.errors) {
                for (const [key, value] of Object.entries(result.errors)) {
                    this.errors.push(`${key}: ${value}`);
                }
            } else {
                await this.getCredentialSets();
                this.logs.push(`Credentials were created!`);
            }

            $('#modalCredentialSet').modal('hide');
        },
        createSet(url, projectId  , credentialSet = null) {
            if (credentialSet) {
                url = this.getRoute(url, credentialSet.id);

                this.credentialSet = {
                    name: credentialSet.name,
                    credentials: credentialSet.credentials,
                    projectId: projectId,
                    url: url,
                };
            } else {
                this.credentialSet = {
                    name: '',
                    credentials: '',
                    projectId: projectId,
                    url: url
                };
            }

            $('#modalCredentialSet').modal('show');
        },
        getRoute(url, id) {
            return url.replace('id', id);
        },
    },
    mounted: function () {
        this.getCredentialSets();
    },
})
