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
        <div class="search-block block">
            <p class="navigation-title"><i class="fas fa-search"></i>Поиск</p><hr>
            <input type="text" v-model="searchCreativesPatternModel" placeholder="Введите название..." maxlength="50">
            <button v-on:click="onSearchCreativesButtonClick" class="navigation-button">Искать</button>
        </div>
    </div>
</template>

<script>

    export default {
        name: "search-component",
        data() {
            return {
                searchCreativesPatternModel: ""
            };
        },
        methods: {
            onSearchCreativesButtonClick() {
                this.$root.$emit("search-creatives-button-clicked", this.searchCreativesPatternModel);
            }
        }
    }

</script>

<style scoped>

    hr {
        padding-top: 0;
        margin: 0 0 20px 0;
        color: #DBDBD8;
    }

    .navigation-title {
        font-family: 'Roboto', sans-serif;
        font-weight: bold;
        font-size: 20px;
        padding: 15px 20px 7px 20px;
    }

    .search-block {
        margin-bottom: 30px;
        border-radius: 5px;
    }

    .fa-search {
        font-size: 15px;
        margin-right: 10px;
        transform: translateY(-1px);
    }

    input[type="text"] {
        border: none;
        display: block;
        margin: 0 20px 20px 20px;
        border-radius: 5px;
        background-color: #EEF3F8;
        font-size: 15px;
        padding: 12px 15px 12px 15px;
        font-family: 'Open Sans', sans-serif;
        width: calc(100% - 40px);
    }

    .navigation-button {
        position: relative;
        width: calc(100% - 40px);
        margin: 0 20px 20px 20px;
        font-size: 16px;
        background-color: #2D71BC;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 8px 10px 8px 10px;
        font-family: 'Open Sans', sans-serif;
        transition: .3s;
    }

    .navigation-button:hover {
        outline: none;
        background-color: #193777;
    }

    @media(max-width:767px) {

        .search-block {
            margin-bottom: 15px;
        }

    }

</style>