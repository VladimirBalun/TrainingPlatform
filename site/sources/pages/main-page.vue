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
        <diV class="main-page container">
            <div class="row">
                <navigation-component class="col-lg-4 col-md-4 col-sm-5 hidden-12"></navigation-component>
                <div v-show="(pageLoaded) && (demoCreatives.length !== 0)">
                    <content-component v-for="creative in demoCreatives" class="col-lg-4 col-md-4 col-sm-7 col-xs-12"
                        :id="creative.id" :title="creative.title" :briefDescription="creative.briefDescription"
                        :imageUrl="creative.imageUrl" :eventDate="creative.eventDate" :price="creative.price"
                        :online="creative.online" :advertiserImageUrl="creative.advertiserImageUrl">
                    </content-component>
                    <advertisement-component class="col-xs-12 hidden-sm hidden-md hidden-lg"></advertisement-component>
                </div>
                <div v-show="(pageLoaded) && (demoCreatives.length === 0)">
                    <div class="main-page-error-message col-lg-8 col-md-8 col-sm-7 col-xs-12">
                        Объявления не найдены...
                    </div>
                </div>
            </div>
        </diV>
    </div>
</template>

<script>

    "use strict";

    import headerComponent from "../components/header-component";
    import contentComponent from "../components/content-component";
    import navigationComponent from "../components/navigation-component.vue";
    import advertisementComponent from "../components/advertisement-component";

    export default {
        components: {
            headerComponent,
            contentComponent,
            navigationComponent,
            advertisementComponent
        },
        data() {
            return {
                pageLoaded: false,
                demoCreatives: []
            };
        },
        methods: {
            fillDemoCreatives() {
                const self = this;
                this.$http.get("http://localhost:8080/demo_creatives")
                    .then(response => {
                        self.demoCreatives = [];
                        response.body.forEach(creative => {
                            self.demoCreatives.push({
                                id : creative.id,
                                title : creative.title,
                                briefDescription : creative.brief_description,
                                imageUrl : creative.image_url,
                                advertiserImageUrl : creative.advertiser_image_url,
                                eventDate : creative.event_date,
                                price : creative.price,
                                online : creative.online
                            })
                        });

                        self.pageLoaded = true;
                    });
            },
            fillCreativesByTitlePattern(titlePattern) {
                const self = this;
                this.$http.get("http://localhost:8080/search_demo_creatives", { params: { title_pattern: encodeURI(titlePattern) } })
                    .then(response => {
                        self.demoCreatives = [];
                        console.log(response);
                        response.body.forEach(creative => {
                            self.demoCreatives.push({
                                id : creative.id,
                                title : creative.title,
                                briefDescription : creative.brief_description,
                                imageUrl : creative.image_url,
                                advertiserImageUrl : creative.advertiser_image_url,
                                eventDate : creative.event_date,
                                price : creative.price,
                                online : creative.online
                            })
                        });
                    });
            }
        },
        created() {
            this.fillDemoCreatives();
            const self = this;
            this.$root.$on("search-creatives-button-clicked", (titlePattern) => {
                self.fillCreativesByTitlePattern(titlePattern);
            })
        }
    };

</script>

<style scoped>

    .main-page {
        margin-top: 30px;
    }

    .main-page-error-message {
        height: 90vh;
        font-size: 18px;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Roboto', sans-serif;
    }

    @media(max-width:767px) {

        .main-page {
            margin-top: 15px;
        }

        .main-page-error-message {
            height: 60vh;
        }

    }

</style>