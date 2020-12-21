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
    <div class="content-wrapper">
        <div class="content block">
            <img class="advertiser-image" alt="image" @error="onProfileImageLoadFailure($event)" :src="advertiserImageUrl">
            <p class="content-title">{{ title }}</p>
            <p class="content-description">{{ briefDescription }}</p>
            <img alt="creative_image" @error="onImageLoadFailure($event)" class="content-image" :src="imageUrl">
            <p class="content-date">
                <i class="fas fa-calendar-alt"></i>{{ (eventDate === null) ? ('Без даты') : (eventDate) }}
                <label v-show="online" class="content-type"><i class="fas fa-toggle-on"></i>Online</label>
                <label v-show="!online" class="content-type"><i class="fas fa-toggle-off"></i>Offline</label>
            </p><hr>
            <p class="content-price">{{ price }}₽</p>
            <router-link target="_blank" :to="'/creative/' + id" class="content-button">Подробнее<i class="fas fa-angle-double-right"></i></router-link>
        </div>
    </div>
</template>

<script>

    "use strict";

    import * as common from "../scripts/common";

    export default {
        props: ["id", "title", "briefDescription", "imageUrl", "advertiserImageUrl", "eventDate", "price", "online"],
        name: "content-component",
        methods: {
            onProfileImageLoadFailure (event) {
                event.target.src = common.defaultUserImage;
            },
            onImageLoadFailure (event) {
                event.target.src = common.defaultCreativeImage;
            }
        }
    }

</script>

<style scoped>

    .content {
        margin-bottom: 30px;
        border-radius: 5px;
    }

    .content-image {
        width: 358px;
        height: 205px;
        object-fit: cover;
        object-position: 50% 50%;
    }

    .advertiser-image {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        float: left;
        margin: 20px 20px 0 20px;
        object-fit: cover;
        object-position: 50% 50%;
    }

    .content-title {
        height: 73px;
        display: flex;
        justify-content: left;
        align-items: center;
        font-family: 'Roboto', sans-serif;
        font-weight: bold;
        font-size: 16px;
        padding: 17px 20px 5px 0;
    }

    .fa-calendar-alt, .fa-toggle-on, .fa-toggle-off {
        font-size: 17px;
        margin-right: 10px;
        transform: translateY(1px);
    }

    .content-date {
        margin: 20px 0 0 20px;
        font-size: 15px;
        font-family: 'Open Sans', sans-serif;
        color: #e08d3c
    }

    .content-type {
        float: right;
        margin-right: 20px;
    }

    .content-description {
        color: #666666;
        padding: 0 20px 10px 20px;
        font-size: 15px;
        height: 115px;
        font-family: 'Open Sans', sans-serif;
    }

    .content-price {
        font-size: 23px;
        color: #10367B;
        font-family: 'Roboto', sans-serif;
        display: inline-block;
        padding: 2px 0 8px 20px;
    }

    .fa-angle-double-right {
        font-size: 15px;
        margin-left: 10px;
        transform: translateY(1px);
    }

    .content-button {
        display: inline;
        float: right;
        margin: 0 20px 20px 20px;
        font-size: 16px;
        text-decoration: none;
        background-color: #2D71BC;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 7px 25px 7px 25px;
        font-family: 'Open Sans', sans-serif;
        transition: .3s;
    }

    .content-button:hover {
        text-decoration: none;
        background-color: #10367B;
    }

    @media (min-width: 992px) and (max-width: 1199px) {

        .fa-angle-double-right {
            font-size: 14px;
            margin-left: 7px;
        }

        .content-button {
            margin: 0 20px 20px 20px;
            font-size: 15px;
            padding: 7px 20px 7px 20px;
        }

        .content-price {
            font-size: 19px;
            padding: 5px 0 8px 20px;
        }

        .content-description {
            height: 130px;
        }

        .content-image {
            width: 292px;
            height: 165px;
        }

    }

    @media (min-width: 768px) and (max-width: 991px) {

        .content-description {
            height: auto;
        }

        .content-image {
            width: 100%;
        }

    }

    @media(max-width:767px) {

        .content {
            height: auto;
            margin-bottom: 15px;
        }

        .content-description {
            height: auto;
        }

        .content-image {
            width: 100%;
        }

        .content-price {
            font-size: 20px;
            padding: 5px 0 8px 20px;
        }

        .content-button {
            margin: 0 20px 20px 10px;
            font-size: 15px;
            padding: 7px 22px 7px 22px;
        }

    }

</style>