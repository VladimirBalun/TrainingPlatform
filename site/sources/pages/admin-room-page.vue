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
    <div class="page">
        <admin-room-header-component></admin-room-header-component>
        <div class="container">
            <div class="row">
                <admin-room-navigation-component class="col-lg-4 col-md-4 col-sm-5 col-xs-12 navigation"
                    :id="id" :advertiserImageUrl="advertiserImageUrl"></admin-room-navigation-component>
                <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                    <div class="admin-room-creative-type-buttons-block block">
                        <p class="admin-room-creative-type-buttons-block-title"><i class="fas fa-filter"></i>Фильтры объявлений</p><hr>
                        <div class="admin-room-creative-type-inner-buttons-block">
                            <button class="admin-room-filter-button" @click="onAllFilterButtonClick"
                                v-bind:class="{ 'admin-room-active-filter-button': activeFilterState === filterState.allCreatives }">Все</button>
                            <button class="admin-room-filter-button" @click="onInModerationFilterButtonClick"
                                v-bind:class="{ 'admin-room-active-filter-button': activeFilterState === filterState.inModerationCreatives }">В модерации</button>
                            <button class="admin-room-filter-button" @click="onActiveFilterButtonClick"
                                v-bind:class="{ 'admin-room-active-filter-button': activeFilterState === filterState.activeCreative }">Aктивные</button>
                            <button class="admin-room-filter-button" @click="onOverdueFilterButtonClick"
                                v-bind:class="{ 'admin-room-active-filter-button': activeFilterState === filterState.overdueCreatives }">Просроченные</button>
                        </div>
                    </div>
                </div>
                <div v-show="filteredCreatives.length !== 0" class="admin-room-creatives-wrapper col-lg-8 col-md-8 col-sm-7 col-xs-12">
                    <div class="row">
                        <admin-room-content-component v-for="creative in filteredCreatives" class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
                            :id="creative.id" :title="creative.title" :imageUrl="creative.imageUrl" :eventDate="creative.eventDate"
                            :moderationStatus="creative.moderationStatus" :moderationText="creative.moderationText"
                            :briefDescription="creative.briefDescription">
                        </admin-room-content-component>
                        <advertisement-component class="col-xs-12 hidden-sm hidden-md hidden-lg"></advertisement-component>
                    </div>
                </div>
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
        <admin-room-message-component v-bind:title="modalMessageTitle"
            v-bind:description="modalMessageDescription" :type="modalMessageType">
        </admin-room-message-component>

        <button ref="triggerShowMessageModal" class="hidden-trigger-button" data-toggle="modal" data-target="#message-modal"></button>
    </div>
</template>

<script>

    import * as network from "../scripts/network";
    import * as protocol from "../scripts/protocol";
    import * as validation from "../scripts/validation";

    import adminRoomHeaderComponent from "../components/admin-room-page/admin-room-header-component";
    import adminRoomContentComponent from "../components/admin-room-page/admin-room-content-component"
    import adminRoomNavigationComponent from "../components/admin-room-page/admin-room-navigation-component";
    import adminRoomAddCreativeComponent from "../components/admin-room-page/admin-room-add-creative-component";
    import adminRoomChangeCreativeModal from "../components/admin-room-page/admin-room-change-creative-component";
    import adminRoomDeleteCreativeModal from "../components/admin-room-page/admin-room-delete-creative-modal";
    import adminRoomMessageComponent from "../components/admin-room-page/admin-room-message-component";
    import advertisementComponent from "../components/advertisement-component";

    export default {
        name: "admin-room-page",
        components: {
            adminRoomHeaderComponent,
            adminRoomContentComponent,
            adminRoomNavigationComponent,
            adminRoomAddCreativeComponent,
            adminRoomChangeCreativeModal,
            adminRoomDeleteCreativeModal,
            adminRoomMessageComponent,
            advertisementComponent
        },
        data() {
            return {
                filterState: {
                    allCreatives: 0,
                    inModerationCreatives: 1,
                    activeCreative: 2,
                    overdueCreatives: 3
                },
                activeFilterState: 0,
                modalMessageType: "",
                modalMessageTitle: "",
                modalMessageDescription: "",
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
            sortCreatives() {
                if (this.activeFilterState === this.filterState.allCreatives) {
                    this.filteredCreatives.sort((lhs, rhs) => {
                        if ((lhs.moderationStatus < rhs.moderationStatus) ||
                            (!validation.validateCreativeEventDate(rhs.moderationStatus))) {
                            return -1;
                        } else if (lhs.moderationStatus > rhs.moderationStatus) {
                            return 1;
                        } else {
                            return 0;
                        }
                    });
                }
            },
            fillAdvertiserCreatives() {
                const self = this;
                network.loadAdvertiserDemoCreatives(this, self.id, response => {
                    console.log(response);
                    self.advertiserImageUrl = response.advertiser_image_url;
                    response.creatives.forEach(creative => {
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
                    self.sortCreatives();
                  //self.$root.$forceUpdate();

                }, error => {

                });
            },
            onAllFilterButtonClick() {
                this.activeFilterState = this.filterState.allCreatives;
                this.filteredCreatives = this.advertiserCreatives;
                this.sortCreatives();
            },
            onInModerationFilterButtonClick() {
                this.activeFilterState = this.filterState.inModerationCreatives;
                this.filteredCreatives = this.advertiserCreatives.filter((creative) => {
                    return ((creative.moderationStatus === protocol.MODERATION_STATUS_IN_PROGRESS) ||
                        (creative.moderationStatus === protocol.MODERATION_STATUS_FAILED)) &&
                        (validation.validateCreativeEventDate(creative.eventDate));
                });
                this.sortCreatives();
            },
            onActiveFilterButtonClick() {
                this.activeFilterState = this.filterState.activeCreative;
                this.filteredCreatives = this.advertiserCreatives.filter((creative) => {
                    return (creative.moderationStatus === protocol.MODERATION_STATUS_SUCCESS) &&
                        (validation.validateCreativeEventDate(creative.eventDate));
                });
                this.sortCreatives();
            },
            onOverdueFilterButtonClick() {
                this.activeFilterState = this.filterState.overdueCreatives;
                this.filteredCreatives = this.advertiserCreatives.filter((creative) => {
                    return (!validation.validateCreativeEventDate(creative.eventDate));
                });
                this.sortCreatives();
            }
        },
        mounted() {
            const self = this;

            this.$root.$on("added-creative-page", (creative) => {
                const creativeForVisualization = {
                    id : creative.id,
                    title : creative.title,
                    briefDescription : creative.briefDescription,
                    imageUrl : creative.image,
                    eventDate : (creative.eventDate !== "") ? (creative.eventDate) : (null),
                    moderationStatus: protocol.MODERATION_STATUS_IN_PROGRESS
                };

                self.advertiserCreatives.push(creativeForVisualization);
                if (self.activeFilterState === self.filterState.inModerationCreatives) {
                    self.onInModerationFilterButtonClick();
                } else if (self.activeFilterState === self.filterState.allCreatives) {
                    self.onAllFilterButtonClick();
                }
            });

            this.$root.$on("changed-creative-page", changedCreative => {
                self.filteredCreatives.forEach(creative => {
                    if (changedCreative.id === creative.id) {
                        creative.title = changedCreative.title;
                        creative.briefDescription = changedCreative.briefDescription;
                        creative.imageUrl = changedCreative.image;
                        creative.eventDate = changedCreative.eventDate;
                        creative.moderationStatus = protocol.MODERATION_STATUS_IN_PROGRESS;
                    }
                });
                self.advertiserCreatives.forEach(creative => {
                    if (changedCreative.id === creative.id) {
                        creative.title = changedCreative.title;
                        creative.briefDescription = changedCreative.briefDescription;
                        creative.imageUrl = changedCreative.image;
                        creative.eventDate = changedCreative.eventDate;
                        creative.moderationStatus = protocol.MODERATION_STATUS_IN_PROGRESS;
                    }
                });
                self.sortCreatives();
            });

            this.$root.$on("deleted-creative-page", creativeId => {
                self.advertiserCreatives = self.advertiserCreatives.filter(creative => {
                    return creative.id !== creativeId;
                });
                self.filteredCreatives = self.filteredCreatives.filter(creative => {
                    return creative.id !== creativeId;
                });
                self.sortCreatives();
            });

            this.$root.$on("show-message-modal", messageData => {
                self.modalMessageType = messageData.type;
                self.modalMessageTitle = messageData.title;
                self.modalMessageDescription = messageData.description;
                self.$refs.triggerShowMessageModal.click();
            });
        },
        beforeDestroy() {
            this.$root.$off("added-creative-page");
            this.$root.$off("changed-creative-page");
            this.$root.$off("deleted-creative-page");
            this.$root.$off("show-message-modal");
        },
        created() {
            this.fillAdvertiserCreatives();
            document.title = "Trainter: Комната администратора";
        }
    }

</script>

<style scoped>

    .admin-room-creatives-wrapper {
        position: relative;
        height: 100%;
    }

    .admin-room-creative-type-buttons-block {
        margin: 30px 0 30px 0;
    }

    .admin-room-creative-type-inner-buttons-block {
        padding: 0 15px 10px 15px;
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

    .admin-room-active-filter-button {
        background-color: #2D71BC;
        color: white;
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
            padding: 0 15px 10px 20px;
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
            padding: 0 15px 10px 15px;
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