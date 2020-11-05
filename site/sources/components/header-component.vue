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

<!--<nav class="main-menu">
    <router-link to="/" class="nav-button">RacingWorld</router-link>
    <router-link to="/news" class="nav-button">News</router-link>
    <router-link to="/forum" class="nav-button">Forum</router-link>
    <router-link to="/downloads" class="nav-button">Downloads</router-link>
</nav>!-->

<template>

  <header>
      <div class="header-up">
          <div class="container">
              <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                      <div class="header-title-wrapper">
                          <router-link to="/" class="header-title">Training.com</router-link>
                      </div>
                  </div>
                  <div class="header-link-wrapper col-lg-6 col-md-6 col-sm-6 col-xs-6">
                      <router-link to="/signup" class="header-link">Подать объявление</router-link>
                  </div>
              </div>
          </div>
      </div>
      <div class="header-down">

      </div>

  </header>

</template>

<script>

    "use strict";

    export default {};

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

    .header-up {
        height: 50px;
        background-color: #10367B;
    }

    .header-down {
        height: 50px;
        background-color: white;
    }

    .header-link {
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
    }

</style>