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
        <div class="admin-room-content-block block">
            <p class="admin-room-content-title">{{ title }}</p><hr>
            <p class="admin-room-content-description">{{ briefDescription }}</p>
            <img class="admin-room-content-image" :src="imageUrl" @error="onImageLoadFailure($event)" alt="advertiser_image">
            <p class="admin-room-content-moderation"
                v-bind:class="{ 'overdue-and-failed-moderation-background': ((moderationStatus === 2) || (moderationStatus === 3)),
                                'active-background': (moderationStatus === 1),
                                'in-moderation-background': (moderationStatus === 0)}">
                {{ moderation }}
            </p>
            <div class="admin-room-content-block-inner-wrapper">
                <router-link target="_blank" :to="'/creative/' + id" class="admin-room-content-button">
                    Подробнее<i class="fas fa-angle-double-right"></i>
                </router-link>
                <button v-on:click="onChangeCreativeButtonClick" class="admin-room-content-button"><i class="fas fa-pencil-alt"></i></button>
                <button data-toggle="modal" data-target="#delete-creative-modal" v-on:click="onDeleteCreativeButtonClick(id)" class="admin-room-content-button"><i class="fas fa-trash-alt"></i></button>
            </div>
        </div>

        <button id="trigger-for-change-creative" data-toggle="modal" data-target="#change-creative-modal" ref="btnTriggerChangeCreative"></button>
    </div>
</template>

<script>

    import * as network from "../../scripts/network";
    import * as protocol from "../../scripts/protocol";
    import * as common from "../../scripts/common";
    import * as validation from "../../scripts/validation";

    export default {
        props: ["id", "title", "briefDescription", "imageUrl", "eventDate", "moderationStatus", "moderationText"],
        name: "admin-room-content-component",
        computed: {
            moderation() {
                let moderation = "";
                switch (this.moderationStatus) {
                    case protocol.MODERATION_STATUS_IN_PROGRESS: {
                        moderation = "Объявление находится в режими модерации";
                        break;
                    }
                    case protocol.MODERATION_STATUS_SUCCESS: {
                        moderation = "Объявление успешно опубликовано и сейчас используется на сайте";
                        break;
                    }
                    case protocol.MODERATION_STATUS_FAILED: {
                        moderation = "Объявление не прошло модерацию по причине: " + this.moderationText + " (но вы можете его исправить)";
                        break;
                    }
                }

                const MODERATION_STATUS_OVERDUE_CREATIVE = 3;
                if (!validation.validateCreativeEventDate(this.eventDate)) {
                    this.moderationStatus = MODERATION_STATUS_OVERDUE_CREATIVE;
                    moderation = "Объявление просрочено, так как дата события уже прошла (но вы можете изменить дату события снова или убрать совсем)";
                }

                return moderation;
            }
        },
        methods: {
            onImageLoadFailure (event) {
                event.target.src = common.defaultCreativeImage;
            },
            onChangeCreativeButtonClick() {
                const self = this;
                network.loadCreativeById(this, self.id, response => {
                    console.log(response);
                    let creative = {};
                    creative.id = self.id;
                    creative.title = response.title;
                    creative.briefDescription = response.brief_description;
                    creative.description = response.description;
                    creative.imageURL = response.image_url;
                    creative.eventDate = response.event_date;
                    creative.price = response.price;
                    creative.advertiserEmail = response.email;
                    creative.advertiserPhone = response.phone;
                    creative.advertiserSite = response.site;
                    creative.city = response.city;
                    creative.country = response.country;
                    creative.category = response.category;
                    creative.theme = response.theme;
                    creative.online = response.online;

                    self.$root.$emit('click-change-creative-page', creative);
                    self.$refs.btnTriggerChangeCreative.click();
                }, error => {
                    console.log(error);
                });
            },
            onDeleteCreativeButtonClick(creativeId) {
                this.$root.$emit('click-delete-creative-page', creativeId);
            }
        }
    }

</script>

<style scoped>

    hr {
        margin: 15px 0 15px 0;
        padding: 0;
    }

    .active-background {
        color: #228B22;
        background-color: #e7f6e2;
    }

    .in-moderation-background {
        color: #795916;
        background-color: #fff3db;
    }

    .overdue-and-failed-moderation-background {
        background-color: #ffcccb;
        color: #c41e3a;
    }

    .admin-room-content-block {
        margin-bottom: 10px;
    }

    .admin-room-content-title {
        padding: 20px 20px 5px 20px;
        height: 70px;
        display: flex;
        justify-content: left;
        align-items: center;
        font-family: 'Roboto', sans-serif;
        font-weight: bold;
        font-size: 17px;
    }

    .admin-room-content-description {
        font-size: 15px;
        height: 115px;
        margin: 0 20px 20px 20px;
        font-family: 'Open Sans', sans-serif;
    }

    .admin-room-content-moderation {
        font-size: 14px;
        font-weight: bold;
        height: 130px;
        padding: 20px 20px 20px 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        font-family: 'Open Sans', sans-serif;
    }

    .admin-room-content-image {
        width: 358px;
        height: 205px;
    }

    .admin-room-content-block-inner-wrapper {
        margin: 20px 15px 20px 15px;
        display: flex;
    }

    .admin-room-content-button {
        position: relative;
        border: 1px solid #2D71BC;
        outline: none;
        text-align: center;
        margin: 0 5px 0 5px;
        font-size: 16px;
        text-decoration: none;
        background-color: transparent;
        color: #2D71BC;
        border-radius: 5px;
        padding: 7px 25px 7px 25px;
        font-family: 'Open Sans', sans-serif;
        transition: .3s;
    }

    .admin-room-content-button:hover {
        text-decoration: none;
        color: white;
        background-color: #2D71BC
    }

    .admin-room-content-button:nth-child(1) {
        width: 60%;
    }

    .admin-room-content-button:nth-child(2) {
        border: 1px solid #e08d3c;
        color: #e08d3c;
        width: 20%
    }

    .admin-room-content-button:nth-child(2):hover {
        color: white;
        background-color: #e08d3c;
    }

    .admin-room-content-button:nth-child(3) {
        border: 1px solid #8A0200;
        color: #8A0200;
        width: 20%
    }

    .admin-room-content-button:nth-child(3):hover {
        color: white;
        background-color: #8A0200;
    }

    .fa-angle-double-right {
        font-size: 14px;
        margin-left: 10px;
        transform: translateY(1px);
    }

    #trigger-for-change-creative {
        visibility: hidden;
    }

    @media (min-width: 992px) and (max-width: 1199px) {

        .admin-room-content-button {
            font-size: 15px;
            padding: 7px 14px 7px 14px;
        }

        .admin-room-content-title {
            font-size: 16px;
        }

        .admin-room-content-description {
            height: 130px;
        }

        .admin-room-content-image {
            width: 292px;
            height: 165px;
        }

    }

    @media (min-width: 768px) and (max-width: 991px) {

        .admin-room-content-description {
            height: auto;
        }

        .admin-room-content-image {
            width: 100%;
            height: auto;
        }

    }

    @media(max-width:767px) {

        .admin-room-content-block {
            margin-bottom: -5px;
        }

        .admin-room-content-button {
            font-size: 14px;
            padding: 7px 14px 7px 14px;
        }

        .admin-room-content-description {
            height: auto;
        }

        .admin-room-content-image {
            width: 100%;
            height: auto;
        }

    }

</style>