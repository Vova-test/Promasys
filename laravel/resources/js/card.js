new Vue({
    el: "#card-app",
    data: {
        credentialSets: [],
        credentialSet: {
            id: '',
            title: '',
            credentials: '',
            project_id: '',
        },
        errors: [],
        logs: [],
        search: '',
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
                this.errors.push(`Error, ${error}`);
            }
        },
        async getCredentialSets() {
            const url = document.getElementById("card-app").getAttribute("data-url");

            const result = await this.ajax(url);

            this.credentialSets = result.credentialSets;
        },
        async deleteSet(url, id, title) {
            url = this.getRoute(url, id);

            const result = await this.ajax(url, 'delete');

            if (result.deleted) {
                await this.getCredentialSets();

                this.logs.push(`Credentials "${title}" was deleted!`);

            } else {
                this.errors.push(`Credentials "${title}" was not defind!`);
            }
        },
        async updateOrStoreSet() {
            const method = 'post';

            const formData = new FormData();
            formData.append('title', this.credentialSet.title);
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
        editOrCreateSet(url, projectId  , credentialSet = null) {
            this.credentialSet = {
                projectId: projectId,
                url: url
            };

            if (credentialSet) {
                this.credentialSet.url = this.getRoute(url, credentialSet.id);
                this.credentialSet.title = credentialSet.title;
                this.credentialSet.credentials = credentialSet.credentials;
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
    computed: {
        filteredCredentialSets() {
            if (this.credentialSets.length == 0) {
                return [];
            }
            return this.credentialSets.filter(credentialSet => {
                return credentialSet.title.toLowerCase().indexOf(this.search.toLowerCase()) > -1
                    || credentialSet.credentials.toLowerCase().indexOf(this.search.toLowerCase()) > -1;
            });
        }
    },
})
