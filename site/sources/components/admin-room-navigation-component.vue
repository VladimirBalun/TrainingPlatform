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
            <button class="admin-room-navigation-button">Добавить объявление</button>
        </div>
        <div class="hidden-xs">
            <div class="admin-room-advertisement-block">
                <img class="admin-room-advertisement-image" src="https://scontent-arn2-1.xx.fbcdn.net/v/t1.0-1/74352875_104980200936259_1210857521053433856_n.png?_nc_cat=102&ccb=2&_nc_sid=dbb9e7&_nc_ohc=M8xnZuw3zh8AX9xNd8C&_nc_ht=scontent-arn2-1.xx&oh=b3b4e9468f4bb7c1fa2495d1ac11c66b&oe=5FD50247">
            </div>
            <div class="admin-room-advertisement-block">
                <img class="admin-room-advertisement-image" src="https://scontent-arn2-1.xx.fbcdn.net/v/t1.0-1/74352875_104980200936259_1210857521053433856_n.png?_nc_cat=102&ccb=2&_nc_sid=dbb9e7&_nc_ohc=M8xnZuw3zh8AX9xNd8C&_nc_ht=scontent-arn2-1.xx&oh=b3b4e9468f4bb7c1fa2495d1ac11c66b&oe=5FD50247">
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "admin-room-navigation-component"

    }

</script>

<style scoped>

    .admin-room-navigation-wrapper {
        padding-bottom: 30px;
    }

    .admin-room-block {
        padding: 20px;
        margin-top: 30px;
    }

    .admin-room-advertisement-image {
        margin-top: 30px;
        position: relative;
        width: 100%;
        border-radius: 5px;
    }

    .admin-room-navigation-button {
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
    }

    .admin-room-navigation-button:hover {
        text-decoration: none;
        background-color: #10367B;
    }

</style>