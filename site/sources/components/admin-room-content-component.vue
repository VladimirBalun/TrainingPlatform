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
            <div class="admin-room-content-block-inner-wrapper">
                <img class="admin-room-content-image" :src="image_url">
            </div>
            <div class="admin-room-content-block-inner-wrapper">
                <p class="admin-room-content-description"></p>
            </div>
            <div class="admin-room-content-block-inner-wrapper">
                <button class="admin-room-content-button">Подробнее</button>
                <button class="admin-room-content-button">Редактировать</button>
                <button class="admin-room-content-button">Удалить</button>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ["id", "title", "image_url"],
        name: "admin-room-content-component"
    }

</script>

<style scoped>

    .admin-room-content-block-inner-wrapper {
        float: left;
    }

    .admin-room-content-block-inner-wrapper:nth-child(1) {
        width: 30%;
    }

    .admin-room-content-block-inner-wrapper:nth-child(2) {
        width: 40%;
    }

    .admin-room-content-block-inner-wrapper:nth-child(3) {
        width: 29%;
    }

    .admin-room-content-block {
        margin-top: 30px;
        min-height: 300px;
        padding: 20px;
    }

    .admin-room-content-title {
        font-size: 20px;
    }

    .admin-room-content-image {
        border-radius: 5px;
        width: 100%;
    }

    .admin-room-content-button {
        border: none;
        outline: none;
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
        margin-bottom: 10px;
    }

    .admin-room-content-button:hover {
        text-decoration: none;
        background-color: #10367B;
    }

</style>