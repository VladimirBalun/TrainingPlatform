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
            <p class="content-title hidden-lg hidden-md hidden-sm">{{ title }}</p>
            <img class="content-image" :src="image_url">
            <p class="content-title hidden-xs">{{ title }}</p>
            <p class="content-date">Дата события: {{ event_date }}</p>
            <p class="content-description">{{ brief_description }}</p>
            <p class="content-price">{{ price }}</p>
            <a class="content-button" href="#">Подробнее</a>
        </div>
    </div>
</template>

<script>

    export default {
        props: ["id", "title", "brief_description", "image_url", "event_date", "price"],
        name: "content-component"
    }

</script>

<style scoped>

    .content {
        height: 400px;
        margin-bottom: 30px;
        border-radius: 5px;
    }

    .content-image {
        float: left;
        position: relative;
        height: 100%;
        padding: 20px;
    }

    .content-title {
        font-family: 'Roboto', sans-serif;
        font-weight: bold;
        font-size: 20px;
        padding: 20px 20px 0 20px;
    }

    .content-date {
        font-size: 14px;
        font-weight: bold;
        font-family: 'Open Sans', sans-serif;
        color: #10367B;;
    }

    .content-description {
        color: #666666;
        padding: 0 20px 20px 20px;
        font-size: 16px;
        height: 225px;
        font-family: 'Open Sans', sans-serif;
    }

    .content-price {
        font-size: 27px;
        color: #10367B;;
        font-family: 'Roboto', sans-serif;
        display: inline-block;
        padding-top: 17px;
    }

    .content-button {
        display: inline;
        float: right;
        margin: 20px;
        font-size: 16px;
        text-decoration: none;
        background-color: #2D71BC;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 7px 30px 7px 30px;
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
        }

        .content-image {
            padding-top: 10px;
            width: 100%;
            height: auto;
        }

        .content-title {
            text-align: center;
        }

        .content-description {
            text-align: center;
        }
    }

</style>