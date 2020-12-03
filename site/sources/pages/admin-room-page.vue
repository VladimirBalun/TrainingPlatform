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
        <div class="container">
            <div class="row">
                <admin-room-navigation-component class="col-lg-4 col-md-4 col-sm-5 col-xs-12"
                    :id="id" :advertiserImageUrl="advertiserImageUrl"></admin-room-navigation-component>
                <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                    <div class="admin-room-creative-type-buttons-block block">
                        <p class="admin-room-creative-type-buttons-block-title"><i class="fas fa-filter"></i>Фильтры объявлений</p><hr>
                        <div class="admin-room-creative-type-inner-buttons-block">
                            <button @click="onAllFilterButtonClick" class="admin-room-filter-button">Все</button>
                            <button @click="onInModerationFilterButtonClick" class="admin-room-filter-button">В модерации</button>
                            <button @click="onActiveFilterButtonClick" class="admin-room-filter-button">Aктивные</button>
                            <button @click="onOverdueFilterButtonClick" class="admin-room-filter-button">Просроченные</button>
                        </div>
                    </div>
                </div>
                <admin-room-content-component v-for="creative in filteredCreatives" class="col-lg-4 col-md-4 col-sm-7 col-xs-12"
                    :id="creative.id" :title="creative.title" :imageUrl="creative.imageUrl" :eventDate="creative.eventDate"
                    :moderationStatus="creative.moderationStatus" :moderationText="creative.moderationText"
                    :briefDescription="creative.briefDescription">
                </admin-room-content-component>
                <div v-show="filteredCreatives.length === 0">
                    <div class="admin-room-error-message col-lg-8 col-md-8 col-sm-7 col-xs-12">
                        Объявления отсутствуют...
                    </div>
                </div>
            </div>
        </div>

        <admin-room-add-creative-component :advertiser-id="id"></admin-room-add-creative-component>
        <admin-room-change-creative-modal :advertiser-id="id"></admin-room-change-creative-modal>
        <admin-room-delete-creative-modal></admin-room-delete-creative-modal>
    </div>
</template>

<script>

    import * as protocol from '../scripts/protocol'

    import headerComponent from "../components/header-component";
    import adminRoomContentComponent from "../components/admin-room/admin-room-content-component"
    import adminRoomNavigationComponent from "../components/admin-room/admin-room-navigation-component";
    import adminRoomAddCreativeComponent from "../components/admin-room/admin-room-add-creative-component";
    import adminRoomChangeCreativeModal from "../components/admin-room/admin-room-change-creative-component";
    import adminRoomDeleteCreativeModal from "../components/admin-room/admin-room-delete-creative-modal";

    export default {
        name: "admin-room-page",
        components: {
            headerComponent,
            adminRoomContentComponent,
            adminRoomNavigationComponent,
            adminRoomAddCreativeComponent,
            adminRoomChangeCreativeModal,
            adminRoomDeleteCreativeModal
        },
        data() {
            return {
                advertiserImageUrl: "",
                advertiserCreatives: [],
                filteredCreatives: []
            };
        },
        computed: {
            id() {
                return this.$route.params.id;
            }
        },
        methods: {
            fillAdvertiserCreatives() {
                const self = this;
                this.$http.get("http://localhost:8080/advertiser_demo_creative", { params: { advertiser_id: self.id } })
                    .then(response => {
                        console.log(response);
                        self.advertiserImageUrl = response.body.advertiser_image_url;
                        response.body.creatives.forEach(creative => {
                            console.log(creative.moderation_status);
                            self.filteredCreatives.push({
                                id : creative.id,
                                title : creative.title,
                                briefDescription : creative.brief_description,
                                imageUrl : creative.image_url,
                                eventDate : creative.event_date,
                                moderationStatus : creative.moderation_status,
                                moderationText : creative.moderation_text,
                            });
                        });
                        self.advertiserCreatives = self.filteredCreatives;
                    });
            },
            onAllFilterButtonClick() {
                this.filteredCreatives = this.advertiserCreatives;
            },
            onInModerationFilterButtonClick() {
                this.filteredCreatives = this.advertiserCreatives.filter((creative) => {
                    return (creative.moderationStatus === protocol.MODERATION_STATUS_IN_PROGRESS) ||
                        (creative.moderationStatus === protocol.MODERATION_STATUS_FAILED);
                });
            },
            onActiveFilterButtonClick() {
                this.filteredCreatives = this.advertiserCreatives.filter((creative) => {
                    return (creative.moderationStatus === protocol.MODERATION_STATUS_SUCCESS);
                });
            },
            onOverdueFilterButtonClick() {

            }
        },
        mounted() {
            const self = this;
            this.$root.$once('added-creative', (creative) => {
                const creativeForVisualization = {
                    id : creative.id,
                    title : creative.title,
                    briefDescription : creative.briefDescription,
                    imageUrl : creative.image,
                    eventDate : creative.eventDate,
                };
                // TODO: need to think about filters
                self.filteredCreatives.push(creativeForVisualization);
                self.advertiserCreatives.push(creativeForVisualization);
            });
            this.$root.$on('deleted-creative', creativeId => {
                self.advertiserCreatives = self.advertiserCreatives.filter(creative => {
                    return creative.id !== creativeId;
                });
                self.filteredCreatives = self.advertiserCreatives;
            });
        },
        beforeDestroy() {
            this.$root.$off('added-creative');
            this.$root.$off('deleted-creative');
        },
        created() {
            this.fillAdvertiserCreatives();
        }
    }

</script>

<style scoped>

    .admin-room-creative-type-buttons-block {
        margin: 30px 0 30px 0;
    }

    .admin-room-creative-type-inner-buttons-block {
        padding: 0 15px 15px 20px;
        display: flex;
    }

    .fa-filter {
        font-size: 15px;
        margin-right: 10px;
        transform: translateY(-1px);
    }

    .admin-room-creative-type-buttons-block-title {
        color: black;
        font-family: 'Roboto', sans-serif;
        font-weight: bold;
        font-size: 20px;
        padding: 15px 20px 0 20px;
    }

    .admin-room-filter-button {
        position: relative;
        border: 1px solid #2D71BC;
        outline: none;
        padding: 7px 14px 7px 14px;
        border-radius: 5px;
        font-size: 14px;
        font-family: 'Open Sans', sans-serif;
        color:  #2D71BC;
        background-color: transparent;
        transition: .3s;
        margin: 0 5px 10px 5px;
    }

    .admin-room-filter-button:hover {
        background-color: #2D71BC;
        color: white;
    }

    .admin-room-filter-button:nth-child(1) {
        width: 10%;
    }

    .admin-room-filter-button:nth-child(2) {
        width: 40%;
    }

    .admin-room-filter-button:nth-child(3) {
        width: 20%;
    }

    .admin-room-filter-button:nth-child(4) {
        width: 30%;
    }

    .admin-room-error-message {
        height: 60vh;
        font-size: 18px;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Roboto', sans-serif;
    }

    @media (min-width: 768px) and (max-width: 991px) {

        .admin-room-creative-type-inner-buttons-block {
            padding: 0 15px 15px 20px;
            display: inherit;
        }

        .admin-room-filter-button:nth-child(1) {
            width: calc(30% - 10px);
        }

        .admin-room-filter-button:nth-child(2) {
            width: calc(70% - 15px);
        }

        .admin-room-filter-button:nth-child(3) {
            width: calc(40% - 10px);
        }

        .admin-room-filter-button:nth-child(4) {
            width: calc(60% - 15px);
        }

    }

    @media(max-width:767px) {

        .admin-room-error-message {
            height: 45vh;
        }

        .admin-room-creative-type-buttons-block {
            margin: 15px 0 15px 0;
        }

        .admin-room-creative-type-inner-buttons-block {
            padding: 0 15px 15px 20px;
            display: inherit;
        }

        .admin-room-filter-button:nth-child(1) {
            width: calc(30% - 10px);
        }

        .admin-room-filter-button:nth-child(2) {
            width: calc(70% - 15px);
        }

        .admin-room-filter-button:nth-child(3) {
            width: calc(40% - 10px);
        }

        .admin-room-filter-button:nth-child(4) {
            width: calc(60% - 15px);
        }

    }

</style>