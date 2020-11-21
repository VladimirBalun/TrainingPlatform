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
            <i class="fas fa-user-circle"></i>
            <p class="content-title">{{ title }}</p>
            <p class="content-description">{{ brief_description }}</p>
            <img class="content-image" :src="image_url">
            <p class="content-date">
                <i class="fas fa-calendar-alt"></i>{{ (event_date === null) ? ('Без даты') : (event_date) }}
                <label class="content-type"><i class="fas fa-toggle-on"></i>Online</label>
            </p><hr>
            <p class="content-price">{{ price }}₽</p>
            <router-link target="_blank" :to="'/creative/' + id" class="content-button">Подробнее<i class="fas fa-angle-double-right"></i></router-link>
        </div>
    </div>
</template>

<script>

    "use strict";

    export default {
        props: ["id", "title", "brief_description", "image_url", "event_date", "price"],
        name: "content-component"
    }

</script>

<style scoped>

    .content {
        margin-bottom: 30px;
        border-radius: 5px;
    }

    .content-image {
        width: 100%;
    }

    .fa-user-circle {
        margin: 20px 20px 0 20px;
        font-size: 42px;
        float: left;
        color: #2D71BC;
    }

    .content-title {
        height: 70px;
        display: flex;
        justify-content: left;
        align-items: center;
        font-family: 'Roboto', sans-serif;
        font-weight: bold;
        font-size: 17px;
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

    @media(max-width:767px) {
        .content {
            height: auto;
            margin-bottom: 15px;
        }

        .content-image {
            padding-top: 10px;
            width: 100%;
            height: auto;
        }

    }

</style>