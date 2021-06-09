new Vue({
    el: "#project-app",
    data: {
        url: '/projects',
        userProjects: [],
        projectAccess: {},
        selectedProjectIndex: -1,
        response: {},
        errors: [],
        logs: [],
        search: '',
        project: {
            id: '',
            name: '',
            logo: '',
            description: '',
        },
        image: null,
    },
    methods: {
        async ajax(url, method = 'post', body = {}) {
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
        },
        async getProjects() {
            const result = await this.ajax(this.url);

            this.userProjects = result.userProjects;
            this.projectAccess = result.accessArray;

            if (this.userProjects.length > 0) {
                this.selectProject(0);
            }
        },
        async deleteProject(url, id) {
            url = this.getRoute(url, id);

            const result = await this.ajax(url, 'delete');

            if (result.deleted) {
                await this.getProjects();

                this.logs.push(`Project id:"${id}" was deleted!`);

            } else {
                this.errors.push(`Project id:"${id}" was not defind!`);
            }
        },
        async updateOrStore() {
            const method = 'post';

            const formData = new FormData();
            formData.append('name', this.project.name);
            formData.append('description', this.project.description);
            formData.append('image', this.image);

            const result = await this.ajax(this.project.url, method, formData);

            if (result.errors) {
                for (const [key, value] of Object.entries(result.errors)) {
                    this.errors.push(`${key}: ${value}`);
                }
            } else {
                await this.getProjects();
                this.logs.push(`Project was updated!`);
            }

            this.image = '';
            this.$refs.inputFile.value = null;

            $('#modalProject').modal('hide');
        },
        selectProject(index) {
            this.selectedProjectIndex = index;
        },
        editOrCreate(url, project = null) {
            if (project) {
                Object.assign(this.project, project);

                this.project.url = this.getRoute(url, project.id);
            } else {
                this.project = {
                    id: '',
                    name: '',
                    logo: '',
                    description: '',
                    url: url
                };
            }

            this.image = '';

            $('#modalProject').modal('show');
        },
        getImage(e) {
            this.image = e.target.files[0];
        },
        getRoute(url, id) {
            return url.replace('id', id);
        },
    },
    mounted: function () {
        this.getProjects();
    },
    computed: {
        filteredUserProjects() {
            if (this.userProjects.length == 0) {
                return [];
            }
            return this.userProjects.filter(userProject => {
                return userProject.project.name.toLowerCase().indexOf(this.search.toLowerCase()) > -1
                    || userProject.project.description.toLowerCase().indexOf(this.search.toLowerCase()) > -1;
            });
        }
    }
})
