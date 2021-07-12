new Vue({
    el: "#setting-app",
    data: {
        errors: [],
        logs: [],
        users: {},
        userSettings: {},
        projectAccess: [],
        userId: '',
        checked: true,
    },
    methods: {
        async ajax(url, method = 'post', body = {}) {
            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'accept': 'application/json',
                        'Content-Type': 'application/json',
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
            const url = document.getElementById("setting-app").getAttribute("data-url");

            const result = await this.ajax(url);

            this.users = result.users;
            this.userSettings = result.userSettings;
            this.projectAccess = result.accessArray;

            if (this.users.length > 0) {
                this.userId = this.users[0].id;
            }
        },
        async setSetting(url, projectId) {
            const body = JSON.stringify({
                projectId: projectId,
                userId: this.userId,
                type: this.checked+1
            });

            const result = await this.ajax(url, 'post', body);

            if (result.errors) {
                for (const [key, value] of Object.entries(result.errors)) {
                    this.errors.push(`${key}: ${value}`);
                }
            } else {
                await this.getSettings();
                this.logs.push(`Setting was added!`);
            }
        },
        async deleteSetting(url, id, name) {
            url = this.getRoute(url, id);

            const result = await this.ajax(url, 'delete');

            if (result.deleted) {
                await this.getSettings();

                this.logs.push(`Settings for "${name}" was deleted!`);

            } else {
                this.errors.push(`Settings for "${name}" was not defind!`);
            }
        },
        async storeSetting() {

        },
        getRoute(url, id) {
            return url.replace('id', id);
        },
    },
    mounted: function () {
        this.getSettings();
    },
})
