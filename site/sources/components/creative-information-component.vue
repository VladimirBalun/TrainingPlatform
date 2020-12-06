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
    <div class="creative-information-block-wrapper">
        <div class="creative-information-block block">
            <img class="advertiser-image" alt="image" @error="onProfileImageLoadFailure($event)" :src="advertiserImageUrl">
            <p class="creative-information-title">{{ title }}</p><hr>
            <div class="creative-information-meta-block">
                <p class="creative-information-meta-data"><span class="bold-label"><i class="fas fa-circle"></i>Тип:</span> {{ (online === 0) ? ('Online') : ('Offline') }}</p>
                <p class="creative-information-meta-data"><span class="bold-label"><i class="fas fa-circle"></i>Дата:</span> {{ (eventDate === null) ? ('Не указана') : (eventDate) }}</p>
                <p class="creative-information-meta-data"><span class="bold-label"><i class="fas fa-circle"></i>Город:</span> {{ (city === null) ? ('Не указан') : (city) }}</p>
                <p class="creative-information-meta-data"><span class="bold-label"><i class="fas fa-circle"></i>Страна:</span> {{ (country === null) ? ('Не указана') : (country) }}</p>
                <p class="creative-information-meta-data"><span class="bold-label"><i class="fas fa-circle"></i>Тема:</span> {{ theme }}</p>
                <p class="creative-information-meta-data"><span class="bold-label"><i class="fas fa-circle"></i>Категория:</span> {{ category }}</p>
            </div><hr>
            <vue-markdown class="creative-information-description" :source="description"></vue-markdown>
        </div>
    </div>
</template>

<script>

    "use strict";

    import * as common from "../scripts/common";

    import VueMarkdown from 'vue-markdown';

    export default {
        props: ["title", "description", "category", "theme", "country", "city", "eventDate", "online", "advertiserImageUrl"],
        name: "creative-information-component",
        components: {
            VueMarkdown
        },
        methods: {
            onProfileImageLoadFailure (event) {
                event.target.src = common.defaultUserImage;
            }
        }
    }

</script>

<style scoped>

    hr {
        margin: 15px 0 15px 0;
    }

    .creative-information-block-wrapper {
        margin-bottom: 30px;
    }

    .creative-information-block {
        padding: 12px 20px 10px 20px;
    }

    .advertiser-image {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        float: left;
        margin: 5px 20px 0 0;
    }

    .creative-information-title {
        font-family: 'Roboto', sans-serif;
        font-size: 24px;
        height: 70px;
        display: flex;
        justify-content: left;
        align-items: center;
    }

    .creative-information-description {
        font-family: 'Open Sans', sans-serif;
        font-size: 17px;
    }

    .creative-information-meta-data {
        font-size: 16px;
        font-family: 'Open Sans', sans-serif;
    }

    .fa-circle {
        font-size: 5px;
        margin-right: 10px;
        transform: translateY(-3px);
    }

    .bold-label {
        color: #949494;
        font-size: 15px;
    }

    @media (min-width: 768px) and (max-width: 991px) {

        .creative-information-meta-data {
            width: 100%;
        }

    }

    @media(max-width:767px) {

        .creative-information-title {
            font-size: 19px;
            font-weight: bold;
        }

        .creative-information-block-wrapper {
            margin-bottom: 15px;
        }

        .creative-information-meta-data {
            width: 100%;
        }

        .creative-information-block {
            margin-top: 15px;
        }

    }

</style>