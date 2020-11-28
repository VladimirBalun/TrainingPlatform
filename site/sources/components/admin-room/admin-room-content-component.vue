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
            <p class="admin-room-content-title">{{ title }}</p>
            <p class="admin-room-content-description">{{ brief_description }}</p>
            <img class="admin-room-content-image" :src="image_url">
            <p class="admin-room-content-moderation">{{ moderation }}</p><hr>
            <div class="admin-room-content-block-inner-wrapper">
                <router-link target="_blank" :to="'/creative/' + id" class="admin-room-content-button">
                    Подробнее<i class="fas fa-angle-double-right"></i>
                </router-link>
                <button v-on:click="onChangeCreativeButtonClick(id)" class="admin-room-content-button"><i class="fas fa-pencil-alt"></i></button>
                <button data-toggle="modal" data-target="#delete-creative-modal" v-on:click="onDeleteCreativeButtonClick(id)" class="admin-room-content-button"><i class="fas fa-trash-alt"></i></button>
            </div>
        </div>
        <admin-room-delete-creative-modal></admin-room-delete-creative-modal>
    </div>
</template>

<script>

    import * as protocol from '../../scripts/protocol'

    import adminRoomDeleteCreativeModal from './admin-room-delete-creative-modal';

    export default {
        components: {
            adminRoomDeleteCreativeModal
        },
        props: ["id", "title", "brief_description", "image_url", "event_date", "moderation_status", "moderation_text"],
        name: "admin-room-content-component",
        computed: {
            moderation() {
                let moderation = "";
                switch (this.moderation_status) {
                    case protocol.MODERATION_STATUS_IN_PROGRESS: {
                        moderation = "Объявление находится в режими модерации";
                        break;
                    }
                    case protocol.MODERATION_STATUS_SUCCESS: {
                        moderation = "Объявление успешно опубликовано и сейчас используется на сайте";
                        break;
                    }
                    case protocol.MODERATION_STATUS_FAILED: {
                        moderation = "Ообъявление не было опубликовано по причине: " + this.moderation_text;
                        break;
                    }
                }

                return moderation;
            }
        },
        methods: {
            onChangeCreativeButtonClick(creativeId) {
                this.$root.$emit('click-change-creative', creativeId);
            },
            onDeleteCreativeButtonClick(creativeId) {
                this.$root.$emit('click-delete-creative', creativeId);
            }
        }
    }

</script>

<style scoped>

    .admin-room-content-block {
        margin-top: 30px;
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
        margin: 20px 20px 0 20px;
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
        border: none;
        outline: none;
        text-align: center;
        margin: 0 5px 0 5px;
        font-size: 16px;
        text-decoration: none;
        background-color: #2D71BC;
        color: white;
        border-radius: 5px;
        padding: 7px 27px 7px 27px;
        font-family: 'Open Sans', sans-serif;
        transition: .3s;
    }

    .admin-room-content-button:hover {
        text-decoration: none;
        background-color: #10367B;
    }

    .admin-room-content-button:nth-child(1) {
        width: 60%;
    }

    .admin-room-content-button:nth-child(2) {
        background-color: #e08d3c;
        width: 20%
    }

    .admin-room-content-button:nth-child(3) {
        background-color: #8A0200;
        width: 20%;
    }

    .fa-angle-double-right {
        font-size: 15px;
        margin-left: 10px;
        transform: translateY(1px);
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

        .admin-room-content-description {
            height: auto;
        }

        .admin-room-content-image {
            width: 100%;
            height: auto;
        }

    }

</style>