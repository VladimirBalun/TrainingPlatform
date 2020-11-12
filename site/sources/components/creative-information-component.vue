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
            <p class="creative-information-title">{{ title }}</p><hr>
            <div class="creative-information-meta-block">
                <p class="creative-information-meta-data">Категория: {{ category }}</p>
                <p class="creative-information-meta-data">Тема: {{ category }}</p>
                <p class="creative-information-meta-data">Страна: {{ (country === null) ? ('Не указана') : (country) }}</p>
                <p class="creative-information-meta-data">Город: {{ (city === 'null') ? ('Не указан') : (city) }}</p>
                <p class="creative-information-meta-data">Дата: {{ category }}</p>
                <p class="creative-information-meta-data">Тип: {{ category }}</p>
            </div>
            <hr>
            <p class="creative-information-description">{{ description }}</p>
        </div>
    </div>
</template>

<script>

    "use strict";

    export default {
        props: ["title", "description", "category", "theme", "country", "city"],
        name: "creative-information-component"
    }

</script>

<style scoped>

    .creative-information-block {
        padding: 12px 20px 20px 20px;
    }

    .creative-information-title {
        font-family: 'Roboto', sans-serif;
        font-size: 27px;
    }

    .creative-information-description {
        font-family: 'Open Sans', sans-serif;
        font-size: 17px;
    }

    .creative-information-meta-data {
        width: 50%;
        display: inline-block;
    }

    @media(max-width:767px) {

        .creative-information-block {
            margin-top: 15px;
        }

    }

</style>