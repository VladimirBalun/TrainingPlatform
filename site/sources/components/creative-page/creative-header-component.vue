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
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 hidden-xs">
                    <div class="header-title-wrapper">
                        <router-link to="/" class="header-title">Trainter</router-link>
                    </div>
                </div>
                <div class="hidden-lg hidden-md hidden-sm col-xs-2">
                    <div class="mobile-filters-menu">
                        <button @click="onClickHomeButton" class="header-button"><i class="fas fa-home"></i></button>
                    </div>
                </div>
                <div class="header-link-wrapper col-lg-6 col-md-6 col-sm-6 col-xs-10">
                    <router-link to="/signup" class="header-link">{{ buttonText }}</router-link>
                </div>
            </div>
        </div>
    </header>
</template>

<script>

    "use strict";

    export default {
        computed: {
            buttonText() {
                if ((document.cookie.indexOf("trainter_id=") !== -1) && (document.cookie.indexOf("trainter_hash=") !== -1)) {
                    return "Комната администратора";
                } else {
                    return "Подать объявление";
                }
            }
        },
        methods: {
            onClickHomeButton() {
                this.$router.push("/");
            }
        },
    };

</script>

<style scoped>

    .header-title-wrapper {
        margin-top: 8px;
    }

    .header-title {
        color: #FDFBF1;
        font-size: 22px;
        font-family: 'Roboto', sans-serif;
        transition: .3s;
    }

    .header-title:hover {
        text-decoration: none;
        color: #439EDC;
    }

    header {
        height: 50px;
        background-color: #10367B;
    }

    .header-link {
        outline: none;
        border-radius: 5px;
        color: white;
        margin-top: 10px;
        font-size: 16px;
        border: 1px solid white;
        padding: 3px 30px 3px 30px;
        font-family: 'Roboto', sans-serif;
        text-decoration: none;
        background-color: transparent;
        float: right;
        transition: .5s;
    }

    .header-link:hover {
        color: #10367B;
        background-color: white;
    }

    .header-button {
        outline: none;
        border: none;
        background-color: transparent;
        padding-left: 0;
    }

    @media(max-width:767px) {

        .mobile-filters-menu {
            color: white;
            font-size: 23px;
            margin-top: 8px;
        }

        .header-link {
            margin-top: 12px;
            font-size: 15px;
            padding: 2px 20px 2px 20px;
        }

    }

</style>