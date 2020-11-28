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
                <p class="creative-information-meta-data"><span class="bold-label"><i class="fas fa-circle"></i>Категория:</span> {{ category }}</p>
                <p class="creative-information-meta-data"><span class="bold-label"><i class="fas fa-circle"></i>Тема:</span> {{ theme }}</p>
                <p class="creative-information-meta-data"><span class="bold-label"><i class="fas fa-circle"></i>Страна:</span> {{ (country === null) ? ('Не указана') : (country) }}</p>
                <p class="creative-information-meta-data"><span class="bold-label"><i class="fas fa-circle"></i>Город:</span> {{ (city === null) ? ('Не указан') : (city) }}</p>
                <p class="creative-information-meta-data"><span class="bold-label"><i class="fas fa-circle"></i>Дата:</span> {{ (event_date === null) ? ('Не указана') : (event_date) }}</p>
                <p class="creative-information-meta-data"><span class="bold-label"><i class="fas fa-circle"></i>Тип:</span> {{ (online === 0) ? ('Online') : ('Offline') }}</p>
            </div><hr>
            <p class="creative-information-description" v-html="description"></p>
            <div style="position:relative;overflow:hidden;"><a href="https://yandex.com/maps?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Yandex.Maps</a><a href="https://yandex.com/maps/?ll=38.583678%2C55.221603&utm_medium=mapframe&utm_source=maps&z=7" style="color:#eee;font-size:12px;position:absolute;top:14px;">Yandex.Maps: search for places, addresses, and public transport</a><iframe src="https://yandex.com/map-widget/v1/-/CCezzrd" width="710" height="400" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe></div>
        </div>
    </div>
</template>

<script>

    "use strict";

    export default {
        props: ["title", "description", "category", "theme", "country", "city", "event_date", "online"],
        name: "creative-information-component"
    }

</script>

<style scoped>

    hr {
        margin: 10px 0 15px 0;
    }

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
        margin-bottom: 20px;
    }

    .creative-information-meta-data {
        font-size: 16px;
        display: inline-block;
        width: 350px;
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

        .creative-information-meta-data {
            width: 100%;
        }

        .creative-information-block {
            margin-top: 15px;
        }

    }

</style>