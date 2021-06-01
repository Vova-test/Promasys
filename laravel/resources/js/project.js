new Vue({
    el: "#project-app",
    data: {
        userProjects: [],
        selectedProjectIndex: -1,
        response: {},
        errors: [],
        logs: [],
        search: '',
        modalVisibility: false,
        project: {
            id: '',
            name: '',
            logo: '',
            description: '',
        },
    },
    methods: {
        async ajax(url, method = 'post', body = {}) {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
                },
                body: JSON.stringify(body),
            });

            if (!response.ok) {
                throw new Error(response.status);
            }

            const data = await response.json();

            return data;
        },
        getProjects() {
            const result = this.ajax('/projects')
                .then(result => {
                    this.errors.length = 0;
                    this.userProjects = result.userProjects;

                    if (this.userProjects.length >0) {
                        this.selectProject(0);
                    }
                })
                .catch(err => {
                    this.errors.push(`getProjects error: ${err.message}`);
                });

            return result;
        },
        selectProject(index) {
            this.selectedProjectIndex = index;
        },
        deleteProject(id){
            const result = this.ajax(`/projects/delete/${id}`, 'delete')
                .then(result => {
                    this.logs.length = 0;
                    this.logs.push(`Project was deleted!`);
                    console.log(this.logs, id, result.deleted );
                    this.getProjects();
                })
                .catch(err => {
                    this.logs.length = 0;
                    this.errors.push(`deleteProject error: ${err.message}`);
                });

            return result;
        },
        editProject(project) {
            Object.assign(this.project, project);

            this.modalVisibility = true;
        },
        createNewProject() {
            this.project = {
                id: '',
                name: '',
                logo: '',
                description: '',
            };
        },
        saveProject(id) {
            body = {
                name: this.project.name,
                description: this.project.description,
            }

            method = 'post';

            if (id) {
                url = `/projects/update/${id}`;

                this.updateProject(url, method, body);
            } else {
                url = `/projects/store`;

                this.storeProject(url, method, body);
            }
        },
        updateProject(url, method, body) {
            const result = this.ajax(url, method, body)
                .then(result => {
                    this.errors.length = 0;
                    this.logs.length = 0;
                    this.logs.push(`Project was updated!`);
                    this.getProjects();
                    this.modalVisibility = false;

                })
                .catch(err => {
                    this.errors.push(`updateProject error: ${err.message}`);
                });

            return result;
        },
        storeProject(url, method, body) {
            const result = this.ajax(url, method, body)
                .then(result => {
                    this.errors.length = 0;
                    this.logs.length = 0;
                    this.logs.push(`Project was created!`);
                    this.getProjects();
                    this.modalVisibility = false;
                    console.log(result);
                })
                .catch(err => {
                    this.errors.push(`storeProject error: ${err.message}`);
                });

            return result;

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
