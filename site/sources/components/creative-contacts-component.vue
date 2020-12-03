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
    <div class="creative-contacts-block-wrapper">
        <div class="creative-contacts-price-block block">
            <p class="creative-contacts-price-text"><i class="fas fa-tags"></i> {{ price }}₽</p>
        </div>
        <div class="creative-contacts-block block">
            <img class="creative-contacts-image" :src="imageUrl" @error="onImageLoadFailure($event)" alt="image">
            <p class="creative-contacts-number">{{ phone }}</p>
            <div class="creative-contacts-wrapper">
                <a :href="site" class="creative-contacts-button">Перейти на сайт</a>
            </div>
            <div class="creative-contacts-wrapper">
                <a :href="'mailto:' + email" class="creative-contacts-button">Написать сообщение</a>
            </div>
        </div>
        <div class="advertisement-block-wrapper hidden-xs">
            <div class="advertisement-block">
                <img class="advertisement-image" src="https://texterra.ru/upload/iblock/fbf/socialprev.jpg">
            </div>
            <div class="advertisement-block">
                <img class="advertisement-image" src="https://texterra.ru/upload/iblock/fbf/socialprev.jpg">
            </div>
        </div>
    </div>
</template>

<script>

    "use strict";

    import * as common from "../scripts/common";

    export default {
        props: ["imageUrl", "email", "site", "phone", "price"],
        name: "creative-contacts-component",
        methods: {
            onImageLoadFailure (event) {
                event.target.src = common.defaultCreativeImage;
            }
        }
    }

</script>

<style scoped>

    .creative-contacts-block {
        padding: 20px 20px 20px 20px;
    }

    .creative-contacts-image {
        width: 100%;
        border-radius: 5px;
    }

    .creative-contacts-number {
        text-align: center;
        font-family: 'Roboto', sans-serif;
        font-size: 20px;
        margin-top: 20px;
    }

    .creative-contacts-wrapper {
        margin-top: 20px;
    }

    .creative-contacts-button {
        text-align: center;
        display: block;
        width: 100%;
        font-size: 16px;
        text-decoration: none;
        background-color: #2D71BC;
        color: white;
        border-radius: 5px;
        padding: 7px 30px 7px 30px;
        font-family: 'Open Sans', sans-serif;
        transition: .3s;
    }

    .creative-contacts-button:hover {
        text-decoration: none;
        background-color: #10367B;
    }

    .creative-contacts-price-block {
        margin-bottom: 30px;
        text-align: center;
        font-size: 25px;
        font-family: 'Roboto', sans-serif;
        padding: 15px 0 5px 0;
    }

    .advertisement-block-wrapper {
        margin-bottom: 30px;
    }

    .advertisement-block {
        margin-top: 30px;
    }

    .advertisement-image {
        position: relative;
        width: 100%;
        border-radius: 5px;
    }

    .fa-tags {
        font-size: 18px;
        margin-right: 5px;
        transform: translateY(-1px);
    }

    @media(max-width:767px) {

        .creative-contacts-price-block {
            margin: 0 0 15px 0;
        }

    }

</style>