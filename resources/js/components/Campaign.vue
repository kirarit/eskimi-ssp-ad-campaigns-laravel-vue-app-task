<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div id="campaign-ad-container" class="p-2">
                    <section id="campaign-ad-header" class="mt-3">
                        <h3 class="text-center">Eskimi SSP Campaigns</h3>
                    </section>

                    <section id="create-campaign-ad" class="mb-2">
                        <div class="text-right">
                            <button
                                @click.prevent="showCreateCampaignAdForm"
                                class="btn-primary fa fa-plus"
                            >
                                Create
                            </button>
                        </div>
                    </section>

                    <section id="campaign-ads-list">
                        <div v-if="ads.isLoading" class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <table>
                            <tr>
                                <th>Name</th>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>Daily budget(USD)</th>
                                <th>Total budget(USD)</th>
                                <th>Action</th>
                            </tr>
                            <tr
                                v-if="!ads.isLoading && ads.data.length > 0"
                                v-for="ad in ads.data"
                                :key="ad.id"
                            >
                                <td>{{ ad.name }}</td>
                                <td>{{ ad.from_date }}</td>
                                <td>{{ ad.to_date }}</td>
                                <td>{{ ad.daily_budget }}</td>
                                <td>{{ ad.total_budget }}</td>

                                <td
                                    class="d-flex justify-content-between align-items-center"
                                >
                                    <a
                                        class="text-success mr-2"
                                        href="#"
                                        @click.prevent="showAdContent(ad)"
                                    >
                                        <i class="fa fa-eye"> </i>
                                        View Image(s)
                                    </a>
                                    <a
                                        class="text-success mr-2"
                                        href="#"
                                        @click.prevent="
                                            showEditAdContentModal(ad)
                                        "
                                    >
                                        <i class="fa fa-edit"> </i>
                                        Edit
                                    </a>
                                    <a
                                        class="text-danger"
                                        href="#"
                                        @click.prevent="destroy(ad)"
                                    >
                                        <i class="fa fa-trash-o"></i>
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <div v-if="!ads.isLoading && ads.data.length === 0">
                            No ad campaign found
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <!-- Modals -->
        <!-- create new campaign ad -->
        <div
            class="modal fade"
            id="createCampaignAdModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="createCampaignAdModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCampaignAdModalLabel">
                            Create Campaign Ad
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <section id="create-ad-errors">
                            <div
                                v-if="createAdForm.errors.length > 0"
                                class="alert alert-warning alert-dismissible fade show"
                                role="alert"
                            >
                                <span
                                    v-for="(error,
                                    index) in createAdForm.errors"
                                    :key="index"
                                    ><ul>
                                        <li>{{ error }}</li>
                                    </ul></span
                                >
                                <button
                                    type="button"
                                    class="close"
                                    data-dismiss="alert"
                                    aria-label="Close"
                                >
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </section>
                        <section id="create-ad-campaign">
                            <div class="container">
                                <FormulateForm @submit="createAdCampaign">
                                    <FormulateInput
                                        type="text"
                                        name="name"
                                        label="Name"
                                        placeholder="Enter name"
                                    />

                                    <FormulateInput
                                        type="date"
                                        name="from_date"
                                        label="From Date"
                                        placeholder="Enter from date"
                                    />

                                    <FormulateInput
                                        type="date"
                                        name="to_date"
                                        label="To Date"
                                        placeholder="Enter to date"
                                    />

                                    <FormulateInput
                                        type="number"
                                        step="any"
                                        name="daily_budget"
                                        label="Daily Budget(USD)"
                                        placeholder="Enter daily budget"
                                    />

                                    <FormulateInput
                                        type="number"
                                        step="any"
                                        name="total_budget"
                                        label="Total Budget(USD)"
                                        placeholder="Enter total budget"
                                    />

                                    <FormulateInput
                                        type="image"
                                        name="img"
                                        upload-url="/public/image-uploads"
                                        label="Creative Upload"
                                        upload-behavior="delayed"
                                        multiple
                                    /><br />
                                    <FormulateInput
                                        type="submit"
                                        class="btn btn-primary"
                                        label="Submit"
                                    />
                                </FormulateForm>
                            </div>
                        </section>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- show campaign ad -->
        <div
            class="modal fade"
            id="showAdContentModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="showAdContentModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="showAdContentModalLabel">
                            Ad Campaign Uploaded Creative
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <section id="show-campaign-ad">
                            <form>
                                <div class="container center">
                                    <h2>Name: {{ editAdContentForm.name }}</h2>
                                    <p>
                                        Image: 
                                        <div id="preview">
                                            <img :src=editAdContentForm.img_path />
                                        </div>
                                    </p>
                                </div>
                            </form>
                        </section>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- edit ad campaign content -->
        <div
            class="modal fade"
            id="editAdContentModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="editAdContentModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAdContentModalLabel">
                            Update Ad Campaign
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <section id="edit-ad-errors" class="mb-3">
                            <div
                                v-if="editAdContentForm.errors.length > 0"
                                class="alert alert-warning alert-dismissible fade show"
                                role="alert"
                            >
                                <span
                                    v-for="(error,
                                    index) in editAdContentForm.errors"
                                    :key="index"
                                    >{{ error }}</span
                                >
                                <button
                                    type="button"
                                    class="close"
                                    data-dismiss="alert"
                                    aria-label="Close"
                                >
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </section>
                        <section id="edit-ad-campaign">
                            <div class="container">
                                <FormulateForm @submit="updateAdContent">
                                    <FormulateInput
                                        type="text"
                                        name="name"
                                        label="Name"
                                        v-model="editAdContentForm.name"
                                    />

                                    <FormulateInput
                                        type="date"
                                        name="from_date"
                                        label="From Date"
                                        v-model="editAdContentForm.from_date"
                                    />

                                    <FormulateInput
                                        type="date"
                                        name="to_date"
                                        label="To Date"
                                        v-model="editAdContentForm.to_date"
                                    />

                                    <FormulateInput
                                        type="number"
                                        step="any"
                                        name="daily_budget"
                                        label="Daily Budget(USD)"
                                        v-model="editAdContentForm.daily_budget"
                                    />

                                    <FormulateInput
                                        type="number"
                                        step="any"
                                        name="total_budget"
                                        label="Total Budget(USD)"
                                        v-model="editAdContentForm.total_budget"
                                    />

                                    <FormulateInput
                                        type="image"
                                        name="img"
                                        upload-url="/public/image-uploads"
                                        label="Creative Upload"
                                        upload-behavior="delayed"
                                        v-model="editAdContentForm.img_path"
                                        multiple
                                    /><br />
                                    <FormulateInput
                                        type="submit"
                                        class="btn btn-primary"
                                        label="Update"
                                    />
                                </FormulateForm>
                            </div>
                        </section>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            ads: {
                isLoading: false,
                data: []
            },
            createAdForm: {
                isSubmitting: false,
                isCreated: false,
                name: undefined,
                from_date: undefined,
                to_date: undefined,
                daily_budget: undefined,
                total_budget: undefined,
                image_path: [],
                errors: []
            },
            editAdContentForm: {
                isSubmitting: false,
                isUpdated: false,
                id: undefined,
                name: undefined,
                from_date: undefined,
                to_date: undefined,
                daily_budget: undefined,
                total_budget: undefined,
                img_path: undefined,
                created_at: undefined,
                errors: []
            },
            error: undefined
        };
    },
    mounted() {
        this.loadCampaignAds();
    },

    methods: {
        showCreateCampaignAdForm() {
            $("#createCampaignAdModal").modal("show");
        },
        showEditAdContentModal(ad) {
            this.editAdContentForm.name = ad.name;
            this.editAdContentForm.from_date = ad.from_date;
            this.editAdContentForm.to_date = ad.to_date;
            this.editAdContentForm.daily_budget = ad.daily_budget;
            this.editAdContentForm.total_budget = ad.total_budget;
            this.editAdContentForm.img_path = ad.image_path;
            this.editAdContentForm.id = ad.id;
            $("#editAdContentModal").modal("show");
        },
        showAdContent(ad) {
            this.editAdContentForm.name = ad.name;
            this.editAdContentForm.img_path = ad.image_path;
            this.editAdContentForm.created_at = ad.created_at;
            this.editAdContentForm.id = ad.id;
            $("#showAdContentModal").modal("show");
        },
        /**
         * Load campaign ads
         */
        loadCampaignAds() {
            // update loader to loading
            this.ads.isLoading = true;

            axios
                .get("/api/advertising-campaign")
                .then(response => {
                    console.log(response.data);
                    this.ads.data = response.data;
                })
                .catch(error => {
                    console.log(error.message);
                    this.error = "Unable to load campaign ads";
                })
                .finally(() => {
                    // disable loader
                    this.ads.isLoading = false;
                });
        },

        /**
         * Create a campaign ad.
         * Uses payload in the this.createAdForm param
         */
        createAdCampaign(data) {
            axios
                .post("/api/advertising-campaign", data)
                .then(response => {
                    $("#createCampaignAdModal").modal("hide");
                    this.loadCampaignAds();
                })
                .catch(error => {
                    /**
                     * Check for form validation error. Laravel return http code 422
                     * _ lodash is already loaded by laravel. check resources/js/bootstrap.js
                     */
                    if (error.response && error.response.status === 422) {
                        this.createAdForm.errors = _.flatten(
                            _.toArray(error.response.data.errors)
                        );
                    } else {
                        console.log(error.message);
                        this.error = "Unable to add campaign ad.";
                    }
                })
                .finally(() => {
                    // disable loader
                    this.createAdForm.isSubmitting = false;
                });
        },
        /**
         * Updates ad content
         *
         */
        updateAdContent(data) {
            // update loader to loading
            this.editAdContentForm.isSubmitting = true;
            axios
                .put(
                    `/api/advertising-campaign/${this.editAdContentForm.id}`,
                    data
                )
                .then(response => {
                    $("#editAdContentModal").modal("hide");
                    this.loadCampaignAds();
                })
                .catch(error => {
                    /**
                     * Check for form validation error. Laravel return http code 422
                     * _ lodash is already loaded by laravel. check resources/js/bootstrap.js
                     */
                    if (error.response && error.response.status === 422) {
                        this.editAdContentForm.errors = _.flatten(
                            _.toArray(error.response.data.errors)
                        );
                    } else {
                        console.log(error.message);
                        this.error = "Unable to update ad content.";
                    }
                })
                .finally(() => {
                    // disable loader
                    this.editAdContentForm.isSubmitting = false;
                });
        },

        /**
         * Deletes a campaign ad
         * @param ad
         */
        destroy(ad) {
            axios
                .delete(`/api/advertising-campaign/${ad.id}`)
                .then(response => {
                    this.loadCampaignAds();
                })
                .catch(error => {
                    console.log(error.message);
                    this.error = "Unable to delete";
                });
        }
    }
};
</script>

<style scoped>
table {
    border: 1px solid black;
}

th,
td {
    border: 1px solid black;
}
</style>
