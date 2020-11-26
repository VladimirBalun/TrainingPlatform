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
    <div class="admin-room-navigation-wrapper">
        <div class="admin-room-block block">
            <input type="text" placeholder="Введите адрес изображения...">
            <button class="admin-room-navigation-button">Сменить изображение</button><hr>
            <button class="admin-room-navigation-button" data-toggle="modal" data-target="#add-creative-modal">Добавить объявление</button>
        </div>
        <div class="hidden-xs">
            <div class="advertisement-block">
                <img class="advertisement-image" src="https://texterra.ru/upload/iblock/fbf/socialprev.jpg">
            </div>
            <div class="advertisement-block">
                <img class="advertisement-image" src="https://texterra.ru/upload/iblock/fbf/socialprev.jpg">
            </div>
            <div class="advertisement-block">
                <img class="advertisement-image" src="https://texterra.ru/upload/iblock/fbf/socialprev.jpg">
            </div>
        </div>
        <admin-room-add-creative-component></admin-room-add-creative-component>
    </div>
</template>

<script>

    import adminRoomAddCreativeComponent from './admin-room-add-creative-component'

    export default {
        name: "admin-room-navigation-component",
        components: {
            adminRoomAddCreativeComponent
        },
    }

</script>

<style scoped>

    .admin-room-navigation-wrapper {
        margin-bottom: 30px;
    }

    .admin-room-block {
        margin-top: 30px;
    }

    .advertisement-block {
        margin-top: 30px;
        position: relative;
        border-radius: 5px;
    }

    .advertisement-image {
        width: 100%;
        border-radius: 5px;
    }

    .admin-room-navigation-button {
        border: none;
        outline: none;
        text-align: center;
        display: block;
        font-size: 16px;
        text-decoration: none;
        background-color: #2D71BC;
        color: white;
        border-radius: 5px;
        padding: 7px 30px 7px 30px;
        font-family: 'Open Sans', sans-serif;
        transition: .3s;
        margin: 20px;
        width: calc(100% - 40px);
    }

    .admin-room-navigation-button:hover {
        text-decoration: none;
        background-color: #10367B;
    }

    input[type="text"] {
        border: none;
        display: block;
        margin: 20px 20px 0 20px;
        border-radius: 5px;
        background-color: #EEF3F8;
        font-size: 16px;
        padding: 10px 15px 10px 15px;
        font-family: 'Open Sans', sans-serif;
        width: calc(100% - 40px);
    }

    @media(max-width:767px) {

        .admin-room-block {
            margin-top: 15px;
        }

        .admin-room-navigation-wrapper {
            margin-bottom: 0;
        }

    }

</style>