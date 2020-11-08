<!--
- Copyright 2018 Vladimir Balun
-
- Licensed under the Apache License, Version 2.0 (the "License");
- you may not use this file except in compliance with the License.
- You may obtain a copy of the License at
-
-     http://www.apache.org/licenses/LICENSE-2.0
-
- Unless required by applicable law or agreed to in writing, software
- distributed under the License is distributed on an "AS IS" BASIS,
- WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
- See the License for the specific language governing permissions and
- limitations under the License.
-->

<template>
    <div>
        <header-component></header-component>
        <div class="creative-page container">
            <div class="row">
                <creative-contacts-component class="col-lg-4 col-md-4 hidden-sm hidden-xs"
                    :image_url="this.creativeImageURL" :price="this.creativePrice">
                </creative-contacts-component>
                <creative-information-component class="col-lg-8 col-md-8 col-sm-12 col-xs-12"
                    :title="this.creativeTitle" :description="this.creativeDescription">
                </creative-information-component>
            </div>
        </div>
    </div>
</template>

<script>

    "use strict";

    import headerComponent from "../components/header-component";
    import footerComponent from "../components/footer-component";
    import creativeContactsComponent from "../components/creative-contacts-component";
    import creativeInformationComponent from "../components/creative-information-component";

    export default {
        name: "creative-page",
        components: {
            headerComponent,
            footerComponent,
            creativeContactsComponent,
            creativeInformationComponent
        },
        data() {
            return {
                pageStatus: 0,
                creativeTitle: "",
                creativeDescription: "",
                creativeImageURL: "",
                creativeEventDate: "",
                creativePrice: 0
            };
        },
        computed: {
            id() {
                return this.$route.params.id;
            }
        },
        methods: {
            loadCreativeInformation() {
                const self = this;
                this.$http.get("http://localhost:8080/creative", { params: { creative_id: self.id } })
                    .then(response => {
                        self.creativeTitle = response.body.title;
                        self.creativeDescription = response.body.description;
                        self.creativeImageURL = response.body.image_url;
                        self.creativeEventDate = response.body.event_date;
                        self.creativePrice = response.body.price;
                    }, error => {
                        console.log(error);
                    });
            },
        },
        created() {
            this.loadCreativeInformation();
        }
    }

</script>

<style scoped>

    .creative-page {
        margin-top: 30px;
    }

</style>