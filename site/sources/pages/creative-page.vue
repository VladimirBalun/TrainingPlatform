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
        <creative-header-component></creative-header-component>
        <div class="creative-page container">
            <div class="row">
                <div v-show="(pageLoaded) && (creative.title !== '') && (creative.description !== '')">
                    <div v-show="moderation !== ''" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="creative-page-error-block">{{ moderation }}</div>
                    </div>
                    <creative-contacts-component class="col-lg-4 col-md-4 col-sm-5 col-xs-12"
                        :image-url="creative.imageURL" :email="creative.advertiserEmail"
                        :phone="creative.advertiserPhone" :site="creative.advertiserSite" :price="creative.price">
                    </creative-contacts-component>
                    <creative-information-component class="col-lg-8 col-md-8 col-sm-7 col-xs-12"
                        :title="creative.title" :description="creative.description"
                        :country="creative.country" :city="creative.city"
                        :category="creative.category" :theme="creative.theme"
                        :event-date="creative.eventDate" :online="creative.online"
                        :advertiser-image-url="creative.advertiserImageUrl">
                    </creative-information-component>
                    <advertisement-component class="col-xs-12 hidden-sm hidden-md hidden-lg"></advertisement-component>
                    <creative-proposed-creatives-component v-show="moderation === ''" :id="id"></creative-proposed-creatives-component>
                </div>
                <div v-show="(pageLoaded) && ((creative.title === '') || (creative.description === ''))">
                    <div class="creative-page-error-message col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        Объявление не найдено, возможно оно было удалено или деактивировано рекламодателем...
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    "use strict";

    import creativeHeaderComponent from "../components/creative-page/creative-header-component";
    import footerComponent from "../components/footer-component";
    import creativeContactsComponent from "../components/creative-page/creative-contacts-component";
    import creativeInformationComponent from "../components/creative-page/creative-information-component";
    import creativeProposedCreativesComponent from "../components/creative-page/creative-proposed-creatives-component";
    import advertisementComponent from "../components/advertisement-component";

    import * as network from "../scripts/network";
    import * as protocol from "../scripts/protocol";
    import * as validation from "../scripts/validation";

    export default {
        name: "creative-page",
        components: {
            creativeHeaderComponent,
            footerComponent,
            creativeContactsComponent,
            creativeInformationComponent,
            creativeProposedCreativesComponent,
            advertisementComponent
        },
        data() {
            return {
                pageLoaded: false,
                creative: {
                    title: "",
                    description: "",
                    imageURL: "",
                    eventDate: "",
                    price: 0,
                    city: "",
                    country: "",
                    category: "",
                    theme: "",
                    status: 0,
                    email: "",
                    advertiserEmail: "",
                    advertiserPhone: "",
                    advertiserSite: "",
                    online: 0,
                    moderationStatus: 0,
                    advertiserImageUrl: ""
                }
            };
        },
        computed: {
            id() {
                return this.$route.params.id;
            },
            moderation() {
                let moderationText = "";
                switch (this.creative.moderationStatus) {
                    case protocol.MODERATION_STATUS_IN_PROGRESS: {
                        moderationText = "Данное объявление не было опубликовано и его пока не могут " +
                            "увидеть другие пользователи, так как оно еще находится в режиме модерации...";
                        break;
                    }
                    case protocol.MODERATION_STATUS_FAILED: {
                        moderationText = "Данное объявление не было опубликовано и его пока не могут " +
                            "увидеть другие пользователи, так как оно не прошло модерацию...";
                        break;
                    }
                }

                if (!validation.validateCreativeEventDate(this.creative.eventDate)) {
                    moderationText = "Данное объявление не опубликовано и его не могут увидеть другие пользователи, " +
                        "так как дата события уже прошла...";
                }

                return  moderationText;
            }
        },
        methods: {
            loadCreativeInformation() {
                const self = this;
                network.loadCreativeById(this, self.id, response => {
                    console.log(response);
                    const getCookie = (name) => {
                        const value = `; ${document.cookie}`;
                        const parts = value.split(`; ${name}=`);
                        if (parts.length === 2) {
                            return parts.pop().split(';').shift();
                        }
                    };

                    if (response.moderation_status !== protocol.MODERATION_STATUS_SUCCESS) {
                        const cookieId = getCookie("trainter_id");
                        const cookieHash = getCookie("trainter_hash");
                        if ((cookieId !== response.advertiser_id) ||
                            ((cookieHash !== response.advertiser_hash))) {
                            self.pageLoaded = true;
                            return;
                        }
                    }

                    if (response instanceof Object) {
                        self.creative.title = response.title;
                        self.creative.description = response.description;
                        self.creative.imageURL = response.image_url;
                        self.creative.eventDate = response.event_date;
                        self.creative.price = response.price;
                        self.creative.advertiserEmail = response.email;
                        self.creative.advertiserPhone = response.phone;
                        self.creative.advertiserSite = response.site;
                        self.creative.city = response.city;
                        self.creative.country = response.country;
                        self.creative.category = response.category;
                        self.creative.theme = response.theme;
                        self.creative.moderationStatus = response.moderation_status;
                        self.creative.online = response.online;
                        self.creative.advertiserImageUrl = response.advertiser_image_url;
                        document.title = "Trainter: " + self.creative.title;
                    }

                    self.pageLoaded = true;
                }, error => {
                    self.pageLoaded = true;
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
        position: relative;
        margin-top: 30px;
    }

    .creative-page-error-block {
        background-color: #ffcccb;
        margin-bottom: 30px;
        border-radius: 5px;
        color: #c41e3a;
        text-align: center;
        font-family: 'Open Sans', sans-serif;
        font-size: 15px;
        font-weight: bold;
        padding: 20px;
    }

    .creative-page-error-message {
        height: 90vh;
        font-size: 18px;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Roboto', sans-serif;
    }

    @media(max-width:767px) {

        .creative-page {
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .creative-page-error-block {
            margin-bottom: 15px;
        }

    }

</style>